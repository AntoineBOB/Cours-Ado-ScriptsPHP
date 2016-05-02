<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array();

$idProf = $_GET["idProf"];
$idInscription = $_GET["idInscription"];
$idInscriptionProf = $_GET["idInsProf"];
$idEleve = $_GET["idEleve"];
$dateSeance = $_GET["date"];
$dureeSeance = $_GET["durée"];
$startSeance = $_GET["start"];
$endSeance = $_GET["end"];
$themes = $_GET["themes"];
$commentaire = $_GET["commentaires"];
$idRDV = $_GET["idRDV"];
$dateEnregistrement = $_GET["dateEnregistrement"];

$ajout = $db->insererBilan($idInscriptionProf,$idProf,$idInscription,$idEleve,$dateSeance,
	$dureeSeance,$startSeance,$endSeance,$themes,$commentaire,$idRDV,$dateEnregistrement);

if($ajout==NULL){
	$response["message"] = "L'ajout n'a pas fonctionné";
}
else{
	$response["message"] = "Le bilan à été ajouté";
}