<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php 
    $userID = $_SESSION['userID'];
    $type = $_SESSION['type'];
    if(empty($userID)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $userID=mysqli_real_escape_string($conn,$userID);

        //prepare sql statement before execution
        $query="SELECT * FROM user WHERE userID=? LIMIT 1;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: User-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $userID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $userID = $data['userID'];
                    $fName = $data['fName'];
                    $mName = $data['mName'];
                    $lName = $data['lName'];
                    $email = $data['email'];
                    $cNumber = $data['cNumber'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("User does not exist! ".$type);
                header('Location: View-Client-List.php?alertmessage='.$alertmessage);
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
    <title>View Client Record</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-center" style="width: 40%;">
                            <h2>Account Information</h2>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center">
                            <table class="table table-condensed table-bordered table-hover text-start w-75">
                                <tbody>
                                    <?php foreach($result as $data) : ?>
                                    <tr>
                                        <td class="medcell">First Name</td>
                                        <td class="largecell"><?php echo $fName; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="medcell">Middle Name</td>
                                        <td class="largecell"><?php echo $mName; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="medcell">Last Name</td>
                                        <td class="largecell"><?php echo $lName; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="medcell">Email</td>
                                        <td class="largecell"><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="medcell">Contact Number</td>
                                        <td class="largecell"><?php echo $cNumber; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                            <a href="Update-User-Form-Personnel.php?userID=<?php echo $userID; ?>&type=<?php echo $type; ?>"><button class="btn btn-primary mt-1 w-50"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>