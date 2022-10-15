<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Users</title>
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
                                <h2>Users</h2>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">Name</th>
                                        <th class="medcell text-bg-dark">Email</th>
                                        <th class="medcell text-bg-dark">Password</th>
                                        <th class="largecell text-bg-dark">Contact Number</th>
                                        <th class="largecell text-bg-dark">Address</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="medcell">Buck</td>
                                            <td class="medcell">Cat</td>
                                            <td class="medcell">Persian</td>
                                            <td class="medcell">Black</td>
                                            <td class="smallcell">Male</td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button> 
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