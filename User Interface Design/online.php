<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Redmoon - Players Online</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        body {
            background-color: #ffffff; 
            color: #00bfa5; 
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .online-section {
            background-color: #f0f0f0; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 50%; 
            max-width: 400px; 
            margin: 40px auto; 
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center; 
            border: 1px solid #00bfa5; 
        }

        th {
            background-color: #00bfa5; 
            color: #ffffff; 
        }

        .home-button-container {
            margin-top: 20px;
        }

        .home-button-container input[type="button"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00bfa5; 
            color: #ffffff; 
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .home-button-container input[type="button"]:hover {
            background-color: #008f7a;
        }
    </style>
	
	
</head>

<body>
    <div class="home-button-container">
        <input type="button" value="HOME" onclick="window.location.href='/index.html'" />
    </div>

    <div class="online-section">
        <h2>Players Currently Online</h2>
        <table>
            <tr>
                <th>Online</th>
                <th>Account Type</th>
            </tr>
            <?php
            include("config.php");
            try {
                $query = "SELECT o.GameID, b.is_hardcore 
                          FROM tblOccupiedBillID o 
                          JOIN tblBillID b ON o.BillID = b.BillID 
                          WHERE o.GameID NOT LIKE 'GM%'";
                $stmt = odbc_exec($conn, $query);

                while ($row = odbc_fetch_array($stmt)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['GameID']) . '</td>';
                    echo '<td>';
                    if ($row['is_hardcore']) {
                        echo '<img src="face/skull.png" style="width: 50px; height: 40px;">';
                    } else {
                        echo '<img src="face/GreySkull.png" style="width: 50px; height: 40px;">';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                odbc_close($conn);
            } catch (Exception $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            ?>
        </table>
        <p>
            <img src="face/GreySkull.png" style="width: 30px; height: 30px;"> = Normal Account<br>
            <img src="face/skull.png" style="width: 30px; height: 25px;"> = Hardcore Account
        </p>
    </div>

    <script>

        setInterval(function() {
            location.reload();
        }, 10000);
    </script>
</body>
</html>
