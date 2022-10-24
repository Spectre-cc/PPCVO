<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Download Records</title>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid justify-content-center align-items-center">
                    <form method="POST" action="" class="form-inline container text-center mt-4 py-2 border" style="width: 40%;">
                            <div class="container-fluid text-center mb-4">
                                <h2>Download Health Records</h2>
                            </div>
                            <div class="container-fluid text-center">
                                <label class="m-0" for="type">Select health record type: </label>
                                <select class="m-0 inputbox2" id="type" name="type">
                                <option value="Animal Health">Animal Health</option>
                                <option value="Vaccination">Vaccination</option>
                                <option value="Routine Services">Routine Services</option>
                                </select>
                            </div>
                            <div class="container-fluid center mt-1">               
                                <label class="form-label mt-2" for="from">From: </label>
                                <input class="m-0 inputbox2" type="date" id="from" name="from">
                                <label class="m-0" for="to">To: </label>
                                <input class="m-0 inputbox2" type="date" id="to" name="to">
                            </div>
                            <input class="btn btn-primary w-25" type="submit" id="retrieve" name="retreieve" value="Go">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>