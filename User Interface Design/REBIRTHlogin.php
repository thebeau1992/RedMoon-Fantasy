<?php

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (session_id() == '') {
    session_start();
}

require 'common.inc.php'; 
require_once 'config.inc.php';
require_once 'DB.class.php';

if (!isset($db)) {

    $db = new DB(); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Redmoon Login</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <style>
        body {
            background-color: #ffffff;
            color: #00bfa5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            text-align: center;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            width: 300px;
        }

        .logout-button, .login-button, .continue-button {
            display: inline-block;
            background-color: #00bfa5;
            color: #ffffff;
            padding: 10px 20px;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-button:hover, .login-button:hover, .continue-button:hover {
            background-color: #008f7a;
        }

        .message {
            margin-bottom: 20px;
        }

        .character-selection {
            margin-top: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #00bfa5;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
	
	<script src="script.js?v=<?php echo filemtime('script.js'); ?>"></script>

	
</head>
<body>

    <div class="home-button-container">
        <input type="button" value="HOME" onclick="window.location.href='/index.html'" />
    </div>

    <?php
    if (isset($_SESSION['username'])) {
        echo "<div class='form-container'>
                <p class='message'></p>
                <a href='/REBIRTHpage.php' class='logout-button'>CLICK HERE TO CONTINUE</a>
              </div>";
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);


            $query = $db->query('SELECT * FROM tblBillID WHERE BillID = ? AND Password = ?', array($username, $password));
            if ($user = $query->fetch()) {
                $_SESSION['username'] = $user['BillID'];
                header("Location: /REBIRTHpage.php");
                exit;
            } else {
                echo "<div class='form-container'><p>Invalid username or password. Please try again.</p></div>";
            }
        }


        echo "<div class='form-container'>
                <form method='post' action=''>
                    <label for='username'>Username:</label>
                    <input type='text' id='username' name='username' maxlength='20' required>
                    <label for='password'>Password:</label>
                    <input type='password' id='password' name='password' maxlength='20' required>
                    <input type='submit' value='Login' class='login-button'>
                </form>
              </div>";
    }
    ?>
</body>
</html>

