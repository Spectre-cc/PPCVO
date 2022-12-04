<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-admin.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php 
    if(isset($_POST['search-personnel'])){
        $search = '%'.mysqli_real_escape_string($conn,$_POST['string']).'%';
        $query="
        SELECT 
            personnelA.personnelID, 
            personnelA.name, 
            personnelA.licenseNo, 
            personnelA.designation 
        FROM 
            (
                SELECT 
                    personnelID, 
                    CONCAT(fName,' ',mName,' ',lName) as 'name', 
                    licenseNo, 
                    designation,
                    status
                FROM 
                    personnel 
            ) AS personnelA 
        WHERE
            personnelA.name LIKE ?
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "s", $search);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }    
    }else{
        $query="
        SELECT 
            personnelID, 
            CONCAT(fName,' ',mName,' ',lName) as 'name', 
            licenseNo, 
            designation,
            status
        FROM 
            personnel;";
        $result = mysqli_query($conn,$query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <title>Personnel</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2><i class="fa-solid fa-user-doctor fa-lg"></i> Personnel</h2>
                            </div>
                            <div class="container-fluid d-flex justify-content-center text-center my-2">
                                <form class="w-50 d-flex justify-content-center" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="w-100 d-flex justify-content-center bg-white border border-secondary rounded-pill">
                                        <input class="form-control search bg-transparent" style="border:0;" type="search" name="string" id="string" placeholder="Search for user...">
                                        <button class="btn btn-secondary text-light searchbtn border" type="submit" name="search-personnel" id="search-personnel"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
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
                                        <th class="medcell text-bg-dark">Status</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="largecell"><?php echo $data['name']; ?></td>
                                            <td class="medcell"><?php echo $data['licenseNo']; ?></td>
                                            <td class="medcell"><?php echo $data['designation']; ?></td>
                                            <td class="medcell"><?php echo $data['status']; ?></td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <a href="Update-Personnel-Form.php?personnelID=<?php echo $data['personnelID']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <?php if($data['status']=="active"){ ?>
                                                    <a href="functions/personnel-status.php?personnelID=<?php echo $data['personnelID']; ?>&action=deactivate"><button class="btn btn-danger mx-1"><i class="fa-solid fa-x"></i> Deactivate</button></a>
                                                <?php }else{ ?>
                                                    <a href="functions/personnel-status.php?personnelID=<?php echo $data['personnelID']; ?>&action=activate"><button class="btn btn-success mx-1"><i class="fa-solid fa-check"></i> Activate</button></a>
                                                <?php } ?>
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