<?php
// retrieve one product will be here
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_login_system/config/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_login_system/objects/user.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/php_login_system/objects/access_level.php";

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$user = new user($db);
$access_level = new access_level($db);
 
// set ID property of user to be edited
$user->id = $id;
 
// read the details of user to be edited
$user->readOne();
 
?>
<!-- 'update user' form will be here -->
<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set user property values
    //$user->firstname = $_POST['firstname'];
    $user->lastname = $_POST['lastname'];
    $user->email = $_POST['email'];
    $user->access_level_id = $_POST['access_level_id'];
 
    // update the user
    if($user->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "User was updated.";
        echo "</div>";
    }
 
    // if unable to update the user, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update user.";
        echo "</div>";
    }
}
// set page header
$page_title = "Update User";
include_once "layout_head.php";
// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='read_users.php' class='btn btn-default pull-right'>Read User</a>";
echo "</div>";
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>First Name</td>
            <td><input type='text' name='name' value='<?php echo $user->firstname; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lastname' value='<?php echo $user->lastname; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Email</td>
            <td><textarea name='email' class='form-control'><?php echo $user->email; ?></textarea></td>
        </tr>
 
        <tr>
            <td>Access Level</td>
            <td>
                <!-- Access Level select drop-down will be here -->
		<?php
			$stmt = $access_level->read();
			 
			// put them in a select drop-down
			echo "<select class='form-control' name='access_level_id'>";
			 
				echo "<option>Please select...</option>";
				while ($row_access_level = $stmt->fetch(PDO::FETCH_ASSOC)){
					$access_level_id=$row_access_level['id'];
					$access_level_name = $row_access_level['level'];
			 
					// current access level of the user must be selected
					if($user->access_level_id==$access_level_id){
						echo "<option value='$access_level_id' selected>";
					}else{
						echo "<option value='$access_level_id'>";
					}
			 
					echo "$access_level_name</option>";
				}
			echo "</select>";
		?>
            </td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
  
// set page footer
include_once "layout_foot.php";
?>