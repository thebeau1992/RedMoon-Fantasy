<?php


session_start();

require 'dbconfig.php'; 

try {
    $dsn = "odbc:Driver={SQL Server};Server=$hostname;Database=$dbname;";
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Unable to connect to the database: " . $e->getMessage());
}


$paypalConfig = include('paypal_config.php');
$paypal_client_id = $paypalConfig['client_id'];


function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


function addPackageToCart($game_id, $package_name, $price, $items = null) {
   
    if (empty($items)) {
        $items = [
            ['name' => $package_name, 'kind' => $_POST['item_kind'], 'index' => $_POST['item_index'], 'count' => $_POST['item_count']]
        ];
    }
    
    $_SESSION['cart'][] = array(
        'game_id' => $game_id,
        'item' => $package_name,
        'price' => $price,
        'sub_items' => $items
    );
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_id = isset($_POST['game_id']) ? sanitize_input($_POST['game_id']) : '';
    $package_name = isset($_POST['item']) ? sanitize_input($_POST['item']) : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $items = array(); 

    if (isset($_POST['add_to_cart'])) {
      
        if ($package_name == 'Beginner Gear Set') {
            $items = [
                ['name' => 'Fresh Breeze', 'kind' => 6, 'index' => 23, 'count' => 1],
                ['name' => 'Erinyes Shield', 'kind' => 6, 'index' => 98, 'count' => 1],
                ['name' => 'Jupiter Chest Piece', 'kind' => 6, 'index' => 8, 'count' => 1],
                ['name' => 'Jupiter Leggings', 'kind' => 6, 'index' => 12, 'count' => 1],
                ['name' => '3x Protections', 'kind' => 6, 'index' => 196, 'count' => 3],
                ['name' => '3x Protections', 'kind' => 6, 'index' => 196, 'count' => 3],
                ['name' => '3x Protections', 'kind' => 6, 'index' => 196, 'count' => 3]
            ];
        } elseif ($package_name == 'Moderate Gear Set') {
            $items = [
                ['name' => 'Ancient Coin', 'kind' => 6, 'index' => 223, 'count' => 1],
                ['name' => 'Legendary Necklace', 'kind' => 6, 'index' => 221, 'count' => 1],
                ['name' => 'Fallen Star', 'kind' => 6, 'index' => 219, 'count' => 1],
                ['name' => '5x Protections', 'kind' => 6, 'index' => 196, 'count' => 5],
                ['name' => '5x Protections', 'kind' => 6, 'index' => 196, 'count' => 5],
                ['name' => '5x Protections', 'kind' => 6, 'index' => 196, 'count' => 5],
                ['name' => '5x Protections', 'kind' => 6, 'index' => 196, 'count' => 5],
                ['name' => '5x Protections', 'kind' => 6, 'index' => 196, 'count' => 5],
                ['name' => '5x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 5],
                ['name' => '5x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 5],
                ['name' => '5x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 5],
                ['name' => '5x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 5],
                ['name' => '5x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 5]
            ];
        } elseif ($package_name == 'Advanced Gear Set') {
            $items = [
                ['name' => 'Fantasy Necklace', 'kind' => 6, 'index' => 237, 'count' => 1],
                ['name' => 'Fantasy Diamond', 'kind' => 6, 'index' => 211, 'count' => 1],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Lotto Tickets', 'kind' => 6, 'index' => 197, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => '8x Protections', 'kind' => 6, 'index' => 196, 'count' => 8],
                ['name' => 'Heart of Redmoon x3', 'kind' => 6, 'index' => 231, 'count' => 3],
                ['name' => 'Heart of Redmoon x3', 'kind' => 6, 'index' => 231, 'count' => 3],
                ['name' => 'Heart of Redmoon x3', 'kind' => 6, 'index' => 231, 'count' => 3]
            ];
        } elseif ($package_name == 'Ring Set') {
            $items = [
                ['name' => 'Graupnel', 'kind' => 6, 'index' => 35, 'count' => 1],
                ['name' => 'Topaz', 'kind' => 6, 'index' => 36, 'count' => 1],
                ['name' => 'Aquarine', 'kind' => 6, 'index' => 37, 'count' => 1]
            ];
        } elseif ($package_name == 'Majestic Ring') {
            $items = [
                ['name' => 'Majestic Ring', 'kind' => 6, 'index' => 107, 'count' => 1]
            ];
		} elseif ($package_name == '7-Day Subscription') {
			$items = [];
        } elseif ($package_name == 'Clear Stage 0 Weapons') {
            $items = [
                ['name' => $_POST['item'], 'kind' => 6, 'index' => $_POST['item_index'], 'count' => 1]
            ];
        } elseif ($package_name == 'Sunset Armor') {
            $items = [
                ['name' => $_POST['item'], 'kind' => 6, 'index' => $_POST['item_index'], 'count' => 1]
            ];
        } elseif ($package_name == 'Miscellaneous Uniques') {
            $items = [
                ['name' => $_POST['item'], 'kind' => 6, 'index' => $_POST['item_index'], 'count' => 1]
            ];
        }

        
        addPackageToCart($game_id, $package_name, $price, $items);
    } elseif (isset($_POST['donate'])) {
        
        $game_id = sanitize_input($_POST['game_id']);
        $donation_amount = floatval($_POST['donation_amount']);
        $package_name = "Contribution";

        $items = [
            ['name' => 'Contribution', 'kind' => 0, 'index' => 0, 'count' => 1] 
        ];

        addPackageToCart($game_id, $package_name, $donation_amount, $items);

        echo "<p>Thank you for your contribution of \${$donation_amount}!</p>";
    } elseif (isset($_POST['remove_item'])) {
        $index = intval($_POST['remove_item']);
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    } elseif (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = array();
    } elseif (isset($_POST['paypal_success'])) {
        foreach ($_SESSION['cart'] as $cart_item) {
            $game_id = $cart_item['game_id'];
            $time = date('Y-m-d H:i:s');

	if ($cart_item['item'] === '7-Day Subscription') {
		$sql = "UPDATE tblGameID1
				SET SETimer = '3:24853705.7:24557789.8:960953.9:24645069.17:24831647.21:24677465.23:49817998.24:24819335.25:2039953.30:24687226.32:24384586.33:24340072.42:9240779.44:11766068.45:11808589.46:24595965.52:49642946.53:0.58:0.64:3093953.'
				, TLETimer= '1:29947974.2:29957974.3:29969986.4:29947974.5:29969986.6:29979985.10:29947974.11:29979985.12:600000.'
				, PoisonUsedDate = DATEADD(DAY, 7, GETDATE())
				, SurvivalEvent = 1
				WHERE GameID = :game_id";
				
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':game_id', $game_id, PDO::PARAM_STR);
		$stmt->execute();

		echo "7-Day Subscription (perks) applied to GameID {$game_id}!<br>";
        
	}
            
            $sub_items = isset($cart_item['sub_items']) ? $cart_item['sub_items'] : [
                [
                    'name' => $cart_item['item'],
                    'kind' => $_POST['item_kind'], 
                    'index' => $_POST['item_index'],
                    'count' => $_POST['item_count']
                ]
            ];

            foreach ($sub_items as $sub_item) {
                $item_name = $sub_item['name'];
                $item_kind = $sub_item['kind'];
                $item_index = $sub_item['index'];
                $item_count = $sub_item['count'];

                
		$sql = "INSERT INTO PurchaseLog (GameID, Item, Price, PurchaseTime, ItemKind, ItemIndex) 
        		VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$game_id, $item_name, $cart_item['price'], $time, $item_kind, $item_index]);


               
                $sql = "EXEC RMS_SENDSPECIALITEMMAIL 
                        @Sender = '[GMFantasy]', 
                        @Recipient = :game_id, 
                        @Title = '[StorePurchase]', 
                        @Content = 'Thank you for your purchase!', 
                        @ItemKind = :itemKind, 
                        @ItemIndex = :itemIndex, 
                        @ItemCount = :CNT"; 

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':game_id', $game_id, PDO::PARAM_STR);
                $stmt->bindParam(':itemKind', $item_kind, PDO::PARAM_INT);
                $stmt->bindParam(':itemIndex', $item_index, PDO::PARAM_INT);
                $stmt->bindParam(':CNT', $item_count, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo "Item (Kind: {$item_kind}, Index: {$item_index}, Count: {$item_count}) sent successfully to $game_id.<br>";
                } else {
                    echo "Error sending item to $game_id: " . implode(", ", $stmt->errorInfo()) . "<br>";
                }
            }
        }
        
        $_SESSION['cart'] = array();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redmoon Fantasy Store</title>
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

        .centered {
            text-align: center;
            margin-top: 20px;
        }

        h2 {
            color: #00bfa5; 
        }

        form {
            margin-top: 20px;
        }

        input[type="button"], input[type="submit"], button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #00bfa5;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="button"]:hover, input[type="submit"]:hover, button:hover {
            background-color: #008f7a; 
        }

        .major {
            margin-top: 40px;
        }

        .paypal-button {
            margin-top: 20px;
        }

        b {
            color: #000000; 
        }

        hr {
            margin-top: 40px;
            border: 1px solid #008f7a; 
        }

        .item-list {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .item-list p {
            margin: 5px 0;
        }

        a {
            color: #00bfa5; 
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .item-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .item-box {
            margin: 10px;
            border: 1px solid #00bfa5; 
            padding: 10px;
            width: 300px;
            text-align: center;
            background-color: #f0f0f0; /
            border-radius: 10px;
        }
    </style>
	<script src="script.js?v=<?php echo filemtime('script.js'); ?>"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $paypal_client_id; ?>&currency=USD"></script>
</head>
<body>
    <div class="centered">
        <form>
            <input type="button" value="HOME" onclick="window.location.href='/index.html'" />
        </form>
    </div>
    <div class="centered major">
        <h2>Redmoon Fantasy Store</h2>
    </div>
    <div class="centered">
        <p>Please enter your Game ID to proceed with purchases. Incentive: For every $200.00 spent you will receive a 1x clear S4 of your choice. Please message the GM your item of choice.</p>
        <form id="checkout-form" action="" method="post">
            <label for="game_id" style="color: #00bfa5;">Game ID:</label>
            <input type="text" id="game_id" name="game_id" maxlength="14" required style="padding: 10px; width: 200px; margin-top: 10px;"><br><br>
        </form>
    </div>

    <div class="item-container">

        <div class="item-box">
            <h3>Advanced Gear Set - $150.00 USD (for levels 950+)</h3>
            <p>Fantasy Necklace</p>
            <p>Fantasy Diamond</p>
            <p>8x Lotto Tickets</p>
            <p>8x Protections</p>
            <p>Heart of Redmoon x3 (ring slot)</p>
            <button class="paypal-button" type="button" onclick="addGearSetToCart('Advanced Gear Set', 150.00, [
                {itemKind: 6, itemIndex: 237, itemCount: 1}, // Fantasy Necklace
                {itemKind: 6, itemIndex: 211, itemCount: 1}, // Fantasy Diamond
                {itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
		{itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
		{itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 231, itemCount: 1}, // Heart of Redmoon
		{itemKind: 6, itemIndex: 231, itemCount: 1}, // Heart of Redmoon
		{itemKind: 6, itemIndex: 231, itemCount: 1}  // Heart of Redmoon
            ])">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Moderate Gear Set - $100.00 USD (for levels 900+)</h3>
            <p>Ancient Coin</p>
            <p>Legendary Necklace</p>
            <p>Fallen Star (orb slot for all characters)</p>
            <p>5x Lotto Tickets</p>
            <p>5x Protections</p>
            <button class="paypal-button" type="button" onclick="addGearSetToCart('Moderate Gear Set', 100.00, [
                {itemKind: 6, itemIndex: 223, itemCount: 1}, // Ancient Coin
                {itemKind: 6, itemIndex: 221, itemCount: 1}, // Legendary Necklace
                {itemKind: 6, itemIndex: 219, itemCount: 1}, // Fallen Star
                {itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
                {itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
                {itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
                {itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
                {itemKind: 6, itemIndex: 197, itemCount: 1}, // Lotto Tickets
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 196, itemCount: 1}  // Protections
            ])">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Beginner Gear Set - $50.00 USD (for levels 1+)</h3>
            <p>Fresh Breeze</p>
            <p>Erinyes Shield</p>
            <p>Jupiter Chest Piece</p>
            <p>Jupiter Leggings</p>
            <p>3x Protections</p>
            <button class="paypal-button" type="button" onclick="addGearSetToCart('Beginner Gear Set', 50.00, [
                {itemKind: 6, itemIndex: 23, itemCount: 1}, // Fresh Breeze
                {itemKind: 6, itemIndex: 98, itemCount: 1}, // Erinyes Shield
                {itemKind: 6, itemIndex: 8, itemCount: 1},  // Jupiter Chest Piece
                {itemKind: 6, itemIndex: 12, itemCount: 1}, // Jupiter Leggings
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 196, itemCount: 1}, // Protections
                {itemKind: 6, itemIndex: 196, itemCount: 1} // Protections
            ])">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Majestic Ring - $7.00 USD Each</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Majestic Ring', 7.00, 6, 107, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Clear Stage 0 Weapons - $15.00 USD Each</h3>
            <select id="clear-stage-0-weapon">
                <option value="Manus Blade" data-price="15.00" data-item-kind="6" data-item-index="110" data-item-count="1">Manus Blade</option>
                <option value="Measure" data-price="15.00" data-item-kind="6" data-item-index="111" data-item-count="1">Measure</option>
                <option value="Destruction" data-price="15.00" data-item-kind="6" data-item-index="112" data-item-count="1">Destruction</option>
                <option value="Creationer" data-price="15.00" data-item-kind="6" data-item-index="113" data-item-count="1">Creationer</option>
                <option value="Sauvagine" data-price="15.00" data-item-kind="6" data-item-index="114" data-item-count="1">Sauvagine</option>
            </select>
            <button class="paypal-button" type="button" onclick="addToCartFromSelect('clear-stage-0-weapon')">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Sunset Armor - $12.00 USD Each</h3>
            <select id="sunset-armor">
                <option value="Nauthiz Helmet" data-price="12.00" data-item-kind="6" data-item-index="100" data-item-count="1">Nauthiz Helmet</option>
                <option value="Nauthiz Armor" data-price="12.00" data-item-kind="6" data-item-index="101" data-item-count="1">Nauthiz Armor</option>
                <option value="Nauthiz Pants" data-price="12.00" data-item-kind="6" data-item-index="102" data-item-count="1">Nauthiz Pants</option>
                <option value="Nauthiz Boots" data-price="12.00" data-item-kind="6" data-item-index="103" data-item-count="1">Nauthiz Boots</option>
                <option value="Nauthiz Shield" data-price="12.00" data-item-kind="6" data-item-index="104" data-item-count="1">Nauthiz Shield</option>
                <option value="Nauthiz Gloves" data-price="12.00" data-item-kind="6" data-item-index="105" data-item-count="1">Nauthiz Gloves</option>
                <option value="Nauthiz Belt" data-price="12.00" data-item-kind="6" data-item-index="106" data-item-count="1">Nauthiz Belt</option>
                <option value="Majestic Necklace" data-price="12.00" data-item-kind="6" data-item-index="108" data-item-count="1">Majestic Necklace</option>
            </select>
            <button class="paypal-button" type="button" onclick="addToCartFromSelect('sunset-armor')">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Miscellaneous Uniques - $5.00 USD Each</h3>
            <select id="misc-uniques">
                <option value="Selion" data-price="5.00" data-item-kind="6" data-item-index="1" data-item-count="1">Selion</option>
                <option value="Tamas" data-price="5.00" data-item-kind="6" data-item-index="2" data-item-count="1">Tamas</option>
                <option value="God of War" data-price="5.00" data-item-kind="6" data-item-index="10" data-item-count="1">God of War</option>
                <option value="Noas" data-price="5.00" data-item-kind="6" data-item-index="11" data-item-count="1">Noas</option>
                <option value="Tears of Heliades" data-price="5.00" data-item-kind="6" data-item-index="12" data-item-count="1">Tears of Heliades</option>
                <option value="Infrascope" data-price="5.00" data-item-kind="6" data-item-index="14" data-item-count="1">Infrascope</option>
                <option value="rajas" data-price="5.00" data-item-kind="6" data-item-index="15" data-item-count="1">rajas</option>
                <option value="Nagrepar" data-price="5.00" data-item-kind="6" data-item-index="18" data-item-count="1">Nagrepar</option>
                <option value="Largesse" data-price="5.00" data-item-kind="6" data-item-index="24" data-item-count="1">Largesse</option>
                <option value="Silpheed" data-price="5.00" data-item-kind="6" data-item-index="26" data-item-count="1">Silpheed</option>
                <option value="Elein" data-price="5.00" data-item-kind="6" data-item-index="28" data-item-count="1">Elein</option>
                <option value="Minerva's Robe" data-price="5.00" data-item-kind="6" data-item-index="91" data-item-count="1">Minerva's Robe</option>
                <option value="Minerva's Blessing" data-price="5.00" data-item-kind="6" data-item-index="92" data-item-count="1">Minerva's Blessing</option>
                <option value="Parcae's Plate" data-price="5.00" data-item-kind="6" data-item-index="93" data-item-count="1">Parcae's Plate</option>
                <option value="Parcae's Buckle" data-price="5.00" data-item-kind="6" data-item-index="94" data-item-count="1">Parcae's Buckle</option>
                <option value="Erinyes" data-price="5.00" data-item-kind="6" data-item-index="95" data-item-count="1">Erinyes</option>
                <option value="Rage of Erinyes" data-price="5.00" data-item-kind="6" data-item-index="96" data-item-count="1">Rage of Erinyes</option>
                <option value="Will of Erinyes" data-price="5.00" data-item-kind="6" data-item-index="97" data-item-count="1">Will of Erinyes</option>
            </select>
            <button class="paypal-button" type="button" onclick="addToCartFromSelect('misc-uniques')">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Ring Set - $15.00 USD (Set)</h3>
            <p>Graupnel</p>
            <p>Topaz</p>
            <p>Aquarine</p>
            <button class="paypal-button" type="button" onclick="addToCart('Ring Set', 15.00, 6, 0, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Minerva's Tears - $5.00 USD Each</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Minerva\'s Tears', 5.00, 6, 90, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Lottery Ticket - $5.00 USD Each</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Lottery Ticket', 5.00, 6, 197, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Mysterious Rune (Level 1 Mage Weapon) - $10.00 USD</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Mysterious Rune', 10.00, 6, 212, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Fallen Star (Level 1 All Char Orb Slot) - $10.00 USD</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Fallen Star', 10.00, 6, 219, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Runes of Death (High Level Mage Weapon) - $25.00 USD</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Runes of Death', 25.00, 6, 216, 1)">Add to Cart</button>
        </div>


        <div class="item-box">
            <h3>Protection - $2.00 USD Each</h3>
            <button class="paypal-button" type="button" onclick="addToCart('Protection', 2.00, 6, 196, 1)">Add to Cart</button>
        </div>
		
		<div class="item-box">
			<h3>7-Day Super-Egg + Booster - $20.00 USD</h3>
			<p>Enjoy 7 days of unlimited super-egg & all boosters, this only works for one (1) character. Not an entire account. If you lose it, please re-log after 5 minutes.</p>
			<button class="paypal-button" type="button" onclick="addToCart('7-Day Subscription', 20.00, 0, 0, 1)">Add to Cart</button>
		</div>



        <div class="item-box">
            <h3>Make a Contribution</h3>
            <p>Enter any amount:</p>
            <form id="donation-form" action="" method="post">
                <input type="number" id="donation_amount" name="donation_amount" step="0.01" min="1" placeholder="USD Amount" required style="padding: 10px; width: 150px; margin-top: 10px;"><br><br>
                <label for="game_id" style="color: #00bfa5;">Game ID:</label>
                <input type="text" id="game_id" name="game_id" maxlength="14" required style="padding: 10px; width: 200px; margin-top: 10px;"><br><br>
                <button type="submit" name="donate">Donate</button>
            </form>
        </div>
    </div>

    <div class="centered">
        <h2>Your Cart</h2>
        <?php
        if (!empty($_SESSION['cart'])) {
            echo '<form method="post" action="">';
            echo '<table border="1" style="width: 50%; margin: 0 auto; color: #000000;">';
            echo '<tr><th>Game ID</th><th>Item</th><th>Price</th><th>Action</th></tr>';
            $total = 0;
            foreach ($_SESSION['cart'] as $index => $cart_item) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($cart_item['game_id']) . '</td>';
                echo '<td>' . htmlspecialchars($cart_item['item']) . '</td>';
                echo '<td>$' . number_format($cart_item['price'], 2) . '</td>';
                echo '<td><button type="submit" name="remove_item" value="' . $index . '">Remove</button></td>';
                echo '</tr>';
                $total += $cart_item['price'];
            }
            echo '<tr><td colspan="2"><b>Total</b></td><td colspan="2">$' . number_format($total, 2) . '</td></tr>';
            echo '</table>';
            echo '<br>';
            echo '<button type="submit" name="clear_cart">Clear Cart</button>';
            echo '</form>';
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>
    <div class="centered">
        <div id="paypal-button-container" style="display: flex; justify-content: center;">
            <div style="transform: scale(1.2);">
                
            </div>
        </div>
    </div>

    <script>
        function addToCartFromSelect(selectId) {
            var selectElement = document.getElementById(selectId);
            var selectedItem = selectElement.options[selectElement.selectedIndex];
            addToCart(
                selectedItem.value,
                parseFloat(selectedItem.getAttribute('data-price')),
                parseInt(selectedItem.getAttribute('data-item-kind')),
                parseInt(selectedItem.getAttribute('data-item-index')),
                parseInt(selectedItem.getAttribute('data-item-count'))
            );
        }

        function addToCart(itemName, price, itemKind, itemIndex, itemCount) {
            var gameID = document.getElementById('game_id').value;
            if (!gameID) {
                alert('Please enter your Game ID.');
                return;
            }
            var form = document.createElement('form');
            form.method = 'post';
            form.action = '';

            var gameIDInput = document.createElement('input');
            gameIDInput.type = 'hidden';
            gameIDInput.name = 'game_id';
            gameIDInput.value = gameID;

            var itemInput = document.createElement('input');
            itemInput.type = 'hidden';
            itemInput.name = 'item';
            itemInput.value = itemName;

            var priceInput = document.createElement('input');
            priceInput.type = 'hidden';
            priceInput.name = 'price';
            priceInput.value = price;

            var itemKindInput = document.createElement('input');
            itemKindInput.type = 'hidden';
            itemKindInput.name = 'item_kind';
            itemKindInput.value = itemKind;

            var itemIndexInput = document.createElement('input');
            itemIndexInput.type = 'hidden';
            itemIndexInput.name = 'item_index';
            itemIndexInput.value = itemIndex;

            var itemCountInput = document.createElement('input');
            itemCountInput.type = 'hidden';
            itemCountInput.name = 'item_count';
            itemCountInput.value = itemCount;

            var addToCartInput = document.createElement('input');
            addToCartInput.type = 'hidden';
            addToCartInput.name = 'add_to_cart';
            addToCartInput.value = '1';

            form.appendChild(gameIDInput);
            form.appendChild(itemInput);
            form.appendChild(priceInput);
            form.appendChild(itemKindInput);
            form.appendChild(itemIndexInput);
            form.appendChild(itemCountInput);
            form.appendChild(addToCartInput);

            document.body.appendChild(form);
            form.submit();
        }

        function addGearSetToCart(gearSetName, price, items) {
            var gameID = document.getElementById('game_id').value;
            if (!gameID) {
                alert('Please enter your Game ID.');
                return;
            }

            items.forEach(function(item) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '';

                var gameIDInput = document.createElement('input');
                gameIDInput.type = 'hidden';
                gameIDInput.name = 'game_id';
                gameIDInput.value = gameID;

                var itemInput = document.createElement('input');
                itemInput.type = 'hidden';
                itemInput.name = 'item';
                itemInput.value = gearSetName;

                var priceInput = document.createElement('input');
                priceInput.type = 'hidden';
                priceInput.name = 'price';
                priceInput.value = price;

                var itemKindInput = document.createElement('input');
                itemKindInput.type = 'hidden';
                itemKindInput.name = 'item_kind';
                itemKindInput.value = item.itemKind;

                var itemIndexInput = document.createElement('input');
                itemIndexInput.type = 'hidden';
                itemIndexInput.name = 'item_index';
                itemIndexInput.value = item.itemIndex;

                var itemCountInput = document.createElement('input');
                itemCountInput.type = 'hidden';
                itemCountInput.name = 'item_count';
                itemCountInput.value = item.itemCount;

                var addToCartInput = document.createElement('input');
                addToCartInput.type = 'hidden';
                addToCartInput.name = 'add_to_cart';
                addToCartInput.value = '1';

                form.appendChild(gameIDInput);
                form.appendChild(itemInput);
                form.appendChild(priceInput);
                form.appendChild(itemKindInput);
                form.appendChild(itemIndexInput);
                form.appendChild(itemCountInput);
                form.appendChild(addToCartInput);

                document.body.appendChild(form);
                form.submit();
            });
        }

        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo isset($total) ? number_format($total, 2) : '0.00'; ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction completed by ' + details.payer.name.given_name);
                    var form = document.createElement('form');
                    form.method = 'post';
                    form.action = '';
                    
                    var paypalSuccessInput = document.createElement('input');
                    paypalSuccessInput.type = 'hidden';
                    paypalSuccessInput.name = 'paypal_success';
                    paypalSuccessInput.value = '1';
                    
                    form.appendChild(paypalSuccessInput);
                    document.body.appendChild(form);
                    form.submit();
                });
            }
        }).render('#paypal-button-container > div');
    </script>
</body>
</html>
