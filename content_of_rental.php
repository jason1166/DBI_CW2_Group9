<!DOCTYPE html>
<html>
<head>
<title>Entertainment: Rental Database</title>
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
$sql = "SELECT * FROM rental";

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
$sql='SELECT * FROM rental LIMIT ' . $this_page_first_result . ',' .  $results_per_page;

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
    if($_GET['id']=='rental_id') 
    {
        $id = "rental_id";
    }
    elseif($_GET['id']=='rental_date') 
    {
        $id = "rental_date";
    }
    elseif($_GET['id']=='inventory_id') 
    {
        $id="inventory_id";
    }
    elseif($_GET['id']=='customer_id') 
    {
        $id="customer_id";
    }
    elseif($_GET['id']=='return_date') 
    {
        $id="return_date";
    }
    elseif($_GET['id']=='staff_id') 
    {
        $id="staff_id";
    }
    elseif($_GET['id']=='last_update') 
    {
        $id="last_update";
    }
        $where = " ORDER BY  $id $action ";
        $sql = "SELECT * FROM rental " . $where . ' LIMIT '. $this_page_first_result . ',' .  $results_per_page;
}

if(isset($_GET["search"]))
{
  $query = $_GET["search"]; 
  $min_length = 1;
  if(strlen($query) >= $min_length) // if query length is more or equal minimum length then
  $sql = 
  "SELECT * FROM rental WHERE (rental_id LIKE '" . $query . "%') OR (first_name LIKE '". $query ."%') OR (last_name LIKE '". $query ."%')";
}

$result = mysqli_query($db, $sql);

if(isset($_POST['Insert']))
{	 
	 $rental_id = $_POST['rental_id'];
	 $rental_date_date = $_POST['rental_date_date'];
     $rental_date_time = $_POST['rental_date_time'];
     $inventory_id = $_POST['inventory_id'];
     $customer_id = $_POST['customer_id'];
     $return_date_date = $_POST['return_date_date'];
     $return_date_time = $_POST['return_date_time'];
     $staff_id = $_POST['staff_id'];

     $rental_date=$rental_date_date . " " . $rental_date_time;
     $return_date=$return_date_date . " " . $return_date_time;

	 $sql = "INSERT INTO rental (rental_id,rental_date,inventory_id,customer_id,return_date,staff_id,last_update) 
	 VALUES ('$rental_id','$rental_date','$inventory_id','$customer_id','$return_date','$staff_id',NOW())";
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
          echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
      
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
          echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
      }
}


if(isset($_POST['Update']))
{	 
	 $rental_id = $_POST['rental_id'];
	 $rental_date_date = $_POST['rental_date_date'];
     $rental_date_time = $_POST['rental_date_time'];
	 $inventory_id = $_POST['inventory_id'];
     $customer_id = $_POST['customer_id'];
     $return_date_date = $_POST['return_date_date'];
     $return_date_time = $_POST['return_date_time'];
     $staff_id = $_POST['staff_id'];

     $rental_date=$rental_date_date . " " . $rental_date_time;
     $return_date=$return_date_date . " " . $return_date_time;

	if(!empty($rental_date)){
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
        echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
        }	
    }
   
    if(!empty($inventory_id)){
		$sql ="UPDATE rental SET inventory_id='$inventory_id' WHERE rental_id=$rental_id";
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
        echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
        }	
    }

    if(!empty($customer_id)){
		$sql ="UPDATE rental SET customer_id='$customer_id' WHERE rental_id=$rental_id";
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
        echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
        }	
    }

    if(!empty($return_date)){
		$sql ="UPDATE rental SET return_date = '$return_date' WHERE rental_id=$rental_id";
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
        echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
        }	
    }

    if(!empty($staff_id)){
		$sql ="UPDATE rental SET staff_id='$staff_id' WHERE rental_id=$rental_id";
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
        echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
        }	
    }

    $sql ="UPDATE rental SET last_update=NOW() WHERE rental_id=$rental_id";
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
            echo '<meta http-equiv="refresh" content="2;url=content_of_rental.php" />';
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
        }
}

if(isset($_POST['Delete']))
{
  $rental_id = $_POST['rental_id'];

  $sql = "DELETE FROM rental WHERE rental_id = '$rental_id'";
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
    echo '<meta http-equiv="refresh" content="2;url=content_of_rental.php" />';

}
else{
?>
  <script>
        swal({
          title: "Query can't be deleted",
          icon: "error",
          button: "Ok done",
          });
  </script><?php
  echo '<meta http-equiv="refresh" content="3;url=content_of_rental.php" />';
}
}

?>
<!--Header-->
<div class="header">
  <a href="index.html" style="text-decoration:none"><h1>9 Warriors</h1></a>
  <p>Entertainment Database</p>
  <form class="header_button" action="content_of_rental.php" method="GET">
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
        <div class="text">Insert Query</div>
        <form action="content_of_rental.php" method="post">
            <div class ="data">
                <label>Rental ID:</label>
                <input type ="text" name="rental_id">
            </div>
            <div>
                <label>Rental Date:</label>
                <input type="date" id="irentaldd" name="rental_date_date" max=<?php echo date('Y-m-d')?>>
                <input type="time" name="rental_date_time" step=1>
            </div>
            <div class ="data">
                <label>Inventory ID:</label>
                <input type ="text" name="inventory_id">
            </div>
            <div class ="data">
                <label>Customer ID:</label>
                <input type ="text" name="customer_id">
            </div>
            <div>
                <label>Return Date:</label>
                <input type="date" id="ireturndd" name="return_date_date">
                <input type="time" name="return_date_time" step=1>
            </div>
            <div class ="data">
                <label>Staff ID:</label>
                <input type ="text" name="staff_id">
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
        <div class="text-update">Update Query</div>
        <form action="content_of_rental.php" method="post">
            <div class ="data-update">
                <label>Enter Rental ID (to update):</label>
                <input type ="text" name="rental_id" required>
            </div>
            <div>
                <label>Change Rental Date to:</label>
                <input type="date" id="urentaldd" name="rental_date_date" max=<?php echo date('Y-m-d')?>>
                <input type="time" name="rental_date_time" step=1>
            </div>
            <div class ="data-update">
                <label>Change Inventory ID to:</label>
                <input type ="text" name="inventory_id">
            </div>
            <div class ="data-update">
                <label>Change Customer ID to:</label>
                <input type ="text" name="customer_id">
            </div>
            <div>
                <label>Change Return Date to:</label>
                <input type="date" id="ureturndd" name="return_date_date">
                <input type="time" name="return_date_time" step=1>
            </div>
            <div class ="data-update">
                <label>Change Staff ID to:</label>
                <input type ="text" name="staff_id">
            </div>
            <div class="btn-update">
                <div class="inner-update"></div>
                <button type="submit" name="Update" value="Update">Update Query</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script src="constrainreturndateinput.js"></script>

<!-- Button for Delete -->
<div>
    <input type="checkbox" id="show3">
    <label for="show3" class="show-btn-delete">Delete</label>
    <div class="container-delete">
        <label for="show3" class="close-btn-delete fas fa-times"></label>
        <div class="text-delete">Delete Query</div>
        <form action="content_of_rental.php" method="post">
            <div class ="data-delete">
                <label>Rental ID:</label>
                <input type ="text" name="rental_id" required>
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
<table class="styled-table">
<thead>
  <tr>
    <th><a href="content_of_rental.php?id=<?php echo 'rental_id';?>&action=<?php echo $action;?>">Rental ID</a></th>
    <th><a href="content_of_rental.php?id=<?php echo 'rental_date';?>&action=<?php echo $action;?>">Rental Date</a></th>
    <th><a href="content_of_rental.php?id=<?php echo 'inventory_id';?>&action=<?php echo $action;?>">Inventory ID</a></th>
    <th><a href="content_of_rental.php?id=<?php echo 'customer_id';?>&action=<?php echo $action;?>">Customer ID </a></th>
    <th><a href="content_of_rental.php?id=<?php echo 'return_date';?>&action=<?php echo $action;?>">Return Date </a></th>
    <th><a href="content_of_rental.php?id=<?php echo 'staff_id';?>&action=<?php echo $action;?>">Staff ID </a></th>
    <th><a href="content_of_rental.php?id=<?php echo 'last_update';?>&action=<?php echo $action;?>">Last Update</a></th>
  </tr>
</thead>

<?php
//This is to display the content of the table
echo '<tbody>';

if (mysqli_num_rows($result) > 0){
  while ($row = mysqli_fetch_assoc($result)){
?>
    <tr class="active-row">
            <td><?php echo $row["rental_id"];?></td>
            <td><?php echo $row["rental_date"];?></td>
            <td><?php echo $row["inventory_id"];?></td>
            <td><?php echo $row["customer_id"];?></td>
            <td><?php echo $row["return_date"];?></td>
            <td><?php echo $row["staff_id"];?></td>
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
<?php echo '<option value="content_of_rental.php">Page: ' . $current_page . '</option>';?>
<?php for ($page=1; $page<=$number_of_pages; $page++) {?>
      <?php echo '<option value="content_of_rental.php?page=' . $page . '">' . $page . '</a></option>'; ?>
<?php }?>
</select>

</div>
</body>
</html> 

