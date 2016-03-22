<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);

$idProf = $_GET["idProf"];
$idEleve = $_GET["idEleve"];
$liste=$db->getListeCours($idEleve, $idProf);
if($liste->num_rows !=0){
	$response["Cours"] = array();
	foreach ($liste as $l) {
		array_push($response["Cours"], $l);
	}
		
	
	echo json_encode($response);
	var_dump($response);
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "L'eleve n'as aucun cours";
    echo json_encode($response);
}
