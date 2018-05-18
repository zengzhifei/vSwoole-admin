<?php
namespace Think;
// Log message levels
define('DLOG_TO_CONSOLE', 1);
define('DLOG_NOTICE', 2);
define('DLOG_WARNING', 4);
define('DLOG_ERROR', 8);
define('DLOG_CRITICAL', 16);

/**
 * Daemon base class
 *
 * Requirements:
 * Unix like operating system
 * PHP 5
 * PHP compiled with:
 * --enable-sigchild
 * --enable-pcntl
 *
 * @package    Ko
 * @author     Ko Team, Eric
 * @version    $Id: daemon.php 7 2014-01-21 09:54:26Z yuchangchun $
 * @copyright  (c) 2008-2009 Ko Team
 * @license    http://kophp.com/license.html
 */
class Daemon
{

    /**
     * User ID
     *
     * @var int
     */
    public $userID = 48;

    /**
     * Group ID
     *
     * @var integer
     */
    public $groupID = 48;

    /**
     * Terminate daemon when set identity failure ?
     *
     * @var bool
     */
    public $requireSetIdentity = false;

    /**
     * Path to PID file
     *
     * @var string
     */
    protected $pidFile = '/var/run/daemon.pid';

    /**
     * Home path
     *
     * @var string
     */
    protected $homePath = '/';

    /**
     * Current process ID
     *
     * @var int
     */
    protected $processId = 0;

    /**
     * Is this process a children
     *
     * @var boolean
     */
    protected $isChildren = false;

    /**
     * Is daemon running
     *
     * @var boolean
     */
    protected $isRunning = false;

    protected $logFile = null ;

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct($identity = NULL)
    {
        set_time_limit(0);
        ob_implicit_flush();

        // Init Log file
        //$logPath = DATA_PATH . 'daemon/';
        $logPath = C('LOG_PATH').'daemon/';
        if (!is_dir($logPath)) {
            mkdir($logPath, 0777, true);
            @chmod($logPath, 0777);
        }
        
        $this->logFile = $logPath . $identity . '.php';
        $this->pidFile = $logPath . $identity . '.pid';

        $fp = fopen($this->logFile, 'a');
        fclose($fp);
            
        @chmod($this->logFile, 0777);

        register_shutdown_function(array(&$this, 'releaseDaemon'));
    }

    /**
     * Starts daemon
     *
     * @access public
     * @return bool
     */
    public function start()
    {
        $this->logMessage('Starting daemon');

        if (!$this->daemonize()) {
            $this->logMessage('Could not start daemon', DLOG_ERROR);
            return false;
        }

        $this->logMessage('[' . $this->processId . '] Running...');
        $this->isRunning = true;
        
        return true;
    }
    
    /**
     * 
     */
    public function run()
    {
        while ($this->isRunning) {
            $this->doTask();
        }
    }

    /**
     * Stops daemon
     *
     * @access public
     * @return void
     */
    public function stop()
    {
        $this->logMessage('[' . $this->processId . '] Stoping daemon');
        $this->isRunning = false;
    }

    /**
     * Check Daemon whether is running
     * @return bool
     */
    public function checkRunning() {
        return $this->isRunning;
    }
    
    /**
     * Signals handler
     *
     * @return void
     */
    public function sigHandler($sigNo)
    {
        switch ($sigNo) {
            case SIGTERM:   // Shutdown
                $this->logMessage('[' . $this->processId . '] Shutdown signal');
                exit();
                break;

            case SIGCHLD:   // Halt
                $this->logMessage('[' . $this->processId . '] Halt signal');
                while (pcntl_waitpid(-1, $status, WNOHANG) > 0);
                break;
        }
    }

    /**
     * Releases daemon pid file
     * This method is called on exit (destructor like)
     *
     * @return void
     */
    public function releaseDaemon()
    {
        if ($this->isChildren && file_exists($this->pidFile)) {
            $this->logMessage('[' . $this->processId . '] Releasing daemon');
            unlink($this->pidFile);
        }
    }

    /**
     * Do task
     *
     * @access protected
     * @return void
     */
    protected function doTask()
    {
        // override this method
    }

    /**
     * Logs message
     *
     * @access protected
     * @return void
     */
    protected function logMessage($msg, $level = DLOG_NOTICE)
    {
        if ($level & DLOG_TO_CONSOLE) {
            print $msg."\n";
        }
        $fp = fopen($this->logFile, 'a+');
        fwrite($fp, date("Y/m/d H:i:s") . "\t" . $msg . "\n");
        fclose($fp);
        return;
    }

    /**
     * Daemonize
     *
     * Several rules or characteristics that most daemons possess:
     * 1) Check is daemon already running
     * 2) Fork child process
     * 3) Sets identity
     * 4) Make current process a session laeder
     * 5) Write process ID to file
     * 6) Change home path
     * 7) umask(0)
     *
     * @return void
     */
    private function daemonize()
    {
        if ($this->isDaemonRunning()) {
            // Deamon is already running. Exiting
            return false;
        }

        if (!$this->forkProcess()) {
            // Coudn't fork. Exiting.
            return false;
        }

        if (!$this->setIdentity() && $this->requireSetIdentity) {
            // Required identity set failed. Exiting
            return false;
        }

        if (!posix_setsid()) {
            $this->logMessage('[' . $this->processId . '] Could not make the current process a session leader', DLOG_ERROR);
            return false;
        }

        if (!$fp = @fopen($this->pidFile, 'w')) {
            $this->logMessage('[' . $this->processId . '] Could not write to PID file' . "[$this->pidFile]", DLOG_ERROR);
            return false;
        } else {
            fputs($fp, $this->processId);
            fclose($fp);
            
            @chmod($this->pidFile, 0777);
        }

        @chdir($this->homePath);
        umask(0);

        declare(ticks = 1);

        pcntl_signal(SIGCHLD, array(&$this, 'sigHandler'));
        pcntl_signal(SIGTERM, array(&$this, 'sigHandler'));

        return true;
    }

    /**
     * Cheks is daemon already running
     *
     * @access private
     * @return bool
     */
    private function isDaemonRunning()
    {
        $oldPid = @file_get_contents($this->pidFile);
        if ($oldPid !== false && posix_kill(trim($oldPid),0)) {
            $this->logMessage('Daemon already running with PID: '.$oldPid, (DLOG_TO_CONSOLE | DLOG_ERROR));
            return true;
        } else {
            return false;
        }
    }

    /**
     * Forks process
     *
     * @return bool
     */
    private function forkProcess()
    {
        $this->logMessage('Forking...');

        $processId = pcntl_fork();

        // error
        if ($processId == -1) {
            $this->logMessage('Could not fork', DLOG_ERROR);
            return false;
        }
        // parent
        elseif ($processId) {
            $this->logMessage('Killing parent ID:' . $processId);
            exit();
        }
        // children
        else {
            $this->isChildren = true;
            $this->processId = posix_getpid();
            return true;
        }
    }

    /**
     * Sets identity of a daemon and returns result
     *
     * @return bool
     */
    private function setIdentity()
    {
        if (!posix_setgid($this->groupID) || !posix_setuid($this->userID)) {
            $this->logMessage('Could not set identity', DLOG_WARNING);
            return false;
        } else {
            return true;
        }
    }

}

/*
<?php
class TestDaemon extends Daemon
{
    function __construct()
    {
        parent::__construct();

        $fp = fopen('/tmp/daemon.log', 'a');
        fclose($fp);
         
        chmod('/tmp/daemon.log', 0777);
    }

    function logMessage($msg, $status = DLOG_NOTICE)
    {
        if ($status & DLOG_TO_CONSOLE) {
            print $msg."\n";
        }

        $fp = fopen('/tmp/daemon.log', 'a');
        fwrite($fp, date("Y/m/d H:i:s ").$msg."\n");
        fclose($fp);
    }

    function doTask()
    {
        static $i = 0;
         
        sleep(1);
        echo $i;
         
        $i++;
         
        if ($i >= 30) {
            $this->stop();
        }
    }
}

<?php
require_once ('daemon.class.php');
require_once ('testdaemon.class.php');

$daemon = new TestDaemon();
if ($daemon->start()) {
    $daemon->run();
}
$daemon->stop();
*/
