<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$response = array();
$codeBarre = $_GET["codeBarre"];

$ticket = $db->getTicket($codeBarre);
$codeBarreExist = $db->codeBarreExists($codeBarre);

if ($ticket == null ){
	//Si le ticket est valide
	if($codeBarre!=null){
		if($codeBarreExist->num_rows>0){
			$billet = $db->getInformationTicket($codeBarre);
			$idInscription = $billet["idInscription"];
			$numeroBon = $billet["numeroBon"];
			$db->saisirTicket($idInscription,$numeroBon);
			$response["message"]="Le ticket a bien été saisi";
		}
		else{
			$response["message"]="Le code barre n'existe pas";
		}
	}
	else{
		$response["message"]="Veuillez entrer un code Barre";
	}
}
else{
	$response["message"]="Le ticket à déjà été saisi, il est impossible de le saisir a nouveau";
}

echo json_encode($response);