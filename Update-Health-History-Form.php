<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/alert.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>

<?php 
    $consultationID = $_GET['consultationID'];
    $animalID = $_GET['animalID'];
    $animalname = $_GET['animalname'];
    $type = $_GET['type'];
    if(empty($animalID) || empty($animalname) || empty($consultationID) || empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //check if animal exist
        //input
        $consultationID=mysqli_real_escape_string($conn,$consultationID);
        $animalID=mysqli_real_escape_string($conn,$animalID);
        $animalname=mysqli_real_escape_string($conn,$animalname);
        $type=mysqli_real_escape_string($conn,$type);

        if($type=="Animal Health"){
            $query="
            SELECT 
                walk_in_transactions.consultationID,
                consultation_types.Type_Description,
                walk_in_transactions.date,
                walk_in_transactions.clinicalSign,
                walk_in_transactions.tentativeDiagnosis,
                walk_in_transactions.prescription,
                walk_in_transactions.treatment,
                walk_in_transactions.remarks,
                personnel.personnelID,
                CONCAT(personnel.fName, ' ', personnel.mName, ' ', personnel.lName) as 'veterinarian',
                walk_in_transactions.animalID
            FROM 
                walk_in_transactions,
                consultation_types,
                personnel
            WHERE 
                walk_in_transactions.consultationID=?
                AND
                consultation_types.Type_Description=?
                AND
                walk_in_transactions.animalID=?
                AND
                walk_in_transactions.personnelID=personnel.personnelID
            LIMIT 1;
            ";

            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type.'&transaction='.$transaction);
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "isi", $consultationID, $type, $animalID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1){
                    foreach ($result as $data):
                        $consultationID=$data['consultationID'];
                        $date=$data['date'];
                        $clinicalSign=$data['clinicalSign'];
                        $tentativeDiagnosis=$data['tentativeDiagnosis'];
                        $prescription=$data['prescription'];
                        $treatment=$data['treatment'];
                        $remarks=$data['remarks'];
                        $personnelID=$data['personnelID'];
                        $veterinarian=$data['veterinarian'];
                        $animalID=$data['animalID'];
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
                    walk_in_transactions.consultationID,
                    walk_in_transactions.date,
                    walk_in_transactions.disease,
                    vaccines.vaccineID,
                    vaccines.name,
                    vaccines.batchNumber,
                    vaccines.source,
                    walk_in_transactions.remarks,
                    walk_in_transactions.personnelID,
                    CONCAT(personnel.fName, ' ', personnel.mName, ' ', personnel.lName) as 'veterinarian',
                    walk_in_transactions.animalID
                FROM 
                    walk_in_transactions,
                    consultation_types,
                    personnel,
                    vaccines
                WHERE 
                    walk_in_transactions.consultationID=?
                    AND
                    consultation_types.Type_Description=?
                    AND
                    walk_in_transactions.animalID=?
                    AND
                    walk_in_transactions.vaccineID=vaccines.vaccineID
                    AND
                    walk_in_transactions.personnelID=personnel.personnelID
                LIMIT 1;
                ";

                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $query)){
                    $alertmessage = urlencode("SQL error!");
                    header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type.'&transaction='.$transaction);
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "isi", $consultationID, $type, $animalID);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($result)==1){
                        foreach ($result as $data):
                            $consultationID=$data['consultationID'];
                            $date=$data['date'];
                            $disease=$data['disease'];
                            $vaccineID=$data['vaccineID'];
                            $vaccineUsed=$data['name'];
                            $batchNumber=$data['batchNumber'];
                            $vaccineSource=$data['source'];
                            $remarks=$data['remarks'];
                            $personnelID=$data['personnelID'];
                            $veterinarian=$data['veterinarian'];
                            $animalID=$data['animalID'];
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
                field_visititations.consultationID,
                field_visititations.date,
                consultation_types.Type_Description,
                field_visititations.clinicalSign,
                field_visititations.activity,
                field_visititations.medication,
                field_visititations.remarks,
                personnel.personnelID,
                CONCAT(personnel.fName, ' ', personnel.mName, ' ', personnel.lName) as 'veterinarian',
                field_visititations.animalID,
                barangays.brgy_name
            FROM 
                field_visititations,
                consultation_types,
                personnel,
                barangays
            WHERE 
                field_visititations.consultationID=?
                AND
                consultation_types.Type_Description=?
                AND
                field_visititations.animalID=?
                AND
                field_visititations.personnelID=personnel.personnelID
                AND
                field_visititations.barangayID=barangays.barangayID
            LIMIT 1;
            ";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: ../View-Health-History.php?alertmessage='.$alertmessage.'&animalID='.$animalID.'&animalname='.$animalname.'&type='.$type.'&transaction='.$transaction);
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "isi", $consultationID, $type, $animalID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1){
                    foreach ($result as $data):
                        $consultationID=$data['consultationID'];
                        $date=$data['date'];
                        $clinicalSign=$data['clinicalSign'];
                        $activity=$data['activity'];
                        $medication=$data['medication'];
                        $remarks=$data['remarks'];
                        $personnelID=$data['personnelID'];
                        $veterinarian=$data['veterinarian'];
                        $animalID=$data['animalID'];
                        $barangay=$data['brgy_name'];
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
    <?php require('./inc/links.php'); ?>
    <title>Update Health History</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <?php if($type=="Animal Health"){ ?>
                        <form method="POST" action="functions/update-mh.php" class="container-fluid my-3 p-4 w-50 rounded bg-transparent shadow-lg h-auto">
                            <div class="container text-center">
                                <h3>Update Animal Health Record</h3>
                            </div>
                            <input type="hidden" name="consultationID" value="<?php echo $consultationID; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="hidden" name="animalID" value="<?php echo $animalID; ?>">
                            <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
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
                                <label class="form-label m-0" for="personnelID">Veterinarian</label>
                                <select class="form-select m-0 inputbox" id="personnelID" name="personnelID">   
                                    <?php 
                                    $query="SELECT personnelID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM personnel WHERE status = 'active' ORDER BY name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                        if($data['vetID']==$vetID){
                                    ?>     
                                            <option value="<?php echo $data['personnelID']; ?>" selected><?php echo $data['name']; ?></option>
                                    <?php 
                                        }else{
                                    ?>                             
                                            <option value="<?php echo $data['personnelID']; ?>"><?php echo $data['name']; ?></option>
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
                                <input type="hidden" name="vaccineID" value="<?php echo $vaccineID; ?>">
                                <input type="hidden" name="consultationID" value="<?php echo $consultationID; ?>">
                                <input type="hidden" name="type" value="<?php echo $type; ?>">
                                <input type="hidden" name="animalID" value="<?php echo $animalID; ?>">
                                <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                                <div class="form-group">
                                    <label class="form-label m-0" for="date">Date</label>
                                    <input class="form-control m-0 inputbox" type="date" id="date" name="date" value="<?php echo $date; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0" for="disease">Disease</label>
                                    <input class="form-control m-0 inputbox" type="text" name="disease" id="disease" value="<?php echo $disease; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0" for="vaccineUsed">Vaccine Used</label>
                                    <input class="form-control m-0 inputbox" type="text" name="vaccineUsed" id="vaccineUsed" value="<?php echo $vaccineUsed; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0" for="batchNumber">Batch/Lot No.</label>
                                    <input class="form-control m-0 inputbox" type="text" name="batchNumber" id="batchNumber" value="<?php echo $batchNumber; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0" for="vaccineSource">Vaccine Source</label>
                                    <input class="form-control m-0 inputbox" type="text" name="vaccineSource" id="vaccineSource" value="<?php echo $vaccineSource; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0" for="remarks">Remarks</label>
                                    <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox"><?php echo $remarks; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label m-0" for="personnelID">Veterinarian</label>
                                    <select class="form-select m-0 inputbox" id="personnelID" name="personnelID">   
                                        <?php 
                                        $query="SELECT personnelID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM personnel WHERE status = 'active' ORDER BY name ASC";
                                        $result = mysqli_query($conn,$query);
                                        foreach($result as $data) :
                                            if($data['personnelID']==$vetID){
                                        ?>     
                                                <option value="<?php echo $data['personnelID']; ?>" selected><?php echo $data['name']; ?></option>
                                        <?php 
                                            }else{
                                        ?>                             
                                                <option value="<?php echo $data['personnelID']; ?>"><?php echo $data['name']; ?></option>
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
                            <input type="hidden" name="consultationID" value="<?php echo $consultationID; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="hidden" name="animalID" value="<?php echo $animalID; ?>">
                            <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
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
                                    <?php endforeach; ?>
                                    </datalist>
                            </div>
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
                                <label class="form-label m-0" for="personnelID">Veterinarian</label>
                                <select class="form-select m-0 inputbox" id="personnelID" name="personnelID">   
                                    <?php 
                                    $query="SELECT personnelID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM personnel WHERE status = 'active' ORDER BY name ASC";
                                    $result = mysqli_query($conn,$query);
                                    foreach($result as $data) :
                                        if($data['personnelID']==$personnelID){
                                    ?>     
                                            <option value="<?php echo $data['personnelID']; ?>" selected><?php echo $data['name']; ?></option>
                                    <?php 
                                        }else{
                                    ?>                             
                                            <option value="<?php echo $data['personnelID']; ?>"><?php echo $data['name']; ?></option>
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