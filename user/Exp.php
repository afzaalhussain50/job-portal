<?php
//require('config.php');
//Including Database Connection From db.php file to avoid rewriting in all files
//require_once("../db.php");
//To Handle Session Variables on This Page
session_start();

require('config.php');
class Exp extends Dbconfig{
    protected $hostName;
    protected $userName;
    protected $password;
    protected $dbName;
    private $expTable = 'user_experience';
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
    public function expList(){
        $user_id = $_SESSION['id_user'];
        $sqlQuery = "SELECT * FROM ".$this->expTable." WHERE user_id=".$user_id." ";

        if(!empty($_POST["search"]["value"])){
            $sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR designation LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR org_name LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR description LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR from_date LIKE "%'.$_POST["search"]["value"].'%") ';
            $sqlQuery .= ' OR to_date LIKE "%'.$_POST["search"]["value"].'%") ';
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
            $expRows[] = $exp['designation'];
            $expRows[] = $exp['org_name'];
            $expRows[] = $exp['description'];
            $expRows[] = $exp['from_date'];
            $expRows[] = $exp['to_date'];
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
    public function getExp(){
        if($_POST["expId"]) {
            $sqlQuery = "
				SELECT * FROM ".$this->expTable." 
				WHERE id = '".$_POST["expId"]."'";
            $result = mysqli_query($this->dbConnect, $sqlQuery);
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        }
    }
    public function updateExp(){
        if($_POST['expId'])
        {
            $updateQuery = "UPDATE ".$this->expTable." 
			SET designation = '".$_POST["designation"]."', org_name = '".$_POST["org_name"]."', description = '".$_POST["description"]."', from_date = '".$_POST["from_date"]."' , to_date = '".$_POST["to_date"]."'
			WHERE id ='".$_POST["expId"]."'";
            $isUpdated = mysqli_query($this->dbConnect, $updateQuery);
            print_r('updated');
        }
    }
    public function addExp(){
        $user_id = $_SESSION['id_user'];
        $insertQuery = "INSERT INTO ".$this->expTable." (designation, org_name, description, from_date, to_date, user_id) 
			VALUES ('".$_POST["designation"]."', '".$_POST["org_name"]."', '".$_POST["description"]."', '".$_POST["from_date"]."', '".$_POST["to_date"]."', '".$user_id."')";
        $isUpdated = mysqli_query($this->dbConnect, $insertQuery);
    }
    public function deleteExp(){
        if($_POST["expId"]) {
            $sqlDelete = "
				DELETE FROM ".$this->expTable."
				WHERE id = '".$_POST["expId"]."'";
            mysqli_query($this->dbConnect, $sqlDelete);
        }
    }
}
?>