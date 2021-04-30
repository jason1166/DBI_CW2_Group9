<!DOCTYPE html>
<html>

<head>
    <title>Entertainment: Customer Database</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=5.0, minimum-scale=0.86">
    <link rel='stylesheet' type='text/css' href='css_file.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php

    // Log In
    require "server.php";

    //Page size
    $results_per_page = 25;
    $sql = "SELECT * FROM customer";

    $result = mysqli_query($db, $sql);
    $number_of_results = mysqli_num_rows($result);

    // determine number of total pages available
    $number_of_pages = ceil($number_of_results / $results_per_page);

    function function_alert($message)
    {
        // Display the alert box 
        echo "<script>alert('$message');</script>";
    }

    // determine which page number visitor is currently on
    if (!isset($_GET["page"])) {
        $page = 1;
        $current_page = 1;
    } else {
        $page = $_GET["page"];
        $current_page = $_GET["page"];
    }

    // determine the sql LIMIT starting number for the results on the displaying page
    $this_page_first_result = ($page - 1) * $results_per_page;

    // retrieve selected results from database and display them on page
    $sql = 'SELECT * FROM customer LIMIT ' . $this_page_first_result . ',' .  $results_per_page;

    $number_of_pages = ceil($number_of_results / $results_per_page);

    //This is for header sorting 
    $action = '';
    $where = '';

    if (isset($_GET["id"])) {
        $id     = $_GET["id"];
        $action = $_GET["action"];

        if ($action == 'ASC') {
            $action = 'DESC';
        } else {
            $action = 'ASC';
        }
        if ($_GET['id'] == 'customer_id') {
            $id = "customer_id";
        } elseif ($_GET['id'] == 'store_id') {
            $id = "store_id";
        } elseif ($_GET['id'] == 'first_name') {
            $id = "first_name";
        } elseif ($_GET['id'] == 'last_name') {
            $id = "last_name";
        } elseif ($_GET['id'] == 'email') {
            $id = "email";
        } elseif ($_GET['id'] == 'address_id') {
            $id = "address_id";
        } elseif ($_GET['id'] == 'active') {
            $id = "active";
        } elseif ($_GET['id'] == 'create_date') {
            $id = "create_date";
        } elseif ($_GET['id'] == 'last_update') {
            $id = "last_update";
        }
        $where = " ORDER BY  $id $action ";
        $sql = "SELECT * FROM customer " . $where . ' LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
    }

    if (isset($_GET["search"])) {
        $query = $_GET["search"];
        $min_length = 1;
        if (strlen($query) >= $min_length) // if query length is more or equal minimum length then
            $sql =
                "SELECT * FROM customer WHERE (customer_id LIKE '" . $query . "%') OR (store_id LIKE '" . $query . "%') OR
                (first_name LIKE '" . $query . "%') OR (last_name LIKE '" . $query . "%') OR (email LIKE '" . $query . "%') OR
                (address_id LIKE '" . $query . "%') OR (active LIKE '" . $query . "%') OR (create_date LIKE '" . $query . "%')";
    }

    $result = mysqli_query($db, $sql);

    if (isset($_POST['Insert'])) {

        $customer_id = $_POST['customer_id'];
        $store = $_POST['store_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $address_id = $_POST['address_id'];
        $active = $_POST['active'];
        $create_date_date = $_POST['create_date_date'];
        $create_date_time = $_POST['create_date_time'];

        $create_date=$create_date_date . " " . $create_date_time;

        $sql = "INSERT INTO customer (customer_id,store_id,first_name,last_name,email,address_id,active,create_date,last_update)
	     VALUES ('$customer_id','$store','$first_name','$last_name','$email','$address_id','$active','$create_date',NOW())";

        if (mysqli_query($db, $sql)) {
            $status = "Query has been inserted";
            $status_code = "success";
    ?>
                <script>
                    swal({
                        title: "<?php echo $status ?>",
                        icon: "<?php echo $status_code ?>",
                        button: "Ok done",
                    });
                </script><?php
                            echo '<meta http-equiv="refresh" content="2;url=content_of_customer.php" />';
                        } else {
                            ?>
                <script>
                    swal({
                        title: "Query can't be inserted",
                        text: "<?php echo "Error: " . mysqli_error($db) ?>",
                        icon: "error",
                        button: "Ok done",
                    });
                </script><?php
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }
                    }


                if (isset($_POST['Update'])) {

                    $customer_id = $_POST['customer_id'];
                    $store = $_POST['store_id'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $email = $_POST['email'];
                    $address_id = $_POST['address_id'];
                    $active = $_POST['active'];
                    $create_date_date = $_POST['create_date_date'];
                    $create_date_time = $_POST['create_date_time'];

                    $create_date=$create_date_date . " " . $create_date_time;

                    if(!empty($store)){
                        $sql ="UPDATE customer SET store_id ='$store' WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    if(!empty($first_name)){
                        $sql ="UPDATE customer SET first_name ='$first_name' WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    if(!empty($last_name)){
                        $sql ="UPDATE customer SET last_name ='$last_name' WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    if(!empty($email)){
                        $sql ="UPDATE customer SET email ='$email' WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    if(!empty($address_id)){
                        $sql ="UPDATE customer SET address_id =$address_id WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    if(!empty($active) || $active == 0){
                        $sql ="UPDATE customer SET active = $active WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    if(!empty($create_date)){
                        $sql ="UPDATE customer SET create_date ='$create_date' WHERE customer_id = $customer_id";
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
                            echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                        }	                    
                    }

                    $sql ="UPDATE customer SET last_update=NOW() WHERE customer_id = $customer_id";
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
                                echo '<meta http-equiv="refresh" content="2;url=content_of_customer.php" />';
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
                                echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                            }
                }

                if (isset($_POST['Delete'])) {
                    $customer_id = $_POST['customer_id'];
                    $sql = "DELETE FROM customer WHERE customer_id = $customer_id";
                    if (mysqli_query($db, $sql)) {
                        $status = "Query has been deleted";
                        $status_code = "success";
                        ?>
                            <script>
                                swal({
                                    title: "<?php echo $status ?>",
                                    icon: "<?php echo $status_code ?>",
                                    button: "Ok done",
                                });
                            </script><?php
                                        echo '<meta http-equiv="refresh" content="2;url=content_of_customer.php" />';
                                    } else {
                                        ?>
                            <script>
                            swal({
                                title: "Query can't be deleted",
                                text: "<?php echo "Error: " . mysqli_error($db) ?>",
                                icon: "error",
                                button: "Ok done",
                            });
                        </script><?php
                                    echo '<meta http-equiv="refresh" content="3;url=content_of_customer.php" />';
                                }
                            }

                        ?>
    <!--Header-->
    <div class="header">
        <a href="index.html" style="text-decoration:none">
            <h1>9 Warriors</h1>
        </a>
        <p>Entertainment Database</p>
        <form class="header_button" action="content_of_customer.php" method="GET">
            <div id="stripe">
                <input type="text" name="search" placeholder="Search table...">
                <input class="search-button" type="submit" value="Search" />
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
            <form action="content_of_customer.php" method="post">
                <!--<form action="content_of_country.php" method="post">-->
                <div class="data">
                    <label>Customer ID:</label>
                    <input type="text" name="customer_id" >
                </div>
                <div class="data">
                    <label>Store ID:</label>
                    <input type="text" name="store_id" required>
                </div>
                <div class="data">
                    <label>First Name:</label>
                    <input type="text" name="first_name" pattern="[A-Za-z]{1,}" required>
                </div>
                <div class="data">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" pattern="[A-Za-z]{1,}" required>
                </div>
                <div class="data">
                    <label>Email:</label>
                    <input type="text" name="email" required>
                </div>
                <div class="data">
                    <label>Address ID:</label>
                    <input type="text" name="address_id" required>
                </div>
                <div class="data">
                    <label>Active:</label>
                    <input type="text" name="active" required>
                </div>
                <div>
                    <label>Create Date:</label>
                    <input type="date" name="create_date_date">
                    <input type="time" name="create_date_time" step=1>
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
            <form action="content_of_customer.php" method="post">
                <div class="data-update">
                    <label>Enter Customer ID (to update):</label>
                    <input type="text" name="customer_id" required>
                </div>
                <div class="data-update">
                    <label>Change Store Id to:</label>
                    <input type="text" name="store_id">
                </div>
                <div class="data-update">
                    <label>Change First Name to:</label>
                    <input type="text" name="first_name" pattern="[A-Za-z]{0,}">
                </div>
                <div class="data-update">
                    <label>Change Last Name to:</label>
                    <input type="text" name="last_name" pattern="[A-Za-z]{0,}">
                </div>
                <div class="data-update">
                    <label>Change Email to:</label>
                    <input type="text" name="email">
                </div>
                <div class="data-update">
                    <label>Change Address ID to:</label>
                    <input type="text" name="address_id">
                </div>
                <div class="data-update">
                    <label>Change Active to:</label>
                    <input type="text" name="active">
                </div>
                <div>
                    <label>Change Create Date to:<br></label>
                    <input type="date" name="create_date_date">
                    <input type="time" name="create_date_time" step=1>
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
            <form action="content_of_customer.php" method="post">
                <div class="data-delete">
                    <label>Customer Id:</label>
                    <input type="text" name="customer_id" required>
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
                <th><a href="content_of_customer.php?id=<?php echo 'customer_id'; ?>&action=<?php echo $action; ?>">Customer ID</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'store_id'; ?>&action=<?php echo $action; ?>">Store ID</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'first_name'; ?>&action=<?php echo $action; ?>">First Name</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'last_name'; ?>&action=<?php echo $action; ?>">Last Name</a></th>
                <th colspan = "4"><a href="content_of_customer.php?id=<?php echo 'email'; ?>&action=<?php echo $action; ?>">Email</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'address_id'; ?>&action=<?php echo $action; ?>">Address ID</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'active'; ?>&action=<?php echo $action; ?>">Active</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'create_date'; ?>&action=<?php echo $action; ?>">Create Date</a></th>
                <th><a href="content_of_customer.php?id=<?php echo 'last_update'; ?>&action=<?php echo $action; ?>">Last Update</a></th>
            </tr>
        </thead>

        <?php
        //This is to display the content of the table
        echo '<tbody>';

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <tr class="active-row">
                    <td><?php echo $row["customer_id"]; ?></td>
                    <td><?php echo $row["store_id"]; ?></td>
                    <td><?php echo $row["first_name"]; ?></td>
                    <td><?php echo $row["last_name"]; ?></td>
                    <td colspan = "4"><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["address_id"]; ?></td>
                    <td><?php echo $row["active"]; ?></td>
                    <td><?php echo $row["create_date"]; ?></td>
                    <td><?php echo $row["last_update"]; ?></td>
                </tr>
        <?php
            }
        }
        echo '
</tbody>
</table>';
        mysqli_close($db);
        ?>

        <select class="page-style" name="page" onchange="location=this.value">
            <?php echo '<option value="content_of_customer.php">Page: ' . $current_page . '</option>'; ?>
            <?php for ($page = 1; $page <= $number_of_pages; $page++) { ?>
                <?php echo '<option value="content_of_customer.php?page=' . $page . '">' . $page . '</a></option>'; ?>
            <?php } ?>
        </select>

        </div>
</body>

</html>