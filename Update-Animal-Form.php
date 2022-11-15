<?php require('functions/config/config.php');?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<?php include('functions/alert.php'); ?>

<?php 
    $animalID = $_GET['animalID'];
    $clientID = $_GET['clientID'];
    $clientname = $_GET['clientname'];
    if(empty($animalID) || empty($clientID) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $clientname=mysqli_real_escape_string($conn,$clientname);
        $animalID=mysqli_real_escape_string($conn,$animalID);
        $clientID=mysqli_real_escape_string($conn,$clientID);

        //prepare sql statement before execution
        $query="
            SELECT 
                animals.name as 'name', 
                animals.classificationID as 'classificationID',
                classifications.species  as 'species', 
                classifications.breed  as 'breed',
                animals.color as 'color',
                animals.sex as 'sex',
                animals.birthdate as 'birthdate',
                animals.noHeads as 'noHeads',
                animals.regDate as 'regDate',
                animals.regNumber as 'regNumber',
                animals.animalID as 'animalID',
                animals.clientID as 'clientID'
            FROM 
                clients, 
                animals, 
                classifications 
            WHERE 
                animals.animalID = ?
                AND 
                animals.classificationID = classifications.classificationID
                AND
                animals.clientID  = ?
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ii", $animalID, $clientID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result)==1){
                foreach ($result as $data):
                    $animalID = $data['animalID'];
                    $name = $data['name'];
                    $classificationID = $data['classificationID'];
                    $species = $data['species'];
                    $breed = $data['breed'];
                    $color = $data['color'];
                    $sex = $data['sex'];
                    $birthdate = $data['birthdate'];
                    $noHeads = $data['noHeads'];
                    $regDate = $data['regDate'];
                    $regNumber = $data['regNumber'];
                    $clientID = $data['clientID'];
                endforeach;
            }
            else{
                $alertmessage = urlencode("Animal does not exist! ".$type);
                header('Location: View-Animals-Owned.php?alertmessage='.$alertmessage.'&clientID='.$clientID);
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
    <title>Update Animal Record</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                <form method="POST" action="functions/update-animal.php" class="container-fluid p-4 w-50 h-auto">
                        <div class="container text-center">
                            <h2>Update Animal</h2>
                        </div>
                        <input type="hidden" id="animalID" name="animalID" value="<?php echo $animalID; ?>">
                        <input type="hidden" id="clientID" name="clientID" value="<?php echo $clientID; ?>">
                        <input type="hidden" id="classificationID" name="classificationID" value="<?php echo $classificationID; ?>">
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
                            <select class="form-select m-0 inputbox" id="sex" name="sex">
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
                            <label class="form-label m-0" for="birthdate">Brthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="noHeads">No. of Heads</label>
                            <input class="form-control m-0 inputbox" type="text" id="noHeads" name="noHeads" value="<?php echo $noHeads; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="regDate">Registration Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="regDate" name="regDate" value="<?php echo $regDate; ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="regNumber">Registration Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="regNumber" name="regNumber" value="<?php echo $regNumber; ?>">
                        </div>
                        <div class="form-group pt-3 container-fluid text-center">
                            <button class="btn btn-primary w-50" type="submit" id="update-animal" name="update-animal"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>