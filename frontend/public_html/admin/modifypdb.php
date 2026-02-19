<!-- Displays a form with values of an item for user to edit or delete record -->
<?php 
    require("../../Private/authorizeadmin.php"); //Check that the user is authorized, redirect if not.
    require_once("../../Private/dbConnect.php"); //Connect to the database to retrieve user details.
    $reportMsg = ''; //This will be used to report to the user what was done in the database.
?> 

<?php
    //Initialize variables that will be used to autofill the form if we're editing a record.
    $itemID = 0;
    $productName = '';
    $itemName = '';
    $price = '';
    $picture = '';
    $description = '';


    //If page was requested through POST (meaning the form was submitted)...
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $itemID = $_POST['Action']; //Check the ID of the button that was clicked (matches itemID or zero for new item)

        //Query the selected Item ID if it's not zero and fill in the current attribute values.
        if($itemID != 0){
            //Prepare to retrieve item ID safely (not really needed since this is an admin page but good practice)
            $sqlQuery = $dbPublicConn->prepare("SELECT * FROM Items WHERE ID = ?");
            $sqlQuery->bind_param("i", $itemID);
            $sqlQuery->execute();
            $queryResult = $sqlQuery->get_result();
            $item = $queryResult->fetch_assoc();

            $productName = $item['ProductName'];
            $itemName = $item['ItemName'];
            $price = $item['Price'];
            $picture = $item['Picture'];
            $description = $item['Description'];
        }
        else {$itemID = 'New';}
    }
    else { //Send the user to the proper starting page if they skipped it somehow.
        header("Location:viewpdb.php"); 
        exit;
    } 
?>

<!DOCTYPE html>

<html>
<!-- As with all our pages, it is structured as one top-level container that contains at least
 one div for the maincontent, with the possibility of adding additional divs above or below
 for common elements like a nav bar, or page header and footer.-->
    <body>
        <div class = "container">
            <div class = "maincontent">
                <!-- This form will submit to processpdbedit.php where the new values will be processed -->
                <form action="processpdbedit.php" method='post'>
                    <!-- Fieldset with current item attributes prefilled if editing a record or empty if adding a new one -->
                    <fieldset>
                        <input type="text" name="itemID" value="<?=$itemID?>" hidden required>
                        <legend>Item: <?=$itemID?></legend>
                        <label for="itemName">Item Name:</label>
                        <input type="text" name="itemName" value="<?=$itemName?>" required>
                        <br>
                        <label for="productName">Product Name:</label>
                        <input type="text" name="productName" value="<?=$productName?>"  required>
                        <br>
                        <label for="price">Price:</label>
                        <input type="number" step = 0.01 name="price" value="<?=$price?>" required>
                        <br>
                        <label for="description">Description:</label>
                        <textarea name="description" required><?=$description?></textarea>
                        <br>
                        
                        <!-- Display the current image for reference -->
                        <!-- Only show image if picture is not currently empty -->
                        <?php if($picture) { ?>
                            <img src="/<?=$picture?>" alt="Current Item Image" width="200px"> 
                            <br>
                        <?php } ?>

                        <!-- I may replace this with an actual file upload if I can be confident of its security -->
                        <label for="image">Image Path*:</label>
                        <input type="text" name="image" value="<?=$picture?>" required>
                        <br>
                        <span>*Note: New images must also be uploaded to website backend at the specified location.</span>
                        <br>
                        
                        <a href="productdb.php" class="hyperButton">Cancel</a> <!-- By returning through a hyperlink we avoid triggering the submission code -->
                        <!--TODO: @Souper this definitely needs a JavaScript 'Are you sure' message I think -->
                        <button type="submit" name="Action" value="Drop">Delete</button>
                        <button type="submit" name="Action" value="Update">Submit</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>