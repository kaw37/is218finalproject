<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="registration.css">
    <script src="registration.js"></script>
</head>
<body>
<form method="post" action="index.php"onSubmit="return validateForm(this)">
        <input type="hidden" name="action" value="register"/>
    <h3>Registration Form:</h3>
    <div class="firstAndLastNameField">
        <input type='text' name='firstName' value="<?php echo $fname?>" placeholder="First Name"/> <br>
    </div>
    <div class="firstAndLastNameField">
        <input type='text' name='lastName' placeholder="Last Name" value="<?php echo $lname?>"/>
    </div>
    <div class="birthdayField">
        <input type='text' name='birthday' placeholder="Birthday (yyyy-mm-dd)"  value="<?php echo $birthday?>"/>
    </div>
    <div class="emailAndPasswordField">
        <input type='text' name='email' placeholder="Email" value="<?php echo $email?>"/>
    </div>
    <div class="emailAndPasswordField">
        <input type='password' name='password' placeholder="Password"/>
    </div>
    <div id="formButtons">
        <input type='submit' value='Register' class="button inner"/>
        <a href="project1index.html" class="button inner">Home</a></div>
</form>
</body>
</html>