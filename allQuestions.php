<html>
    <head><title>
        </title></head>    
<body>
<?php
$questions = $_SESSION['allQuestions'];
$cnt = count($questions);
//echo $cnt;
echo "<table border='1'><tr><th>Title</th><th>Skills</th><th>Body</th></tr>";
for ($i=0; $i < $cnt; ++$i)
{
    echo "<tr><td>".$questions[$i]->getQuestionTitle() . "</td><td>".$questions[$i]->getQuestionSkills() . "</td><td>".$questions[$i]->getQuestionBody() . "</td></tr>";
}
echo "</table>"
?>
</body>
</html>
