
<?php
$email="";
$msg="<h3>Welcome! What would you like to do?</h3>";
$userId=0;

if (isset ($_SESSION['UserID']))
{
    
    $userId= ($_SESSION['UserID']);
    $name=$_SESSION['UserFullName'];
    $msg="<h3>Welcome back, $name!<br>What would you like to do?</h3>";
}else
    header("Location: login.html");
?>

<html>
<head>
    <title>Main Menu</title>
    <style>
        h3{
            font-size: 30px;
        }
        h4{
            font-size: 20px;
            margin-bottom: 10px;
        }
        html, body{
            height: 100%;
            background-color: #3CAEA3;
            vertical-align: middle;
        }


        body{
            font-family: sans-serif;
            background-color: #3CAEA3;
            display: table;
            margin: auto;
            text-align: center;
            width: 40%;
            height: 40%;
        }
        .indexphpContent {
            display: table-cell;
            width: 300px;
            height: 150px;
            padding: 60px 70px;
            border-radius: 25px;
            background: #f8f8ff;
            text-align: center;
            position: relative;
            top: 25%;
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
<div class="indexphpContent">
<?php
    echo $msg;
    echo "<h4>Your Questions:</h4>";
    try{
        include_once ("database.php");

       $dbh = new Database();
       if (isset($_GET['toggle']))
           $stmt = $dbh->getAllQuestions($userId);
       else
           $stmt = $dbh->getUserQuestions($userId);
       
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<p><a href='index.php?action=question&id=".$row['id']."'>". $row['title']. "</a></p>";

        }
        $dbh=null;
    }catch (Exception $e){
        echo $e;
    }

   // $dbh->close()
?>
    <div class="formButtons">
        <a href="index.php?action=addQuestion" target="_self" class="button inner">Add a Question</a> &nbsp;
        <a href="index.php?toggle=All" target="_self" class="button inner">All Questions</a> &nbsp;  
        <a href="index.php" target="_self" class="button inner">My Questions</a> &nbsp;          
        <a href="logout.php" target="_self" class="button inner">Log Out</a>
    </div>

</div>
</body>
</html>