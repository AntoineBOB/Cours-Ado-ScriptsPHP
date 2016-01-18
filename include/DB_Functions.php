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
 
        // Changer la requete pour qu'elle corresponde à la table des professeurs
        $stmt = $this->conn->prepare("SELECT * FROM professeurs WHERE email = ? AND pwd = ?");
 
        $stmt->bind_param("ss", $email, $password);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
}
?>