<?php

// Connect to MySQL
$link = mysqli_connect("localhost", "root", "", "ppcvo3");

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set the name of the backup file
$backup_file_name = "dataBackups/PPCVO" . date("Y-m-d-H-i-s") . ".sql";

// Use the `mysqldump` command to create a backup of the database
exec("mysqldump -h localhost -u root ppcvo3 > $backup_file_name");

// Close the MySQL connection
mysqli_close($link);

?>
