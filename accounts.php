

<?php
try{
    include_once ("dbconn.php");

    $dbh = new PDO($dsn, $usr, $pwd);
    $sql = "SELECT * FROM accounts";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>". $row['email']. "</p>";

    }
}catch (Exception $e){
    echo $e;
}
