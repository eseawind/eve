<?php
//蓝图抽象类
abstract class Blueprint{
	function __construct{
		$this->waste=0.1;			#材料利用率基数,10%
	}
}
?>