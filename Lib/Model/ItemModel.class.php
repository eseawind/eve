<?php
//php 文件

class ItemModel extends Model {
	public function _initialize(){
		$m=new Model();
		#language:中文
		#Other language: trntranslationlanguages.languageName
		#
		$q=$m->query("select languageid from trntranslationlanguages where languageName='CHINESE (SIMPLIFIED)'");		
		$this->language=$q[0]['languageid']?$q[0]['languageid']:'ZH';
	}
	public function getItem($name){
		$rtn=$this->getInfo($name);
		if(!$rtn['id']) return;
		$Mineral=$this->getMineral($rtn['id']);
		$DeeperMineral=$this->getDeeperMineral($Mineral);
		return array('name'=>$rtn['name'],'Mineral'=>$Mineral,'DeeperMineral'=>$DeeperMineral);	
	}
	public function getItems($items){
		$total=array();
		foreach($items as $item){
			$current=$this->MulItems($this->getItem($item['type']),$item['num']);
			$all[]=$current;
			$total=$this->AddItems($current,$total);
		}
		if(sizeof($items)==1){
			return array($current);
		}else{
			$all['total']=$total;
			return $all;
		}
	}
	protected function MulItems($item,$num){
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
	protected function AddItems($item1,$item2){
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
		$Mineral=$this->getWastedMineral($id,-4)+$this->getExtraMineral($id);
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
		$rtn['id']= $query['keyID'];
		$rtn['name']=$query['text'];
		return $rtn;
	}

	protected function getBaseMineral($id){
		$db=M('invtypematerials');
		$map['typeid']=$id;
		$query=$db->where($map)->select();
		$bp=$this->getBlueprint($id);
		$blueprintid=$bp['blueprintTypeID'];
		$Mineral=$this->translation($query);
		if($bp['techLevel']==2){		#tech 2 blueprint
			$parentid=$this->getParentItem($id);
			$extraMineral=$this->getExtraMineral($id);
			if($extraMineral[$parentid]['quantity']>0){
				$Mineral=$this->SubMineral($Mineral,$this->getBaseMineral($parentid));
			}
		}
		return $Mineral;
	}
	protected function getWastedMineral($id,$ME=0){
		$bp=$this->getBlueprint($id);
		$blueprintid=$bp['blueprintTypeID'];
		return $this->AddWaste($this->getBaseMineral($id),$ME,$blueprintid);
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
	protected function getParentItem($id){
		$db=M('invmetatypes');
		$map['typeid']=$id;
		$query=$db->where($map)->find();
		return $query['parentTypeID'];
	}
	protected function translation($array){
		$Mineral=array();
		foreach($array as $m){
			$zh=$this->getZH($m['materialTypeID']);
			$Mineral[$m['materialTypeID']]=array('Mineral'=>$zh,'quantity'=>$m['quantity']);
		}
		//print_r($array);
		return $Mineral;
	}
	protected function getZH($id){
		$db=M('trntranslations');
		$map['tcid']=8;
		$map['languageid']=$this->language;
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
	protected function AddWaste($array,$wastelevel,$blueprintid){
		$baseFactor=$this->getbaseFactor($blueprintid);
		$wasteFactor=$this->wasteFactor($wastelevel,$baseFactor);
		foreach($array as $typeid => $m){
			$array[$typeid]['quantity']=round($m['quantity']*(1+$wasteFactor/100),0);
		}
		return $array;
	}
	protected function getbaseFactor($blueprintid){
		$db=M('invblueprinttypes');
		$map['blueprintTypeID']=$blueprintid;
		$query=$db->where($map)->find();
		return $query['wasteFactor'];
	}
	public function wasteFactor($wastelevel,$baseFactor=10){
		if(!is_integer($wastelevel))
			return;
		if($wastelevel>=0){
  		bcscale(6);
  		$wasteFactor=bcmul($baseFactor,bcdiv(1,$wastelevel+1));
  	}else{
  		$wasteFactor=$baseFactor*(1-$wastelevel);
  	}
		return $wasteFactor;
	}
	protected function SubMineral($Mineral1,$Mineral2){

		foreach($Mineral2 as $typeid => $m){
			$Mineral1[$typeid]['quantity']=$Mineral1[$typeid]['quantity']-$Mineral2[$typeid]['quantity'];
			if($Mineral1[$typeid]['quantity']<=0) unset($Mineral1[$typeid]);
		}
		return $Mineral1;
	}
}
?>
