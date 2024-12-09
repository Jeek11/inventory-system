<?php
session_start();
include('dbcon.php');

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function resend_email_verify($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Uncomment for debugging
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "iandivinenniepes11@gmail.com"; // Your SMTP username
    $mail->Password = "sjobswwfdrppcvjj"; // Your SMTP password
    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;

    // Recipients
    $mail->setFrom("iandivinenniepes11@gmail.com", "Niepes");
    $mail->addAddress($email);

    // Email content
    $email_template = "
    <h2>You have registered with the Login Form of Niepes.</h2>
    <h5>Verify your email to login with the given link below.</h5>
    <br/>
    <a href='http://localhost/login_reg/verify-email.php?token=$verify_token'>Click Me!</a>
    ";

    // Set content-type to HTML
    $mail->isHTML(true);
    $mail->Subject = "Resend - Email Verification from Jeek Ian Niepes";
    $mail->Body = $email_template;

    // Send the email
    $mail->send();
}

if(isset($_POST['resend_email_verify_btn']))
{
    if(!empty(trim($_POST['email'])))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $checkemail_query);

            if(mysqli_num_rows($checkemail_query_run) > 0)
            {
                $row = mysqli_fetch_array($checkemail_query_run);
                if($row['verify_status'] == "0")
                {
                    $name = $row['name'];
                    $email = $row['email'];
                    $verify_token = $row['verify_token'];

                    resend_email_verify($name,$email,$verify_token);
                    $_SESSION['status'] = "Verification email link has sent to your email address.!";
                    header("Location: login.php");
                    exit(0);
                }
                else
                {
                    $_SESSION['status'] = "Email already verify. Please login";
                    header("Location: resend-email-verification.php");
                    exit(0);
                }

            }
            else
            {
                $_SESSION['status'] = "Email is not registered. Please register now.!";
                header("Location: register.php");
                exit(0);
            }
    }
    else
    {
        $_SESSION['status'] = "Please enter the email field";
        header("Location: resend-email-verification.php");
        exit(0);
    }
}

?>