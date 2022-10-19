<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Add Animal</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form action="" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Animal</h2>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" placeholder="Enter full name..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="species">Species</label>
                            <input class="form-control m-0 inputbox" type="text" id="species" placeholder="Enter species..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="breed">Breed</label>
                            <input class="form-control m-0 inputbox" type="text" id="breed" placeholder="Enter breed..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="color">Color</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" placeholder="Enter color..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="sex">Sex</label>
                            <input class="form-control m-0 inputbox" type="text" id="sex" placeholder="Enter sex..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="dateofbirth">Date of Birth</label>
                            <input class="form-control m-0 inputbox" type="date" id="dateofbirth" placeholder="Enter date of birth..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="registrationdate">Registration Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="registrationdate" placeholder="Enter date of registration..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="registrationnumber">Registration Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="registrationnumber" placeholder="Enter registration number..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="vaccinationdate">Vaccination Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="vaccinationdate" placeholder="Enter date of vaccination..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" id="submit" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>