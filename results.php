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
        <script src="./jquery-3.5.1.js"></script>
        <style>
            input{
                width:100px;
            }
        </style>
    </head>
    <body>
        <h1>Welcome, <?php echo $_GET["user"]?></h1>
        <table>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Full Name
                </th>
                <th>
                    Username
                </th>
                <th>
                    Email
                </th>
                <th>
                    Phone
                </th>
                <th>
                    Experience
                </th>
                <th>
                    Profiles
                </th>
                <th>
                    Gender
                </th>
                <th>
                    Profile Pic URL
                </th>
              
                <th>
                    Action
                </th>
            </tr>
            <?php
            require_once('./dao/databaseDao.php');
            $dao = new databaseDao();
            $dao->createConnection();
            $results = $dao->getAllData();

            if ($results->num_rows > 0) {
                // output data of each row
                /*
                 * ***********************************
                 * Inserts data to table
                 * ***********************************
                 */
                while ($row = $results->fetch_assoc()) {
                    echo "<tr><td><input class='userid' disabled value='" . $row["userId"] . "'></td><td><input class='fullName' disabled value='" . $row['fullName'] . "'></td><td><input class='username' disabled value='" . $row['username'] . "'></td><td><input class='email' disabled value='" . $row['email'] . "'></td><td><input class='phone' disabled value='" . $row['phone'] . "'></td><td><input class='experience' disabled value='" . $row['experience'] . "'></td><td><input class='profile' disabled value='" . $row['profile'] . "'></td><td><input class='gender' disabled value='" . $row['gender'] . "'></td><td><input class='profilePicUrl' disabled value='" . $row['profilePicture'] . "'></td><input type ='hidden' class='password' disabled value='" . $row['password'] . "'></td>";
                    echo "<td><button class='updateButton' type='submit' value='update' name='" . $row["userId"] . "'>Edit</button>";
                    echo "<button class='deleteButton' type='submit' value='delete' name='" . $row["userId"] . "'>Delete</button></td></tr>";
                }
            } else {
                echo "0 results";
            }
            ?>
        </table>
        <script>
            const SUCCESS_CODE = 200;
            $(".updateButton").on("click", function () {
                if ($(this).text() === "Edit") {
                    $(this).text("Update");
                    $(this).parent().parent().find("input").prop("disabled", false)
                } else if ($(this).text() === "Update") {
                    $.ajax({
                        type: 'post',
                        url: './php/updateData.php',
                        data: {'userid': $(this).parent().parent().find(".userid").val(),
                            'fullName': $(this).parent().parent().find(".fullName").val(),
                            'username': $(this).parent().parent().find(".username").val(),
                            'email': $(this).parent().parent().find(".email").val(),
                            'phone': $(this).parent().parent().find(".phone").val(),
                            'experience': $(this).parent().parent().find(".experience").val(),
                            'profile': $(this).parent().parent().find(".profile").val(),
                            'gender': $(this).parent().parent().find(".gender").val(),
                            'profilePictureUrl': $(this).parent().parent().find(".profilePicUrl").val(),
                            'password': $(this).parent().parent().find(".password").val()
                        },
                        success: function (response) {
                            console.log(response == SUCCESS_CODE);
                            if (response == SUCCESS_CODE) {
                                alert("Data updated successfully");
                                location.reload();
                                $(".updateButton").parent().parent().find("input").prop("disabled", true);
                            } else {
                                confirm("Something went wrong!");

                            }
                        }
                    });
                }
            });
            $(".deleteButton").on("click", function () {
                let userSelection = confirm("Are you sure? This cannot be undone!");
                if (userSelection) {
                    $.ajax({
                        type: 'post',
                        url: './php/updateData.php',
                        data: {"action": "delete",
                            'userid': $(this).parent().parent().find(".userid").val()},
                        success: function (response) {
                            if (response == SUCCESS_CODE) {
                                alert("Row deleted successfully!");
                                location.reload();
                            } else {
                                alert("Something went wrong!");
                            }
                        }
                    });
                }
            });
        </script>
    </body>
</html>
