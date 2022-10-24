<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Analytics</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-auto">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100 text-center">
                <?php echo $_SESSION['type']; ?>
                <?php echo $_SESSION['isloggedin']; ?>
            </div>
        </div>
    </div>
</body>
</html>