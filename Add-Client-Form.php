<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Add Client</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/add-client.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Client</h2>
                        </div>
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
                            <label class="form-label m-0" for="birthdate">Birthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <select class="form-select m-0 inputbox" id="sex" name="sex">
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="barangay">Barangay</label>
                            <input class="form-control m-0 inputbox" type="text" id="barangay" name="barangay" placeholder="Enter barangay..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="cNumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" name="cNumber" id="cNumber" placeholder="Enter contact number..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" placeholder="Enter email..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-success w-50" type="submit" id="add-client" name="add-client"><i class="fa-solid fa-plus"></i> Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>