<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $animalid = $_GET['animalid'];
    $clientid = $_GET['clientid'];
    $clientname = $_GET['clientname'];
    if(empty($animalid) || empty($clientid) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        require('functions/config/config.php');
        require('functions/config/db.php');

        //input
        $clientname=mysqli_real_escape_string($conn,$clientname);
        $animalid=mysqli_real_escape_string($conn,$animalid);
        $clientid=mysqli_real_escape_string($conn,$clientid);

        //prepare sql statement before execution
        $query="SELECT * FROM animal WHERE animalID=? AND clientID=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientid='.$clientid);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ii", $animalid, $clientid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $animalid = $data['animalID'];
                    $name = $data['name'];
                    $species = $data['species'];
                    $breed = $data['breed'];
                    $color = $data['color'];
                    $sex = $data['sex'];
                    $birthdate = $data['birthdate'];
                    $vaccinationdate = $data['vaccinationDate'];
                    $registrationdate = $data['registrationDate'];
                    $registrationnumber = $data['registrationNumber'];
                    $clientid = $data['clientID'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("Animal does not exist! ".$type);
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
    <title>Update Animal Record</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-auto">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                <form method="POST" action="functions/update-animal.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Animal</h2>
                        </div>
                        <input type="hidden" id="animalid" name="animalid" value="<?php echo $animalid; ?>">
                        <input type="hidden" id="clientid" name="clientid" value="<?php echo $clientid; ?>">
                        <input type="hidden" id="clientname" name="clientname" value="<?php echo $clientname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" name="name" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="species">Species</label>
                            <input class="form-control m-0 inputbox" type="text" id="species" name="species" value="<?php echo $species; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="breed">Breed</label>
                            <input class="form-control m-0 inputbox" type="text" id="breed" name="breed" value="<?php echo $breed; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="color">Color</label>
                            <input class="form-control m-0 inputbox" type="text" id="color" name="color" value="<?php echo $color; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <input class="form-control m-0 inputbox" type="text" id="sex" name="sex" value="<?php echo $sex; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="birthdate">Brthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="vaccinationdate">Vaccination Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="vaccinationdate" name="vaccinationdate" value="<?php echo $vaccinationdate; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="registrationdate">Registration Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="registrationdate" name="registrationdate" value="<?php echo $registrationdate; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="registrationnumber">Registration Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="registrationnumber" name="registrationnumber" value="<?php echo $registrationnumber; ?>">
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" id="add-animal" name="update-animal" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>