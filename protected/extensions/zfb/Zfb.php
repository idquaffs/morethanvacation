<?php
require 'src/facebook.php';

class Zfb {
	
	public $fb;
	public $user;
	public $user_profile;
	
	function zfb($appid,$appsec) {
		$this->fb = new Facebook(array(
		  'appId'  => $appid,
		  'secret' => $appsec,
		));
	}
	
	public function getUser() {
		
		$this->user 		= $this->fb->getUser();
		$this->user_profile = false;
		if ($this->user) {
			try {
				$tmp_profile = $this->fb->api('/me');
				$this->user_profile = array(
					'fid'			=>$tmp_profile['id'],
					'name'			=>$tmp_profile['name'],
					'email'			=>$tmp_profile['email'],
				);
				if (isset($tmp_profile['gender'])) {
					$this->user_profile['gender'] = ($tmp_profile['gender']=='male')?'M':'F';
				}
				if (isset($tmp_profile['birthday'])) {
					$dobarray = explode('/',$tmp_profile['birthday']);
					$this->user_profile['dob'] = $dobarray[2].'-'.$dobarray[0].'-'.$dobarray[1];
				}
				
			} catch (FacebookApiException $e) {
				Fish::log('zfb.getUser',$e->getMessage());
			}
		}
		return $this->user_profile;
	}
	
	public function loginUrl($permission) {
		return $this->fb->getLoginUrl($permission);
	}
	
	public function logoutUrl() {
		if ($this->user)
			return $this->fb->getLogoutUrl();
		return false;
	}
	
	public function go($url) {
		echo("<script> top.location.href='" . $url . "'</script>");
		exit;
	}
}

?>