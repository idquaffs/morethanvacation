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
				echo "Name: " . $user_profile['name'];

			} catch(FacebookApiException $e) {

				$login_url = $facebook->getLoginUrl(Yii::app()->params['fb']['permission']); 
				echo '1 Please <a href="' . $login_url . '">login.</a>';
			}	  
		} else {
			// No user, print a link for the user to login
			$login_url = $facebook->getLoginUrl(Yii::app()->params['fb']['permission']);
			echo '2 Please <a href="' . $login_url . '">login.</a>';
		}
		exit;
		$zfb->go(Yii::app()->params['fb']['pageurl']);
		
		$this->render('index',array(
		));
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