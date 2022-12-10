<?php
// Set database connection details
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'ppcvo3';

// Set the filename for the backup
$filename = 'dataBackups/PPCVO' . date("Y-m-d-H-i-s") . '.sql';

// Dump the database using mysqldump
$command = "mysqldump --user={$user} --password={$password} --host={$host} {$database} > {$filename}";
system($command);
?>




