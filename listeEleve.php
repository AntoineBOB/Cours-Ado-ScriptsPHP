<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);

$idProf = $_GET["idProf"];
//$idProf="4186";
$liste=$db->getListeEleveProf($idProf);
if($liste->num_rows !=0){
	//$response["eleve"]["Cours"] = array();
	$compteur=0;
	foreach ($liste as $l) {
		//if ($compteur==0){
			$response["eleve"]=$l;

		/*}else{
			array_push($response["eleve"], $l);

		}*/
		
		var_dump($l);
		$data=$db->getListeCours($l["id"],$idProf);
		if ($data->num_rows!=0)
		{
			$response["eleve"]["Cours"] = array();
			foreach ($data as $d) {
				array_push($response["eleve"]["Cours"], $d);
				//$response["eleve"]["Cours"] = $d;
				var_dump($d);
				
			}
		}
	}
	echo json_encode($response);
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "Le professeur n'as aucun eleve";
    echo json_encode($response);
}