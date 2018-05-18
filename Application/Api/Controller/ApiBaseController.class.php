<?php
/**
 * 接口基类
 * 
 */
namespace Api\Controller;
use Think\Controller;
class ApiBaseController extends Controller {
	
    const MAX_PAGE_SIZE = 200;
    protected $format = 'JSONP';
    protected $formatArr = array('JSON', 'XML', 'HTML', 'GX','VL','JSONP');
    protected $ouputMessage;
    protected $pagesize;
    protected $offset;
    protected $pagenume;
    protected $sort;
    protected $redis;
    protected $stage_id;
	protected $stage_desc;

	function _initialize() {
		//客户端CORS请求
        header("Access-Control-Allow-Origin:*");
        
		$this->format = I('format');
		$this->pagesize = I('pagesize',10);
		$this->pagenume = I('pagenum');
		$this->sort = I('sort','DESC');
		$this->format = (isset($this->format) && in_array(strtoupper($this->format), $this->formatArr)) ? strtoupper($this->format) : 'JSON';
		
		if(isset($this->pagesize) && intval($this->pagesize) > self::MAX_PAGE_SIZE) {
		    $this->pagesize = self::MAX_PAGE_SIZE;
		}
		if(isset($this->pagenume) && intval($this->pagenume)>1){
		    $this->offset = (I('pagenum') -1) * $this->pagesize;
		}
		else {
		    $this->offset = 0;
		    $this->pagenume =1;
		}
	}
	
	protected function check_login(){
		if(!isset($_SESSION["user"])){
			return false;
		}
	}

    /*
     * 获取图片信息
    */
    public function getImageinfo($where){
        $imgModel = M('picture');
        return $imgModel->where($where)->select();
    }

    /**
     * 连接缓存
     */
    public function connectRedis()
    {
        $this->redis = new \Redis();
        $this->redis->pconnect(C("REDIS_HOST"), C("REDIS_PORT"));
        C("REDIS_AUTH") && $this->redis->auth(C("REDIS_AUTH"));
    }

	
}