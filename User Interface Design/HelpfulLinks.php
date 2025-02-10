<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Redmoon</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #ffffff; 
            color: #00bfa5; 
        }

        .center-container {
            text-align: center;
            margin-top: 20px;
        }

        form {
            margin-top: 20px;
        }

        input[type="button"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00bfa5; 
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="button"]:hover {
            background-color: #008f7a;
        }

        .character-section, .online-section, .button-section {
            margin: 20px auto;
            width: 80%;
            background-color: #f0f0f0; 
            padding: 20px;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 2px solid #00bfa5; 
        }

        th {
            background-color: #00bfa5; 
            color: #ffffff; 
        }
    </style>
	
	<script src="script.js?v=<?php echo filemtime('script.js'); ?>"></script>
	
</head>

<body>

    <div class="center-container">
        <form>
            <input type="button" value="Home" onclick="window.location.href='/index.html'" />
        </form>
    </div>

    <div class="button-section">
        <center>
            <form>
                <input type="button" class="circular-button" value="Lotto Ticket Items" onclick="window.location.href='/Lotto.php'" />
            </form>
            <form>
                <input type="button" class="circular-button" value="Game Guide" onclick="window.location.href='/Guide.php'" />
            </form>
	    <form>
                <input type="button" class="circular-button" value="Troubleshooting" onclick="window.location.href='/troubleshoot.php'" />
            </form>
            <form>
                <input type="button" class="circular-button" value="Map Levels" onclick="window.location.href='/MapLevels.php'" />
            </form>
            <form>
                <input type="button" class="circular-button" value="Custom Items" onclick="window.location.href='/CustomItems.php'" />
            </form>
            <form>
                <input type="button" class="circular-button" value="Skill List" onclick="window.location.href='/SkillList.php'" />
            </form>
            <form>
                <input type="button" class="circular-button" value="Un-Stuck" onclick="window.location.href='/login.php'" />
            </form>

            <form>
                <input type="button" class="circular-button" value="Delete Character" onclick="window.location.href='/DELETElogin.php'" />
            </form>
            <form>
                <input type="button" class="circular-button" value="Rebirth" onclick="window.location.href='/REBIRTHlogin.php'" />
            </form>
            <form>
                <input type="button" value="BattleMatchGuide" onclick="window.location.href='/BattleMatchGuide.php'" />
            </form>
            <form>
                <input type="button" value="Honor Change" onclick="window.location.href='/HonorChange.php'" />
            </form>
        </center>
    </div>

</body>

</html>
