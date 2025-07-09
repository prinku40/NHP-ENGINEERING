<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';
require 'mail/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = strip_tags(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
        http_response_code(400);
        echo "Please complete the form.";
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';       // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nikhilparmar2707@gmail.com';  // 🔁 Replace with your Gmail address
        $mail->Password   = 'jsny qkhm rrje ebxa';    // 🔁 Replace with your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Email Headers
        $mail->setFrom($email, $name);               // From user's input
        $mail->addAddress('nikhilparmar2707@gmail.com');    // 🔁 Replace with your Gmail address

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br("From: $name\nEmail: $email\n\nMessage:\n$message");

        // Send Email
        $mail->send();
        http_response_code(200);
        echo "Message sent successfully!";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "Invalid request method.";
}