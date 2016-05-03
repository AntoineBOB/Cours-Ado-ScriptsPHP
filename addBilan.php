<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array();

$idProf = $_GET["idProf"];
$idInscription = $_GET["idInscription"];
$idInscriptionProf = $_GET["idInscriptionProf"];
$idEleve = $_GET["idEleve"];
$dateSeance = $_GET["date"];
$dureeSeance = $_GET["duree"];
$startSeance = $_GET["start"];

$themesAvec_ = $_GET["themes"];
$themes = str_replace("_"," ",$themesAvec_);

$commentaireAvec_ = $_GET["commentaires"];
$commentaires = str_replace("_"," ",$commentaireAvec_);

$dateEnregistrement = date("y-m-d H:i:s");
$realDuree;
$realEnd;
$duree = date_create($dureeSeance);
if(date_format($duree,"i")=="15"){
	$realDuree = date_format($duree,"H").".25";
}
if(date_format($duree,"i")=="30"){
	$realDuree = date_format($duree,"H").".5";
}
if(date_format($duree,"i")=="45"){
	$realDuree = date_format($duree,"H").".75";
}



//$ajout = $db->insererBilan($idInscriptionProf,$idProf,$idInscription,$idEleve,$dateSeance,
//	$realDuree,$startSeance,/*$endSeance,*/$themes,$commentaires,$dateEnregistrement);

/*$response["message"] = "L'ajout n'a pas fonctionné";

echo json_encode($response);*/