<?php
    include_once 'config/database.php';

    // create var and set empty
    $email = $agreement = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(empty($_POST["agreement"])){
            $Error = "You must accept the terms and conditions";
        }else{
            $agreement = test_input($_POST["agreement"]);
            }

            if(empty($_POST["email"])){
                $Error = "Email address is required";
            }else{
                if(!preg_match("/\S+@\S+\.\S+/", $_POST["email"])){
                    $Error = "Please provide a valid e-mail address";
                }
                else if(preg_match("/\.co$/", $_POST["email"])){
                    $Error = "We are not accepting subscriptions from Colombia
                    emails";
                }
                else{
                    $email = test_input($_POST['email']);
                }
            }

            if(!$Error){
                $db = new Database('localhost', 'root', 'root', 'magebit_email');
                // $dataSavedMessage = $db->save('emails', $email);
                $db->save('email', $email);
                header('Location: showData.php');
                exit;
            }
        }

        function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

                    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Pineapple page</title>
</head>
<body>

<div class="content">
    <div class="content-right">
        <nav>
            <div class="logo">
                <!-- <div class="logo-icon"><img src="img/icons/ic_pineapple.svg" alt="pineapple logo"></div> -->
                <!-- <div class="logo-icon"></div> -->
                <!-- <div class="logo-text"><img src="img/icons/ic_pineapple_text..svg" alt="pineapple text"></div> -->
                <img src="img/icons/ic_pineapple_text..svg" alt="pineapple text">
            </div>
            <ul class="links">
                <li><a href="#">About</a></li>
                <li><a href="#">How it works</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <div class="info">
            <div class="info-header">
                <h1>Subscribe to newsletter</h1>
                <p>Subscribe to our newsletter and get 10% discount on pineapple glasses.</p>
            </div>
            <div class="form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                    <div class="email">
                        <div class="border"></div>
                        <input type="text" name="email" placeholder="Type your email address here…" value="<?php echo $email;?>">
                        <input type="submit" class="submit" value="">
                    </div>
                    <div class="error"><?php echo $Error;?></div>
                    <div class="form-checkbox">
                        <input type="checkbox" name="agreement">
                        <span>I agree to <a href="#">terms of service</a></span>
                    </div>
                </form>
            </div>
        </div>
        <div class="subscription_success">
            <div class="icon_goblet">
                <img src="img/icons/ic_goblet.svg" alt="Goblet icon">
            </div>
            <h1>Thanks for subscribing!</h1>
            <p>You have successfully subscribed to our email listing. Check your email for the discount code.</p>
        </div>
        <hr class="break_line">
        <div class="bottom-icons">
            <a href="#" class="icon-item"></a>
            <a href="#" class="icon-item"></a>
            <a href="#" class="icon-item"></a>
            <a href="#" class="icon-item"></a>
        </div>
    </div>
    <div class="left-image">
        <img src="img/image_summer.png" alt="pineapple image">
    </div>
</div>

<script src='js/script.js'></script>
</body>
</html>
