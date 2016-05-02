<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$response = array("error" => FALSE);

$idProf = $_GET["idProf"];
$idInscriptionProf=$_GET["idInscriptionProf"];
$idInscription=$_GET["idInscription"];
$idEleve=$_GET["idEleve"];
//idProf="4186";
$liste=$db->getListeBilan($idInscriptionProf, $idProf,$idEleve,$idInscription);
if($liste->num_rows !=0){
	$response["Bilans"] = array();
	$compteur=0;
	foreach ($liste as $l) {
		array_push($response["Bilans"], $l);
	}
	echo json_encode($response);
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "Le professeur n'as aucun bilan";
    echo json_encode($response);
}