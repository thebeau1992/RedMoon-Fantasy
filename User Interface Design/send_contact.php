<?php


header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $title = htmlspecialchars($_POST["title"]);
    $message = htmlspecialchars($_POST["message"]);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0; 
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'redmoon.fantasy1@gmail.com'; 
        $mail->Password = 'pbwy iwgw cqgn okiw'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587; 

        
        $mail->setFrom('redmoon.fantasy1@gmail.com', 'Shawn Thebeau');

        $mail->isHTML(true); 
        $mail->Subject = $title;
        $mail->Body    = nl2br("Email: $email\n\nMessage:\n$message");
        $mail->AltBody = "Email: $email\n\nMessage:\n$message";

        $mail->send();
        
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Message Sent</title>
			<link rel="icon" href="/favicon.ico" type="image/x-icon">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    color: #046276;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    text-align: center;
                }
                .message-container {
                    background-color: #fff;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .message-container h1 {
                    font-size: 24px;
                    margin-bottom: 20px;
                    color: #046276;
                }
                .message-container button {
                    background-color: #40E0D0;
                    color: #fff;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                .message-container button:hover {
                    background-color: #26867d;
                }
            </style>
			
        </head>
        <body>
            <div class="message-container">
                <h1>Message sent successfully!</h1>
                <button onclick="goBack()">Go Back</button>
            </div>
            <script>
                function goBack() {
                    window.history.back();
                }
            </script>
			
        </body>
        </html>';
    } catch (Exception $e) {
        echo "Failed to send message. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
