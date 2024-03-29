<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php 
    $clientID = $_GET['clientID'];
    if(empty($clientID)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $clientID=mysqli_real_escape_string($conn,$clientID);

        //prepare sql statement before execution
        $query="
        SELECT 
            clients.clientID,
            clients.fName,
            clients.mName,
            clients.lName,
            clients.birthdate,
            clients.sex,
            clients_addresses.Specific_add,
            barangays.brgy_name,
            clients.cNumber,
            clients.email
        FROM 
            `clients`,
            `clients_addresses`,
            `barangays`
        WHERE 
            clients.clientID=?
            AND
            clients.addressID=clients_addresses.addressID
            AND
            clients_addresses.barangayID=barangays.barangayID
        LIMIT 1;
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $clientID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $clientID = $data['clientID'];
                    $fName = $data['fName'];
                    $mName = $data['mName'];
                    $lName = $data['lName'];
                    $birthdate = $data['birthdate'];
                    $sex = $data['sex'];
                    $address = $data['Specific_add'];
                    $barangay = $data['brgy_name'];
                    $cNumber = $data['cNumber'];
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
                            <h2>Client Record</h2>
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
                                            <td class="medcell">Birthdate</td>
                                            <td class="largecell"><?php echo $birthdate; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Sex</td>
                                            <td class="largecell"><?php echo $sex; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Address</td>
                                            <td class="largecell"><?php echo $address; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Barangay</td>
                                            <td class="largecell"><?php echo $barangay; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Contact Number</td>
                                            <td class="largecell"><?php echo $cNumber; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">Email</td>
                                            <td class="largecell"><?php echo $email; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                            </table>
                            </div>
                            <a href="Update-Client-Form.php?clientID=<?php echo $clientID; ?>"><button class="btn btn-primary mt-1 w-50"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                            <a href="functions/delete-client.php?clientID=<?php echo $clientID; ?>"><button class="btn btn-danger mt-1 w-50"><i class="fa-solid fa-trash"></i> Delete</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>