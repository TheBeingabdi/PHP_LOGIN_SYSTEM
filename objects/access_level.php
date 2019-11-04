<?php
class access_level{
 
    // database connection and table name
    private $conn;
    private $table_name = "access_level";
 
    // object properties
    public $id;
    public $level;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    id, level
                FROM
                    " . $this->table_name . "
                ORDER BY
                    level";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }
	
// used to read level name by its ID
	function readOne(){
     
    $query = "SELECT level FROM " . $this->table_name . " WHERE id = ? limit 0,1";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
    $this->level = $row['level'];
	}
}
function create(){
 
    // to get time stamp for 'created' field
    $this->created=date('Y-m-d H:i:s');
 
    // insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
        level = :level,
        created = :created,
		modified = :modified";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->level=htmlspecialchars(strip_tags($this->level));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->modified=htmlspecialchars(strip_tags($this->modified));
    
    // bind the values
    $stmt->bindParam(':level', $this->level);
    $stmt->bindParam(':created', $this->created);
    $stmt->bindParam(':modified', $this->modified);
 
    // execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }else{
        $this->showError($stmt);
        return false;
    }
 
}


?>
