<html>
    <head>
        <title>Questions</title>
        <link rel="stylesheet" href="questions.css">
        <script src="questions.js"></script>
        <?php
        $question = $_SESSION['QuestionObject'];
        ?>
        <script>
            const data = <?php echo $question->toString(); ?>;
        </script>
    </head>
    <body>

        <form method="post" action="index.php" class="boxed" onSubmit="return validateForm(this)">
            <input type="hidden" name="action" value="addQuestion"/>
            <input type="hidden" name="questionId" value="<?php echo $question->getId() ?>"/>
            <div class="questionborder">
                <h3>Questions2</h3>
            </div>
            <div class="questionNamesContent">
                <input type='text' size="45" name='questionName' value = "<?php echo $question->getQuestionTitle() ?>" placeholder="Question Name" class="input"/>
            </div>

            <div class="skillsContent">
                <input type='text'  size="45" name='questionSkills' value = "<?php echo  $question->getQuestionSkills() ?>" placeholder="Question Skills"/>
            </div>

            <div class="questionBodiesContent">
                <textarea cols="45" name="questionBody" placeholder="Question Body"><?php echo $question->getQuestionBody() ?></textarea>
            </div>
               <div class="questionBodiesContent">
                <textarea cols="45" name="questionBody" placeholder="User Id"><?php echo $question->getUserId() ?></textarea>
            </div>
            <?php
                $answers = $question->getAnswers();
                $cnt = count($answers);
                echo "<table border='1'><tr><th>Account</th><th>Votes</th></tr>";
                for ($i=0; $i< $cnt; ++$i)
                {
                    echo "<tr><td>".$answers[$i]->getUserName() . "</td><td>". $answers[$i]->getVote() . "</td></tr>";
                }
                echo "</table>";
            ?>
            <h4>(You must be logged in to ask a question.)</h4>
            <div id="formButtons">
                <input type='submit' value='Submit' class="button inner"/> &nbsp;
                <a href="index.php?action=delQuestion&id=<?php echo $id ?>" class="button inner">DELETE</a>
                <a href="project1index.php" target="_self" class="button inner">Log out</a>
            </div>
        </form>
    </body>
</html>