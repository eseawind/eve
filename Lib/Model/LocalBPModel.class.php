<?php
//php 文件
#Local BluePrint 
class LocalBPModel extends Model {
	protected $tableName='LocalBP';
	
	public function temp($id){ #临时使用
		$bps=array(
			#'---'=>array('ME'=>,'TE'=>),			#TypeId=>(材料等级,时间等级)
			'2047'=>array('ME'=>25,'TE'=>0),   #损伤控制 I
			'2049'=>array('ME'=>-4,'TE'=>0),   #损伤控制 II
			#R.A.M ---- STATR---
			'11872'=>array('ME'=>10,'TE'=>0),   #弹药
			'11889'=>array('ME'=>10,'TE'=>0),   #护盾
			'11890'=>array('ME'=>10,'TE'=>0),   #星舰
			'11891'=>array('ME'=>10,'TE'=>0),   #武器
			'11870'=>array('ME'=>10,'TE'=>0),   #电子
			'11873'=>array('ME'=>10,'TE'=>0),   #装甲
			'11859'=>array('ME'=>10,'TE'=>0),   #能源
			#R.A.M ---- END-----
		);
		return $bps[$id];
	}
}
?>