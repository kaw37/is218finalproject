<html>
    <head>
        <title>Questions</title>
        <link rel="stylesheet" href="questions.css">
        <script src="questions.js"></script>
        <?php
        $userId = $_SESSION['UserID'];
        $question = $_SESSION['QuestionObject'];
        ?>
        <script>
            const data = <?php echo $question->toString(); ?>;
            
            function vote (val)
            {
                var vote = parseInt(document.getElementById ("vote").value);
                vote+= val;
                document.getElementById ("vote").value=vote;
            }
        </script>
    </head>
    <body>

        <form method="post" action="index.php" class="boxed" onSubmit="return validateForm(this)">
            <input type="hidden" name="action" value="addQuestion"/>
            <input type="hidden" name="questionId" value="<?php echo $question->getId() ?>"/>
            <div class="questionborder">
                <h3>Questions</h3>
            </div>
            <div class="questionNamesContent">
                <input type='text' size="45" name='questionName' value = "<?php echo $question->getQuestionTitle() ?>" placeholder="Question Name" class="input"/>
            </div>

            <div class="skillsContent">
                <input type='text'  size="45" name='questionSkills' value = "<?php echo $question->getQuestionSkills() ?>" placeholder="Question Skills"/>
            </div>

            <div class="questionBodiesContent">
                <textarea cols="45" name="questionBody" placeholder="Question Body"><?php echo $question->getQuestionBody() ?></textarea>
            </div>
   <?php if ($userId == $question->getUserId()){?>
            <div class="skillsContent">
                <font color='white'>Vote:</font> <input type='text'  size="10" name='vote' id="vote" value = "<?php echo $question->getUserVote() ?>"/>
                <a href="javascript:vote(1)"><font color='white'>[+]</font></a><a href="javascript:vote(-1)"><font color='white'>[-]</font></a>
            </div>
            <?php }?>
            <h4>(You must be logged in to ask a question.)</h4>
  
            <div id="formButtons">
                <input type='submit' value='Submit' class="button inner"/> &nbsp;
                <a href="index.php?action=delQuestion&id=<?php echo $id ?>" class="button inner">DELETE</a>
                <a href="project1index.php" target="_self" class="button inner">Log out</a>
            </div>
        </form>
    </body>
</html>