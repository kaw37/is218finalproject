<html>
<head>
    <title>Questions</title>
    <link rel="stylesheet" href="questions.css">
    <script src="questions.js"></script>
</head>
<body>
<form method="post" action="index.php" class="boxed" onSubmit="return validateForm(this)">
        <input type="hidden" name="action" value="addQuestion"/>
    <div class="questionborder">
        <h3>Questions</h3>
    </div>
    <div class="questionNamesContent">
        <input type='text' size="45" name='questionName' value = "<?php echo $name?>" placeholder="Question Name" class="input"/>
    </div>

    <div class="skillsContent">
        <input type='text'  size="45" name='questionSkills' value = "<?php echo $skills?>" placeholder="Question Skills"/>
    </div>

    <div class="questionBodiesContent">
        <textarea cols="45" name="questionBody" placeholder="Question Body">value = "<?php echo $body?>"</textarea>
    </div>
    <h4>(You must be logged in to ask a question.)</h4>
    <div id="formButtons">
        <input type='submit' value='Submit' class="button inner"/> &nbsp;
        <a href="project1index.php" target="_self" class="button inner">Login</a>
    </div>
</form>
</body>
</html>