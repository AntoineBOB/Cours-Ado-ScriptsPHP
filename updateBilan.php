<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

$response = array();

$id = $_GET["id"];
$themeAvec_ = $_GET["theme"];
$commentaireAvec_ = $_GET["commentaire"];
$theme=str_replace("_", " ", $themeAvec_);
$commentaire=str_replace("_", " ", $commentaireAvec_);


$update = $db->updateBilan($theme,$commentaire,$id);

$response["message"] = "Le bilan à été modifié";

echo json_encode($response);
