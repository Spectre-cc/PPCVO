<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

<?php 
    $vetID = $_GET['vetID'];
    if(empty($vetID)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
        //input
        $vetID=mysqli_real_escape_string($conn,$vetID);

        //prepare sql statement before execution
        $query="SELECT * FROM veterinarian WHERE vetID=? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Veterinarian.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $vetID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $vetID = $data['vetID'];
                    $fName = $data['fName'];
                    $mName = $data['mName'];
                    $lName = $data['lName'];
                    $licenseNo = $data['licenseNo'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("Veterinarian does not exist! ");
                header('Location: View-Veterinarian.php?alertmessage='.$alertmessage);
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
    <title>Update User</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/update-veterinarian.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update Admin</h2>
                        </div>
                        <input type="hidden" name="vetID" id="vetID" value="<?php echo $vetID; ?>">
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
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-primary w-50" type="submit" id="update-veterinarian" name="update-veterinarian"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>