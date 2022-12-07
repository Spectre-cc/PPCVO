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
            clients.addressID,
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
            mysqli_stmt_bind_param($stmt, "i", $clientID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $addressID = $data['addressID'];
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
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <title>Update Client Record</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/update-client.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update Client</h2>
                        </div>
                        <input type="hidden" name="clientID" id="clientID" value="<?php echo $clientID; ?>">
                        <input type="hidden" name="addressID" id="addressID" value="<?php echo $addressID; ?>">
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
                            <label class="form-label m-0" for="birthdate">Birthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <select class="form-select m-0 inputbox" id="sex" name="sex" required>
                                <?php if($sex=="Male"){?>
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                <?php }elseif($sex=="Female"){ ?>
                                    <option value="Male">Male</option>
                                    <option value="Female" selected>Female</option>
                                    <option value="Other">Other</option>
                                <?php }elseif($sex=="Other"){ ?>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other" selected>Other</option>
                                <?php 
                                    }else{
                                    $alertmessage = urlencode("Invalid link! Logging out...");
                                    header('Location: functions/logout.php?alertmessage='.$alertmessage);
                                    exit();  
                                    }  
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="address">Address</label>
                            <input class="form-control m-0 inputbox" type="text" id="address" name="address" value="<?php echo $address; ?>">
                        </div>
                        <div class="form-group">
                            <label for="barangay" class="form-label m-0">Barangay</label>
                            <input class="form-control m-0 inputbox" list="datalistOptions" id="barangay" name="barangay" value="<?php echo $barangay; ?>" placeholder="Enter barangay..." required>
                                <datalist id="datalistOptions">
                                <?php 
                                    $query="SELECT brgy_name FROM barangays ORDER BY brgy_name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                ?>
                                    <option value="<?php echo $data['brgy_name']; ?>">
                                <?php 
                                    endforeach; 
                                    mysqli_free_result($result);
                                    mysqli_close($conn);
                                ?>
                                </datalist>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="cNumber">Contact Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="cNumber" name="cNumber" value="<?php echo $cNumber; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="contactnumber">Email</label>
                            <input class="form-control m-0 inputbox" type="email" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-primary w-50" type="submit" id="update-client" name="update-client"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>