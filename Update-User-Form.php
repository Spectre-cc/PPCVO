<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-admin.php'); ?>

<?php 
    $userid = $_GET['user'];
    $type = $_GET['type'];
    if(empty($userid) && empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage'.$alertmessage);
        exit();
    }
    else{
        require('functions/config/config.php');
        require('functions/config/db.php');

        //input
        $userid=mysqli_real_escape_string($conn,$userid);
        $type=mysqli_real_escape_string($conn,$type);

        //prepare sql statement before execution
        $query="SELECT * FROM user WHERE userid=? AND type=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: Update-User-Form.php?alertmessage='.$alertmessage.'&userid='.$userid.'&type='.$type);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "is", $userid, $type);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $userid = $data['userid'];
                    $type = $data['type'];
                    $name = $data['name'];
                    $email = $data['email'];
                    $contactnumber = $data['contactNumber'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("User does not exist! ".$type);
                if($type="personnel"){
                    header('Location: View-Users-Personnel.php?alertmessage='.$alertmessage);
                    exit();
                  }
                else if($type="admin"){
                    header('Location: View-Users-Admin.php?alertmessage='.$alertmessage);
                    exit();
                }
                else{
                    $alertmessage = urlencode("Invalid link! Logging out...");
                    header('Location: functions/logout.php?alertmessage='.$alertmessage);
                    exit();
                }
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
                    <form method="POST" action="functions/update-user.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update Admin</h2>
                        </div>
                        <input type="hidden" name="userid" id="userid" value="<?php echo $userid; ?>">
                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" name="name" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="email">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="password">Set New Password</label>
                            <input class="form-control m-0 inputbox" type="password" id="password" name="password" placeholder="Please leave blank if you don't want to set new password..">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="contactnumber" name="contactnumber" value="<?php echo $contactnumber; ?>">
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-primary w-50" type="submit" id="update-user" name="update-user" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>