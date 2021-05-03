<?php
//To Handle Session Variables on This Page
if(session_status() !== PHP_SESSION_ACTIVE){session_start();};
class Education extends Dbconfig{
    protected $hostName;
    protected $userName;
    protected $password;
    protected $dbName;
    private $table = 'user_education';
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
    public function eduList(){
        $user_id = $_SESSION['id_user'];
        $sqlQuery = "SELECT * FROM ".$this->table." WHERE user_id=".$user_id." ";

        if(!empty($_POST["search"]["value"])){
            $sqlQuery .= 'where(id LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR degree LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR institute LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR from_date LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR to_date LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR obtained_marks LIKE "%'.$_POST["search"]["value"].'%" ';
            $sqlQuery .= ' OR total_marks LIKE "%'.$_POST["search"]["value"].'%" ';
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

        $sqlQueryTotal = "SELECT * FROM ".$this->table." WHERE user_id=".$user_id." ";
        $resultTotal = mysqli_query($this->dbConnect, $sqlQueryTotal);
        $numRowsTotal = mysqli_num_rows($resultTotal);

        $eduData = array();
        while( $edu = mysqli_fetch_assoc($result) ) {
            $eduRows = array();
            $eduRows[] = $edu['degree'];
            $eduRows[] = $edu['institute'];
            $eduRows[] = $edu['from_date'];
            $eduRows[] = $edu['to_date'];
            $eduRows[] = $edu['obtained_marks'];
            $eduRows[] = $edu['total_marks'];
            $eduRows[] = '<button type="button" name="update" id="'.$edu["id"].'" class="btn btn-warning btn-xs update">Update</button>';
            $eduRows[] = '<button type="button" name="delete" id="'.$edu["id"].'" class="btn btn-danger btn-xs delete" >Delete</button>';
            $eduData[] = $eduRows;
        }
        $output = array(
            "draw"	=>	intval($_POST["draw"]),
            "iTotalRecords"	=> 	$numRows,
            "iTotalDisplayRecords"	=>  $numRowsTotal,
            "data"	=> 	$eduData
        );
        echo json_encode($output);
    }
    public function getEdu(){
        if($_POST["eduId"]) {
            $sqlQuery = "
				SELECT * FROM ".$this->table." 
				WHERE id = '".$_POST["eduId"]."'";
            $result = mysqli_query($this->dbConnect, $sqlQuery);
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        }
    }
    public function updateEdu(){
        if($_POST['eduId'])
        {
            $updateQuery = "UPDATE ".$this->table." 
			SET degree = '".$_POST["degree"]."', institute = '".$_POST["institute"]."', from_date = '".$_POST["from_date"]."', to_date = '".$_POST["to_date"]."', obtained_marks = '".$_POST["obtained_marks"]."', total_marks = '".$_POST["total_marks"]."'
			WHERE id ='".$_POST["eduId"]."'";
            $isUpdated = mysqli_query($this->dbConnect, $updateQuery);
        }
    }
    public function addEdu(){
        $user_id = $_SESSION['id_user'];
        $insertQuery = "INSERT INTO ".$this->table." (degree, institute, from_date, to_date, obtained_marks, total_marks, user_id) 
			VALUES ('".$_POST["degree"]."', '".$_POST["institute"]."', '".$_POST["from_date"]."',  '".$_POST["to_date"]."', '".$_POST["obtained_marks"]."', '".$_POST["total_marks"]."','".$user_id."')";
        $isUpdated = mysqli_query($this->dbConnect, $insertQuery);
        //print_r('added');
    }
    public function deleteEdu(){
        if($_POST["eduId"]) {
            $sqlDelete = "
				DELETE FROM ".$this->table."
				WHERE id = '".$_POST["eduId"]."'";
            mysqli_query($this->dbConnect, $sqlDelete);
        }
    }
}
?>