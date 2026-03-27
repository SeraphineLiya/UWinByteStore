<!-- Individual product page with item details -->

<?php 
require_once("../Private/dbConnect.php");

/* ---------- Secure query ---------- */
$sqlQuery = $dbPublicConn->prepare(
    "SELECT * FROM Items WHERE ProductName = ? ORDER BY ID"
);

$productName = $_GET['name'] ?? '';
$sqlQuery->bind_param("s", $productName);
$sqlQuery->execute();

$queryResult = $sqlQuery->get_result();

$items = [];

while ($row = $queryResult->fetch_assoc()) {
    $items[] = $row;
}

/* Safety fallback */
if (empty($items)) {
    die("Product not found.");
}

$topItem = $items[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($topItem['ProductName']) ?> | UWinByteStore</title>

<meta name="description" content="View product details for technology items in the UWinByteStore catalog.">
<meta name="keywords" content="technology catalog, electronics">
<meta name="robots" content="index, follow">

<link rel="stylesheet" href="css/main.css">

<!-- Pass data safely to JS -->
<script>
const productOptions = <?= json_encode($items, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>

<!-- External JS -->
<script src="js/product.js" defer></script>

</head>

<body>

<header>
    <h1>UWinByteStore</h1>
    <nav>
        <a href="index.html">Home</a>
        <a href="catalog.php">Products</a>
        <a href="about.html">About</a>
        <a href="help.html">Help</a>
        <a href="login.html">Login</a>
        <a href="signup.html">Signup</a>
    </nav>
</header>

<div class="container">
<div class="maincontent">

<h1 class="product-title">
    <?= htmlspecialchars($topItem['ProductName']) ?>
</h1>

<hr>

<div class="product-layout">

    <!-- LEFT: IMAGE -->
    <div class="product-image-area">
        <img
            id="productImage"
            src="<?= htmlspecialchars($topItem['Picture']) ?>"
            alt="<?= htmlspecialchars($topItem['ProductName']) ?>"
            loading="eager"
            decoding="async"
        >
    </div>

    <!-- RIGHT: DETAILS -->
    <div class="product-details">

        <span id="priceDisplay" class="product-price">
            $<?= htmlspecialchars($topItem['Price']) ?>
        </span>

        <label for="productOptionSelect">Options:</label>

        <select id="productOptionSelect">
            <?php foreach ($items as $index => $itemOption) { ?>
                <option value="<?= $index ?>">
                    <?= htmlspecialchars($itemOption['ItemName']) ?>
                </option>
            <?php } ?>
        </select>

        <p id="descriptionDisplay" class="product-description">
            <?= htmlspecialchars($topItem['Description']) ?>
        </p>

    </div>

</div>

</div>
</div>

<footer>
    <p>&copy; 2026 UWinByteStore</p>
</footer>

</body>
</html>