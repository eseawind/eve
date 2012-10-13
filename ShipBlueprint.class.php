<?php
require_once('Blueprint.class.php');
class ShipBlueprint extends Blueprint{
	function __construct(){
		parent::__construct();				#基类构造函数
		$this->research_process=1;		#发明流程基数
	}
}
?>