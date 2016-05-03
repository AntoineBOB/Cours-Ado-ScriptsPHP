<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$response = array("error" => FALSE);

$idProf = $_GET["idProf"];
$liste=$db->getListeEleveProf($idProf);
if($liste->num_rows !=0){
	$response["eleve"] = array();
	$compteur=0;
	foreach ($liste as $l) {
		array_push($response["eleve"], $l);
	}
	echo json_encode($response);
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "Le professeur n'as aucun eleve";
    echo json_encode($response);
}