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
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid justify-content-center align-items-center">
                    <form method="POST" action="functions/add-mh-V.php" class="container-fluid my-3 p-4 w-50 rounded bg-transparent shadow-lg h-auto">
                        <div class="container text-center">
                            <h3>Vaccination</h3>
                        </div>
                        <input type="hidden" name="animalid" value="<?php echo $animalid; ?>">
                        <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="date">Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="disease">Disease</label>
                            <input class="form-control m-0 inputbox" type="text" name="disease" id="disease" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="vaccineUsed">Vaccine Used</label>
                            <input class="form-control m-0 inputbox" type="text" name="vaccineUsed" id="vaccineUsed" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="batchNumber">Batch/Lot No.</label>
                            <input class="form-control m-0 inputbox" type="text" name="batchNumber" id="batchNumber" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="vaccineSource">Vaccine Source</label>
                            <input class="form-control m-0 inputbox" type="text" name="vaccineSource" id="vaccineSource" placeholder="...">
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
                            <input class="btn btn-success w-50" type="submit" id="add-mh-V" name="add-mh-V" value="Accept">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>