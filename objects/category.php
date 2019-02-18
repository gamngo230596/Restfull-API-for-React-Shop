<?php
class Category{

// database connection and table name
private $conn;
private $table_name = "categories";

// object properties
public $id;
public $name;
public $description;
public $imageurl;

public function __construct($db){
    $this->conn = $db;
}
// used by select drop-down list
public function read(){

//select all data
$query = "SELECT
            id, name, description, imageurl
        FROM
            " . $this->table_name . "
        ORDER BY
            name";

$stmt = $this->conn->prepare( $query );
$stmt->execute();

return $stmt;
}
public function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name,description=:description,imageurl=:imageurl";
                // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->imageurl=htmlspecialchars(strip_tags($this->imageurl));

 
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":imageurl", $this->imageurl);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                description = :description,
                imageurl= :imageurl
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->imageurl=htmlspecialchars(strip_tags($this->imageurl));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':imageurl', $this->imageurl);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}
?>