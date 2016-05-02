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

        $stmt = $this->conn->prepare("SELECT id, nom, prenom FROM eleve WHERE id in (SELECT idEleve FROM inscription WHERE id in (SELECT idInscription FROM inscription_prof WHERE idProf=?));");
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

        $stmt=$this->conn->prepare("SELECT inscription.id AS idInscription, inscription_prof.id,matiere.matiere, inscription_prof.heure_cadence, niveau.niveau, inscription.ville_cours AS ville, inscription.num_inscription,(select IFNULL(SUM(compteur),0) from bon_prof WHERE idinscription_prof=inscription_prof.id) as nbTickets, (SELECT SUM(dureeSeance) AS nbHeures FROM inscription_bilan WHERE idInscriptionProf=inscription_prof.id AND isRempliViaProf=1) AS nbHeures
        FROM inscription INNER JOIN inscription_prof ON inscription_prof.idInscription= inscription.id  INNER JOIN niveau ON niveau.id = inscription.niveau  INNER JOIN matiere ON inscription_prof.matiere = matiere.id LEFT OUTER JOIN bon_prof ON inscription_prof.id = bon_prof.idinscription_prof
        WHERE inscription.idEleve=? AND inscription_prof.idProf=?;");
        $stmt->bind_param('ss',$idEleve, $idProf);

        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }
    }


    public function getInformationTicket($codeBarre){
        $stmt=$this->conn->prepare("SELECT * from inscription_tickets where codeBarre = ?");
        $stmt->bind_param('s',$codeBarre);

        if($stmt->execute()){
            $result=$stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }
    }

    public function saisirTicket($idInscription, $numTicket){
        $stmt=$this->conn->prepare("INSERT into bon_prof (idinscription,numTicket) values (?,?);");
        $stmt->bind_param('ss',$idInscription, $numTicket);

        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }
    }
    public function insererBilan($idinscription_prof, $idProf,$idInscription,$idEleve,$dateSeance,$dureeSeance,$startSeance,$endSeance,$themesAbordes,$commentaires,$idRDV,$dateEnregistrement){
        $stmt=$this->conn->prepare("INSERT INTO inscription_bilan (idInscriptionProf,idProf,idInscription,idEleve,suppr,isRempliViaProf,dateSeance,dureeSeance,startSeance,endSeance,themesAbordes,commentaires,idRDV,dateEnregistrement) VALUES (?,?,?,?,0,1,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssssssss',$idinscription_prof, $idProf,$idInscription,$idEleve,$dateSeance,$dureeSeance,$startSeance,$endSeance,$themesAbordes,$commentaires,$idRDV,$dateEnregistrement);

        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }

    }
    public function ListeHoraires($idinscription_prof,$idProf){
        $stmt=$this->conn->prepare("SELECT date_deb FROM agenda WHERE idInscriptionProf=? AND (supp IS NULL OR supp=0) AND idProf=? AND is_horaire IS NULL AND idBilan IS NULL ORDER BY date_deb");
        $stmt->bind_param('ss',$idinscription_prof, $idProf);

        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }

    }

    public function codeBarreExists($codeBarre){
        $stmt=$this->conn->prepare("SELECT idInscription from inscription_tickets where codeBarre= ?");
        $stmt->bind_param('s',$codeBarre);

        if($stmt->execute()){
            $result=$stmt->get_result();
            $stmt->close();
            return $result;
        } else {
            return NULL;
        }
    }

    public function updateBilan($themes,$commentaire,$id){
        $stmt=$this->conn->prepare("UPDATE inscription_bilan SET themesAbordes=? AND commentaires=? WHERE id=?");
        $stmt->bind_param('sss',$themes,$commentaire,$id);

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