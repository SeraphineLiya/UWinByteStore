<!-- The main panel for administrators to choose what to do -->

<!--Check that the user is authorized, redirect if not.-->
<?php require("../../Private/authorizeadmin.php");?> 

<!DOCTYPE html>

<html>

<!-- As with all our pages, it is structured as one top-level container that contains at least
 one div for the maincontent, with the possibility of adding additional divs above or below
 for common elements like a nav bar, or page header and footer.-->
    <body>
        <div class = "container">
            <div class = "maincontent">
                <!-- This page serves as a menu for admin options. More content may be added in future-->
                <!-- Fieldset box with hyperlinks to a page for each admin option -->
                 <fieldset>
                    <legend>Administrator Options</legend>

                    <!-- Dropdown to select CSS theme and button to submit to php block at top of page -->
                    <form action="" method="post">
                        <label for="cssTheme">Website Theme:</label>
                        <select name="cssTheme" id="cssTheme">
                            <option value="Theme1.css">Theme 1</option> <!-- Theme options go here -->
                        </select>
                        <button type="submit">Set</button>
                    </form>
                    <span><strong>Data Management:</strong></span><br>
                    <!-- TODO: @NotDashy, the following hyperlinks would look better with CSS Button styling I think --> 
                    <a href="manageusers.php" class = "hyperButton">Manage User Accounts</a> 
                    <br>
                    <a href="productdb.php" class = "hyperButton">Change Products</a>
                 </fieldset>
            </div>
        </div>
    </body>
</html>
