<?php

namespace Addons\Comment;
use Common\Controller\Addon;

/**
 * 微平台评论插件
 * @author php
 */

    class CommentAddon extends Addon{

        public $info = array(
            'name'=>'Comment',
            'title'=>'微平台评论',
            'description'=>'这是微平台的互动中的评论',
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