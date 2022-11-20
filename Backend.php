<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
date_default_timezone_set("UTC");
$final = array("Status"=>"ERROR", "Message"=>"Unknown Command !");

//////////////////////////////////DATABASE/////////////////////////////////
define('db_user','root');
define('db_pass','');
define('db_name','mydatabase');
///////////////////////////////////////////////////////////////////////////

//////////////////////////////////SETTINGS/////////////////////////////////
$jwt_issuer = "https://yourdomain.com";
$jwt_key = 'your-secret-key';
$request_pw_intime = 30;
$pw_validity_period = 3600;
$jwt_validity_period = 604800;
$defaultAvatar64 = "data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAABGAAD/4QMraHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDYtMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3M";
$defaultAvatar64 .= "pIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjdCOUNGMTdBNjc3QzExRUQ5NkY4RDcyMDZDODRBMjEwIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjdCOUNGMTdCNjc3QzExRUQ5NkY4RDcyMDZDODRBMjEwIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6N0I5Q0YxNzg2NzdDMTFFRDk2RjhENzIwNkM4NEEyMTAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6N0I5Q0YxNzk2NzdDMTFFRDk2RjhENzIwNkM4NEEyMTAiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz7/7gAOQWRvYmUAZMAAAAAB/9sAhAAEAwMDAwMEAwMEBgQDBAYHBQQEBQcIBgYHBgYICggJCQkJCAoKDAwMDAwKDAwNDQwMEREREREUFBQUFBQUFBQUAQQFBQgHCA8KCg8UDg4OFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCABAAEADAREAAhEBAxEB/8QAbwABAAEFAQEAAAAAAAAAAAAAAAgBBAUGCQcDAQEAAAAAAAAAAAAAAAAAAAAAEAABAwMDAwIDBwUAAAA";
$defaultAvatar64 .= "AAAABAgMEEQUGACEHMUESEwhRIhRhMkJSYnIVkSNjJBYRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/aBoGgaBoGgaBoGgw2WTMht+O3CfisFm536K0XodukLU0iQpG5bC018VKFfHanlQH4gImWL3yzHMhh27KsUZtlpVIDFzktPurfjIJ8VL9NTYr4HdSetAe+gmQw+xKYalRnEvRnkJcZebIUhaFiqVJI2IINQdB858+FaoMm53F9Ea3w2lyJUl0+KG2mklSlKPYACughvcvfNdHL7IgYxh7Vwt65BYta3X3UypCCrxbJaQ2qil7UQK9aaCXmNyL5LsUCVkkVmDfH2UuzoUZanGmHFipbC1UKimviT0r020GU0DQNBBr3icIizz1crYxFCbXPcCcljtDZmW4aJkhI6JdJo5+uh/GdBtXs45r/AJOEnibI5FZ8FCnMafcJJdjIqpcYk92h8zf6Kj8I0GE943N31Dq+I8YkkNMqSvKJLR2WsALREBHUJ2W79tE9lDQU9nPCP1TyOXMnjf6zClIxeM6Nlupqhcsg9kGqGv1VV2SdBNfQNA0DQWd1tVvvlsl2e7R0S7ZPZXGlxnR5IcadSUqSR9oOg5i8s8e5DwHyWhu1ynWmWnU3PF7wjZZZSuqanceo0oeCwevWnioaCvBvFVy5q5AESc64bLGX/IZLcFKJcLS1klAV19V5VUg9t1b0oQ6eW+3wrTAjW";
$defaultAvatar64 .= "u2sIjW+E0iPFjtiiG2mkhKEpHwAFNBc6BoGgaDEZTk1mw3Hrhk+QSBFtFsZU/JdV1oNkpSO6lqISlI3KiBoOX+bZXlvPXJpmNR1ybnd30wbHa26qDEbyIaaHYBIJW4vpXyUaDQXmC5blft45UdXMZWiTa3127IbWD8kmL5DzSkmlagB1lf7T90modOcev8AacpskDIrHITLtNyZRJiPp/EhYrQjsoHZSTuDUHfQZLQNA0DQc+fdrzd/3GQnAsckE4pYXiJrzavkm3BFUqOxoptr7qPiryVuPHQeve0HhA4vaE8m5NGKMhuzRFljuAeUaA4B/dI7OPD+iP3EaCnvC4V/6Syq5Px1jyv1maCb2w2N5FvbqfVoButjv/jr+UDQeYe0Pm8YnehxtksgIxy8u1tEh1VExbg4aenU9EPnb7F0/Mo6CfGgaBoNJ5WtOfX/AAydYuOZUG3324j6Z243B55gR4rgIcUyWGXj6pHyp2HjXyBqBoIv8ceyfIbZl9vufIlwtM/GISvXft8B2S85JcRQoaWHo7KQ2Tuv5jUDxpvUBNVKUoSEpASlIolI2AA7DQUWhDiFNuJC21gpWhQqCDsQQeoOghPyB7JcnnZdcblx9c7TCxiU59RDhT3ZLL0ZS/mU0kMx3klCVfcPlXx2ptUhKzjSBnVpw+BauRZMKdksFP07lwtzrrrchlugbcc9ZplQcpsvYgkeVd6ANu0DQNA0DQNA0DQNB//Z";
$random_avatar = true;
///////////////////////////////////////////////////////////////////////////

//////////////////////////////////ENDPOINTS////////////////////////////////
if(isset($_GET['newAuth'])){
	$email = $_GET['e'];
	$currentTime = time();
	$newUniqKey = md5(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10));
	$conn = mysqli_connect("localhost", db_user, db_pass, db_name);
	$conn->set_charset("utf8mb4");
	$records = $conn->query("SELECT * FROM vi_auth WHERE email='".$email."'");
	if(mysqli_num_rows($records)){
		$user = $records->fetch_all(MYSQLI_ASSOC);
		$createdAt = intval($user[0]['createdAt']);
		if($currentTime>$createdAt+$request_pw_intime){
			if ($conn->query("DELETE FROM vi_auth WHERE id=".$user[0]['id']) === TRUE){
				if ($conn->query("INSERT INTO vi_auth (email,password,createdAt) VALUES ('".$email."','".$newUniqKey."','".$currentTime."')") === TRUE){
					require 'Extras/EMAIL.php';
					$newMail = new EMAIL($email,"USER LOGIN","Member Login Informations<br/>Password: ".$newUniqKey."<br/><a href='https://yourdomain.com/login/".$newUniqKey."'>https://yourdomain.com/login/".$newUniqKey."</a><br/>The validity period of the password is <b>".$pw_validity_period."</b> seconds!");
					$aaa = $newMail->send();
					if($aaa['Status']=="SUCCESS"){
					$final = array("Status"=>"SUCCESS","Message"=>"You can log in by clicking the link sent to your e-mail address.");
					}else{
					$final = array("Status"=>"ERROR","Message"=>$aaa['Message']);
					}
				}else{
					$final = array("Status"=>"ERROR","Message"=>$conn->error);
				}
			}
		}else{
			$kalanSure = ($createdAt+$request_pw_intime)-$currentTime;
			$final = array("Status"=>"ERROR","Message"=>"Wait ".strval($kalanSure)." seconds to request a password again!");
		}
	}else{
		if ($conn->query("INSERT INTO vi_auth (email,password,createdAt) VALUES ('".$email."','".$newUniqKey."','".$currentTime."')") === TRUE){
			require 'Extras/EMAIL.php';
			$newMail = new EMAIL($email,"USER LOGIN","Member Login Informations<br/>Password: ".$newUniqKey."<br/><a href='https://yourdomain.com/login/".$newUniqKey."'>https://yourdomain.com/login/".$newUniqKey."</a><br/>The validity period of the password is <b>".$pw_validity_period."</b> seconds!");
			$aaa = $newMail->send();
			if($aaa['Status']=="SUCCESS"){
			$final = array("Status"=>"SUCCESS","Message"=>"You can log in by clicking the link sent to your e-mail address.");
			}else{
			$final = array("Status"=>"ERROR","Message"=>$aaa['Message']);
			}
		}else{
			$final = array("Status"=>"ERROR","Message"=>$conn->error);
		}
	}
	mysqli_close($conn);
}
if(isset($_GET['userLogin'])){
	require 'Extras/JWT.php';
	require 'Extras/Key.php';
	$password = $_GET['p'];
	$currentTime = time();
	$conn = mysqli_connect("localhost", db_user, db_pass, db_name);
	$conn->set_charset("utf8mb4");
	$records = $conn->query("SELECT * FROM vi_auth WHERE password='".$password."'");
	if(mysqli_num_rows($records)){
		$authDatas = $records->fetch_all(MYSQLI_ASSOC);
		$createdAt = intval($authDatas[0]['createdAt']);
		$email = $authDatas[0]['email'];
		if($currentTime<$createdAt+$pw_validity_period){
			if ($conn->query("DELETE FROM vi_auth WHERE id=".$authDatas[0]['id']) === TRUE){
				$user = $conn->query("SELECT * FROM vi_users WHERE email='".$email."'");
				if(mysqli_num_rows($user)){
					$userDatas = $user->fetch_all(MYSQLI_ASSOC);
					$payload = [
						'iss' => $jwt_issuer,
						'exp' => time() + $jwt_validity_period,
						'email'=> $email
					];
					$jwt = Firebase\JWT\JWT::encode($payload, $jwt_key, 'HS256');
					if ($conn->query("UPDATE vi_users SET lastLogin = '".date("Y-m-d H:i:s", substr($currentTime, 0, 10))."', jwToken = '".$jwt."' WHERE id = ".$userDatas[0]['id']) === TRUE){
						$final = array("Status"=>"SUCCESS","Message"=>$jwt);
					}else{
						$final = array("Status"=>"ERROR","Message"=>$conn->error);
					}
				}else{
					if($random_avatar){
					$temp_img = file_get_contents("https://avatars.dicebear.com/api/human/".$email.".jpg?size=64");
					if ($temp_img !== false){
						$defaultAvatar64 = 'data:image/jpg;base64,'.base64_encode($temp_img);
					}
					}
					$name = "User".substr(str_shuffle("0123456789"), 0, 7);
					$payload = [
						'iss' => $jwt_issuer,
						'exp' => time() + $jwt_validity_period,
						'email'=> $email
					];
					$jwt = Firebase\JWT\JWT::encode($payload, $jwt_key, 'HS256');
					$sql = "INSERT INTO vi_users (name,email,avatar,lastLogin,jwToken) VALUES ('".$name."','".$email."','".$defaultAvatar64."','".date("Y-m-d H:i:s", substr($currentTime, 0, 10))."','".$jwt."')";
					if ($conn->query($sql) === TRUE){
						$final = array("Status"=>"SUCCESS","Message"=>$jwt);
					}else{
						$final = array("Status"=>"ERROR","Message"=>$conn->error);
					}
				}
			}
		}else{
			if ($conn->query("DELETE FROM vi_auth WHERE id=".$authDatas[0]['id']) === TRUE){
				$final = array("Status"=>"ERROR","Message"=>"The key you entered has expired!");
			}
		}
	}else{
		$final = array("Status"=>"ERROR","Message"=>"The key you entered was not found in the system!");
	}
	mysqli_close($conn);
}
if(isset($_GET['userLogout'])){
	$token = $_GET['t'];
	require 'Extras/JwtKontrol.php';
	$results = jwtCheck($token,$jwt_key);
	if($results["Status"]=="SUCCESS"){
		$conn = mysqli_connect("localhost", db_user, db_pass, db_name);
		$conn->set_charset("utf8mb4");
		if ($conn->query("UPDATE vi_users SET jwToken = '' WHERE email = '".$results["email"]."'") === TRUE){
			$final = array("Status"=>"SUCCESS","Message"=>"Session closed successfully");
		}else{
			$final = array("Status"=>"ERROR","Message"=>$conn->error);
		}
		mysqli_close($conn);
	}else{
		$final = array("Status"=>"ERROR","Message"=>"Token Error: ".$results["Exception"]);
		if($results["Exception"]=="Class 'ExpiredException' not found"){
			$final = array("Status"=>"ERROR","Message"=>"Expired sessions cannot be closed!");
		}
	}
}
if(isset($_GET['getMyData'])){
	$token = $_GET['t'];
	$currentTime = time();
	require 'Extras/JwtKontrol.php';
	$results = jwtCheck($token,$jwt_key);
	if($results["Status"]=="SUCCESS"){
		$conn = mysqli_connect("localhost", db_user, db_pass, db_name);
		$conn->set_charset("utf8mb4");
		$user = $conn->query("SELECT * FROM vi_users WHERE email='".$results["email"]."'");
		if(mysqli_num_rows($user)){
			$userDatas = $user->fetch_all(MYSQLI_ASSOC);
			if($userDatas[0]['jwToken']==$token){
				$validAt = floor((intval($results["exp"])-$currentTime)/3600);
				$final = array("Status"=>"SUCCESS","Message"=>"The key used is still valid.","ValidAt"=>$validAt,"Id"=>$userDatas[0]['id'],"Name"=>$userDatas[0]['name'],"Email"=>$userDatas[0]['email'],"Avatar"=>$userDatas[0]['avatar'],"Permission"=>$userDatas[0]['perm'],"Birthday"=>$userDatas[0]['birth'],"Total Messages"=>$userDatas[0]['totalMsg']);
			}else{
				$removeToken = $conn->query("UPDATE vi_users SET jwToken = '' WHERE id = ".$userDatas[0]['id']);
				$final = array("Status"=>"ERROR","Message"=>"Token Error: Sign in again!");
			}
		}else{
			$final = array("Status"=>"ERROR","Message"=>"Token Error: Token owner not found!");
		}
		mysqli_close($conn);
	}else{
		$final = array("Status"=>"ERROR","Message"=>"Token Error: ".$results["Exception"]);
		if($results["Exception"]=="Class 'ExpiredException' not found"){
			$final = array("Status"=>"ERROR","Message"=>"The session has expired!");
		}
	}
}

echo json_encode($final);
?>