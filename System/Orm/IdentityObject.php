<?php

namespace System\Orm;

class IdentityObject{
	protected $currentfield=null; //????Field
	protected $fields=array(); //??? ????????Field
	protected $what=array('*');// ??? ??? ??????????? ? ????
	protected $join= array();
	protected $limit=array();
	protected $order=array();
	private $enforce=array(); //????????????
	private $type= array('LEFT', 'RIGHT', 'INNER', 'OUTER');
	private $and=true;


	function __construct($field=null,array $enforce=null){
		if (!is_null($enforce)){
			$this->enforce=$enforce;
		}
		if (!is_null($field)){
			$this->field($field);
		}
	}

	function getObjectFields(){
		return $this->enforce;
	}

	function field($fieldname){
		if (!$this->isVoid()&&$this->currentfield->isIncomplete()){
			throw new Exception("Неполное поле");
		}
		$this->enforceField($fieldname);
		if (isset($this->fields[$fieldname])){
			$this->currentfield=$this->fields[$fieldname];
		}
		else{
			$this->currentfield=new Field($fieldname);
			$this->fields[$fieldname]=$this->currentfield;
		}
		return $this;
	}

	function isVoid(){
		return empty($this->fields);
	}

	function enforceField($fieldname){
		if (!in_array($fieldname,$this->enforce)&&!empty($this->enforce)){
			$forcelist=implode(',',$this->enforce);
			echo "Поле {$fieldname} не является корректным полем {$forcelist}";
			throw new Exception("Поле {$fieldname} не является корректным полем {$forcelist}");
		}
	}

	function eq($value){
		return $this->operator('=',$value);
	}

	function neq($value){
		return $this->operator('<>',$value);
	}

	function lt($value){
		return $this->operator('<',$value);
	}

	function rgt($value){
		return $this->operator('>',$value);
	}

	function like($value,$not=false){
		if ($not){
			return $this->operator(' NOT LIKE ',$value);
		} return $this->operator(' LIKE ',$value);
	}

	private function operator($symbol,$value){
		if($this->isVoid()){
			throw new Exception("Поле не определено");
		}
		$this->currentfield->addTest($symbol,$value);
		return $this;
	}

	function getComps(){
		$ret=array();
		foreach ($this->fields as $key=>$field){
			$ret=array_merge($ret,$field->getComps());
		}
		return $ret;
	}

	function addWhat(array $fields){
		if (is_array($fields)){
			foreach ($fields as $field){
				$this->enforceField($field);
			}
			$this->what=$fields;
		}
	}

	function checkWhat(){
		$result= implode(', ',$this->what);
		return $result;
	}

	function addJoin($type='INNER',array $tables,array $raws){
		$type=strtoupper($type);
		if(in_array($type,$this->type)&&is_array($tables)&&is_array($raws)){
			$this->join[]=$type;
			$this->join[]=$tables;
			$this->join[]=$raws;
		} else{
			throw new Exception("Ошибка в передаваемых параметрах");
		}
	}

	function checkJoin(){
		if (!empty($this->join)){
			$t0=$this->join[1][0];
			$t1=$this->join[1][1];
			$result= $this->join[0].' JOIN '.$this->join[1][1].' ON '.$t0.'.'.$this->join[2][0].'='.$t1.'.'.$this->join[2][1];
			return $result;
		}else return null;
	}

	function addOrder($order){
		if(is_array($order)&&count($order)>0){
			foreach($order as $row=>$dir){
				$this->enforceField($row);
				if (!in_array($dir,array('DESC','ASC'))){
					throw new Exception("Недопустимое имя сортировки для проедложения ORDER!");
				}
			}
			$this->order=$order;
		}
	}

	function checkOrder(){
		if (!empty($this->order)){
			foreach($this->order as $row=>$dir){
				$res[]=$row.' '.$dir;
			}
		 return 'OREDER BY '.implode(',',$res);
		}else return null;
	}

	function addLimit($limit){
		if (is_array($limit)){
			if (count($limit)==1&&is_numeric($limit[0])){
				$this->limit['start']=$limit[0];
			}elseif(count($limit)==2&&is_numeric($limit[0])&&is_numeric($limit[1])){
				$this->limit['start']=$limit[0];
				$this->limit['count']=$limit[1];
			}else throw new Exception("Недопустимое число элементов массива $limit!");
		}
	}

	function checkLimit(){
		if(! empty($this->limit)){
			$res=' LIMIT '.$this->limit['start'];
			if(isset($this->limit['count'])){
				$res.=', '.$this->limit['count'];
			}
			return $res;
		} else return null;
	}

	function changeLink(){
		$this->and=false;
	}

	function returnLink(){
		return $this->and;
	}
}

?>