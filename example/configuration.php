<?php
if(!session_id()){
    session_start();
}
require_once 'easy_facebook.php';
/*
 * Configuration and setup Facebook SDK
 */
$facebook = new easy_facebook(array(
    'app_id' => 'app_id', //Facebook App ID
    'app_secret' => 'app_secret', //Facebook App Secret
    'default_graph_version' => 'v2.10', //Graph version
));

// Oprations on Facebook SDK
 
$facebook -> permissions(['permissions']); //permission must be in array
$facebook -> redirect_url('redirect_url'); //url in which page redirect after login
$facebook -> facebook_helper(); // return redirect login helper
$facebook -> access_token();
//$facebook -> logout('config.php');
?>
