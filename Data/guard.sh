#!/bin/bash
# $1应用路径  $2守护进程方法名
if [ ! -n "$1" ] ;then
	echo "Parameter1 error;please input root path";
exit 1;
fi
if [ ! -n "$2" ] ;then
	echo "Parameter2 error;please input function name";
exit 1;
fi

#进程号文件地址
pid=$(cat $1/Runtime/Logs/daemon/$2$2.pid);

#查看进程状态
status=$(ps -ef | grep  $pid | grep -v grep | wc -l);

currTime=$(date "+%Y%m%d");
filename=$1/Runtime/Logs/daemon/guard_${currTime}.log;

if [ $status -gt 0 ]
	then
	echo -e $2 " is running  " $(date "+%Y-%m-%d %H:%M:%S") >> $filename
else
	/opt/php/bin/php $1/cli.php Api/Daemon/$2
	echo -e $2 "not running----restart  " $(date "+%Y-%m-%d %H:%M:%S") >> $filename
fi
