<!-- Page that displays user accounts as a table and allows for admins to modify details.
 This page includes both the form and php code it executes to process the form -->

<!-- Load external php scripts -->
<?php 
    require("../../Private/authorizeadmin.php"); //Check that the user is authorized, redirect if not.
    require_once("../../Private/dbConnect.php"); //Connect to the database to retrieve user details.
    $reportMsg = ''; //This will be used to report to the user what was done.
?> 

<!-- PHP code that runs when the form is executed. --> 
<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){ //If page was requested through POST (meaning the form was submitted)...
        $action = $_POST['Action']; //Check which button was clicked to submit the form (what action to do)
        $selectedAccounts = $_POST['SelectedAccounts']; //Retrieves array containing IDs of the accounts selected.
        
        //If at least one account was selected...
        if(isset($selectedAccounts)){
            //Perform the associated action.
            switch($action){
                case 'mkAdmin': //Sets the selected user account statuses to Admin.
                    foreach($selectedAccounts as $sAccount){
                        $id = filter_var($sAccount, FILTER_VALIDATE_INT); //Filter input for safety

                        //Prepare to update account status safely
                        $sqlQuery = $dbAdminConn->prepare("UPDATE Accounts SET AccountStatus = 'Admin' WHERE ID = ?");
                        $sqlQuery->bind_param("i", $id);
                        
                        if($sqlQuery->execute()){ //If the query executed successfully..
                            $reportMsg .= "Account $id granted Admin status.<br>";
                        } 
                        else {
                            $reportMsg .= "Error granting Account $id Admin status.<br>";
                        }
                    }
                    break;
                
                //The next case sets the selected account statuses to blocked (blocks admin access).
                //The user can actually block their own account too. Takes effect when they log out.
                //TODO: @Souper, a JavaScript confirmation before blocking one's own account would probably be useful.
                case 'blockAdmin':
                    foreach($selectedAccounts as $sAccount){
                        $id = filter_var($sAccount, FILTER_VALIDATE_INT); //Filter input for safety

                        //Prepare to update account status safely
                        $sqlQuery = $dbAdminConn->prepare("UPDATE Accounts SET AccountStatus = 'Blocked' WHERE ID = ?");
                        $sqlQuery->bind_param("i", $id);
                        
                        if($sqlQuery->execute()){ //If the query executed successfully..
                            $reportMsg .= "Admin access has been blocked for Account $id.<br>";
                        } 
                        else {
                            $reportMsg .= "Error updating Account $id status.<br>";
                        }
                    }
                    break;
                
                //Deletes the selected accounts
                case 'deleteAcc':
                    foreach($selectedAccounts as $sAccount){
                        $id = filter_var($sAccount, FILTER_VALIDATE_INT); //Filter input for safety

                        //Prepare to delete account safely
                        $sqlQuery = $dbAdminConn->prepare("DELETE FROM Accounts WHERE ID = ?");
                        $sqlQuery->bind_param("i", $id);
                        
                        if($sqlQuery->execute()){ //If the query executed successfully..
                            $reportMsg .= "Account $id has been deleted.<br>";
                        } 
                        else {
                            $reportMsg .= "Error deleting Account $id.<br>";
                        }
                    }
                    break;
                
                //An unexpected error occurred if default runs.
                default:
                    echo 'An unknown error occurred.<br>';
                    echo '<a href="adminpanel.php">Return</a>';
                    exit;
            }
        }
        $_SESSION["SubmissionResult"] = $reportMsg;
        header("Location:manageusers.php"); // Redirect back to the original page to prevent form resubmission on refresh.
        exit; //No need to run the rest, it will rerun after the redirect anyways.
    }
?>

<!-- Run query to get pertinent user details -->
<?php
    //Query user database for details we want to show admins. Sort such that pending requests are on top.
    $sqlQuery = "SELECT ID, Username, FirstName, LastName, AccountStatus FROM Accounts ORDER BY AccountStatus DESC";
    $queryResult = $dbPublicConn->query($sqlQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Accounts | UWinByteStore</title>
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
            <div class = "maincontent">
                <!-- This page allows admins to view a list of user accounts and basic details, then change permission levels or delete
                 accounts. They may not freely modify user details here, as that would be improper. -->

                <!-- Check if there is a report message to display from the form being submitted previously. -->
                <?php if(isset($_SESSION["SubmissionResult"])){ ?> 
                <!-- TODO:@NotDashy This could benefit from styling as a pop up box I think -->
                    <p><?=$_SESSION["SubmissionResult"]?></p> <!--Echo the submission result to the user-->
                    <hr>
                <!-- Clear submission result and end if -->
                <?php 
                    unset($_SESSION["SubmissionResult"]); 
                    } 
                ?> 

                <h1>Manage Accounts</h1>
                <p>On this page, administrators can change the permission levels of other accounts and delete accounts.
                    It provides a lot of power over the website, so administrator permissions should only be granted to 
                    individuals you trust fully.
                </p>
                <a href="../Help/manageusers.html">Help</a>
                <hr>
                
                <form action="" method = "post"> <!-- Blank form action will make it run on this page -->
                    <!-- Output a mobile-friendly list of users, with accounts pending approval at the top. -->
                    <!--TODO: @NotDashy, this table will need borders and CSS I think -->
                    <table>
                        <tr>
                            <th>User Accounts</th>
                        </tr>
                        <!--The following php/html loop makes a selectable list of boxes in the table -->
                        <?php while($account = $queryResult->fetch_assoc()) { ?>
                            <!-- Make checkbox with account id as its name.
                             The IDs of selected accounts will be returned through POST. -->
                            <tr>
                                <td>
                                    <input type="checkbox" name="SelectedAccounts[]" id = "<?=$account['ID']?>" value = "<?=$account['ID']?>">
                                    <label for="<?=$account['ID']?>">
                                        <strong>Account ID:</strong> <?=($account['ID'])?>
                                        <br>
                                        <strong>Username:</strong> <?=htmlspecialchars($account['Username'])?>
                                        <br>
                                        <strong>Name:</strong> <?=htmlspecialchars($account['FirstName'] . " " . $account['LastName'])?>
                                        <br>
                                        <strong>Account Permission:</strong> <?=$account['AccountStatus']?>
                                    </label>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <!-- Buttons to trigger specified actions on the selected accounts. 
                     TODO: @Souper, a JavaScript message asking the user if they're sure would be good here.-->
                    <button type="submit" name="Action" value="mkAdmin">Make Admin</button>
                    <button type="submit" name="Action" value="blockAdmin">Block Admin</button>
                    <button type="submit" name="Action" value="deleteAcc">Delete</button>
                </form>
            </div>
        </div>
    </body>
</html>
