<?php

namespace Addons\Baoliao;
use Common\Controller\Addon;

/**
 * 留言插件
 * @author Michence
 */

    class BaoliaoAddon extends Addon{

        public $info = array(
            'name'=>'Baoliao',
            'title'=>'爆料',
            'description'=>'互动平台爆料',
            'status'=>1,
            'author'=>'Michence',
            'version'=>'0.1',
            'has_adminlist'=>1,
            'type'=>1
        );

	public function install() {
// 		$install_sql = './Addons/Board/install.sql';
// 		if (file_exists ( $install_sql )) {
// 			execute_sql_file ( $install_sql );
// 		}
		return true;
	}
	public function uninstall() {
// 		$uninstall_sql = './Addons/Board/uninstall.sql';
// 		if (file_exists ( $uninstall_sql )) {
// 			execute_sql_file ( $uninstall_sql );
// 		}
		return true;
	}

        //实现的weixin钩子方法
        public function weixin($param){

        }

    }