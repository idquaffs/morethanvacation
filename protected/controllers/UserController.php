<?php

class UserController extends Controller
{
	public $layout = 'default';
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	public function actionProfile() {
		//echo "<pre>"; print_r( UserId::get() ); exit;
		$model = new User();
		$model = $model->findByPk(Yii::app()->user->id);
		if ( !empty($_POST) && isset($_POST['User']) ) {
			echo $model->ajaxUpdate($_POST['User'],Yii::app()->user->id);
			UserId::refresh();
			Yii::app()->end();
		}
		$this->render('profile',array(
			'profile'=>UserId::get(),
			'model'=>$model,
		));
	}
	# fb auth return url
	public function actionFblogin() {
		
		Yii::import('ext.zfb.Zfb');
		$fb = new Zfb(
			Yii::app()->params['fb']['appid'],
			Yii::app()->params['fb']['appsec']
		);
		
		# fb login ok
		if ( $profile = $fb->getUser() ) {
			
			$rs = Yii::app()->db->createCommand()
				->select('id')
				->from('user a')
				->where('fid=:fid', array(':fid'=>$profile['fid']))
				->queryRow();
			
			# has fid record - update and login
			if ($rs) {
				
				# what to update?
				#Yii::app()->db->createCommand()->update('user',$profile,'id=:id',array(':id'=>$rs['id']));
				$this->_loginWithEmail($profile['email']);
				Yii::app()->user->setFlash('success',"Authenticate Successfully");
				$this->redirect(Yii::app()->request->getUrlReferrer());

			# no fid record - signup or merge
			} else {
				
				$profile['is_activate'] = 1;
				$model = new User();
				$rs = $model->saveMe($profile,$profile['email'],array('fid','is_activate'));
				Fish::sSet('fbsignup',$profile);
				$this->redirect(array('/user/fbsignup'));
			}
			

		#user denied
		} else if ( isset($_GET['error_reason'] ) && $_GET['error_reason']=='user_denied' ) {

			Yii::app()->user->setFlash('error',"Authentication Failed");

		}
		$this->redirect(array('/home'));
	}
	
	public function actionFbsignup() {
		$profile 	= Fish::sGet('fbsignup');
		if (empty($profile)) {
			$this->redirect(array('/home'));
		}
		$user = Yii::app()->db->createCommand()
			->select('*')
			->from('user a')
			->where('a.fid=:id', array(':id'=>$profile['fid']))
			->queryRow();
		$model = new User;
		
		if ( !empty($_POST) ) {

			$data = array(
				'name'				=>$_POST['User']['name'],
				'dob'				=>$_POST['User']['dob'],
				'gender'			=>$_POST['User']['gender'],
				'contact_country'	=>$_POST['User']['contact_country'],
				'is_activate'		=>1,
				'is_subscriber'		=>1,
			);
			if (isset($_POST['User']['pwd'])) {
				$data['pwd'] 			= User::model()->hash($_POST['User']['pwd'],'pwd');
				$data['ip_create'] 		= Yii::app()->request->userHostAddress;
				$data['date_create'] 	= date('Y-m-d H:i:s');
			}
			$model->saveMe($data,$profile['email'],true);
			$this->_loginWithEmail($profile['email']);
			Yii::app()->user->setFlash('success',"Profile Update Successfully");
			$this->redirect(array('/home'));
		}
		$this->render('fbsignup',array(
			'profile'=>$profile,
			'user'	=>$user,
			'model'=>$model,
		));
	}

	public function actionLogin()
	{
		$this->pageTitle='Login';
		$model = new LoginForm;
		
		if (UserId::isLogin()) {
			Yii::app()->user->setFlash('success',"You have already login");
			$this->redirect(array('/home'));
		}
		
		if(isset($_POST['LoginForm']))
		{
			# match
			$rs = Yii::app()->db->createCommand()
				->select('email')
				->from('user a')
				->where('email=:email AND pwd=:pwd', array(':email'=>$_POST['LoginForm']['email'],':pwd'=>User::model()->hash($_POST['LoginForm']['pwd'],'pwd')))
				->queryRow();
			if (isset($rs['email'])) {
				$this->_loginWithEmail($rs['email']);
				Yii::app()->user->setFlash('success',"Login Successful");
				$this->redirect(Yii::app()->request->getUrlReferrer());
			} else {
				$model->email = $_POST['LoginForm']['email'];
				$model->addError('pwd','Email or password mismatch...');
			}
		}
		
		if (isset($_GET['email'])) {
			$model->email = $_GET['email'];
		}
		$this->render('login',array(
			'model'=>$model,
		));
	}
	
	public function actionSubscribe() {
		# subscribe
		if ( !empty($_POST) && isset($_POST['email']) && !empty($_POST['email']) &&
			filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
		) {
			
			$rs = $this->_subscribe($_POST['email']);
			# new go signup
			if ($rs['code']=='1') {
				Yii::app()->user->setFlash('success',"Just 2 minute to complete.");
				$this->redirect(array('/user/signup','email'=>$_POST['email']));
			# exist go login
			} else if($rs['code']=='2'){
				Yii::app()->user->setFlash('success',"Thanks for subscribe!");
				$this->redirect(array('/user/login','email'=>$_POST['email']));
			}
		} else {
			Yii::app()->user->setFlash('error',"Incorrect Email Address");
		}
		$this->redirect(Yii::app()->request->getUrlReferrer());
	}

	
	public function actionSignup() {
		
		$model = new User();

		# register
		if ( !empty($_POST) && isset($_POST['User']) ) {
			
			$data = array(
				'email' 	=> $_POST['User']['email'],
				'pwd'		=> User::model()->hash($_POST['User']['pwd'],'pwd'),
				'name'		=> $_POST['User']['name'],
				'gender'	=> $_POST['User']['gender'],
				'contact_country' => $_POST['User']['contact_country'],
				'dob'			=> $_POST['User']['dob'],
				'date_create'	=> date('Y-m-d H:i:s'),
				'ip_create'		=> Yii::app()->request->userHostAddress,
				'is_subscriber'	=>1,
			);
			$rs = $model->saveMe($data,$_POST['User']['email'],false);
			
			# new and nice
			if($rs['code']==1) {
				
				Yii::app()->user->setFlash('success',"Signup Successful");
				$this->redirect(array('/home'));
			
			# exist
			} else if ($rs['code']==-1) {
				
				# exist but new
				if ($rs['data']['pwd']=='') {
					$ow = array('pwd','name','gender','contact_country','dob','is_subscriber');
					$rs2 = $model->saveMe($data,$_POST['User']['email'],$ow);
					Yii::app()->user->setFlash('success',"Signup Successful");
					$this->redirect(array('/home'));

				# registered failed
				} else {
					$attr = array(
						'email' 	=> $_POST['User']['email'],
						'name'		=> $_POST['User']['name'],
						'gender'	=> $_POST['User']['gender'],
						'dob'		=>$_POST['User']['dob'],
						'contact_country' => $_POST['User']['contact_country'],
					);
					$model->attributes = $attr;
					$model->dobday = $_POST['User']['dobday'];
					$model->dobmonth = $_POST['User']['dobmonth'];
					$model->dobyear = $_POST['User']['dobyear'];
					$model->addError('email','This email address is already registered');
				}
				
			# unknown failed
			} else {
				
				$attr = array(
					'email' 	=> $_POST['User']['email'],
					'name'		=> $_POST['User']['name'],
					'gender'	=> $_POST['User']['gender'],
					'dob'		=>$_POST['User']['dob'],
					'contact_country' => $_POST['User']['contact_country'],
				);
				$model->attributes = $attr;
				$model->dobday = $_POST['User']['dobday'];
				$model->dobmonth = $_POST['User']['dobmonth'];
				$model->dobyear = $_POST['User']['dobyear'];
				Yii::app()->user->setFlash('error',"Unknown Error, Please Contact Administrator");
			}
			
		} else {
			if (isset($_GET['email'])) {
				$model->email = $_GET['email'];
			}
		}

		$this->render('signup',array('model'=>$model));
	}
	
	# key through email only
	public function actionResetPassword($email,$key) {
		$model = new User;
		$user = Yii::app()->db->createCommand()
			->select('*')
			->from('user a')
			->where('a.email=:email', array(':email'=>$email))
			->queryRow();
		if (
			$user && 
			$key == User::model()->hash($user['date_last_login'],'pwd')
		) {
			if ( !empty($_POST) && isset($_POST['User'] ) && 
				$_POST['User']['pwd'] == $_POST['User']['pwd2']
			) {
				Yii::app()->db->createCommand()
					->update('user',array(
						'pwd'=>User::model()->hash($_POST['User']['pwd'],'pwd'),
					),'email=:email',array(':email'=>$email));
				UserId::logout();
				Yii::app()->user->setFlash('success',"Password Reset Successful. Please Login");
				$this->redirect(array('/user/login'));
			}
		} else {
			Yii::app()->user->setFlash('error',"Link expired");
			$this->redirect(array('/home'));
		}
		$this->render('reset-pwd',array(
			'model'=>$model,
		));
	}
	public function actionPassword() {
		$model = new User;
		# request reset pwd email
		if ( !empty($_POST) && isset($_POST['User']) ) {
			# send request password email
			$user = Yii::app()->db->createCommand()
				->select('*')
				->from('user a')
				->where('a.email=:email AND a.dob=:dob', array(':email'=>$_POST['User']['email'],':dob'=>$_POST['User']['dob']))
				->queryRow();
			if ($user) {
				
				$key = User::model()->hash($user['date_last_login'],'pwd');
				$this->_emailResetPasswordLink($user['email'],$key);
				Yii::app()->user->setFlash('success',"An Email had sent to {$user['email']} reset login password.");
				$this->redirect(array('/user/login','email'=>$user['email']));
			} else {
				$model->attributes = $_POST['User'];
				Yii::app()->user->setFlash('error',"Email not found or details mismatch");
			}
			
		}
		$this->render('pwd',array(
			'model'=>$model,
		));
	}
	
	# key through email only
	public function actionUnsubscribe($email,$key) {
		
		if (
			!empty($email) &&
			$key = User::model()->hash($email,'newsletter')
		) {
			
			if ( !empty($_POST) && isset($_POST['unsubscribe']) ) {
				Yii::app()->db->createCommand()
					->update('user',array(
						'is_subscribe'=>'0',
					),'email=:email',array(':email'=>$email));
				$this->redirect(array('/home'));
			}
			$this->render('unsubscribe');
		}
	}
	
	# no view
	public function actionActivate($email,$key) {
		if (
			!empty($email) &&
			$key = User::model()->hash($email,'activate')
		) {
			Yii::app()->db->createCommand()
				->update('user',array(
					'is_activate'=>'1',
				),'email=:email',array(':email'=>$email));
			
			Yii::app()->user->setFlash('success',"Account Activated");
			$this->redirect(Yii::app()->request->getUrlReferrer());
		}
	}

	public function actionLogout()
	{
		UserId::logout();
		Yii::app()->user->setFlash('success',"Logout Successful, Thank you.");
		$this->redirect(Yii::app()->homeUrl);
	}
	private function _emailResetPasswordLink($email,$key) {
		$url = 'http://'.Yii::app()->request->getServerName().Yii::app()->request->baseUrl.Yii::app()->createUrl('/user/resetPassword',array('email'=>$email,'key'=>$key));
		echo "<pre>"; print_r( $url ); exit;
		#email send here
	}
	private function _subscribe($email) {
		
		$model = new User;
		$data = array(
			'is_subscriber'=>1,
			'email'=>$email,
			'is_subscriber'=>1,
			'ip_create'=>Yii::app()->request->userHostAddress,
			'date_create'=>date('Y-m-d H:i:s'),
		);
		$rs = $model->saveMe($data,$email,array('is_subscriber'));

		$result = array(
			'success'=>false,
			'code'=>-99,
		);

		# found record
		if ($rs['code']==3) {

			$result = array(
				'success'=>true,
				'code'=>1, // go to register
				'desc'=>'subscribe again',
			);

			# already register just go login
			if (!empty($rs['data']['pwd'])) {
				$result = array(
					'success'=>true,
					'code'=>2,
					'desc'=>'subscribed and registered',
				);
			}

		# new user
		} else if($rs['code']==1){
			
			if ($rs['success']) {
				$result = array(
					'success'=>true,
					'code'	=>1, // go to register
					'desc'	=>'subscribed to register'
				);
			}
		}
		return $result;
	}
	
	private function _loginWithEmail($email) {
		$profile = Yii::app()->db->createCommand()
			->select('*')
			->from('user a')
			->where('email=:email', array(':email'=>$email))
			->queryRow();
		Yii::app()->db->createCommand()
			->update('user',array(
				'date_last_login'=>date('Y-m-d H:i:s'),
				'ip_last_login'=>Yii::app()->request->userHostAddress,
			),'email=:email', array(':email'=>$email));
		
		UserId::login($profile['id']);
	}
}