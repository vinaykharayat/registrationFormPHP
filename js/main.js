/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
let isEmailVerified = false;
let isPhoneNumberVerified = false;
let isPasswordValid = false;
let isPasswordMatched = false;
let isEmailExist = false;
const SUCCESS_CODE = 200;
$("#resetbtn").on('click', function (e) {
    $('#reg')[0].reset();
});
/*
 ***************************************************
 * Hides incorrect information indicators at start.
 * Like username taken, email taken, etc.
 ***************************************************
 */
$(document).ready(function () {
    $('#valid').hide();
    $('#invalid').hide();
    $('#invalidEmail').hide();
    $('#validEmail').hide();
    $('#verifyEmailButton').hide();
    $('#verifyPhoneButton').hide();
    $('#invalidPhone').hide();
    $('#invalidLength').hide();
    $('#validLength').hide();
    $('#invalidConPassword').hide();
    $('#validConPassword').hide();


});

//On form submit
$('form').on('click', "#submit", function (e) {
    if (isEmailVerified && isPhoneNumberVerified && isPasswordValid && isPasswordMatched) {
        $.ajax({
            type: 'POST',
            url: './registerUser.php',
            data: $("form").serialize(),
            cache: false,
            success: function () {
                let r = confirm("User registered successfully, press ok to goto login page");
                if (r === true) {
                    window.location.href = "./login.php";
                }
            }
        });
    } else if (!isEmailVerified) {
        e.preventDefault();
        alert("Your Email is not verified.");
    } else if (!isPhoneNumberVerified) {
        e.preventDefault();
        alert("Your Phone is not verified.");
    }

});

$('form').on('click', '#loginBtn', function (e) {
    e.preventDefault();
    console.log(isEmailExist);
    if (isEmailExist) {
        loginUser();
    } else {
        alert("Please register first!");
    }
})

function loginUser() {
    $.ajax({
        type: 'post',
        url: './loginUser.php',
        data: $('form').serialize(),
        cache: false,
        success: function (response) {
            if (response === 'exist') {
                sessionStorage.setItem("email", $('#email').val());
                console.log(sessionStorage.getItem("email"));
                window.location.href = "./results.php?user=" + sessionStorage.getItem("email");
            } else {

            }
        }
    });
}

/*
 **********************************************************
 *  Checks whether email exist in database,
 *  when user clicks out of input box after entering email
 **********************************************************
 */
document.getElementById("email").addEventListener("blur", function (e) {
    let valid = true;
    $('[required]').each(function () {
        if ($(this).is(':invalid') || !$(this).val())
            valid = false;
    });
    if (valid) {
        $.ajax({
            type: 'get',
            url: './validate.php',
            data: {'email': $('#email').val()},
            cache: false,
            success: function (response) {
                console.log(response);
                if (response === "nExist") {
                    
                    $('#validEmail').show();
                    $('#invalidEmail').hide();
                    $('#verifyEmailButton').show();
                    isEmailExist = false;

                } else {
                    $('#invalidEmail').show();
                    $('#validEmail').hide();
                    $('#verifyEmailButton').hide();
                    isEmailExist = true;

                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }else{
        console.log(valid);
    }

});

/*
 ***************************************************
 *  Checks whether email exist in database,
 *  when user changes email address in input field.
 ***************************************************
 */
$("#email").change(function (e) {
    $.ajax({
        type: 'get',
        url: './validate.php',
        data: {'email': $('#email').val()},
        cache: false,
        success: function (response) {
            if (response === "nExist") {
                $('#validEmail').show();
                $('#invalidEmail').hide();
                $('#verifyEmailButton').show();

            } else {
                $('#invalidEmail').show();
                $('#validEmail').hide();
                $('#verifyEmailButton').hide();

            }
        },
        error: function (error) {
            console.log(error);
        }
    });
});
try {
    /*
     *************************************************************
     *  Checks whether username exist in database,
     *  when user clicks out of input box after entering username
     *************************************************************
     */

    document.getElementById("username").addEventListener("blur", function (e) {
        $.ajax({
            type: 'get',
            url: './validate.php',
            data: {'username': $('#username').val()},
            cache: false,
            success: function (response) {
                if (response === "nExist") {
                    $('#valid').show();
                    $('#valid').prev().append("<br>");
                    $('#invalid').hide();
                } else {
                    $('#invalid').show();
                    $('#valid').hide();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    /*
     *********************************************************
     *  Checks password length on value change of input field
     *********************************************************
     */
    $('#password').keyup(function () {
        if ($(this).val().length < 6) {
            $('#invalidLength').show();
            $('#validLength').hide();
            isPasswordValid = false;
        } else {
            $('#invalidLength').hide();
            $('#validLength').show();
            isPasswordValid = true;
        }
    });

    /*
     ********************************************
     *  Checks confirm password matches password
     ********************************************
     */
    $('#conPassword').keyup(function () {
        if ($(this).val() !== $(this).parent().parent().find('#password').val()) {
            $('#invalidConPassword').show();
            $('#validConPassword').hide();
            isPasswordMatched = false;


        } else {
            $('#invalidConPassword').hide();
            $('#validConPassword').show();
            isPasswordMatched = true;
        }
    });
    /*
     *******************************************
     * Send a verification otp if email is valid
     *******************************************
     */
    $('#verifyEmailButton').on("click", function () {
        let responseOTP;
        if ($(this).text() === "Verify Email!") {
            $(this).text("Sending verification email...");
            $.ajax({
                type: 'post',
                url: './php/sendOTP.php',
                data: {'email': $('#email').val()},
                cache: false,
                success: function (response) //Response contains otp generated by sendOTP.php
                {
                    checkOtp(response).then((resolve) => {
                        if (resolve === SUCCESS_CODE) {
                            //If email is verified successfully
                            isEmailVerified = true;
                        }

                    }).catch(reject => {
                        if (reject) {
                            responseOTP = response;
                            $("#verifyEmailButton").text("Enter OTP");

                        }
                    });
                }
            });
            /*
             * ******************************************************************************
             * If user cancelled prompt without submitting OTP and clicks on Enter OTP later.
             * ******************************************************************************
             */
        } else if ($(this).text() === "Enter OTP") {
            const OTP = prompt("Enter OTP sent to " + $('#email').val());
            if (OTP === responseOTP) {
                $("#verifyEmailButton").text("Email verified successfully!");
                $('#validEmail').hide();

            }
        }
    });

    /*
     ******************************************************
     * Checks user entered otp with generated otp for email
     ******************************************************
     */
    function checkOtp(response) {
        return new Promise((resolve, reject) => {
            if (response !== -1) {
                const OTP = prompt("Enter OTP sent to " + $('#email').val());
                if (OTP === response) {
                    $("#verifyEmailButton").replaceWith("Email verified successfully!");
                    $('#validEmail').hide();

                    resolve(SUCCESS_CODE);
                } else if (OTP !== response && OTP !== null) {
                    alert("Invalid Email OTP. Try Again");

                } else {
                    reject(["OTP"]); //If user click on cancel.
                }
            }
        });

    }

    /*
     *****************************************************************
     *  Checks whether phone number exist in database,
     *  when user clicks out of input box after entering phone number
     *****************************************************************
     */
    document.getElementById("phone").addEventListener("blur", function (e) {

        $.ajax({
            type: 'get',
            url: './validate.php',
            data: {'phone': $('#phone').val()},
            cache: false,
            success: function (response) {
                console.log(response);
                if (response === "nExist") {
                    $('#invalidPhone').hide();
                    $('#verifyPhoneButton').show();

                } else {
                    $('#invalidPhone').show();
                    $('#verifyPhoneButton').hide();

                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    /*
     *******************************************
     * Send a verification otp if phone is valid
     *******************************************
     */
    $('#verifyPhoneButton').on("click", function () {
        let responseOTP;
        if ($(this).text() === "Verify Phone!") {
            $(this).text("Sending verification code...");
            $.ajax({
                type: 'post',
                url: './php/sendOTP.php',
                data: {'phone': $('#phone').val()},
                cache: false,
                success: function (response) //Response contains otp generated by sendOTP.php
                {
                    checkPhoneOtp(response).then((resolve, reject) => {
                        if (resolve === SUCCESS_CODE) {
                            //If phone is verified successfully
                            isPhoneNumberVerified = true;

                        }

                    }).catch(reject => {
                        if (reject) {
                            responseOTP = response;
                            $("#verifyPhoneButton").text("Enter OTP");

                        }
                    });
                }
            })
        } else if ($(this).text() === "Enter OTP") {
            const OTP = prompt("Enter OTP sent to " + $("#phone").val());
            if (OTP === responseOTP) {
                $("#verifyPhoneButton").text("Phone verified successfully!");
            }
        }
    });

    /*
     **********************************************
     * Send a verification otp if phone is valid,
     * and if user changes it later in input field.
     **********************************************
     */
    $("#phone").change(function (e) {
        $.ajax({
            type: 'get',
            url: './validate.php',
            data: {'phone': $('#phone').val()},
            cache: false,
            success: function (response) {
                console.log(response);
                if (response === "nExist") {
                    $('#invalidPhone').hide();
                    $('#verifyPhoneButton').show();

                } else {
                    $('#invalidPhone').show();
                    $('#verifyPhoneButton').hide();

                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    /*
     *******************************************************
     * Checks user entered otp with generated otp for phone
     *******************************************************
     */
    function checkPhoneOtp(response) {
        return new Promise((resolve, reject) => {
            if (response !== -1) {
                const OTP = prompt("Enter OTP sent to " + $("#phone").val());
                if (OTP === response) {
                    $("#verifyPhoneButton").replaceWith("Phone verified successfully!");
                    resolve(SUCCESS_CODE);
                } else if (OTP !== response && OTP !== null) {
                    alert("Invalid Phone OTP. Try Again");

                } else {
                    reject(["OTP"]); //If user click on cancel.
                }
            }
        });

    }
} catch (exception) {

}



