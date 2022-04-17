<?php 
//sigin with google
//author dadanhidayats
require "Google/autoload.php";

$google_client = new Google_Client();
$google_client->setClientId('679398728316-kd93iq6m079jpn72u48t53bosbr224ic.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri("http://localhost/belajar-php/dadan/google-auth.php");
//add scope
$google_client->addScope("email");
$google_client->addScope("profile");

session_start();
$service = new Google_Service_Oauth2($google_client);
if( isset($_GET['code']) ) {
	$google_client->authenticate($_GET['code']);
	$token = $google_client->getAccessToken($_GET['code']);
	$_SESSION['accsess_token'] = $token;
	header("location:http://localhost/belajar-php/dadan/google-auth.php");
	exit;
}

if(isset($_SESSION['accsess_token']) && !empty($_SESSION['accsess_token'])){
	$google_client->setAccessToken($_SESSION['accsess_token']);
	$userinfo = $service->userinfo->get();
	$nama = $userinfo['name'];
	$email = $userinfo['email'];
	$picture = $userinfo['picture'];
	echo $nama."<br>";
	echo $email;
	?>
	<img src="<?= $picture ?>" alt="">
	<?php

	echo "<pre>";
	var_dump($userinfo);
	?><?php

}else{
echo ' <a href="'.$google_client->createAuthUrl().'">Signin with gogle</a>';
}

