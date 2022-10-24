<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $clientid = $_GET['clientid'];
    $clientname = $_GET['clientname'];
    if(empty($clientid) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        require('functions/config/config.php');
        require('functions/config/db.php');

        //check if client exist
        //input
        $clientid=mysqli_real_escape_string($conn,$clientid);
        $clientname=mysqli_real_escape_string($conn,$clientname);
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
            if(mysqli_num_rows($result)!==1){
                $alertmessage = urlencode("Client does not exist! ".$type);
                header('Location: View-Client-List.php?alertmessage='.$alertmessage);
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
    <title>Add Animal</title>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/add-animal.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Animal</h2>
                        </div>
                        <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>">
                        <input type="hidden" id="clientname" name="clientname" value="<?php echo $clientname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" name="name" placeholder="Enter full name..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="species">Species</label>
                            <input class="form-control m-0 inputbox" type="text" id="species" name="species" placeholder="Enter species..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="breed">Breed</label>
                            <input class="form-control m-0 inputbox" type="text" id="breed" name="breed" placeholder="Enter breed..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="color">Color</label>
                            <input class="form-control m-0 inputbox" type="text" id="color" name="color" placeholder="Enter color..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <input class="form-control m-0 inputbox" type="text" id="sex" name="sex" placeholder="Enter sex..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="birthdate">Brthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" placeholder="Enter date of birth..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="vaccinationdate">Vaccination Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="vaccinationdate" name="vaccinationdate">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="registrationdate">Registration Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="registrationdate" name="registrationdate">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="registrationnumber">Registration Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="registrationnumber" name="registrationnumber" placeholder="Enter registration number...">
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" id="add-animal" name="add-animal" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>