<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

function utf8_encode_recursive($array)
    {
        $result = array();
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $result[$key] = utf8_encode_recursive($value);
            }
            else if (is_string($value))
            {
                $result[$key] = utf8_encode($value);
            }
            else
            {
                $result[$key] = $value;
            }
        }
        return $result;
    }

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
		
	$li=utf8_encode_recursive($response);
	echo json_encode($li);
}
else{
	$response["error"] = TRUE;
    $response["error_msg"] = "L'eleve n'as aucun cours";
    echo json_encode($response);
}
