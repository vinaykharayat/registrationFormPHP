<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form id="reg" method="post" action="loginUser.php">
            <section>
                <h1>Login Form</h1>
                <fieldset>
                    <legend>Login Information</legend>
                    <br>
                    <label>Email</label>
                    <input type="email" name="email" required="required" placeholder="Email" id="email"><span style="color:red" class="valid" id="validEmail">This email is not found in our database! Are you trying to <u>Register?</u></span><br><br>
                    <br>
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" id="password"><br><br>
                    <br>
                    <label><u>Forgot Password!</u></label>
                    <br>
                    <br>
                    <input type="submit" id="loginBtn" value="Login">
                    <input type="button" value="Register" id="registerBtn">
                </fieldset>
            </section>
            <script src="./jquery-3.5.1.js"></script>
            <script src="./js/main.js"></script>
    </body>
</html>
