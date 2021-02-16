<!DOCTYPE html>
<html>
    <head>
        <title>Form</title>
        <link rel="stylesheet " href="./css/style.css">
    </head>
    <body>
        <form id="reg" method="post" action="registerUser.php" enctype="multipart/form-data">
            <section>
                <h1>Registration Form</h1>
                <fieldset>
                    <legend>Basic Information</legend>
                    <div id="basicInformation">
                        <div id="basicLabel">
                            <label>Full Name</label>
                            <label>Username</label>
                            <label>Email</label>
                            <label>Password</label>
                            <label>Confirm Password</label>
                            <label>Phone</label>
                        </div>
                        <div id="basicInput">
                            <input type="text" name="name" required="required" placeholder="Firstname Lastname">

                            <div><input id="username" type="text" name="username" required="required" placeholder="username"><span id="valid" class="valid">Username valid</span><span id="invalid" class="invalid">Username taken</span></div>

                            <div><input type="email" name="email" required="required" placeholder="Email" id="email"> <span class="valid" id="validEmail">Email valid</span> &nbsp; &nbsp;<u><span id="verifyEmailButton">Verify Email!</span></u><span id="invalidEmail" class="invalid">Email taken</span></div>

                            <div><input type="password" name="password" required="required" placeholder="Password (>6)" id="password"><span id="invalidLength" class="invalid">Password should have minimum 6 digits</span><span class="valid" id="validLength">Password passed all requirements</span><br><br></div>

                            <div><input type="password" name="conPassword" required="required" placeholder="Re-enter password" id="conPassword"><span class="invalid" id="invalidConPassword">Password did not match!</span><span class="valid" id="validConPassword">Password matched!</span><br><br></div>

                            <div><input type="number" name="phone" required="required" placeholder="Phone Number" id="phone"><u><span id="verifyPhoneButton">Verify Phone!</span></u><br><span class="invalid" id="invalidPhone">Phone Number already registered!</span><br><br></div>

                        </div>

                    </div>
                </fieldset>

                <fieldset>
                    <legend>Job profile</legend>
                    <br>
                    <label>Experience</label>
                    <select name="dropdown" id="dropdown">
                        <option value="0">zero</option>
                        <option value="1">one</option>
                        <option value="2">two</option>
                        <option value="3">three</option>
                        <option value="4">four</option>
                    </select>
                    <span>year(s)</span>
                    <br>
                    <br>
                    <label>Profile</label><br>
                    <input type="checkbox" name="checkboxes" value="softwareDeveloper">Software developer<br>
                    <input type="checkbox" name="checkboxes" value="javaProgrammer">Java Programmer<br>
                    <input type="checkbox" name="checkboxes" value="ai">Artificial Intelligence<br>
                    <input type="checkbox" name="checkboxes" value="ml">Machine Learning<br>
                    <br>
                    <label>Gender</label>
                    <input type="radio" name="radio" checked="checked" value="male">male
                    <input type="radio" name="radio" value="female">female
                    <input type="radio" name="radio" value="other">other
                    <br>
                    <br>
                    <label>Profile Picture</label>
                    <input type="file" name="profilePicture" value="profilePicture">
                    <br>
                    <br>
                    <input type="submit" id="submit" value="submit" name="submit">
                    <input type="button" value="Reset" id="resetbtn">

                </fieldset>
            </section>
        </form>
        <script src="./jquery-3.5.1.js"></script>
        <script src="./js/main.js"></script>
    </body>
</html>