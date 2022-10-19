<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Animals Owned</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2>Animals owned by John Doe</h2>
                            </div>
                            <div class="container-fluid mb-2">
                                <form action="">
                                    <div class="form-group d-flex justify-content-center">
                                        <input class="form-control inputbox w-25 mx-1" type="search" name="search" id="search" placeholder="Search client name...">
                                        <input class="btn btn-primary" type="submit" id="submit" value="Search">
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid text-center mb-2">
                                <button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">Name</th>
                                        <th class="medcell text-bg-dark">Species</th>
                                        <th class="medcell text-bg-dark">Breed</th>
                                        <th class="medcell text-bg-dark">Color</th>
                                        <th class="smallcell text-bg-dark">Sex</th>
                                        <th class="medcell text-bg-dark">Date of Birth</th>
                                        <th class="medcell text-bg-dark">Registration Date</th>
                                        <th class="medcell text-bg-dark">Vaccination Date</th>
                                        <th class="autocell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="medcell">Buck</td>
                                            <td class="medcell">Cat</td>
                                            <td class="medcell">Persian</td>
                                            <td class="medcell">Black</td>
                                            <td class="smallcell">Male</td>
                                            <td class="medcell">0/00/0000</td>
                                            <td class="medcell">0/00/0000</td>
                                            <td class="medcell">0/00/0000</td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button> 
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-notes-medical"></i> View Health History</button> 
                                                <button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>