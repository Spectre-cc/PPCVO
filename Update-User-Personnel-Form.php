<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Update User</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form action="" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update User</h2>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" placeholder="Enter full name..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="email">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" placeholder="Enter email..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="password">Password</label>
                            <input class="form-control m-0 inputbox" type="password" id="password" placeholder="Enter password..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="contactnumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="number" id="contactnumber" placeholder="Enter contact number..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-primary w-50" type="submit" id="submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>