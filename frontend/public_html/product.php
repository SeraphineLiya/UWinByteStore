<!-- Individual product page with item details -->

<!-- The following php block will query the data needed for this page (all item attributes, details, and other options) -->
<?php 
    //Calls file that establishes a connection to the database.
    require_once("../Private/dbConnect.php");

    //To run the query securely, we must prepare it this time since it takes flexible input from user.
    $sqlQuery = $dbPublicConn->prepare("SELECT * FROM Items WHERE ProductName = ? ORDER BY ID");
    $sqlQuery->bind_param("s", $_GET['name']); //Retrieve product name from GET query string and put it into sql safely
    $sqlQuery->execute(); //Run the query
    $queryResult = $sqlQuery->get_result(); //Save the results of the query

    $topItem = $queryResult->fetch_assoc(); //Save all the attributes of the first item it returned (default product option)
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product | UWinByteStore</title>
    <link rel="stylesheet" href="styles.css">
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
        <h1><?= $topItem['ProductName']?></h1> <!-- Product title -->
        <hr>
        <img src = "<?= $topItem['Picture']?>"> <!-- Product photo -->
        <br>
        <!-- This select list will allow for other options to be viewed. It will need JavaScript to make the page update though. 
         TODO: @Souper, this will require JavaScript to make work properly.-->
        <select name="productOptionSelect" id="productOptionSelect">
            
            <!-- Add the current product option as the first option in the select list -->
            <option><?= $topItem['ItemName'] ?></option>

            <!-- While loop to get all option names of this product -->
            <?php while($itemOption = $queryResult->fetch_assoc()) { ?> 
                <option><?= $itemOption['ItemName'] ?></option>
            <?php } ?>
        </select>
        <span>$<?= $topItem['Price'] ?></span> <!--Display the price -->
        <br>
        <p><?= $topItem['Description'] ?> <!-- Short text description of the product option -->
            <footer>
<p>&copy; 2026 UWinByteStore</p>
</footer>
    </body>

</html>


