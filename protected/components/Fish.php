<?php
//
//  Fish
//
//  Created by Elliot Yap on 2011-09-06.
//  Copyright (c) 2011 __MyCompanyName__. All rights reserved.
//

class Fish {

	public static function xr($arr,$key) {
		return isset($arr[$key]) ? $arr[$key] : false ;
	}
	
	# yii session
	public static function sAdd($key,$aval,$akey=null) {
		if (!isset(Yii::app()->session[$key])) 
			Yii::app()->session[$key] = array();
		if (!is_array(Yii::app()->session[$key]))
			Yii::app()->session[$key] = array();
		$rs = Yii::app()->session[$key];
		if ($akey!==null) 
			$rs[$akey] = $aval;
		else
			$rs[] = $aval;
		Yii::app()->session[$key] = $rs;
	}
	public static function sGet($key,$akey=null) {
		if (isset(Yii::app()->session[$key]) ) {
			if ($akey===null) {
				return Yii::app()->session[$key];
			} else {
				return isset(Yii::app()->session[$key][$akey]);
			}
		}
		return false;
	}
	public static function sSet($key,$aval) {
		Yii::app()->session[$key] = $aval;
	}
	public static function sDel($key,$akey=null) {
		if ($akey===null) {
			unset(Yii::app()->session[$key]);
		} else {
			$rs = Yii::app()->session[$key];
			unset($rs[$akey]);
			Yii::app()->session[$key] = $rs;
		}
	}
	public static function sHas($key,$akey=null) {
		if (isset(Yii::app()->session[$key]) ) {
			if ($akey===null) {
				return true;
			} else {
				return isset(Yii::app()->session[$key][$akey]);
			}
		}
		return false;
	}
	
	public static function getRow($table,$id,$flush=false){
		
		if (!empty($id)) {
			$result = self::__getSessionOrDb($table,$flush);
			if (isset($result[$id])) {
				return $result[$id];
			}
			return false;
		}
		return false;
	}
	
	public static function getList($table,$valcol,$flush=false,$default='-SELECT-'){
		
		$result = self::__getSessionOrDb($table,$flush);
		$list = array(''=>$default);
		foreach ($result as $key => $row) $list[$row['id']] = $row[$valcol];
		return $list;
	}
	
	public static function getListDetails($table,$flush=false){
		
		$result = self::__getSessionOrDb($table,$flush);
		foreach ($result as $key => $row) $list[$row['id']] = $row;
		return $list;
	}
	
	public static function log($c1,$c2='',$c3='') {
		Yii::app()->db->createCommand()
			->insert('log',array(
				'c1'=>$c1,
				'c2'=>$c2,
				'c3'=>$c3,
				'date_create'=>date('Y-m-d H:i:s'),
			));
		
	}
	
	public static function select($arr,$label='') {
		return array(''=>$label)+$arr;
	}
	public static function selectdate($name,$type='') {
		# month
		$months = array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December');
		$optionMonth = '<option value=""> Month </option>';
		foreach ($months as $key => $row)
			$optionMonth .= '<option value="'.$key.'">'.$row.'</option>';

		# day
		$optionDay = '<option value=""> Day </option>';
		for ($i=1; $i <= 31; $i++)
			$optionDay .= '<option value="'.$i.'">'.$i.'</option>';

		# year
		$optionYear = '<option value=""> Year </option>';
		for ($i=date('Y'); $i > date('Y',strtotime('-100 years')); $i--)
			$optionYear .= '<option value="'.$i.'">'.$i.'</option>';
			
		return 	'<select name="'.$name.'[month]" class="selectdate month" style="" >'.$optionMonth.'</select>'.
				'<select name="'.$name.'[day]"   class="selectdate day"   style="" >'.$optionDay.'</select>'.
				'<select name="'.$name.'[year]"  class="selectdate year"  style="" >'.$optionYear.'</select>';
	}
	
	public static function date($key) {
		if ($key=='day') {
			$d = array();
			for ($i=1; $i <= 31; $i++) $d[$i] = $i;
			return $d;
		}
		if ($key=='month') {
			return array('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December');
		}
		if ($key=='year') {
			$y = array();
			$to = date('Y',strtotime('-150 years'));
			for ($i=date('Y'); $i > $to; $i--)
				$y[$i] = $i;
			return $y;
		}
	}
	public static function slug($input) {
		$from = array(
			'/[^a-zA-Z0-9\-_]/',
			'/--+/',
			'/__+/',
			'/^-|^_/'
		);
		$to = array(
			'-',
			'-',
			'_',
			''
		);
		return strtolower(preg_replace($from, $to, $input));
	}
	
	private static function __getSessionOrDb($table,$flush) {
		$flush = true;
		$result = Yii::app()->session->get($table.'list');
		if ( empty($result) || $flush ) {
			$result = array();
			$rs = Yii::app()->db->createCommand('SELECT * FROM '.$table)->queryAll();
			foreach ($rs as $row) {
				$result[$row['id']] = $row;
			}
			Yii::app()->session->add($table.'list',$result);
		}
		return $result;
	}
}