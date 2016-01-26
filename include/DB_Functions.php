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
        $stmt->bind_param('s',$idProf);

 
        $stmt->execute();
        $result = $stmt->get_result();
        /*while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            foreach ($row as $r)
            {
                print "$r ";
            }
            print "\n";
        }*/
    }
}
?>