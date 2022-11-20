<?php
require 'JWT.php';
require 'Key.php';
function jwtCheck($receivedToken,$receivedKey)
{
	$finalReturn=array("Status"=>"ERROR", "Exception"=>"Unknown Error");
	try{
		$anahtar = new Firebase\JWT\Key($receivedKey, 'HS256');
		$decoded = Firebase\JWT\JWT::decode($receivedToken, $anahtar);
		$finalReturn = (array)$decoded;
		$finalReturn["Status"]="SUCCESS";
	}catch(Error $a){
		$finalReturn = array("Status"=>"ERROR", "Exception"=>$a->getMessage());
	}catch(DomainException $b){
		$finalReturn = array("Status"=>"ERROR", "Exception"=>$b->getMessage());
	}catch(UnexpectedValueException $c){
		$finalReturn = array("Status"=>"ERROR", "Exception"=>$c->getMessage());
	}catch(Exception $d){
		$finalReturn = array("Status"=>"ERROR", "Exception"=>$d->getMessage());
	}catch(InvalidArgumentException $e){
		$finalReturn = array("Status"=>"ERROR", "Exception"=>$e->getMessage());
	}catch(ExpiredException $e){
		$finalReturn = array("Status"=>"ERROR", "Exception"=>$e->getMessage());
	}
	return $finalReturn;
}
?>