<?php

include_once 'model/Account.php';
include_once 'model/Question.php';


// $dsn = "mysql:dbname=kaw37;host=sql1.njit.edu;port=3306";
//  $usr = "kaw37";
// $pwd = "Kawaiiasfuck0315__";


class Database {

    static function getConn() {
        $dsn = "mysql:dbname=kaw37;host=sql1.njit.edu;port=3306";
        $usr = "kaw37";
        $pwd = "Kawaiiasfuck0315__";
        //global Database::dsn, Database::usr, Database::pwd;
        return new PDO($dsn, $usr, $pwd);
    }

    static function login($email, $password) {
        try {

            $dbh = Database::getConn();
            $sql = "SELECT * FROM accounts WHERE email = ? AND password = ?";
            //echo "login: $email / $password";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);

            $stmt->bindParam(2, $password, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() < 1) {
                echo "not found";
                return 0;
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $user = new Account($row);
            $id = $row['id'];
            $_SESSION['UserID'] = $row['id'];
            $_SESSION['UserEmail'] = $email;
            $_SESSION['UserFullName'] = $row['lname'] . ", " . $row['fname'];
//echo "returning $id";
            $dbh = null;
            return $user;
        } catch (PDOException $ex) {
            echo $ex;
            return 0;
        }
    }

    static function currentUser() {
        if (!isset($_SESSION['UserID'])) {
            return null;
        }
        $sql = "SELECT * FROM accounts WHERE id = ?";
        $dbh = Database::getConn();
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(1, $_SESSION['UserID'], PDO::PARAM_INT);

        $stmt->execute();
        if ($stmt->rowCount() < 1) {
            return null;
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $_SESSION['userObject'] = $row;
        return new Account($stmt->fetch(PDO::FETCH_ASSOC));
    }

    static function getUserQuestions($userId) {
        // $userId=1;
        $dbh = Database::getConn();
        $sql = "SELECT id, title FROM questions WHERE ownerid = $userId ";
//echo $sql;
        $stmt = $dbh->prepare($sql);

        //$stmt-> bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    static function getAllQuestions() {
        // $userId=1;
        $dbh = Database::getConn();
        $sql = "SELECT * FROM questions";
//echo $sql;
        $stmt = $dbh->prepare($sql);

        //$stmt-> bindParam(1, $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    static function register($firstName, $lastName, $email, $birthday, $password) {
        try {
            $dbh = Database::getConn();
            $sql = "INSERT INTO `accounts` ( `email`, `fname`, `lname`, `birthday`, `password`) VALUES (?,?,?,?,?) ";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->bindParam(2, $firstName, PDO::PARAM_STR);
            $stmt->bindParam(3, $lastName, PDO::PARAM_STR);
            $stmt->bindParam(4, $birthday, PDO::PARAM_STR);
            $stmt->bindParam(5, $password, PDO::PARAM_STR);
            $stmt->execute();
            $dbh = null;
            return 1;
        } catch (PDOException $ex) {
            echo $ex;
            return 0;
        }
    }

    static function saveQuestion($id, $questionName, $questionBody, $questionSkills, $vote = 0) {
        $sql = "UPDATE questions SET title=?, body=?, skills=? WHERE id = ?";

//echo "question: $questionName";
        try {
            $dbh = Database::getConn();
            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(1, $questionName, PDO::PARAM_STR);
            $stmt->bindParam(2, $questionBody, PDO::PARAM_STR);
            $stmt->bindParam(3, $questionSkills, PDO::PARAM_STR);
            $stmt->bindParam(4, $id, PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt) {
                $dbh = null;
                return 0;
            }
            $sql = "UPDATE answers SET vote = ? WHERE question_id = ? AND account_id = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $vote, PDO::PARAM_INT);
            $stmt->bindParam(2, $id, PDO::PARAM_INT);
            $stmt->bindParam(3, $_SESSION['UserID'], PDO::PARAM_INT);
            $stmt->execute();
            $dbh = null;
            return 1;
        } catch (PDOException $ex) {
            $dbh = null;
            echo $ex;
            return 0;
        }
    }

    static function addQuestion($email, $userId, $questionName, $questionBody, $questionSkills, $vote = 0) {

        $sql = "INSERT INTO `questions` (`owneremail`, `ownerid`, `createddate`, `title`, `body`, `skills`, `score`)        
                VALUES (?,?,SYSDATE(),?,?,?,0) ";

        //echo "question: $questionName";
        try {
            $dbh = Database::getConn();
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->bindParam(3, $questionName, PDO::PARAM_STR);
            $stmt->bindParam(4, $questionBody, PDO::PARAM_STR);
            $stmt->bindParam(5, $questionSkills, PDO::PARAM_STR);
            $stmt->execute();

            if (!$stmt) {
                $dbh = null;
                return 0;
            }
            $id = $dbh->lastInsertId();;
            $sql = "INSERT INTO answers
                    (`question_id`,
                    `account_id`,
                    `vote`)
                    VALUES (?,?,0)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->execute();

            $dbh = null;
            return 1;
        } catch (PDOException $ex) {
            $dbh = null;
            echo $ex;
            return 0;
        }
    }

    static function getQuestion($id) {
        try {
            $dbh = Database::getConn();
            $sql = "SELECT * FROM questions WHERE id = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            if (!$stmt) {
                $dbh = null;
                return 0;
            }
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $question = new Question($row);

            $dbh = null;
            return $question;
        } catch (PDOException $ex) {
            $dbh = null;
            echo $ex;
            return 0;
        }
    }

    static function getUserVote($userId, $questionId) {
        try {
            $dbh = Database::getConn();
            $sql = "SELECT vote FROM answers WHERE question_id = ? AND account_id = ?";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(1, $questionId, PDO::PARAM_INT);
            $stmt->bindParam(2, $userId, PDO::PARAM_INT);
            $stmt->execute();
            if (!$stmt) {
                $dbh = null;
                return 0;
            }
            $vote = 0;

            if ($stmt->rowCount()) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $vote = $row['vote'];
            }
            $dbh = null;
            return $vote;
        } catch (PDOException $ex) {
            $dbh = null;
            echo $ex;
            return 0;
        }
    }

    static function delQuestion($id) {
        $sql = "DELETE FROM questions WHERE id = ?";

        try {
            $dbh = Database::getConn();
            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt) {
                $dbh = null;
                return 0;
            }
            $dbh = null;
            return 1;
        } catch (PDOException $ex) {
            $dbh = null;
            echo $ex;
            return 0;
        }
    }

    static function checkDateFormat($date) {
// match the format of the date
        if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {

// check whether the date is valid or not
            if (checkdate($parts[2], $parts[3], $parts[1])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>