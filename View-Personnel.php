<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/checksession-admin.php'); ?>
<?php include('functions/alert.php'); ?>

<?php 
    $query="SELECT personnelID, CONCAT(fName,' ',mName,' ',lName) as 'name', licenseNo, designation FROM personnel;";
    $result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Personnel</title>
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
                                <h2><i class="fa-solid fa-user-doctor fa-lg"></i> Personnel</h2>
                            </div>
                            <div class="container-fluid mb-2 text-center">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddVet" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="largecell text-bg-dark">Name</th>
                                        <th class="medcell text-bg-dark">License Number</th>
                                        <th class="medcell text-bg-dark">Designation</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="largecell"><?php echo $data['name']; ?></td>
                                            <td class="medcell"><?php echo $data['licenseNo']; ?></td>
                                            <td class="medcell"><?php echo $data['designation']; ?></td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <a href="Update-Personnel-Form.php?personnelID=<?php echo $data['personnelID']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="functions/delete-personnel.php?personnelID=<?php echo $data['personnelID']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
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
                <form method="POST" action="functions/add-personnel.php">
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
                            <input class="form-control m-0 inputbox" type="text" name="licenseNo" id="licenseNo" placeholder="Enter license number..." maxlength="45">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="designation">Designation</label>
                            <select class="form-select m-0 inputbox" id="designation" name="designation">
                                <option value="Veterinarian" selected>Veterinarian</option>
                                <option value="Personnel">Personnel</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" name="add-personnel" id="add-personnel"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="reset" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>