<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Client List</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-center px-4">
                            <h2>Client Records</h2>
                            <div class="container-fluid mb-2">
                                <form action="">
                                    <div class="form-group d-flex justify-content-center">
                                        <input class="form-control inputbox w-25 mx-1" type="search" name="search" id="search" placeholder="Search client name...">
                                        <input class="btn btn-primary" type="submit" id="submit" value="Search">
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid mb-2">
                                <button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-center align-items-center">
                                <table class="table table-condensed table-bordered table-hover text-start w-75">
                                    <thead>
                                        <th class="medcell text-bg-dark">Name</th>
                                        <th class="autocell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="medcell">John Doe</td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-eye"></i> View Client Record</button> 
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-paw"></i> View Animals Owned</button> 
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