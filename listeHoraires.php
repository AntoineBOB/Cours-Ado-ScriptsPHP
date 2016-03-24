<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array('reponse'=>false);
$idInscription = $_GET['idInscription'];
$idProf = $_GET['idProf'];

$horaires = $db->ListeHoraires($idInscription,$idProf);
if($horaires->num_rows>0){
	$response["reponse"]=true;
	$response["date_debut"]= array();
	foreach ($horaires as $h) {
		array_push($response["date_debut"],$h);
	}
}
echo json_encode($response);
var_dump($response);

