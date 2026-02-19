<!-- Processes any database edits submitted through the modifypdb.php page -->

<?php 
    require("../../Private/authorizeadmin.php"); //Check that the user is authorized, redirect if not.
    require_once("../../Private/dbConnect.php"); //Connect to the database to retrieve product details.
    require_once("../../Private/functions.php"); //Contains the validation functions
    $reportMsg = ''; //This will be used to report to the user what was done in the database.

    //If page was requested through POST (meaning the form was submitted)...
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        //Gather all the variables from the POST package.
        $action = $_POST['Action']; //Check which button was clicked to submit the form (what action to do)
        $itemID = $_POST['itemID'];
        $itemName = $_POST['itemName'];
        $productName = $_POST['productName'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $picture = $_POST['image'];

        //Validate all the variables
        $reportMsg .= validate_input($itemName, "shortString", "Item Name");
        $reportMsg .= validate_input($productName, "shortString", "Product Name");
        $reportMsg .= validate_input($price, "price", "Price");
        $reportMsg .= validate_input($description, "longString", "Description");
        $reportMsg .= validate_input($picture, "shortString", "Image Path");

        if($reportMsg){ //If reportMsg is not empty anymore and therefore truthy, an input error of some kind was detected..
            $_SESSION['SubmissionResult'] = $reportMsg; //Put the contents of the report message here
            header("Location:/admin/productdb.php"); //Redirect to the database view where the results are displayed.
            exit;
        }

        //Otherwise, if there are no validation issues, try to perform the selected action on the database.
        if($action === "Drop"){
            //Prepare to drop item safely
            $sqlQuery = $dbAdminConn->prepare("DELETE FROM Items WHERE ID = ?");
            $sqlQuery->bind_param("i", $itemID);
            $actionDesc = "deleted";
        }
        else if($action === "Update"){
            if($itemID === "New"){//If itemID is "New" it means a new record should be created
                $sqlQuery = $dbAdminConn->prepare("INSERT INTO Items (ItemName, ProductName, `Description`, Price, Picture)
                                                   VALUES (?, ?, ?, ?, ?)");
                $sqlQuery->bind_param("sssds", $itemName, $productName, $description, $price, $picture);
                $actionDesc = "added";
            }
            else if($itemID !== "New"){ //Else if its not new then we are updating an existing item record.
                $sqlQuery = $dbAdminConn->prepare("UPDATE Items 
                                                   SET ItemName = ?, ProductName=?, `Description`=?, Price=?, Picture=?
                                                   WHERE ID = ?");
                $sqlQuery->bind_param("sssdsi", $itemName, $productName, $description, $price, $picture, $itemID);
                $actionDesc = "updated";
            }
        }

        if($sqlQuery->execute()){ //If the query executed successfully..
            $reportMsg .= "Item $itemID has been $actionDesc successfully.<br>";
        } 
        else { //Else an error occurred...
            $reportMsg .= "Database Error: Item $itemID could not be $actionDesc.<br>";
        }
        $_SESSION["SubmissionResult"] = $reportMsg; //Set a message that will be displayed on the main product page with the results of the query.
        header("Location:/admin/productdb.php"); // Redirect back to the main product database page.
        exit;
    }
?> 
