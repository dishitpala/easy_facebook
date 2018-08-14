<?php

// Include the autoloader provided in the SDK
require_once __DIR__ . '/Facebook/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

class easy_facebook extends Facebook{
	
	public $permission,$url,$facebook_helper;
	protected $access_token;
	
	function facebook_helper(){
		$this->facebook_helper = $this->getRedirectLoginHelper();
		return  $this->facebook_helper;
	}
	function permissions($permission){
		return $this->permission = $permission;
	}
	function redirect_url($url){
		return $this->url = $url;
	}
	function login(){
		return $this->facebook_helper->getLoginUrl($this->url,$this->permission);
	}
	function access_token(){
		
		// Try to get access token
		try {
			if(isset($_SESSION['Facebook_Token'])){
				$access_token = $_SESSION['Facebook_Token'];
				
				$this->access_token = $access_token;
			}else{
				$access_token = $this->facebook_helper->getAccessToken();
				$this->access_token = $access_token;
			}
		} catch(FacebookResponseException $e) {
			 echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
		} catch(FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
		}
		if (isset($this->access_token)){
		
				if(isset($_SESSION['Facebook_Token'])){
					$this->setDefaultAccessToken($_SESSION['Facebook_Token']);
				}else{
					// Put short-lived access token in session
					$_SESSION['Facebook_Token'] = (string) $this->access_token;
					
					  // OAuth 2.0 client handler helps to manage access tokens
					$oAuth2Client = $this->getOAuth2Client();
					
					// Exchanges a short-lived access token for a long-lived one
					$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['Facebook_Token']);
					$_SESSION['Facebook_Token'] = (string) $longLivedAccessToken;
					
					// Set default access token to be used in script
					$this->setDefaultAccessToken($_SESSION['Facebook_Token']);
				}
		}else{
			return '<a href="' . $this->login() . '">Login with Facebook</a>';
		}

	}
	
	
	function query_data($query){
	
	    if (isset($this->access_token) && isset($_SESSION['Facebook_Token'])){
		
				$url = "https://graph.facebook.com/v2.6/me?fields=".$query."&access_token={$this->access_token}";
				$headers = array("Content-type: application/json");
				
					 
				 $ch = curl_init();
				 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				 curl_setopt($ch, CURLOPT_URL, $url);
					 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
				 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
				 curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
				 curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
				 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
				 curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
				 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
				 
				 $st=curl_exec($ch); 
				 $result=json_decode($st,true);
				 $json = json_encode($result,JSON_PRETTY_PRINT);
				 return "<pre>".print_r($json,true)."</pre>";
				 
		} else {
			
			return '<a href="' . $this->login() . '">Login with Facebook</a>';
		}
	}
	
	function logout($to_redirect){
		// Remove access token from session
		unset($_SESSION['Facebook_Token']);

		// Redirect to the homepage
		header("Location:".$to_redirect);
	}

}


?>