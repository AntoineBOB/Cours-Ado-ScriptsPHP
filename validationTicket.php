<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array

$response = array("error" => FALSE);
$codeBarre = $_GET["codeBarre"];

// get the user by email and password
$ticket = $db->getTicket($codeBarre);

if ($ticket == null) {
	$codeBarreExist = $db->codeBarreExists($codeBarre);
	if($codeBarreExist->num_rows>0){
	    $response["error"] = FALSE;
	    $response["message"]= "Le ticket est valide";
	}
	else{
		$response["error"]=TRUE;
    	$response["error_msg"] = "Le ticket n'existe pas";
	}
}
else{
    $response["error"]=TRUE;
    $response["error_msg"] = "Le ticket a déjà été validé";
}
echo json_encode($response);
?>