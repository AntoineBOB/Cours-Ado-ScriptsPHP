<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$response = array();
$codeBarre = $_GET["codeBarre"];

$ticket = $db->getTicket($codeBarre);

if ($ticket == null && $codeBarre!= null) {
	//Si le ticket est valide
	$billet = $db->getInformationTicket($codeBarre);
	$idInscription = $billet["idInscription"];
	$numeroBon = $billet["numeroBon"];
	$db->saisirTicket($idInscription,$numeroBon);
	$response["message"]="Le ticket a bien été saisi";
	echo json_encode($response);
}
else{
	$response["message"]="Le ticket à déjà été saisi, il est impossible de le saisir a nouveau";
	echo json_encode($response);
}