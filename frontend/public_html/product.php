<!-- Individual product page with item details -->

<!-- The following php block will query the data needed for this page (all item attributes, details, and other options) -->
<?php 
    //Calls file that establishes a connection to the database.
    require_once("../Private/dbConnect.php");

    //To run the query securely, we must prepare it this time since it takes flexible input from user.
    $sqlQuery = $dbPublicConn->prepare(
        "SELECT * FROM Items WHERE ProductName = ? ORDER BY ID"
    );

    $sqlQuery->bind_param("s", $_GET['name']); //Retrieve product name from GET query string and put it into sql safely
    $sqlQuery->execute(); //Run the query
    $queryResult = $sqlQuery->get_result(); //Save the results of the query

    $items = [];

    while ($row = $queryResult->fetch_assoc()) {
        $items[] = $row;
    }

    $topItem = $items[0]; // default item
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product | UWinByteStore</title>

    <meta name="description" content=" View product details for technology items in the UWinByteStore catalog, including options, price, and description.">
    <meta name="keywords" content="product details, technology catalog, keyboard, mouse, webcam, projector, electronics">
    <meta name="robots" content="index, follow">

    <link rel="stylesheet" href="css/main.css">

    <!-- Pass data to JS-->
    <script>
        const productOptions = <?= json_encode($items) ?>;
    </script>

    <!-- External JS -->
    <script src="js/product.js" defer></script>
</head>

<!-- As with all our pages, it is structured as one top-level container that contains at least
one div for the maincontent, with the possibility of adding additional divs above or below
for common elements like a nav bar, or page header and footer.-->
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

    <h1><?= $topItem['ProductName'] ?></h1> <!-- Product title -->
    <hr>

    <img id="productImage"
     src="<?= $topItem['Picture']?>"
     alt="<?= $topItem['ProductName'] ?>">

    <br>

    <select id="productOptionSelect">

        <!-- While loop to get all option names of this product -->
        <?php foreach ($items as $index => $itemOption) { ?>
            <option value="<?= $index ?>">
                <?= $itemOption['ItemName'] ?>
            </option>
        <?php } ?>

    </select>

    <span id="priceDisplay">$<?= $topItem['Price'] ?></span> <!--Display the price -->

    <br>

    <p id="descriptionDisplay">
        <?= $topItem['Description'] ?>
    </p>

    <footer>
        <p>&copy; 2026 UWinByteStore</p>
    </footer>

</body>
</html>