<!DOCTYPE html>
<html>
<head>
<title>Entertainment: Payment</title>
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
$sql = "SELECT * FROM payment";

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
$sql='SELECT * FROM payment LIMIT ' . $this_page_first_result . ',' .  $results_per_page;

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
    if($_GET['id']=='payment_id') 
    {
        $id = "payment_id";
    }
    elseif($_GET['id']=='customer_id') 
    {
        $id = "customer_id";
    }
    elseif($_GET['id']=='staff_id') 
    {
        $id="staff_id";
    }
    elseif($_GET['id']=='rental_id') 
    {
        $id="rental_id";
    }
    elseif($_GET['id']=='amount') 
    {
        $id="amount";
    }
    elseif($_GET['id']=='payment_date') 
    {
        $id="payment_date";
    }
    elseif($_GET['id']=='last_update') 
    {
        $id="last_update";
    }
        $where = " ORDER BY  $id $action ";
        $sql = "SELECT * FROM payment " . $where . ' LIMIT '. $this_page_first_result . ',' .  $results_per_page;
}

if(isset($_GET["search"]))
{
  $query = $_GET["search"]; 
  $min_length = 1;
  if(strlen($query) >= $min_length) // if query length is more or equal minimum length then
  $sql = 
  "SELECT * FROM payment WHERE (payment_id LIKE '" . $query . "%') OR (customer_id LIKE '". $query ."%') OR (staff_id LIKE '". $query ."%') OR (rental_id LIKE '". $query ."%') OR (amount LIKE '". $query ."%') OR (payment_date LIKE '". $query ."%')";
}

$result = mysqli_query($db, $sql);

if(isset($_POST['Insert']))
{	 
	 $payment_id = $_POST['payment_id'];
	 $customer_id = $_POST['customer_id'];
     $staff_id = $_POST['staff_id'];
     $rental_id = $_POST['rental_id'];
     $amount = $_POST['amount'];
     $payment_date_date=$_POST['payment_date_date'];
     $payment_date_time=$_POST['payment_date_time'];
     
     $payment_date=$payment_date_date . " " . $payment_date_time;

	 $sql = "INSERT INTO payment (payment_id,customer_id,staff_id,rental_id,amount,payment_date,last_update)
	 VALUES ('$payment_id','$customer_id','$staff_id','$rental_id','$amount','$payment_date',NOW())";
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
          echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
      
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
          echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
      }
}


if(isset($_POST['Update']))
{	 
    $payment_id = $_POST['payment_id'];
    $customer_id = $_POST['customer_id'];
    $staff_id = $_POST['staff_id'];
    $rental_id = $_POST['rental_id'];
    $amount = $_POST['amount'];
    $payment_date_date=$_POST['payment_date_date'];
    $payment_date_time=$_POST['payment_date_time'];

    $status = "Query has been updated";
    $status_code = "success";

    $payment_date=$payment_date_date . " " . $payment_date_time;

	if(!empty($customer_id)){
		$sql ="UPDATE payment SET customer_id='$customer_id' WHERE payment_id=$payment_id";
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
        }	
    }
   
    if(!empty($staff_id)){
		$sql ="UPDATE payment SET staff_id='$staff_id' WHERE payment_id=$payment_id";
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
        }	
    }

    if(!empty($rental_id)){
		$sql ="UPDATE payment SET rental_id='$rental_id' WHERE payment_id=$payment_id";
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
        }	
    }

    if(!empty($amount)){
		$sql ="UPDATE payment SET ammount='$amount' WHERE payment_id=$payment_id";
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
        }	
    }

    if(!empty($payment_date)){
		$sql ="UPDATE payment SET payment_date='$payment_date' WHERE payment_id=$payment_id";
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
        }	
    }

    $sql ="UPDATE payment SET last_update=NOW() WHERE payment_id=$payment_id";
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
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
            echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
        }
  }

if(isset($_POST['Delete']))
{
  $payment_id = $_POST['payment_id'];

  $sql = "DELETE FROM payment WHERE payment_id = '$payment_id'";
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
      echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
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
      echo '<meta http-equiv="refresh" content="3;url=content_of_payment.php" />';
  }
}

?>
<!--Header-->
<div class="header">
  <a href="index.html" style="text-decoration:none"><h1>9 Warriors</h1></a>
  <p>Entertainment Database</p>
  <form class="header_button" action="content_of_payment.php" method="GET">
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
        <form action="content_of_payment.php" method="post">
            <div class ="data">
                <label>Payment ID:</label>
                <input type ="text" name="payment_id">
            </div>
            <div class ="data">
                <label>Customer ID:</label>
                <input type ="text" name="customer_id" required>
            </div>
            <div class ="data">
                <label>Staff ID:</label>
                <input type ="text" name="staff_id" required>
            </div>
            <div class ="data">
                <label>Rental ID:</label>
                <input type ="text" name="rental_id" required>
            </div>
            <div class ="data">
                <label>Amount:</label>
                <input type ="text" name="amount" required>
            </div>
            <div>
                <label>Payment Date:</label>
                <input type="date" name="payment_date_date">
                <input type="time" name="payment_date_time" step=1>
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
        <form action="content_of_payment.php" method="post">
        <div class ="data-update">
                <label>Payment ID:</label>
                <input type ="text" name="payment_id">
            </div>
            <div class ="data-update">
                <label>Change Customer ID to:</label>
                <input type ="text" name="customer_id">
            </div>
            <div class ="data-update">
                <label>Change Staff ID to:</label>
                <input type ="text" name="staff_id">
            </div>
            <div class ="data-update">
                <label>Change Rental ID to:</label>
                <input type ="text" name="rental_id">
            </div>
            <div class ="data-update">
                <label>Change Amount to:</label>
                <input type ="text" name="amount">
            </div>
            <div>
                <label>Change Payment Date to:<br></label>
                <input type="date" name="payment_date_date">
                <input type="time" name="payment_date_time" step=1>
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
        <form action="content_of_payment.php" method="post">
            <div class ="data-delete">
                <label>Payment ID:</label>
                <input type ="text" name="payment_id" required>
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
    <th><a href="content_of_payment.php?id=<?php echo 'payment_id';?>&action=<?php echo $action;?>">Payment ID</a></th>
    <th><a href="content_of_payment.php?id=<?php echo 'customer_id';?>&action=<?php echo $action;?>">Customer ID</a></th>
    <th><a href="content_of_payment.php?id=<?php echo 'staff_id';?>&action=<?php echo $action;?>">Staff ID</a></th>
    <th><a href="content_of_payment.php?id=<?php echo 'rental_id';?>&action=<?php echo $action;?>">Rental ID</a></th>
    <th><a href="content_of_payment.php?id=<?php echo 'amount';?>&action=<?php echo $action;?>">Amount</a></th>
    <th><a href="content_of_payment.php?id=<?php echo 'payment_date';?>&action=<?php echo $action;?>">Payment Date</a></th>
    <th><a href="content_of_payment.php?id=<?php echo 'last_update';?>&action=<?php echo $action;?>">Last Update</a></th>
  </tr>
</thead>

<?php
//This is to display the content of the table
echo '<tbody>';

if (mysqli_num_rows($result) > 0){
  while ($row = mysqli_fetch_assoc($result)){
?>
    <tr class="active-row">
            <td><?php echo $row["payment_id"];?></td>
            <td><?php echo $row["customer_id"];?></td>
            <td><?php echo $row["staff_id"];?></td>
            <td><?php echo $row["rental_id"];?></td>
            <td><?php echo $row["amount"];?></td>
            <td><?php echo $row["payment_date"];?></td>
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
<?php echo '<option value="content_of_payment.php">Page: ' . $current_page . '</option>';?>
<?php for ($page=1; $page<=$number_of_pages; $page++) {?>
      <?php echo '<option value="content_of_payment.php?page=' . $page . '">' . $page . '</a></option>'; ?>
<?php }?>
</select>

</div>
</body>
</html> 

