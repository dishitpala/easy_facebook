<?php
if(!session_id()){
    session_start();
}
require_once 'easy_facebook.php';
/*
 * Configuration and setup Facebook SDK
 */
$facebook = new easy_facebook(array(
    'app_id' => '436236276867765', //Facebook App ID
    'app_secret' => 'ce8cc318069e1388e8d22c3686a079f8', //Facebook App Secret
    'default_graph_version' => 'v2.10', //Graph version
));

// Oprations on Facebook SDK
 
$facebook -> permissions(['email','user_photos']); //permission must be in array
$facebook -> redirect_url('https://localhost/facebook/resources/library/facebook-sdk/main.php'); //url in which page redirect after login
$facebook -> facebook_helper(); // return redirect login helper
$facebook -> access_token();
//$facebook -> logout('config.php');
?>