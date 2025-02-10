<?php

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

session_start();

require 'dbconfig.php'; 

try {
    $dsn = "odbc:Driver={SQL Server};Server=$hostname;Database=$dbname;";
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Unable to connect to the database: " . $e->getMessage());
}

$goal_amount = 50000.00;

$sql_total = "SELECT SUM(Price) AS total_purchases FROM PurchaseLog";
$stmt_total = $pdo->query($sql_total);
$total_purchases_row = $stmt_total->fetch(PDO::FETCH_ASSOC);
$total_purchases = $total_purchases_row['total_purchases'] ?? 0; 

$sql_latest = "
    SELECT TOP 1 Price, PurchaseTime
    FROM PurchaseLog
    ORDER BY PurchaseTime DESC
";
$stmt_latest = $pdo->query($sql_latest);
$latest_purchase = $stmt_latest->fetch(PDO::FETCH_ASSOC);

if (!$latest_purchase) {
    $latest_purchase = [
        'Price' => 'N/A',  
        'PurchaseTime' => 'N/A'  
    ];
}

$progress = ($total_purchases / $goal_amount) * 100;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Progress</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            background-color: #f4f4f4; 
        }
        .container {
            width: 50%;
            text-align: center;
            background-color: #ffffff; 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .progress-bar-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 25px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            width: <?php echo $progress; ?>%;
            height: 30px;
            background-color: #00bfa5;
            text-align: center;
            line-height: 30px;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .home-button {
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
        .events {
            margin-top: 20px;
        }
        .events h3, .events p {
            margin: 5px 0;
        }
    </style>
    <script>
        setInterval(function() {
            location.reload();
        }, 10000);
    </script>
	
	<script src="script.js?v=<?php echo filemtime('script.js'); ?>"></script>
	
</head>
<body>

        <div class="home-button">
            <form>
                <center><input type="button" value="Home" onclick="window.location.href='/index.html'" /></center>
            </form>

        </div>


    <div class="container">
        <div class="message">
            <h2>Once at 100% we will have a month long ingame event! Please PM me for other event suggestions.</h2>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar"><?php echo round($progress, 2); ?>%</div>
        </div>
        <table>
            <tr>
                <th>Latest Contribution Amount</th>
                <th>Date</th>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($latest_purchase['Price']); ?></td>
                <td><?php echo htmlspecialchars($latest_purchase['PurchaseTime']); ?></td>
            </tr>
        </table>

        <div class="home-button">
            <form>
                <input type="button" value="Contribute Here" onclick="window.location.href='/Shop.php'" />
            </form>
        </div>
        <div class="events">
            <h3>Event Ideas</h3>
            <p>1. Double EXP</p>
            <p>2. Shapeshift</p>
            <p>3. Wyvern event</p>
            <p>4. Enhanced SS drops</p>
            <p>5. Super Egg</p>
            <p>6. All boosters</p>
        </div>
    </div>

</body>
</html>
