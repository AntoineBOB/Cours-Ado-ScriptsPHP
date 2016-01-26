<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);

$idProf = $_GET["idProf"];
//$idProf="4186";
$liste=$db->getListeEleveProf($idProf);

if($liste->num_rows !=0){
	$response["eleve"] = array();
	foreach ($liste as $l) {
		array_push($response["eleve"],$l);
	}
	echo json_encode($response);
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "Le professeur n'as aucun eleve";
    echo json_encode($response);
}