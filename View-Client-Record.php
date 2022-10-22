<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $clientid = $_GET['clientid'];
    if(empty($clientid)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        require('functions/config/config.php');
        require('functions/config/db.php');

        //input
        $clientid=mysqli_real_escape_string($conn,$clientid);

        //prepare sql statement before execution
        $query="SELECT * FROM client WHERE clientID=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $clientid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $clientid = $data['clientID'];
                    $name = $data['name'];
                    $birthdate = $data['birthdate'];
                    $sex = $data['sex'];
                    $barangay = $data['barangay'];
                    $contactnumber = $data['contactNumber'];
                    $email = $data['email'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("Client does not exist! ".$type);
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
    <?php require('inc\links.php'); ?>
    <title>View Client Record</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-center" style="width: 40%;">
                            <h2>Client Record</h2>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center">
                            <table class="table table-condensed table-bordered table-hover text-start w-75">
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="medcell">Name</td>
                                            <td class="largecell"><?php echo $name; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Birthdate</td>
                                            <td class="largecell"><?php echo $birthdate; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Sex</td>
                                            <td class="largecell"><?php echo $sex; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Barangay</td>
                                            <td class="largecell"><?php echo $barangay; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Contact Number</td>
                                            <td class="largecell"><?php echo $contactnumber; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Email</td>
                                            <td class="largecell"><?php echo $email; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                            </table>
                            </div>
                            <a href="Update-Client-Form.php?clientid=<?php echo $clientid; ?>"><button class="btn btn-primary mt-3 w-50"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                            <a href="functions/delete-client.php?clientid=<?php echo $clientid; ?>"><button class="btn btn-danger mt-3 w-50"><i class="fa-solid fa-trash"></i> Delete</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>