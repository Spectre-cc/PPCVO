<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $mhID = $_GET['mhid'];
    $animalid = $_GET['animalid'];
    $animalname = $_GET['animalname'];
    $type = $_GET['type'];
    if(empty($animalid) || empty($animalname) || empty($mhID) || empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //check if animal exist
        //input
        $mhID=mysqli_real_escape_string($conn,$mhID);
        $animalid=mysqli_real_escape_string($conn,$animalid);
        $animalname=mysqli_real_escape_string($conn,$animalname);
        $type=mysqli_real_escape_string($conn,$type);

        if($type=="Animal Health"){
            $query="
            SELECT
                medicalhistory.medicalhistoryID as 'mhID',
                medicalhistory.date as 'date',
                medicalhistory.type as 'type',
                medicalhistory.clinicalSign as 'clinicalSign',
                medicalhistory.tentativeDiagnosis as 'tentativeDiagnosis',
                medicalhistory.prescription as 'prescription',
                medicalhistory.treatment as 'treatment',
                medicalhistory.remarks as 'remarks',
                medicalhistory.vetID as 'vetID',
                CONCAT(veterinarian.fName, ' ', veterinarian.mName, ' ', veterinarian.lName) as 'veterinarian',
                medicalhistory.animalID as 'animalID'
            FROM 
                medicalhistory, 
                veterinarian
            WHERE
                medicalhistory.medicalhistoryID=?
                AND
                medicalhistory.type=?
                AND
                medicalhistory.animalID=?
                AND
                medicalhistory.vetID=veterinarian.vetID
            ";

            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "isi", $mhID, $type, $animalid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1){
                    foreach ($result as $data):
                        $mhID=$data['mhID'];
                        $date=$data['date'];
                        $clinicalSign=$data['clinicalSign'];
                        $tentativeDiagnosis=$data['tentativeDiagnosis'];
                        $prescription=$data['prescription'];
                        $treatment=$data['treatment'];
                        $remarks=$data['remarks'];
                        $vetID=$data['vetID'];
                        $veterinarian=$data['veterinarian'];
                        $animalid=$data['animalID'];
                    endforeach;
                }
                else{
                    $alertmessage = urlencode("Animal does not exist! ".$type);
                    header('Location: View-Client-List.php?alertmessage='.$alertmessage);
                }
            }
        }elseif($type=="Vaccination"){
            $query="
            SELECT
                medicalhistory.medicalhistoryID as 'mhID',
                medicalhistory.date as 'date',
                medicalhistory.type as 'type',
                medicalhistory.disease as 'disease',
                vaccine.vaccineID as 'vaccineID',
                vaccine.name as 'name',
                vaccine.batchNumber as 'batchNumber',
                vaccine.source as 'source',
                medicalhistory.remarks as 'remarks',
                medicalhistory.vetID as 'vetID',
                CONCAT(veterinarian.fName, ' ', veterinarian.mName, ' ', veterinarian.lName) as 'veterinarian',
                medicalhistory.animalID as 'animalID'
            FROM 
                medicalhistory, 
                vaccine, 
                veterinarian
            WHERE 
                medicalhistory.medicalhistoryID=?
                AND
                medicalhistory.type=?
                AND
                medicalhistory.animalID=?
                AND
                medicalhistory.vaccineID=vaccine.vaccineID
                AND
                medicalhistory.vetID=veterinarian.vetID
            ";

            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "isi", $mhID, $type, $animalid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1){
                    foreach ($result as $data):
                        $mhID=$data['mhID'];
                        $date=$data['date'];
                        $disease=$data['disease'];
                        $vaccineID=$data['vaccineID'];
                        $vaccineUsed=$data['name'];
                        $batchNumber=$data['batchNumber'];
                        $vaccineSource=$data['source'];
                        $remarks=$data['remarks'];
                        $vetID=$data['vetID'];
                        $veterinarian=$data['veterinarian'];
                        $animalid=$data['animalID'];
                    endforeach;
                }
                else{
                    $alertmessage = urlencode("Animal does not exist! ".$type);
                    header('Location: View-Client-List.php?alertmessage='.$alertmessage);
                }
            }
        }elseif($type=="Routine Service"){
            $query="
            SELECT
                medicalhistory.medicalhistoryID as 'mhID',
                medicalhistory.date as 'date',
                medicalhistory.type as 'type',
                medicalhistory.clinicalSign as 'clinicalSign',
                medicalhistory.activity as 'activity',
                medicalhistory.medication as 'medication',
                medicalhistory.remarks as 'remarks',
                medicalhistory.vetID as 'vetID',
                CONCAT(veterinarian.fName, ' ', veterinarian.mName, ' ', veterinarian.lName) as 'veterinarian',
                medicalhistory.animalID as 'animalID'
            FROM 
                medicalhistory, 
                veterinarian
            WHERE 
                medicalhistory.medicalhistoryID=?
                AND
                medicalhistory.type=?
                AND
                medicalhistory.animalID=?
                AND
                medicalhistory.vetID=veterinarian.vetID
            ";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: View-Health-History.php?alertmessage='.$alertmessage.'&animalid='.$animalid.'&animalname='.$animalname);
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "isi", $mhID, $type, $animalid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1){
                    foreach ($result as $data):
                        $mhID=$data['mhID'];
                        $date=$data['date'];
                        $clinicalSign=$data['clinicalSign'];
                        $activity=$data['activity'];
                        $medication=$data['medication'];
                        $remarks=$data['remarks'];
                        $vetID=$data['vetID'];
                        $veterinarian=$data['veterinarian'];
                        $animalid=$data['animalID'];
                    endforeach;
                }
                else{
                    $alertmessage = urlencode("Animal does not exist! ".$type);
                    header('Location: View-Client-List.php?alertmessage='.$alertmessage);
                }
            }
        }
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Update Health History</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <?php if($type=="Animal Health"){ ?>
                        <form method="POST" action="functions/update-mh.php" class="container-fluid my-3 p-4 w-50 rounded bg-transparent shadow-lg h-auto">
                            <div class="container text-center">
                                <h3>Update Animal Health Record</h3>
                            </div>
                            <input type="hidden" name="mhid" value="<?php echo $mhID; ?>">
                            <input type="hidden" name="animalid" value="<?php echo $animalid; ?>">
                            <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <div class="form-group">
                                <label class="form-label m-0" for="birthdate">Date</label>
                                <input class="form-control m-0 inputbox" type="date" id="birthdate" name="date" value="<?php echo $date; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="clinicalSign">Clinical Sign</label>
                                <textarea name="clinicalSign" id="clinicalSign" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $clinicalSign; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="tentativeDiagnosis">Tentative Diagnosis</label>
                                <textarea name="tentativeDiagnosis" id="tentativeDiagnosis" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $tentativeDiagnosis; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="prescription">Prescription</label>
                                <textarea name="prescription" id="prescription" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $prescription; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="treatment">Treatment</label>
                                <textarea name="treatment" id="treatment" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $treatment; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="remarks">Remarks</label>
                                <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $remarks; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="vetID">Veterinarian</label>
                                <select class="form-select m-0 inputbox" id="vetID" name="vetID">   
                                    <?php 
                                    $query="SELECT vetID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM veterinarian ORDER BY name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                        if($data['vetID']==$vetID){
                                    ?>     
                                            <option value="<?php echo $data['vetID']; ?>" selected><?php echo $data['name']; ?></option>
                                    <?php 
                                        }else{
                                    ?>                             
                                            <option value="<?php echo $data['vetID']; ?>"><?php echo $data['name']; ?></option>
                                    <?php
                                        }
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group pt-3 container-fluid text-center">
                                <button class="btn btn-primary w-50" type="submit" id="update-mh" name="update-mh"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                            </div>
                        </form>
                    <?php }elseif($type=="Vaccination"){ ?>
                        <form method="POST" action="functions/update-mh.php" class="container-fluid my-3 p-4 w-50 rounded bg-transparent shadow-lg h-auto">
                            <div class="container text-center">
                                <h3>Update Vaccination Record</h3>
                            </div>
                            <input type="hidden" name="mhid" value="<?php echo $mhID; ?>">
                            <input type="hidden" name="animalid" value="<?php echo $animalid; ?>">
                            <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
                            <div class="form-group">
                                <label class="form-label m-0" for="date">Date</label>
                                <input class="form-control m-0 inputbox" type="date" id="date" name="date" value="<?php echo $date; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="disease">Disease</label>
                                <input class="form-control m-0 inputbox" type="text" name="disease" id="disease" value="<?php echo $disease; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="vaccineUsed">Vaccine Used</label>
                                <input class="form-control m-0 inputbox" type="text" name="vaccineUsed" id="vaccineUsed" value="<?php echo $vaccineUsed; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="batchNumber">Batch/Lot No.</label>
                                <input class="form-control m-0 inputbox" type="text" name="batchNumber" id="batchNumber" value="<?php echo $batchNumber; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="vaccineSource">Vaccine Source</label>
                                <input class="form-control m-0 inputbox" type="text" name="vaccineSource" id="vaccineSource" value="<?php echo $vaccineSource; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="remarks">Remarks</label>
                                <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $remarks; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="vetID">Veterinarian</label>
                                <select class="form-select m-0 inputbox" id="vetID" name="vetID">   
                                    <?php 
                                    $query="SELECT vetID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM veterinarian ORDER BY name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                        if($data['vetID']==$vetID){
                                    ?>     
                                            <option value="<?php echo $data['vetID']; ?>" selected><?php echo $data['name']; ?></option>
                                    <?php 
                                        }else{
                                    ?>                             
                                            <option value="<?php echo $data['vetID']; ?>"><?php echo $data['name']; ?></option>
                                    <?php
                                        }
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group pt-3 container-fluid text-center">
                                <button class="btn btn-primary w-50" type="submit" id="update-mh" name="update-mh"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                            </div>
                        </form>
                    <?php }elseif($type=="Routine Service"){ ?>
                        <form method="POST" action="functions/update-mh.php" class="container-fluid my-3 p-4 w-50 rounded bg-transparent shadow-lg h-auto">
                            <div class="container text-center">
                                <h3>Update Routine Service Record</h3>
                            </div>
                            <input type="hidden" name="mhid" value="<?php echo $mhID; ?>">
                            <input type="hidden" name="animalid" value="<?php echo $animalid; ?>">
                            <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <div class="form-group">
                                <label class="form-label m-0" for="birthdate">Date</label>
                                <input class="form-control m-0 inputbox" type="date" id="birthdate" name="date" value="<?php echo $date; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="clinicalSign">Clinical Sign</label>
                                <textarea name="clinicalSign" id="clinicalSign" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $clinicalSign; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="activty">Activity</label>
                                <input class="form-control m-0 inputbox" type="text" id="activity" name="activity" value="<?php echo $activity; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="medication">Medication</label>
                                <input class="form-control m-0 inputbox" type="text" id="medication" name="medication" value="<?php echo $medication; ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="remarks">Remarks</label>
                                <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $remarks; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label m-0" for="vetID">Veterinarian</label>
                                <select class="form-select m-0 inputbox" id="vetID" name="vetID">   
                                    <?php 
                                    $query="SELECT vetID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM veterinarian ORDER BY name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                        if($data['vetID']==$vetID){
                                    ?>     
                                            <option value="<?php echo $data['vetID']; ?>" selected><?php echo $data['name']; ?></option>
                                    <?php 
                                        }else{
                                    ?>                             
                                            <option value="<?php echo $data['vetID']; ?>"><?php echo $data['name']; ?></option>
                                    <?php
                                        }
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group pt-3 container-fluid text-center">
                                <button class="btn btn-primary w-50" type="submit" id="update-mh" name="update-mh"><i class="fa-solid fa-pen-to-square"></i> Update</button>
                            </div>
                        </form>
                    <?php 
                    }else{
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        $alertmessage = urlencode("Invalid link! Logging out...");
                        header('Location: functions/logout.php?alertmessage='.$alertmessage);
                        exit();
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>