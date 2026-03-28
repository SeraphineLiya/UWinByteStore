<!-- Displays the contents of the product database and links to page to edit or delete records. -->

<?php 
    require("../../Private/authorizeadmin.php"); //Check that the user is authorized, redirect if not.
    require_once("../../Private/dbConnect.php"); //Connect to the database to retrieve product details.

    //Query all product data
    $sqlQuery = "SELECT * FROM Items";
    $queryResult = $dbPublicConn->query($sqlQuery);
?> 



<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Item Database | UWinByteStore</title>
<meta name="description" content=" Learn about UWinByteStore and our technology catalog of recommended tech products and accessories.">
<meta name="keywords" content="technology catalog, tech accessories, keyboards, webcams, projectors, electronics">
<meta name="robots" content="index, follow">
<link rel="stylesheet" href="../css/main.css">
<script src="/js/theme.js" defer></script>
</head>
<!-- As with all our pages, it is structured as one top-level container that contains at least
 one div for the maincontent, with the possibility of adding additional divs above or below
 for common elements like a nav bar, or page header and footer.-->
<body>
<header>
<h1>UWinByteStore</h1>
<nav>
    <a href="../index.html">Home</a>
    <a href="../catalog.php">Products</a>
    <a href="../about.html">About</a>
    <a href="../help.html">Help</a>
    <a href="../login.html">Login</a>
    <a href="../signup.html">Signup</a>
</nav>
</header>

<!-- As with all our pages, it is structured as one top-level container that contains at least
 one div for the maincontent, with the possibility of adding additional divs above or below
 for common elements like a nav bar, or page header and footer.-->
    <body>
        <div class = "container">
            <!--Main page content goes in the following div.-->
            <div class = "maincontent">
                <!-- Check if there is a report message to display from the form being submitted previously. -->
                <?php if(isset($_SESSION["SubmissionResult"])){ ?> 
                    <p><?=$_SESSION["SubmissionResult"]?></p> <!--Echo the submission result to the user-->
                    <hr>
                
                <?php //Clear submission result and end if
                    unset($_SESSION["SubmissionResult"]); 
                } ?> 
                <h1>Product Database</h1>
                <p>This page displays all of the items in the product database. Each row represents a single 
                    option ('item') of a product group. Click on an item in the list below to open a form where
                    that item can be edited or deleted. See the associated wiki page for further details.
                </p>
                <a href="../Help/productdb.html">Help</a>
                <hr>
                
                    <!-- Display a mobile-friendly table with the details of each item record.
                    Clicking on an item cell will cause it to open the modifypdb page with prefilled values that can be edited or deleted.
                    No bulk editing or deleting is allowed by design. That would be risky. -->
                    <!--TODO: @NotDashy, this table will need borders and CSS I think. -->
                    <form action="modifypdb.php" method = "post">
                    <!-- Buttons to allow user to add a new item record. ID of 0 (falsy) will be default for new record since the DB blocks ID=0.-->
                    <button type="submit" name="Action" value="0">Add New</button>
                    <table>
                        <tr>
                            <th>Item Catalog</th>
                        </tr>
                        <!--The following php/html loop makes a list of clickable boxes-->
                        <?php while($item = $queryResult->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <!-- Make submit button with item id as its name.
                                    The IDs of selected items will be sent through POST. -->
                                    <button type="submit" name="Action" id = "<?=$item['ID']?>" value = "<?=$item['ID']?>">
                                        <strong>Item ID:</strong> <?=$item['ID']?>
                                        <br>
                                        <strong>Item Name:</strong> <?=$item['ItemName']?>
                                        <br>
                                        <strong>Product Name:</strong> <?=$item['ProductName']?>
                                        <br>
                                        <strong>Price:</strong> <?=$item['Price']?>
                                        <br>
                                        <strong>Picture:</strong> <?=$item['Picture']?>
                                        <br>
                                        <strong>Description:</strong> <?=$item['Description']?>
                                        <br>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </form> 
            </div>
        </div>
    </body>
</html>
