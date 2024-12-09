<?php
session_start();
include('dbcon.php'); // Include your database connection file

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token) {
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
    $mail->Subject = "Email Verification";
    $mail->Body = $email_template;

    // Send the email
    $mail->send();
}

if (isset($_POST['register_btn'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());

    // Check if email exists
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email ID Already Exists";
        header("Location: register.php");
    } else {
        // Insert user data
        $query = "INSERT INTO users (name, phone, email, password, verify_token) VALUES ('$name', '$phone', '$email', '$password', '$verify_token')";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            sendemail_verify($name, $email, $verify_token);
            $_SESSION['status'] = "Registration Successful! Please verify your email address.";
            header("Location: register.php");
        } else {
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");
        }
    }
}
?>w