<!DOCTYPE html>
<html>
<head>
<title>Entertainment: Film Feature Database</title>
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
$sql = "SELECT * FROM `film_feature`";

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
$sql='SELECT * FROM `film_feature` LIMIT ' . $this_page_first_result . ',' .  $results_per_page;

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
    if($_GET['id']=='feature_id') 
    {
        $id = "feature_id";
    }
    elseif($_GET['id']=='feature_name') 
    {
        $id = "feature_name";
    }
    elseif($_GET['id']=='last_update') 
    {
        $id="last_update";
    }
        $where = " ORDER BY  $id $action ";
        $sql = "SELECT * FROM `film_feature` " . $where . ' LIMIT '. $this_page_first_result . ',' .  $results_per_page;
}

if(isset($_GET["search"]))
{
  $query = $_GET["search"]; 
  $min_length = 1;
  if(strlen($query) >= $min_length) // if query length is more or equal minimum length then
  $sql = 
  "SELECT * FROM `film_feature` WHERE (feature_id LIKE '" . $query . "%') OR (feature_name LIKE '". $query ."%')";
}

$result = mysqli_query($db, $sql);

if(isset($_POST['Insert']))
{	 
	 $feature_id = $_POST['feature_id'];
	 $feature_name = $_POST['feature_name'];
	 $sql = "INSERT INTO `film_feature` (feature_id,feature_name,last_update)
	 VALUES ('$feature_id','$feature_name',NOW())";
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
        echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
    
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
        echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
    }
}


if(isset($_POST['Update']))
{	 
    $feature_id = $_POST['feature_id'];
    $feature_name = $_POST['feature_name'];
    $status = "Query has been updated";
    $status_code = "success";


    if(!empty($feature_name)){
		$sql ="UPDATE `film_feature` SET feature_name='$feature_name' WHERE feature_id = $feature_id";
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
        echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
    }	
}

    $sql ="UPDATE `film_feature` SET last_update=NOW() WHERE feature_id=$feature_id";
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
          echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
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
          echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
      }
}

if(isset($_POST['Delete']))
{
  $feature_id = $_POST['feature_id'];
  $sql = "DELETE FROM `film_feature` WHERE feature_id = $feature_id";
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
      echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
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
      echo '<meta http-equiv="refresh" content="2;url=content_of_film_feature.php" />';
  }
}

?>
<!--Header-->
<div class="header">
  <a href="index.html" style="text-decoration:none"><h1>9 Warriors</h1></a>
  <p>Entertainment Database</p>
  <form class="header_button" action="content_of_film_feature.php" method="GET">
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
        <form action="content_of_film_feature.php" method="post">
        <!--<form action="content_of_country.php" method="post">-->
            <div class ="data">
                <label>Feature ID:</label>
                <input type ="text" name="feature_id">
            </div>
            <div class ="data">
                <label>Feature Name:</label>
                <input type ="text" name="feature_name" required>
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
        <form action="content_of_film_feature.php" method="post">
            <div class ="data-update">
                <label>Enter Feature ID (to update):</label>
                <input type ="text" name="feature_id" required>
            </div>
            <div class ="data-update">
                <label>Change Feature Name to:</label>
                <input type ="text" name="feature_name" required>
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
        <form action="content_of_film_feature.php" method="post">
            <div class ="data-delete">
                <label>Feature Id:</label>
                <input type ="text" name="feature_id" required>
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
    <th><a href="content_of_film_feature.php?id=<?php echo 'feature_id';?>&action=<?php echo $action;?>">Feature Id</a></th>
    <th><a href="content_of_film_feature.php?id=<?php echo 'feature_name';?>&action=<?php echo $action;?>">Feature Name</a></th>
    <th><a href="content_of_film_feature.php?id=<?php echo 'last_update';?>&action=<?php echo $action;?>">Last Update</a></th>
  </tr>
</thead>

<?php
//This is to display the content of the table
echo '<tbody>';

if (mysqli_num_rows($result) > 0){
  while ($row = mysqli_fetch_assoc($result)){
?>
    <tr class="active-row">
            <td><?php echo $row["feature_id"];?></td>
            <td><?php echo $row["feature_name"];?></td>
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
<?php echo '<option value="content_of_film_feature.php">Page: ' . $current_page . '</option>';?>
<?php for ($page=1; $page<=$number_of_pages; $page++) {?>
      <?php echo '<option value="content_of_film_feature.php?page=' . $page . '">' . $page . '</a></option>'; ?>
<?php }?>
</select>

</div>
</body>
</html> 

