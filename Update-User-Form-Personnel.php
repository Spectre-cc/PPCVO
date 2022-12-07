<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php') ?>
<?php include('./functions/alert.php'); ?>

<?php 
    $userID = $_GET['userID'];
    $type = $_GET['type'];
    if(empty($userID) && empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
        //input
        $userID=mysqli_real_escape_string($conn,$userID);
        $type=mysqli_real_escape_string($conn,$type);

        //prepare sql statement before execution
        $query="SELECT * FROM user WHERE userID=? AND type=? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Users.php?alertmessage='.$alertmessage.'&userID='.$userID.'&type='.$type);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "is", $userID, $type);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $userID = $data['userID'];
                    $type = $data['type'];
                    $fName = $data['fName'];
                    $mName = $data['mName'];
                    $lName = $data['lName'];
                    $email = $data['email'];
                    $cNumber = $data['cNumber'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("User does not exist! ");
                header('Location: View-Users.php?alertmessage='.$alertmessage.'&type='.$type);
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
    <?php require('./inc/links.php'); ?>
    <title>Update User</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/update-user-personnel.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update <?php echo $type; ?></h2>
                        </div>
                        <input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>">
                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="fName">First Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="fName" name="fName" maxlength="45" placeholder="Enter first name..." value="<?php echo $fName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="mName">Middle Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="mName" name="mName" maxlength="45" placeholder="Enter middle name..." value="<?php echo $mName; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="lName">Last Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="lName" name="lName" maxlength="45" placeholder="Enter last name..." value="<?php echo $lName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="email">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" maxlength="45" placeholder="Enter email..." value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="password">Set New Password (Optional)</label>
                            <input class="form-control m-0 inputbox" type="password" id="password" name="password" placeholder="Please leave blank if you don't want to set new password..">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="cNumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="cNumber" name="cNumber" maxlength="50" placeholder="Enter contact number..." value="<?php echo $cNumber; ?>">
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-primary w-50" type="submit" id="update-user" name="update-user"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>