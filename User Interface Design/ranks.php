<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redmoon Fantasy</title>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <style>
       
        body {
            height: 100%;
            width: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #ffffff; 
            color: #00bfa5; 
        }
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh; 
        }
        .home-button-container {
            margin-top: 20px;
            text-align: center; 
        }
        .home-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00bfa5;
            color: #ffffff; 
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .home-button:hover {
            background-color: #008f7a;
        }
        .section {
            margin: 20px auto;
            width: 90%; 
            max-width: 1200px;
            background-color: #f0f0f0; 
            padding: 20px;
            border-radius: 10px;
            text-align: center; 
            box-sizing: border-box; 
        }
        table {
            width: 100%; 
            border-collapse: collapse;
            margin: 0 auto;
        }
        th, td {
            padding: 15px;
            text-align: center;
            border: 2px solid #00bfa5; 
            word-wrap: break-word; 
        }
        th {
            background-color: #00bfa5; 
            color: #ffffff; 
        }
        td img {
            width: 50px;
            height: 40px;
        }
    </style>
	
	<script src="script.js?v=<?php echo filemtime('script.js'); ?>"></script>

	
</head>

<body>
    <div class="home-button-container">
        <a href="/index.html" class="home-button">HOME</a>
    </div>

    <div class="main-content">
        <div class="section">
            <h2>Redmoon Fantasy Army</h2>
            <table>
                <tr>
                    <th>Army Names</th>
                    <th>Commander</th>
                    <th>Camp</th>
                </tr>
                <?php
                include("config.php"); 
                if (isset($conn)) {
                    $query = "SELECT TOP 500 Name, Commander, Camp FROM tblArmyList1";
                    $result = odbc_exec($conn, $query);
                    if ($result) {
                        while ($row = odbc_fetch_array($result)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['Name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['Commander']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['Camp']) . '</td>';
                            echo '</tr>';
                        }
                        odbc_free_result($result);
                    } else {
                        echo "<tr><td colspan='3'>Error in query execution: " . odbc_errormsg($conn) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Error: Database connection not established.</td></tr>";
                }
                ?>
            </table>
        </div>

        <div class="section">
            <h2>Redmoon Fantasy Characters</h2>
            <p>
                <img src="face/GreySkull.png" style="width: 20px; height: 20px;"> = Normal Account<br>
                <img src="face/skull.png" style="width: 30px; height: 25px;"> = Hardcore Account
            </p>
            <?php
			
			header("Cache-Control: no-cache, must-revalidate");
			header("Pragma: no-cache");
			header("Expires: 0");
			
            if (isset($conn)) {

                $execSPQuery = "{CALL redmoon.dbo.StoreHardcoreBonusPoints}";
                odbc_exec($conn, $execSPQuery);


                $query = "
                    SELECT TOP 3000 g.GameID, g.Lvl, g.Face, g.SubQuestGiftFame, g.STotalBonus, g.BillID, 
                           ISNULL(hbp.Post1000LevelUps, 0) AS Post1000LevelUps
                    FROM tblGameid1 g
                    LEFT JOIN HardcoreBonusPoints hbp
                    ON g.GameID = hbp.GameID AND g.BillID = hbp.BillID
                    WHERE g.GameID NOT LIKE 'GM%' AND g.GameID NOT LIKE 'MasterSadad' AND g.GameID NOT LIKE 'King' AND g.GameID NOT LIKE 'LON' AND g.GameID NOT LIKE 'MIMI' AND g.GameID NOT LIKE 'KTDY' AND g.GameID NOT LIKE 'HOT' AND g.GameID NOT LIKE 'Thanksgod' AND g.GameID NOT LIKE 'KRDKsssL' AND g.Lvl >= 1
                    ORDER BY 
                        (g.STotalBonus + ISNULL(hbp.Post1000LevelUps, 0)) DESC, 
                        g.SubQuestGiftFame DESC,                               
                        g.Lvl DESC                                              
                ";
                $result = odbc_exec($conn, $query);
                if ($result) {
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Name</th>';
                    echo '<th>Level</th>';
                    echo '<th>Character</th>';
                    echo '<th>Rebirth Count</th>';
                    echo '<th>Bonus Points</th>';
                    echo '<th>Hardcore</th>';
                    echo '<th>Last Login</th>';
                    echo '</tr>';

                    while ($row = odbc_fetch_array($result)) {

                        $accountQuery = "SELECT is_hardcore, LastLogin FROM tblBillID WHERE BillID = ?";
                        $accountStmt = odbc_prepare($conn, $accountQuery);
                        odbc_execute($accountStmt, array($row['BillID']));
                        $accountRow = odbc_fetch_array($accountStmt);


                        $isHardcore = false;
                        $lastLogin = 'N/A';
                        if ($accountRow !== false) {
                            $isHardcore = ($accountRow['is_hardcore'] == '1');
                            $lastLogin = isset($accountRow['LastLogin']) ? $accountRow['LastLogin'] : 'N/A';
                        }


                        if ($isHardcore) {
                            $bonusPoints = intval($row['Post1000LevelUps']); 
                        } else {
                            $bonusPoints = intval($row['STotalBonus']);  
                        }
                        $displayedLevel = ($row['Lvl'] >= 1000) ? 1000 : $row['Lvl'];

                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['GameID']) . '</td>';
                        echo '<td>' . htmlspecialchars($displayedLevel) . '</td>';
                        echo '<td><img src="face/' . htmlspecialchars($row['Face']) . '.jpg"></td>';
                        echo '<td>' . htmlspecialchars($row['SubQuestGiftFame']) . '</td>';
                        echo '<td>' . htmlspecialchars($bonusPoints) . '</td>';  
                        echo '<td>';
                        if ($isHardcore) {
                            echo '<img src="face/skull.png">';
                        } else {
                            echo '<img src="face/GreySkull.png">';
                        }
                        echo '</td>';
                        echo '<td>' . htmlspecialchars($lastLogin) . '</td>';
                        echo '</tr>';
                    }
                    odbc_free_result($result);
                } else {
                    echo "<tr><td colspan='7'>Error in query execution: " . odbc_errormsg($conn) . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Error: Database connection not established.</td></tr>";
            }
            ?>
        </div>


        <div class="section">
            <h2>Hardcore Bonus Points Summary</h2>
            <table>
                <tr>
                    <th>GameID</th>
                    <th>BillID</th>
                    <th>Post-1000 Level Ups</th>
                    <th>Calculation Date</th>
                </tr>
                <?php
                if (isset($conn)) {
                    $logQuery = "SELECT GameID, BillID, Post1000LevelUps, CalculationDate FROM HardcoreBonusPoints ORDER BY CalculationDate DESC";
                    $logResult = odbc_exec($conn, $logQuery);
                    if ($logResult) {
                        while ($logRow = odbc_fetch_array($logResult)) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($logRow['GameID']) . '</td>';
                            echo '<td>' . htmlspecialchars($logRow['BillID']) . '</td>';
                            echo '<td>' . htmlspecialchars($logRow['Post1000LevelUps']) . '</td>';  
                            echo '<td>' . htmlspecialchars($logRow['CalculationDate']) . '</td>';
                            echo '</tr>';
                        }
                        odbc_free_result($logResult);
                    } else {
                        echo "<tr><td colspan='4'>Error in query execution: " . odbc_errormsg($conn) . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Error: Database connection not established.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
