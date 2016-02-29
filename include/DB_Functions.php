<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM professeur WHERE email = ? AND pwd = ?");
        $stmt->bind_param("ss", $email, $password);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
    public function getListeEleveProf($idProf) {

        $stmt = $this->conn->prepare("SELECT id, nom, prenom FROM eleve WHERE id in (SELECT idEleve FROM agenda WHERE idProf=?);");
        $stmt->bind_param('i',$idProf);

        if($stmt->execute()){
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }
        else{
            return NULL;
        }
    }

    public function getTicket($codeBarre){

        $stmt = $this->conn->prepare(
            "SELECT * from bon_prof where idinscription= (Select idInscription from inscription_tickets where codeBarre= ?)
             and numTicket = (Select numeroBon from inscription_tickets where codeBarre = ?);");
        $stmt->bind_param('ss',$codeBarre,$codeBarre);

        if($stmt->execute()){
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }
    }
    public function getListeCours($idEleve, $idProf){
        $stmt=$this->conn->prepare("SELECT inscription.num_inscription FROM inscription INNER JOIN inscription_prof ON inscription_prof.idInscription= inscription.id WHERE inscription.idEleve=? AND inscription_prof.idProf=?");
        $stmt->bind_param('ss',$idEleve, $idProf);

        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }
    }

}
?>