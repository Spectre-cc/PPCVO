<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $animalid = $_GET['animalid'];
    $animalname = $_GET['animalname'];
    if(empty($animalid) || empty($animalname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        require('functions/config/config.php');
        require('functions/config/db.php');

        //check if animal exist
        //input
        $animalid=mysqli_real_escape_string($conn,$animalid);
        $animalname=mysqli_real_escape_string($conn,$animalname);
        //prepare sql statement before execution
        $query="SELECT * FROM animal WHERE animalID=? AND name=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "is", $animalid, $animalname);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)!==1){
                $alertmessage = urlencode("Animal does not exist! ".$type);
                header('Location: View-Client-List.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
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
    <title>Add Health History</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <form method="POST" action="functions/add-mh.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Add Health History</h2>
                        </div>
                        <input type="hidden" name="animalid" value="<?php echo $animalid; ?>">
                        <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="birthdate">Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="date" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="case">Case History / Complaint</label>
                            <textarea name="case" id="case" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="tentativeDiagnosis">Tentative Diagnosis</label>
                            <textarea name="tentativeDiagnosis" id="tentativeDiagnosis" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="prescription">Prescription</label>
                            <textarea name="prescription" id="prescription" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="treatment">Treatment</label>
                            <textarea name="treatment" id="treatment" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="veterinarian">Veterinarian</label>
                            <input class="form-control m-0 inputbox" type="text" id="veterinarian" name="veterinarian" placeholder="Enter veterinarian name..." required>
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <input class="btn btn-success w-50" type="submit" id="add-mh" name="add-mh" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>