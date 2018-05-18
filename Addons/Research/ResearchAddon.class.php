<?php

namespace Addons\Research;
use Common\Controller\Addon;

/**
 * 微平台调研插件
 * @author php
 */

    class ResearchAddon extends Addon{

        public $info = array(
            'name'=>'Research',
            'title'=>'微平台调研',
            'description'=>'微平台互动中的调研功能',
            'status'=>1,
            'author'=>'php',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }


    }