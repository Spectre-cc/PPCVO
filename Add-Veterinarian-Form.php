<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

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
                    <form method="POST" action="functions/add-veterinarian.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add <?php echo ucfirst($type); ?></h2>
                        </div>
                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="fName">First Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="fName" id="fName" placeholder="Enter first name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="mname">Middle Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="mName" id="mName" placeholder="Enter middle name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="lName">Last Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="lName" id="lName" placeholder="Enter last name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="licenseNo">License Number</label>
                            <input class="form-control m-0 inputbox" type="text" name="licenseNo" id="licenseNo" placeholder="Enter license number..." maxlength="45" required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-success w-50" type="submit" name="add-veterinarian" id="add-veterinarian"><i class="fa-solid fa-plus"></i> Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>