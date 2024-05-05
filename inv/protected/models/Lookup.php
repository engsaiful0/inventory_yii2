<?php

class Lookup extends CActiveRecord
{

	private static $_items=array();
        private static $_names=array();
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return 'lookup';
	}
	
	
	public static function items($type)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return self::$_items[$type];
	}
        
        public static function items2($type2)
	{
		if(!isset(self::$_items[$type2]))
			self::loadItems2($type2);
		return self::$_items[$type2];
	}
        
        public static function names($name)
	{
		if(!isset(self::$_names[$name]))
			self::loadNames($name);
		return self::$_names[$name];
	}

              
	public static function item($type,$code)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : false;
	}
	
	private static function loadItems($type)
	{
		self::$_items[$type]=array();
		$models=self::model()->findAll(array(
			'condition'=>'type=:type',
			'params'=>array(':type'=>$type),
			
		));
		foreach($models as $model)
			self::$_items[$type][$model->code]=$model->name;
	}
        
        private static function loadItems2($type2)
	{
		self::$_items[$type2]=array();
		$models=self::model()->findAll(array(
			'condition'=>'type2=:type2',
			'params'=>array(':type2'=>$type2),
			
		));
		foreach($models as $model)
			self::$_items[$type2][$model->code]=$model->name;
	}
        
        private static function loadNames($name)
	{
		self::$_names[$name]=array();
		$models=self::model()->findAll(array(
			'condition'=>'name=:name',
			'params'=>array(':name'=>$name),
			
		));
		foreach($models as $model)
			self::$_names[$name][$model->code]=$model->name;
	}

	
}