<?php

require 'common.inc.php';
require 'dbconfig.php'; 

html_header('Character Rebirth', '#00bfa5', '#ffffff'); 

function executeWithRetry($pdo, $sql, $params, $maxRetries = 3) {
    $attempt = 0;
    while ($attempt < $maxRetries) {
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'deadlock victim') !== false && $attempt < $maxRetries - 1) {
                $attempt++;
                sleep(1); 
            } else {
                throw $e;
            }
        }
    }
    return false;
}

function logRebirth($pdo, $gameID, $prevLvl, $prevSubQuestGiftFame, $prevSTotalBonus, $success, $errorMessage = null) {
    $sql = 'INSERT INTO tblRebirthLog 
            (GameID, PreviousLevel, PreviousSubQuestGiftFame, PreviousSTotalBonus, Success, ErrorMessage) 
            VALUES (:gameID, :prevLvl, :prevSubQuestGiftFame, :prevSTotalBonus, :success, :errorMessage)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':gameID' => $gameID,
        ':prevLvl' => $prevLvl,
        ':prevSubQuestGiftFame' => $prevSubQuestGiftFame,
        ':prevSTotalBonus' => $prevSTotalBonus,
        ':success' => $success,
        ':errorMessage' => $errorMessage
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];

    $lockFile = sys_get_temp_dir() . "/rebirth_lock_" . md5($name) . ".lock";

    if (file_exists($lockFile)) {
        echo "<p>Rebirth is already in progress for $name. Please try again later.</p><hr>";
        exit;
    }

    file_put_contents($lockFile, "locked");

    try {

        $fetchSql = 'SELECT Lvl, SubQuestGiftFame, STotalBonus FROM tblGameID1 WHERE GameID = :name';
        $stmt = $pdo->prepare($fetchSql);
        $stmt->execute([':name' => $name]);
        $charData = $stmt->fetch(PDO::FETCH_ASSOC);

        $prevLvl = $charData['Lvl'];
        $prevSubQuestGiftFame = $charData['SubQuestGiftFame'];
        $prevSTotalBonus = $charData['STotalBonus'];

        if ($prevLvl >= 1000) {
            $sql = 'UPDATE tblGameID1 SET 
                Lvl = 1, 
                SubQuestGiftFame = COALESCE(SubQuestGiftFame, 0) + 1, 
                STotalBonus = STotalBonus + 2000,
                Bonus = 2, 
                Bonus2 = 0, 
                SBonus = 0, 
                Strength = 10,
                Spirit = 10,
                Dexterity = 10,
                Power = 10,
                HP = 50,
                MP = 50,
                SP = 0,
                DP = 0,
                Map = 22,
                X = 9,
                Y = 15
                WHERE GameID = :name';

            $success = executeWithRetry($pdo, $sql, [':name' => $name]);

            if ($success) {
                echo "<p>$name has now been reborn and moved to the starting location.</p><hr>";
                logRebirth($pdo, $name, $prevLvl, $prevSubQuestGiftFame, $prevSTotalBonus, 1);
            } else {
                echo "<p>Failed to rebirth $name due to a deadlock. Please try again later.</p><hr>";
                logRebirth($pdo, $name, $prevLvl, $prevSubQuestGiftFame, $prevSTotalBonus, 0, 'Deadlock occurred');
            }
        } else {
            echo "<p>$name does not meet the level requirement for rebirth.</p><hr>";
        }

    } catch (PDOException $e) {
        echo "Database query execution failed: " . $e->getMessage();
        logRebirth($pdo, $name, $prevLvl, $prevSubQuestGiftFame, $prevSTotalBonus, 0, $e->getMessage());
    }

    unlink($lockFile);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redmoon - Rebirth Character</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="home-button-container">
        <input type="button" value="LOGOUT" onclick="window.location.href='/REBIRTHlogout.php'" />
    </div>

    <div class="form-container">
        <form method="post">
            <strong>Rebirth Your Character</strong><br><br>
<?php
if (isset($account) && isset($account['loggedin']) && $account['loggedin']) {
    echo '<form method="post">';
    echo '<select name="name">';
    foreach ($account['chars'] as $char) {
        if ($char['Lvl'] >= 1000) {  
            echo "<option value='{$char['GameID']}'>{$char['GameID']}</option>";
        }
    }
    echo '</select>';
    echo '<input type="submit" value="Rebirth Now">';
    echo '</form>';
} else {
    echo "<p>(log in to get a select box)</p>";
}
?>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Redmoon Login</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
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
