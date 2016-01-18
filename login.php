<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['EmailProf']) && isset($_POST['PasswordProf'])) {
 
    // receiving the post params
    $email = $_POST['EmailProf'];
    $password = $_POST['PasswordProf'];
 
    // get the user by email and password
    $user = $db->getUserByEmailAndPassword($email, $password);
 
    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["nom"]= $user["nom"];
        $response["prenom"] = $user["prenom"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "L'email ou le mot de passe est faux";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Veuillez remplir les champs";
    echo json_encode($response);
}
?>