<?php

class UserId
{
	public static function login($id) {
		$profile = Yii::app()->db->createCommand()
			->select('*')
			->from('user a')
			->where('a.id=:id', array(':id'=>$id))
			->queryRow();
		if ($profile) {
			self::setupProfile($profile);
			$ui = new UserIdentity($profile['email'], '');
			$ui->authenticate();
			Yii::app()->user->login($ui);
		}
	}
	
	public static function get($key=null) {
		if ($key==null) {
			return Fish::sGet('user');
		} else {
			return Fish::xr(Fish::sGet('user'),$key);
		}
	}
	
	public static function refresh() {
		$profile = Yii::app()->db->createCommand()
			->select('*')
			->from('user a')
			->where('a.id=:id', array(':id'=>UserId::get('id')))
			->queryRow();
		Fish::sSet('user',$profile);
	}
	
	public static function logout() {
		Yii::app()->user->logout(false);
		Fish::sDel('user');
	}
	public static function isLogin() {
		return Fish::sHas('user');
	}
	

	/**
	 * setup Role
	 */
	public static function setupProfile($profile) {

		$profile['isDev'] 				= ($profile['is_dev']=='1');
		$profile['isSuper'] 			= ($profile['is_super']=='1');
		$profile['isAdmin'] 			= ($profile['is_admin']=='1');
		$profile['isEditor'] 			= ($profile['is_editor']=='1');
		$profile['isMember'] 			= ($profile['pwd']!=='');
		$profile['isActivate'] 			= ($profile['is_activate']=='1');
		$profile['isBanned'] 			= ($profile['is_ban']==='1');
		$profile['isPremium'] 			= (strtotime($profile['is_premium']) >= time());
		$profile['isVIP'] 				= (strtotime($profile['is_vip']) >= time());
		$profile['canAccessPremium'] 	= ($profile['isPremium']||$profile['isVIP']);
		$profile['canAccessAdmin'] 		= ($profile['is_dev']||$profile['is_super']||$profile['is_admin']||$profile['is_editor']);
		Fish::sSet('user',$profile);
	}
	
}