<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

<?php 
    $query="SELECT * FROM veterinarian;";
    $result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Veterinarian</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2><i class="fa-solid fa-user-doctor fa-lg"></i> Veterinarian</h2>
                            </div>
                            <div class="container-fluid mb-2 text-center">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddVet" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">First Name</th>
                                        <th class="medcell text-bg-dark">Middle Name</th>
                                        <th class="medcell text-bg-dark">Last Name</th>
                                        <th class="medcell text-bg-dark">License Number</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['fName']; ?></td>
                                            <td class="medcell"><?php echo $data['mName']; ?></td>
                                            <td class="medcell"><?php echo $data['lName']; ?></td>
                                            <td class="largecell"><?php echo $data['licenseNo']; ?></td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <a href="Update-Veterinarian-Form.php?vetID=<?php echo $data['vetID']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="functions/delete-veterinarian.php?vetID=<?php echo $data['vetID']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <?php 
                                        endforeach; 
                                        mysqli_free_result($result);
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="AddVet" tabindex="-1" aria-labelledby="AddVetLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-3 " id="AddVetLabel"><i class="fa-solid fa-user-doctor fa-lg"></i> Veterinarian</h1>
                </div>
                <form method="POST" action="functions/add-veterinarian.php">
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" name="add-veterinarian" id="add-veterinarian"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>