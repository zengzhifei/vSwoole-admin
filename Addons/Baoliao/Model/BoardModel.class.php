<?php

namespace Addons\Baoliao\Model;
use Think\Model;

/**
 * Baoliao模型
 */
class BaoliaoModel extends Model{
	public function getlist(){
		$model = M('Baoliao');
		var_dump($model);
	}
}
