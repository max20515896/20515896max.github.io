<?php

class Database{
    private $link;
    
    public function __construct($host, $user, $password, $database)
    {
        $this->link = mysqli_connect($host, $user, $password, $database);
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
    
    public function del($table, $id)
    {
        // удаляет запись по ее id
    }
    
    public function delAll($table, $ids)
    {
        // удаляет записи по их id
    }
    
    public function get($table, $id)
    {
        // получает одну запись по ее id
    }
    
    public function getAll($table, $ids)
    {
        // получает массив записей по их id
    }
    
    // public function selectAll($table, $condition)
    // {
    //     // получает массив записей по условию
    // }
    public function selectAllByCondition($query)
    {
        // получает массив записей по условию
        $result = $this->link->query($query);

        if($result->num_rows > 0){
            return $result;
        }else{
            return 0;
        }
          
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