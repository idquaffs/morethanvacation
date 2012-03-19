<?php

class SiteController extends Controller
{
	public $layout = 'default';
	public function actions()
	{
		return array(
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		Yii::import('ext.zfb.Zfb');
		$zfb = new Zfb(
			Yii::app()->params['fb']['appid'],
			Yii::app()->params['fb']['appsec']
		);
		
		$facebook = $zfb->fb;
		
		$user_id = $facebook->getUser();
		
		if($user_id) {

			try {

				$user_profile = $facebook->api('/me','GET');
//				echo "Name: " . $user_profile['name'];

			} catch(FacebookApiException $e) {
				$this->pageTitle = 'First Page';
				$login_url = $facebook->getLoginUrl(Yii::app()->params['fb']['permission']); 
				$this->render('login_url',array('login_url',$login_url));
				exit;
			}
		} else {
			// No user, print a link for the user to login
			$this->pageTitle = 'First Page';
			$login_url = $facebook->getLoginUrl(Yii::app()->params['fb']['permission']);
			$this->render('login_url',array('login_url',$login_url));
			exit;
		}
		
		if ( !empty($_POST) ) {
			$this->render('success');
			exit;
		}
		$this->render('form',array(
			'user_profile'=>$user_profile,
		));
		exit;
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		$this->layout = 'default-error';
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	public function actionStatic($id)
	{
		$result = Yii::app()->db->createCommand()
			->select('*')
			->from('navigation a')
			->where('a.id=:id', array(':id'=>$id))
			->queryRow();
		$this->render('static',array(
			'result'=>$result,
		));
	}

}