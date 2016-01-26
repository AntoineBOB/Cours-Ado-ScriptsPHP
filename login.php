<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);

    $email = $_GET['email'];
    $password = $_GET['mdp'];
    // get the user by email and password
    $user = $db->getUserByEmailAndPassword($email, $password);
 
    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["nom"]= $user["nom"];
        $response["prenom"] = $user["prenom"];
        $response["id"]= $user["id"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "L'email ou le mot de passe est faux";
        echo json_encode($response);
    }
?>