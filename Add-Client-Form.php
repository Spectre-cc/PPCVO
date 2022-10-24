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
        <div class="wrapper d-flex h-auto">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/add-client.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Client</h2>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" name="name" placeholder="Enter full name..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="birthdate">Birthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <input class="form-control m-0 inputbox" type="text" id="sex" name="sex" placeholder="Enter sex..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="barangay">Barangay</label>
                            <input class="form-control m-0 inputbox" type="text" id="barangay" name="barangay" placeholder="Enter barangay..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="contactnumber" name="contactnumber" placeholder="Enter contact number..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" placeholder="Enter email..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" id="add-client" name="add-client" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>