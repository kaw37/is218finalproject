<?php

session_start();

require("database.php");
$method = 1;
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    //echo "method two";
    $method = 2;
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        //$action = 'list_products';
        if (isset($_SESSION['UserID'])) {
            
            include("project1index.php");
        } else {
            include("login.html");
        }
    }
}

if ($action == "login") {
    $email = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    if ($email && $password) {
        $dbh = new Database();
        $user = $dbh->login($email, $password);
        $_SESSION['userObject'] = $user;
        if ($user == null) {
            die("login failed");
        }
       // echo "logged in successfully";
        $dbh = null;
        include("project1index.php");
    } else {
        include("login.html");
    }
} else if ($action == "register") {
    if ($method == 2) {
        if (isset($_SESSION['UserID'])) {
            $dbh = new Database();
            $row = $dbh->currentUser();
            include("registration.php");
            return;
        } else {
            include("registration.html");
            return;
        }
    }
    extract($_POST);
    //echo "$firstName, $lastName, $email, $birthday, $password";
    if (!$firstName || !$lastName || !$email || !$birthday || !$password) {
        //echo "Missing data.";
        include("registration.html");
    }
    else {
        $dbh = new Database();
        $id = $dbh->register($firstName, $lastName, $email, $birthday, $password);
        if ($id == 0) {
            die("registration failed");
        }
        //echo "logged in successfully";
        include("project1index.php");
    }
} else if ($action == "addQuestion") {
    $email = "";
    $userId = 0;
    if (isset($_SESSION['UserID'])) {
        $email = $_SESSION['UserEmail'];
        $userId = $_SESSION['UserID'];
    } else {
        die("user not logged in");
    }
    if ($method == 2) { // get method.
        include("questions.html");
        return;
    }
    extract($_POST);
    if (!$questionName || !$questionSkills || !$questionBody) {
        die("no question data");
    }
    $dbh = new Database();
    $vote = isset($vote)?$vote:0;
    if (!isset($questionId))
        $id = $dbh->addQuestion($email, $userId, $questionName, $questionBody, $questionSkills, $vote);
    else
        $id = $dbh->saveQuestion($questionId, $questionName, $questionBody, $questionSkills, $vote);
    if ($id == 1)
        header("location: index.php");
        //include("project1index.php");
    else {
        echo "question not saved";
    }
} else if ($action == "question") {
    if ($method == 2) {
        $id = filter_input(INPUT_GET, 'id');
        if ($id > 0) {
            $dbh = new Database();

            $row = $dbh->getQuestion($id);
            if ($row == null)
                die("null");
            //extract($row);
             if (isset($_SESSION['UserID']))
                $row->setUserVote($dbh->getUserVote($_SESSION['UserID'], $id));     
            $_SESSION['QuestionObject'] = $row;
            include ("question.php");
        } else
            die("no id");
    } else {
        die("post question");
    }

} else if ($action == "question2") {
    if ($method == 2) {
        $id = filter_input(INPUT_GET, 'id');
        if ($id > 0) {
            $dbh = new Database();

            $row = $dbh->getQuestion($id);
            if ($row == null)
                die("null");
            //extract($row);
            $row->setAnswers($dbh);
            $_SESSION['QuestionObject'] = $row;
            include ("question2.php");
        } else
            die("no id");
    } else {
        die("post question");
    }
}else if ($action == "delQuestion") {
    $id = filter_input(INPUT_GET, 'id');
    if ($id > 0) {
        $dbh = new Database();
        $row = $dbh->delQuestion($id);
        include("project1index.php");
    } else
        die("no id for question to delete");
} else if ($action == "allQuestions") {
    
        $dbh = new Database();
        $stmt = $dbh->getAllQuestions();
        $list = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $question = new Question($row);
            array_push($list, $question);
        }
        $_SESSION['allQuestions']=$list;
        include("allQuestions.php");

}
?>
