<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);

    //$codeBarre = "M175145480001";
    $codeBarre = $_GET["codeBarre"];
    // get the user by email and password
    $ticket = $db->getTicket($codeBarre);
 
    if ($ticket != false) {
        if($ticket["dateValidation"]==NULL){
            $response["error"] = FALSE;
            $response["message"]= "Le ticket est valide";
            echo json_encode($response);
        }
        else{
            $response["error"]=TRUE;
            $response["error_msg"] = "Le ticket à déjà été validé";
            echo json_encode($response);
        }
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Le ticket n'existe pas";
        echo json_encode($response);
    }
?>