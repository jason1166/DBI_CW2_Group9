<!DOCTYPE html>
<html>
<head>
<title>Entertainment: Staff Database</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=5.0, minimum-scale=0.86">
<link rel='stylesheet' type='text/css' href='css_file.css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php 

// Log In
require "server.php";

//Page size
$results_per_page = 25;
$sql = "SELECT * FROM staff";

$result = mysqli_query($db, $sql);
$number_of_results = mysqli_num_rows($result);

// determine number of total pages available
$number_of_pages = ceil($number_of_results/$results_per_page);

function function_alert($message) { 
  // Display the alert box 
  echo "<script>alert('$message');</script>";
}

// determine which page number visitor is currently on
if (!isset($_GET["page"])) {
  $page = 1;
  $current_page=1;
} else {
  $page = $_GET["page"];
  $current_page=$_GET["page"];
}

// determine the sql LIMIT starting number for the results on the displaying page
$this_page_first_result = ($page-1)*$results_per_page;

// retrieve selected results from database and display them on page
$sql='SELECT * FROM staff LIMIT ' . $this_page_first_result . ',' .  $results_per_page;

$number_of_pages = ceil($number_of_results/$results_per_page);

//This is for header sorting 
$action = '';   
$where = '';

if(isset($_GET["id"]))
{
  $id     = $_GET["id"]; 
  $action = $_GET["action"]; 
    
    if($action == 'ASC')
    { 
        $action='DESC';
    }
    else  
    { 
        $action='ASC';
    }
    if($_GET['id']=='staff_id') 
    {
        $id = "staff_id";
    }
    elseif($_GET['id']=='first_name') 
    {
        $id = "first_name";
    }
    elseif($_GET['id']=='last_name') 
    {
        $id="last_name";
    }
    elseif($_GET['id']=='address_id') 
    {
        $id="address_id";
    }
    elseif($_GET['id']=='email') 
    {
        $id="email";
    }
    elseif($_GET['id']=='store_id') 
    {
        $id="store_id";
    }
    elseif($_GET['id']=='active') 
    {
        $id="active";
    }
    elseif($_GET['id']=='username') 
    {
        $id="username";
    }
    elseif($_GET['id']=='password') 
    {
        $id="password";
    }
    elseif($_GET['id']=='last_update') 
    {
        $id="last_update";
    }
        $where = " ORDER BY  $id $action ";
        $sql = "SELECT * FROM staff " . $where . ' LIMIT '. $this_page_first_result . ',' .  $results_per_page;
}

if(isset($_GET["search"]))
{
  $query = $_GET["search"]; 
  $min_length = 1;
  if(strlen($query) >= $min_length) // if query length is more or equal minimum length then
  $sql = 
  "SELECT * FROM staff WHERE (staff_id LIKE '" . $query . "%') OR (first_name LIKE '". $query ."%') OR (last_name LIKE '". $query ."%') 
  OR (address_id LIKE '". $query ."%') OR (email LIKE '". $query ."%') OR (store_id LIKE '". $query ."%') OR (active LIKE '". $query ."%')
  OR (username LIKE '". $query ."%')";
}

$result = mysqli_query($db, $sql);

if(isset($_POST['Insert']))
{	 
	 $staff_id = $_POST['staff_id'];
	 $first_name = $_POST['first_name'];
     $last_name = $_POST['last_name'];
     $address_id = $_POST['address_id'];
     $email = $_POST['email'];
     $store_id = $_POST['store_id'];
     $active = $_POST['active'];
     $username = $_POST['username'];    
     $password = $_POST['password'];

     $picture_name = $_FILES['picture']['name'];
     $picture = file_get_contents($picture_name);     

	$sql = "INSERT INTO staff (staff_id,first_name,last_name,address_id,picture,email,store_id,active,username,`password`,last_update)
	VALUES ('$staff_id','$first_name','$last_name',$address_id,$picture,$email,$store_id,$active,$username,$password,NOW())";
	if (mysqli_query($db, $sql)) {
    $status = "Query has been inserted";
    $status_code = "success";
    ?>
      <script>
          swal({
            title: "<?php echo $status?>",
            icon: "<?php echo $status_code?>",
            button: "Ok done",
            });
    </script><?php
      echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
}
else{
    ?>
      <script>
            swal({
              title: "Query can't be inserted",
              text: "<?php echo "Error: ".mysqli_error($db) ?>",
              icon: "error",
              button: "Ok done",
              });
      </script><?php
      echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
  }
}


if(isset($_POST['Update']))
{	 
    $staff_id = $_POST['staff_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address_id = $_POST['address_id'];    
    $email = $_POST['email'];
    $store_id = $_POST['store_id'];
    $active = $_POST['active'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $picture_name = $_FILES['picture']['name'];
    $picture = file_get_contents($picture_name);

    if(!empty($first_name)){
	$sql = "UPDATE staff SET first_name='$first_name' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
 			 	
    }
    else {
      ?>
        <script>
              swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
}

    if(!empty($last_name)){
		$sql ="UPDATE staff SET last_name='$last_name' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
 			 	
    }
    else {
      ?>
        <script>
              swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
}

    if(!empty($address_id)){
        $sql ="UPDATE staff SET address_id='$address_id' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
                
    }
    else {
    ?>
        <script>
            swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
    }

    if(!empty($picture)){
		$sql ="UPDATE staff SET picture='$picture' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
 			 	
    }
    else {
      ?>
        <script>
              swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
}

    if(!empty($email)){
        $sql ="UPDATE staff SET email='$email' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {             
    }
    else {
    ?>
        <script>
            swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
    }

    if(!empty($store_id)){
        $sql ="UPDATE staff SET store_id='$store_id' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
                
    }
    else {
    ?>
        <script>
            swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
    }

    if(!empty($active)){
		$sql ="UPDATE staff SET active='$active' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
 			 	
    }
    else {
      ?>
        <script>
              swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
    }

    if(!empty($username)){
        $sql ="UPDATE staff SET username='$lusername' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
                
    }
    else {
    ?>
        <script>
            swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
    }

    if(!empty($password)){
		$sql ="UPDATE staff SET password='$password' WHERE staff_id = $staff_id";
    if (mysqli_query($db, $sql) === TRUE) {
 			 	
    }
    else {
      ?>
        <script>
              swal({
                title: "Query can't be updated",
                text: "<?php echo "Error: ".mysqli_error($db) ?>",
                icon: "error",
                button: "Ok done",
                });
        </script><?php
        echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }	
    }   

    $sql ="UPDATE staff SET last_update=NOW() WHERE staff_id=$staff_id";
	if (mysqli_query($db, $sql) === TRUE) {
      $status = "Query has been updated";
        $status_code = "success";
        ?>
          <script>
              swal({
                title: "<?php echo $status?>",
                icon: "<?php echo $status_code?>",
                button: "Ok done",
                });
        </script><?php
          echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
    }
    else{
        ?>
          <script>
                swal({
                  title: "Query can't be updated",
                  text: "<?php echo "Error: ".mysqli_error($db) ?>",
                  icon: "error",
                  button: "Ok done",
                  });
          </script><?php
          echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
      }
}

if(isset($_POST['Delete']))
{
  $staff_id = $_POST['staff_id'];
  $sql = "DELETE FROM `staff` WHERE staff_id = $staff_id";
  if (mysqli_query($db, $sql)) {
    $status = "Query has been deleted";
    $status_code = "success";
    ?>
      <script>
          swal({
            title: "<?php echo $status?>",
            icon: "<?php echo $status_code?>",
            button: "Ok done",
            });
    </script><?php
      echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
}
else{
    ?>
      <script>
            swal({
              title: "Query can't be deleted",
              text: "<?php echo "Error: ". mysqli_error($db)?>",
              icon: "error",
              button: "Ok done",
              });
      </script><?php
      echo '<meta http-equiv="refresh" content="3;url=content_of_staff.php" />';
  }
}

?>
<!--Header-->
<div class="header">
  <a href="index.html" style="text-decoration:none"><h1>9 Warriors</h1></a>
  <p>Staff Table</p>
  <form class="header_button" action="content_of_staff.php" method="GET">
  <div id="stripe">
  <input type="text" name="search" placeholder="Search table...">
  <input class="search-button" type="submit" value="Search"/>
  </div>
</form>
</div>

<!--Content-->
<!-- Button for Insert -->
<div>
    <input type="checkbox" id="show">
    <label for="show" class="show-btn">Insert</label>
    <div class="container">
        <label for="show" class="close-btn fas fa-times"></label>
       
        <form action="content_of_staff.php" method="post" enctype="multipart/form-data">
        <!--<form action="content_of_country.php" method="post">-->
            <div class ="data">
                <label>Staff ID:</label>
                <input type ="text" name="staff_id" style=" width: 70%; height : 70%; display: inline-block; margin: px; ">
            </div>
            <div class ="data">
                <label>First Name:</label>
                <input type ="text" name="first_name" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data">
                <label>Last Name:</label>
                <input type ="text" name="last_name" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data">
                <label>Address ID:</label>
                <input type ="text" name="address_id" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div>
                <label>Picture:</label>
                <img name="picture_preview">
                <input type="file" name="picture" accept="image/*">
            </div>
            <!-- TODO: add image preview -->
            <div class ="data">
                <label>Email:</label>
                <input type="email" name ="email" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data">
                <label>Store ID:</label>
                <input type ="text" name="store_id" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data">
            <label>Active:</label>
                <input type ="text" name="active" placeholder="1 or 0" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data">
                <label>Username:</label>
                <input type ="text" name="username" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data">
                <label>Password:</label>
                <input type ="password" name="password" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class="btn">
                <div class="inner"></div>
                <button type="submit" name="Insert" value="Insert">Insert into Database</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Button for Update -->
<div>
    <input type="checkbox" id="show2">
    <label for="show2" class="show-btn-update">Update</label>
    <div class="container-update">
        <label for="show2" class="close-btn-update fas fa-times"></label>
        <form action="content_of_staff.php" method="post" enctype="multipart/form-data">
        <div class ="data-update">
                <label>Staff ID:</label>
                <input type ="text" name="staff_id" style=" width: 70%; height : 70%; display: inline-block; margin: px; ">
            </div>
            <div class ="data-update">
                <label>First Name:</label>
                <input type ="text" name="first_name" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data-update">
                <label>Last Name:</label>
                <input type ="text" name="last_name" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data-update">
                <label>Address ID:</label>
                <input type ="text" name="address_id" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div>
                <label>Picture:</label>
                <img name="picture_preview">
                <input type="file" name="picture" accept="image/*">
            </div>
            <div class ="data-update">
                <label>Email:</label>
                <input type="email" name ="email" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data-update">
                <label>Store ID:</label>
                <input type ="text" name="store_id" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data-update">
            <label>Active:</label>
                <input type ="text" name="active" placeholder="1 or 0" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data-update">
                <label>Username:</label>
                <input type ="text" name="username" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class ="data-update">
                <label>Password:</label>
                <input type ="password" name="password" style=" width: 70%; height : 70%; display: inline-block;" required>
            </div>
            <div class="btn-update">
                <div class="inner-update"></div>
                <button type="submit" name="Update" value="Update">Update Query</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Button for Delete -->
<div>
    <input type="checkbox" id="show3">
    <label for="show3" class="show-btn-delete">Delete</label>
    <div class="container-delete">
        <label for="show3" class="close-btn-delete fas fa-times"></label>
        <div class="text-delete">Delete Query</div>
        <form action="content_of_staff.php" method="post">
            <div class ="data-delete">
                <label>Staff ID:</label>
                <input type ="text" name="staff_id">
            </div>
            <div class="btn-delete">
                <div class="inner-delete"></div>
                <button type="submit" name="Delete" value="Delete">Delete</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Header of the table-->
<table class="styled-table" style="width: 100%;">
<thead>
  <tr>
    <th><a href="content_of_staff.php?id=<?php echo 'staff_id';?>&action=<?php echo $action;?>">Staff ID</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'first_name';?>&action=<?php echo $action;?>">First Name</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'last_name';?>&action=<?php echo $action;?>">Last Name</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'address_id';?>&action=<?php echo $action;?>">Address ID</a></th>
    <th>Picture</th>
    <th colspan="2"><a href="content_of_staff.php?id=<?php echo 'email';?>&action=<?php echo $action;?>">Email</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'store_id';?>&action=<?php echo $action;?>">Store ID</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'active';?>&action=<?php echo $action;?>">Active</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'username';?>&action=<?php echo $action;?>">Username</a></th>
    <th colspan="3"><a href="content_of_staff.php?id=<?php echo 'password';?>&action=<?php echo $action;?>">Password</a></th>
    <th><a href="content_of_staff.php?id=<?php echo 'last_update';?>&action=<?php echo $action;?>">Last_Update</a></th>
  </tr>
</thead>

<?php
//This is to display the content of the table
echo '<tbody>';

if (mysqli_num_rows($result) > 0){
  while ($row = mysqli_fetch_assoc($result)){
?>
    <tr class="active-row">
            <td><?php echo $row["staff_id"];?></td>
            <td><?php echo $row["first_name"];?></td>
            <td><?php echo $row["last_name"];?></td>
            <td><?php echo $row["address_id"];?></td>
            <td><?php echo '<img src="data:image/*;base64,'.base64_encode($row["picture"] ).'"/>';?></td>
            <td colspan="2"><?php echo $row["email"];?></td>
            <td><?php echo $row["store_id"];?></td>
            <td><?php echo $row["active"];?></td>
            <td><?php echo $row["username"];?></td>
            <td colspan="3"><?php echo $row["password"];?></td>
            <td><?php echo $row["last_update"];?></td>
            
    </tr>
<?php     
  }
}
echo '
</tbody>
</table>';
mysqli_close($db);
?>

<select class= "page-style" name="page" onchange="location=this.value">
<?php echo '<option value="content_of_staff.php">Page: ' . $current_page . '</option>';?>
<?php for ($page=1; $page<=$number_of_pages; $page++) {?>
      <?php echo '<option value="content_of_staff.php?page=' . $page . '">' . $page . '</a></option>'; ?>
<?php }?>
</select>

</div>
</body>
</html> 

