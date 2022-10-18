<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>View Client Record</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-center" style="width: 40%;">
                            <h2>Client Record</h2>
                            <div class="container pt-4 border border-2 border-dark rounded-4">
                                <p class="client-record text-start">
                                <u>Name:</u>  John Doe <br>
                                <u>Birthdate:</u>  09/10/2000 <br>
                                <u>Contact Number:</u>  09********* <br>
                                <u>Sex:</u> Male <br>
                                <u>Barangay:</u> Tagburos 
                                </p>
                            </div>
                            <button class="btn btn-primary mt-3 w-50"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>