<?php session_start(); ?>
<html>
<head>
    <title>Login Successful</title>
    <style>

        h3{
            font-size: 30px;
        }
        h4{
            font-size: 20px;
            margin-bottom: 10px;
        }
        html, body{
            background-color: #3CAEA3;
            vertical-align: middle;
        }

        body{
        font-family: sans-serif;
        background-color: #3CAEA3;
        display: table;
        margin: auto;
        text-align: center;
        width: 30%;
        height: 40%;
        }

        .loginphpContent{
            font-family: sans-serif;
            display: table-cell;
            width: 300px;
            padding: 60px 70px;
            border-radius: 25px;
            background: #f8f8ff;
            text-align: center;
            position: relative;
            top: 50%;
            vertical-align: middle;
        }

        .button{
            color: ghostwhite;
        }

        .formButtons{
            width:100%;
            text-align: center;
        }

        .inner{
            display:inline-block;
            font-size: 14px;
            text-align: center;
            width: 100px;
            border: 2px solid #FF66CC;
            border-radius: 25px;
            vertical-align: center;
            background-color: #FF66CC;
            height: auto;
            margin: 0;
            padding: 10px;
            position: relative;
            margin-bottom: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="loginphpContent">
<?php

try {
    include_once ("dbconn.php");


    $dbh = new PDO($dsn, $usr, $pwd);
    $sql = "SELECT id, fname, lname FROM accounts WHERE email = ? AND password = ?";

    $stmt = $dbh->prepare($sql);
    extract ($_POST);

    if (!$email || !$password)
    {
        die ("Missing fields. Click back to fix.");
    }

    $stmt-> bindParam(1, $email, PDO::PARAM_STR);

    $stmt-> bindParam(2, $password, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount()<1)
    {
        die ("<h3>Invalid Login.</h3> <a href='login.html' class='button inner'>Retry</a>");
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id=$row['id'];
    $_SESSION['UserID']=$id;
    $_SESSION['UserEmail']=$email;
    $_SESSION['UserFullName']=$row['fname']. " ". $row['lname'];
    echo "<h3>Login successful.</h3>  <a href='project1index.php' class='button inner'>Home</a></h3>";
} catch (Exception $e) {
    echo $e;
}
?>
</div>
</body>
</html>
