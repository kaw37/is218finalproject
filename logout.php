<?php session_start(); ?>
<html>
<head>
    <title>Logout Successful</title>
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

        .logoutphpContent{
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
            padding: 10px 30px;
            position: relative;
            margin-bottom: 15px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="logoutphpContent">
<?php
$_SESSION['UserID']=null;
$_SESSION['UserEmail']=null;
$_SESSION['UserFullName']=null;
?>
    <h3>You need to log in.</h3>
<a href="login.html" class="button inner">Login</a>
</div>
</body>
</html>
