<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

<?php
    $type = $_GET['type'];
    if(empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Add Admin</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/add-user.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Admin</h2>
                        </div>
                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="name" id="name" placeholder="Enter full name..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="email">Email</label>
                            <input class="form-control m-0 inputbox" type="email" name="email" id="email" placeholder="Enter email..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="password">Password</label>
                            <input class="form-control m-0 inputbox" type="password" name="password" id="password" placeholder="Enter password..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="contactnumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" name="contactnumber" id="contactnumber" placeholder="Enter contact number..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" name="add-user" id="add-user" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>