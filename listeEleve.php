<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);
$idProf="86";
$liste=array();
$liste=$db->getListeEleveProf($idProf);