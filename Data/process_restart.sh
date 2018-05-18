#!/bin/bash
#$1应用路径  $2进程方法名
if [ ! -n "$1" ] ;then
	echo "Parameter1 error;please input root path";
exit 1;
fi
if [ ! -n "$2" ] ;then
	echo "Parameter2 error;please input function name";
exit 1;
fi
#杀掉进程后重启进程
phpBinPath="/opt/php/bin/php"
pid=$(ps -ef | grep $1 | grep $2"\>" | grep -v grep | grep -v ' sleep\>' | grep -v 'process_restart.sh' | awk '{print $2}')
if [ ! -n "$pid" ];then
	$phpBinPath $1/cli.php Api/Daemon/$2
else
	kill -9 "$pid"
	$phpBinPath $1/cli.php Api/Daemon/$2
fi