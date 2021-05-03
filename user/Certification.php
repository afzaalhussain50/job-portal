<?php
//To Handle Session Variables on This Page
if(session_status() !== PHP_SESSION_ACTIVE){session_start();};
class Certification extends Dbconfig{
    protected $hostName;
    protected $userName;
    protected $password;
    protected $dbName;
    private $expTable = 'user_certifications';
    private $dbConnect;
    public function __construct(){
        if(!$this->dbConnect){
            $database = new dbConfig();
            $this -> hostName = $database->serverName;
            $this -> userName = $database->userName;
            $this -> password = $database->password;
            $this -> dbName = $database->dbName;
            $conn = new mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else{
                $this->dbConnect = $conn;
            }
        }
    }
    private function getData($sqlQuery) {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if(!$result){
            die('Error in query: '. mysqli_error());
        }
        $data= array();
        while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
            $data[]=$row;
        }
        return $data;
    }
    private function getNumRows($sqlQuery) {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if(!$result){
            die('Error in query: '. mysqli_error());
        }
        $numRows = mysqli_num_rows($result);
        return $numRows;
    }
    public function cerList(){
        $user_id = $_SESSION['id_user'];
        $sqlQuery = "SELECT * FROM ".$this->expTable." WHERE user_id=".$user_id." ";

        if(!empty($_POST["search"]["value"])){
            $sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR certificate LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR certification_date LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR description LIKE "%'.$_POST["search"]["value"].'%" ';
        }
        if(!empty($_POST["order"])){
            $sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        } else {
            $sqlQuery .= 'ORDER BY id DESC ';
        }
        if($_POST["length"] != -1){
            $sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $numRows = mysqli_num_rows($result);

        $sqlQueryTotal = "SELECT * FROM ".$this->expTable." WHERE user_id=".$user_id." ";
        $resultTotal = mysqli_query($this->dbConnect, $sqlQueryTotal);
        $numRowsTotal = mysqli_num_rows($resultTotal);

        $expData = array();
        while( $exp = mysqli_fetch_assoc($result) ) {
            $expRows = array();
            $expRows[] = $exp['certificate'];
            $expRows[] = $exp['certification_date'];
            $expRows[] = $exp['description'];
            $expRows[] = '<button type="button" name="update" id="'.$exp["id"].'" class="btn btn-warning btn-xs update">Update</button>';
            $expRows[] = '<button type="button" name="delete" id="'.$exp["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
            $expData[] = $expRows;
        }
        $output = array(
            "draw"	=>	intval($_POST["draw"]),
            "iTotalRecords"	=> 	$numRows,
            "iTotalDisplayRecords"	=>  $numRowsTotal,
            "data"	=> 	$expData
        );
        echo json_encode($output);
    }
    public function getCer(){
        if($_POST["cerId"]) {
            $sqlQuery = "
				SELECT * FROM ".$this->expTable." 
				WHERE id = '".$_POST["cerId"]."'";
            $result = mysqli_query($this->dbConnect, $sqlQuery);
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        }
    }
    public function updateCer(){
        if($_POST['cerId'])
        {
            $updateQuery = "UPDATE ".$this->expTable." 
			SET certificate = '".$_POST["certificate"]."', certification_date = '".$_POST["certification_date"]."', description = '".$_POST["description"]."'
			WHERE id ='".$_POST["cerId"]."'";
            $isUpdated = mysqli_query($this->dbConnect, $updateQuery);
        }
    }
    public function addCer(){
        $user_id = $_SESSION['id_user'];
        $insertQuery = "INSERT INTO ".$this->expTable." (certificate, certification_date, description, user_id) 
			VALUES ('".$_POST["certificate"]."', '".$_POST["certification_date"]."', '".$_POST["description"]."', '".$user_id."')";
        $isUpdated = mysqli_query($this->dbConnect, $insertQuery);
        //print_r('added');
    }
    public function deleteCer(){
        if($_POST["cerId"]) {
            $sqlDelete = "
				DELETE FROM ".$this->expTable."
				WHERE id = '".$_POST["cerId"]."'";
            mysqli_query($this->dbConnect, $sqlDelete);
        }
    }
}
?>