<?php

namespace Addons\Vote;
use Common\Controller\Addon;

/**
 * 微平台投票插件
 * @author php
 */

    class VoteAddon extends Addon{

        public $info = array(
            'name'=>'Vote',
            'title'=>'微平台投票',
            'description'=>'微平台的互动中的投票功能',
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