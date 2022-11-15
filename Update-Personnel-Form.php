<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/checksession-admin.php'); ?>
<?php include('functions/alert.php'); ?>

<?php 
    $personnelID = $_GET['personnelID'];
    if(empty($personnelID)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $personnelID=mysqli_real_escape_string($conn,$personnelID);

        //prepare sql statement before execution
        $query="SELECT * FROM personnel WHERE personnelID=? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Personnel.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $personnelID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $personnelID = $data['personnelID'];
                    $fName = $data['fName'];
                    $mName = $data['mName'];
                    $lName = $data['lName'];
                    $licenseNo = $data['licenseNo'];
                    $designation = $data['designation'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("Personnel does not exist! ");
                header('Location: View-Personnel.php?alertmessage='.$alertmessage);
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Update Personnel</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/update-personnel.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update Personnel</h2>
                        </div>
                        <input type="hidden" name="personnelID" id="personnelID" value="<?php echo $personnelID; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="fName">First Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="fName" name="fName" maxlength="45" placeholder="Enter first name..." value="<?php echo $fName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="mName">Middle Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="mName" name="mName" maxlength="45" placeholder="Enter middle name..." value="<?php echo $mName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="lName">Last Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="lName" name="lName" maxlength="45" placeholder="Enter last name..." value="<?php echo $lName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="licenseNo">License Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="licenseNo" name="licenseNo" maxlength="45" placeholder="Enter license number..." value="<?php echo $licenseNo; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="designation">Designation</label>
                            <select class="form-select m-0 inputbox" id="designation" name="designation">
                                <?php if($designation=="Veterinarian"){?>
                                    <option value="Veterinarian" selected>Veterinarian</option>
                                    <option value="Personnel">Personnel</option>
                                <?php }elseif($designation=="Personnel"){ ?>
                                    <option value="Veterinarian">Veterinarian</option>
                                    <option value="Personnel" selected>Personnel</option>
                                <?php 
                                    }else{
                                    $alertmessage = urlencode("Invalid link! Logging out...");
                                    header('Location: functions/logout.php?alertmessage='.$alertmessage);
                                    exit();  
                                    }  
                                ?>
                            </select>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-primary w-50" type="submit" id="update-personnel" name="update-personnel"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>