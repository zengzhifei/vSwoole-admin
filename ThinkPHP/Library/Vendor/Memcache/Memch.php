<?php
/**
 * 分装memcache
 * 方便分页使用缓存 
 * 对于不同的模块请使用不同的版本名称 $versionname=‘’；
 * @author masongsong
 * @date   20141011
 */
class Memch{
    public function __construct($versionname){
        S(array(
                'type'=>c('CACHE_API'),
                'host'=>c('MEMCACHE_HOST'),
                'port'=>c('MEMCACHE_PORT'),
                'expire'=>c('MEMCACHE_EXPIRE')
        ));
        $this->weiting_version=$versionname;
    }
     /*
     * 获取缓存的方法
     * $cachename 缓存名称
    */
    public function getCache($cachename)
    {
       $cachename = $cachename.'_'.$this->weiting_version.'_'.$this->getVersion($this->weiting_version);
       $cachInfo  = S($cachename);
        return empty($cachInfo) ? array() : $cachInfo;
    }
    
    /*
     * 设置缓存的方法
     * $cachename 缓存名称
     * $cachevalue 缓存内容
    */
    public function setCache($cachename,$cachevalue)
    {
        $cachename = $cachename.'_'.$this->weiting_version.'_'.$this->getVersion($this->weiting_version);
        S($cachename,$cachevalue);
    }
    
    /*
     * 更新缓存的方法
    */
    public function updateCache()
    {
        $this->setVersion();
    }
    
    /*
     * 删除缓存的方法
     */
    public function delCache($cachename)
    {
        $cacheKey = $cachename.'_'.$this->weiting_version.'_'.$this->getVersion($this->weiting_version);
        S($cacheKey,null);
    }
    
    
    /*
     * 获取缓存版本号的方法
    */
    private function getVersion()
    {
        $version_num = S($this->weiting_version);
        if(empty($version_num)){
            $version_num = 1;
            S($this->weiting_version,$version_num);
        }
        return empty($version_num) ? array() : $version_num;
    }
    
    /*
     * 获取缓存版本号的方法
    */
    private function setVersion(){
        $version_num=S($this->weiting_version);
        if(empty($version_num)){
             $version_num=1;
        }
        $version_num++;
        S($this->weiting_version,$version_num);
    }
//End Class
}