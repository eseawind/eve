<?php
//php 文件

class ItemModel extends Model {
	public function _initialize(){
		$m=new Model();
		#language:中文
		#Other language: trntranslationlanguages.languageName
		#
		$q=$m->query("select languageid from trntranslationlanguages where languageName='CHINESE (SIMPLIFIED)'");		
		$this->language=$q[0]['languageid'];
	}
	public function getItem($name){
		$this->getInfo($name);
		if(is_null($this->id))	return;	
		$Mineral=$this->getMineral($this->id);
		$DeeperMineral=$this->getDeeperMineral($Mineral);
		return array('name'=>$this->name,'Mineral'=>$Mineral,'DeeperMineral'=>$DeeperMineral);	
	}
	public function getItems($items){
		$total=array();
		foreach($items as $item){
			$current=$this->MultiItem($this->getItem($item['type']),$item['num']);
			$all[]=$current;
			$total=$this->addItems($current,$total);
		}
		if(sizeof($items)==1){
			return array($current);
		}else{
			$all['total']=$total;
			return $all;
		}
	}
	protected function MultiItem($item,$num){
		$num=$num<=0 ? 1:$num;
		$item['name']=$item['name']." *".$num;
		foreach($item['Mineral'] as $typeid=> $m){
			$item['Mineral'][$typeid]['quantity']*=$num;
		}
		foreach($item['DeeperMineral'] as $typeid=> $m){
			$item['DeeperMineral'][$typeid]['quantity']*=$num;
		}
		return $item;
	}
	protected function addItems($item1,$item2){
		foreach($item2['Mineral'] as $typeid => $m){
			$item1['Mineral'][$typeid]['Mineral']=$item2['Mineral'][$typeid]['Mineral'];
			$item1['Mineral'][$typeid]['quantity']+=$item2['Mineral'][$typeid]['quantity'];
		}
		foreach($item2['DeeperMineral'] as $typeid => $m){
			$item1['DeeperMineral'][$typeid]['Mineral']=$item2['DeeperMineral'][$typeid]['Mineral'];
			$item1['DeeperMineral'][$typeid]['quantity']+=$item2['DeeperMineral'][$typeid]['quantity'];
		}
		return $item1;
	}
	
	public function getMineral($id){
		$Mineral=$this->getBaseMineral($id)+$this->getExtraMineral($id);
		return $Mineral;
	}
	public function getDeeperMineral($Mineral){
		$old=$Mineral;
		foreach ($Mineral as $TypeId => $m){
   		$tmp=$this->getMineral($TypeId);
   		if(sizeof($tmp)==0){  			
     		continue;
     	}
  		foreach($tmp as $mtypeid => $m_m){
  			$Mineral[$mtypeid]['Mineral']=$m_m['Mineral'];
				$Mineral[$mtypeid]['quantity']+=$m_m['quantity']*$Mineral[$TypeId]['quantity'];
  		}
  		unset($Mineral[$TypeId]);
		}
 		if($old!=$Mineral)
  		$this->getDeeperMineral($Mineral);
  	return $Mineral;
	}
	protected function getInfo($name){
		$db=M('trntranslations');
		$map['tcid']=8;
		$map['languageid']=$this->language;
		$map['text']=array('like',$name.'%');
		$query=$db->where($map)->find();
		$this->id= $query['keyID'];
		$this->name=$query['text'];
	}

	protected function getBaseMineral($id){
		$db=M('invtypematerials');
		$map['typeid']=$id;
		$query=$db->where($map)->select();
		return $this->translation($query);
	}
	public function getExtraMineral($id){
		$bp=$this->getBlueprint($id);
		$blueprintid=$bp['blueprintTypeID'];
		$db=M('ramtyperequirements');
		$map['typeid']=$blueprintid;
		$map['activityid']=1;
		$map['damagePerJob']=array('gt',0);
		$query=$db->field('typeid,requiredTypeID as materialTypeID,round(damagePerJob*quantity,1) as quantity')->where($map)->select();
		return $this->translation($query);
	} 
	protected function getBlueprint($productid){
		$db=M('invblueprinttypes');
		$map['productTypeID']=$productid;
		$query=$db->where($map)->find();
		return $query;
	}
	protected function translation($array){
		$Mineral=array();
		foreach($array as $m){
			$zh=$this->getZH($m['materialTypeID']);
			$Mineral[$m['materialTypeID']]=array('Mineral'=>$zh,'quantity'=>$m['quantity']);
		}
		return $Mineral;
	}
	protected function getZH($id){
		$db=M('trntranslations');
		$map['tcid']=8;
		$map['languageid']='ZH-HANS';
		$map['keyid']=$id;
		$query=$db->where($map)->find();
		return $query['text'];
	}
	protected function getPrice($array){
		$Mineral=array();
			foreach($array as $typeid=>$m){
				$Mineral[$typeid]=$m+array('price'=>$this->getItemPrice($typeid));
		}
		return $Mineral;
	}
	public function getItemPrice($typeid){
		$api='http://cem.copyliu.org/api/marketstat?typeid='.$typeid.'&usesystem=30000142';
		$ch = curl_init($api);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$xmlstring=curl_exec($ch);
		$xml=simplexml_load_string($xmlstring);
		$buymax= removeHtmlTagsWithExceptions($xml->marketstat->type->buy->max->asXML());
		$sellmin=removeHtmlTagsWithExceptions($xml->marketstat->type->sell->min->asXML());
		return array('sell'=>$sellmin,'buy'=>$buymax);
	}
	
}
?>
