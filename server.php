<?php
$USERNAME = "root";
$PW = "";
$DATABASE_NAME = "entertainment";
$db = mysqli_connect ("localhost", $USERNAME, $PW, $DATABASE_NAME);

if (mysqli_connect_errno())
{
    die ("Failed to connect to MySql Database" . mysqli_connect_error());
}
?>