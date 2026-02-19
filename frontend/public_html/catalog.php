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

<!DOCTYPE html>

<html>

<!-- As with all our pages, it is structured as one top-level container that contains at least
 one div for the maincontent, with the possibility of adding additional divs above or below
 for common elements like a nav bar, or page header and footer.-->
    <body>
        <div class = "container">
            <div class = "maincontent">
                <h1>Recommended Technology Catalog</h1>
                <p>Take a look at some of the types of products we recommend! Further details for each product type can be viewed by
                    clicking on them. 
                </p>
                <hr>
                <!-- Create another div containing a grid with clickable product cards for each product in the database -->
                <!-- @NotDashy This page will need a fair bit of CSS to make the product grid look right I think. -->
                <div>
                    <!-- While loop will fetch one row at a time from the query, until there are no more rows.
                     At that point, the condition returns false and the while loop stops.-->
                    <?php while ($product = $queryResult->fetch_assoc()){ ?>
                        
                        <!--This is the individual product card wrapped in a hyperlink element to make it clickable.
                        When clicked, it goes to the page of the associated product with the help of a query string. -->
                        <a href="product.php?name=<?=$product['ProductName']?>">
                            <div> 
                                <img src = "<?= $product['Picture'] ?>">
                                <h2><?= $product['ProductName'] ?></h2>
                            </div>
                        </a>

                    <?php } ?> <!-- End while loop-->
                </div>
            </div>
        </div>
    </body>
</html>