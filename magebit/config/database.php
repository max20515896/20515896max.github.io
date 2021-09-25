<?php

class Database{
    private $link;
    
    public function __construct($host, $user, $password, $database)
    {
        $this->link = new mysqli($host, $user, $password, $database);
        mysqli_query($this->link, "SET NAMES 'utf8'");
    }
    
    public function save($table, $data)
    {
        $query = "INSERT INTO $table (email) VALUES ('$data')";

        if ($this->link->query($query) === TRUE) {
            return "Data is saved";
          } else {
            return  "Error: " . $query . "<br>" . $link->error;
          }
          
          $this->link->close();
    }
    
    public function selectAllByCondition($query)
    {
        $result = $this->link->query($query);

        if($result->num_rows > 0){
            return $result;
        }else{
            return 0;
        }
          
          $this->link->close();
    }
    public function deleteById($id)
    {
        $this->link->query("DELETE from email WHERE id = $id");
          
          $this->link->close();
    }
    public function createTable($data)
    {
        // creating html table 
        if($data){
            echo "<table>";
                foreach($data as $row){
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["date"]."</td>";
                    echo "<td><form method='post' action='".$_SERVER["PHP_SELF"]."'><input type='hidden'  value='".$row["id"]."' name='itemId'><input type='submit'  value='delete' name='delete'></form></td>";
                    echo "</tr>";
                }
            echo "<table>";
        }else{
            echo '0 results';
        }
    }
    public function createSelectList($domains){
        echo '<select name="domain" id="domain_list">';
        echo '<option value="'.$_SESSION['domain'].'">'.$_SESSION['domain'].'</option>';
        for($i = 0; $i < count($domains); $i++){
            if($domains[$i] == $_SESSION['domain']){
                echo '<option value="Select All">Select All</option>';
            }else{
                echo '<option value="'.$domains[$i].'">'.mb_convert_case($domains[$i], MB_CASE_TITLE).'</option>';
            }
        }
        echo '</select>';
        echo '<input type="submit" value="Sort">';
    }
    public function getDomains($emailArr){
        $newArr = [];
        //cut from ('@') till ('.') to get domain;
        foreach($emailArr as $str){
            $newStr = explode("@", $str)[1];

            $length = strpos($newStr,'.');
            $result = substr($newStr, 0, $length);

            $newArr[] = $result;
    
        }
        //return array of unique domains;
        $newArr = array_unique($newArr);

        //set correct indexes
        $selectValues = [];
        $key = new \stdClass;
        foreach($newArr as $key->$value){
            $selectValues[] = $key->$value;
        }
        return $selectValues;
    }

}
?>