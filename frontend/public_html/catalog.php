<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | UWinByteStore</title>

    <meta name="description" content=" Browse the UWinByteStore catalog of recommended technology products including keyboards, webcams, projectors, storage devices, and more.">
    <meta name="keywords" content="technology catalog, keyboards, webcams, projectors, SSD, power bank, tech accessories, electronics">
    <meta name="robots" content="index, follow">

    <link rel="stylesheet" href="css/main.css">
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

    <!-- Full product catalog displayed as grid -->

    <!-- The following php block will query the data needed for this page (ProductName, ID, and Picture) -->
    <?php 
        //Calls file that establishes a connection to the database.
        require_once("../Private/dbConnect.php");

        //Query each product's name, along with a link to a picture of it. Returns one row containing the product name
        // as well as a picture associated with that product.
        $sqlQuery = "SELECT ProductName, Picture FROM Items GROUP BY ProductName";
        $queryResult = $dbPublicConn->query($sqlQuery);
    ?>

    <div class="container">
        <div class="maincontent">

            <h1>Recommended Technology Catalog</h1>

            <p>
                Take a look at some of the types of products we recommend! Further details for each product type can be viewed by
                clicking on them.
            </p>

            <hr>

            <!-- Create another div containing a grid with clickable product cards for each product in the database -->
            <div class="product-grid">

                <!-- While loop will fetch one row at a time from the query, until there are no more rows.
                     At that point, the condition returns false and the while loop stops.-->
                <?php while ($product = $queryResult->fetch_assoc()) { ?>

                    <!--This is the individual product card wrapped in a hyperlink element to make it clickable.
                    When clicked, it goes to the page of the associated product with the help of a query string. -->
                    <a class="product-card"
                       href="product.php?name=<?= urlencode($product['ProductName']) ?>">

                        <div class="card">
                            <img src="<?= $product['Picture'] ?>"
                                 alt="<?= $product['ProductName'] ?>">

                            <h2><?= $product['ProductName'] ?></h2>
                        </div>

                    </a>

                <?php } ?> <!-- End while loop-->

            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 UWinByteStore</p>
    </footer>

</body>
</html>