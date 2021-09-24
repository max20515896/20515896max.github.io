
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="dataList">
<?php
        include_once 'config/database.php';

        $db = new Database('localhost', 'root', 'root', 'magebit_email');

            $isPostOrderBy = false;
            $orderByBtnValueKey = array(
                'A-z'=>'ORDER BY email ASC', 
                'Z-a'=>'ORDER BY email DESC', 
                '0-9'=>'ORDER BY date ASC',
                '9-0'=>'ORDER BY date DESC'
            );
            
            $postOrderBtnValue = '';
            if(isset($_POST)){
                $key = new \stdClass;
                foreach($_POST as $key->$value){
                    if($key->$value != $_POST['domain']){
                        $postOrderBtnValue = $key->$value;
                        $isPostOrdertBy = true;
                    }
                }
            }

            $_SESSION['domain'] = isset($_POST['domain'])? $_POST['domain'] : 'Select All';

                if(isset($_POST['domain']) && is_bool($isPostOrderBy) === true){
                    $orderBy = $orderByBtnValueKey[$postOrderBtnValue];
                    $whereEmail = $_POST['domain'] === 'Select All'? '' : "WHERE email LIKE '%".$_POST['domain']."%'";
                    $select = "SELECT * FROM email";
                    $query = $select.' '.$whereEmail.' '.$orderBy;
                    $result = $db->selectAllByCondition($query);
                    $db->createTable($result);
                }else{
                    $select = "SELECT * FROM email";
                    $whereEmail = !isset($_POST['domain']) || $_POST['domain'] === 'Select All'? '' : "WHERE email LIKE '%".$_POST['domain']."%'";
                    $orderBy = "ORDER BY date ASC";
                    $query =  $select.' '.$whereEmail.' '.$orderBy;
                    $result = $db->selectAllByCondition($query);
                    $db->createTable($result);
                }

?>
</div>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <div><b>Sort by email: </b></div>
        <input type="submit" name="sortByEmailAsc" value='A-z'>
        <input type="submit" name="sortByEmailDesc" value='Z-a'>

        <div><b>Sort by date: </b></div>
        <input type="submit" name="sortByDateAsc" value='0-9'>
        <input type="submit" name="sortByDateDesc" value='9-0'>

        <div><b>Sort by domain: </b></div>

        <?php 
            $query = 'SELECT email FROM email';
            $result = $db->selectAllByCondition($query);

        //create simple email array
            $emailArr = [];
            $key = new \stdClass();
            foreach($result as $key->$value){
                $emailArr[] = $key->$value['email'];
            }
            //get array of domains like: 'yahoo', 'gmail'...
            $domains = $db->getDomains($emailArr);

            //create html elements: select, options
            $db->createSelectList($domains);
        ?>
    </form>
</body>
</html>