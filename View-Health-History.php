<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $animalID = $_GET['animalid'];
    $animalname = $_GET['animalname'];
    $type = urldecode($_GET['type']);

    switch ($type) {
        case "Animal Health":
            $modalSelect = "AH";
            break;
        case "Vaccination":
            $modalSelect = "V";
            break;
        case "Routine Service":
            $modalSelect = "RS";
            break;
        default:
            $alertmessage = urlencode("Invalid link! Logging out...");
            header('Location: functions/logout.php?alertmessage='.$alertmessage);
            exit();
    }

    if(empty($animalID) || empty($animalname) || empty($type)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $animalID=mysqli_real_escape_string($conn,$animalID);
        $animalname=mysqli_real_escape_string($conn,$animalname);
        $type=mysqli_real_escape_string($conn,$type);
        //prepare sql statement before execution
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
                CONCAT(veterinarian.fName, ' ', veterinarian.mName, ' ', veterinarian.lName) as 'veterinarian',
                medicalhistory.animalID as 'animalID'
            FROM 
                medicalhistory, 
                veterinarian
            WHERE 
                medicalhistory.type=?
                AND
                medicalhistory.animalID=?
                AND
                medicalhistory.vetID=veterinarian.vetID
            ";
        }elseif($type=="Vaccination"){
            $query="
            SELECT
                medicalhistory.medicalhistoryID as 'mhID',
                medicalhistory.date as 'date',
                medicalhistory.type as 'type',
                medicalhistory.disease as 'disease',
                vaccine.name as 'name',
                vaccine.batchNumber as 'batchNumber',
                vaccine.source as 'source',
                medicalhistory.remarks as 'remarks',
                CONCAT(veterinarian.fName, ' ', veterinarian.mName, ' ', veterinarian.lName) as 'veterinarian',
                medicalhistory.animalID as 'animalID'
            FROM 
                medicalhistory, 
                vaccine, 
                veterinarian
            WHERE 
                medicalhistory.type=?
                AND
                medicalhistory.animalID=?
                AND
                medicalhistory.vaccineID=vaccine.vaccineID
                AND
                medicalhistory.vetID=veterinarian.vetID
            ";
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
                CONCAT(veterinarian.fName, ' ', veterinarian.mName, ' ', veterinarian.lName) as 'veterinarian',
                medicalhistory.animalID as 'animalID'
            FROM 
                medicalhistory, 
                veterinarian
            WHERE 
                medicalhistory.type=?
                AND
                medicalhistory.animalID=?
                AND
                medicalhistory.vetID=veterinarian.vetID
            ";
        }
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "si", $type, $animalID,);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Health History</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center mb-2">
                                <h2>Health History of <?php echo $animalname; ?></h2>
                                <button class="btn btn-primary dropdown-toggle" style="width: 15%;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $type?>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="View-Health-History.php?animalid=<?php echo $animalID; ?>&animalname=<?php echo $animalname; ?>&type=Animal%20Health">Animal Health</a></li>
                                    <li><a class="dropdown-item" href="View-Health-History.php?animalid=<?php echo $animalID; ?>&animalname=<?php echo $animalname; ?>&type=Vaccination">Vaccination</a></li>
                                    <li><a class="dropdown-item" href="View-Health-History.php?animalid=<?php echo $animalID; ?>&animalname=<?php echo $animalname; ?>&type=Routine%20Service">Routine Sevice</a></li>
                                </ul>
                            </div>
                            <div class="container-fluid text-center mb-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#<?php echo $modalSelect ?>" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <?php if($type=="Animal Health"){ ?>
                                <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                    <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                        <thead>
                                            <th class="medcell text-bg-dark">Date</th>
                                            <th class="largecell text-bg-dark">Clinical Sign</th> 
                                            <th class="largecell text-bg-dark">Tentative Diagnosis</th> 
                                            <th class="largecell text-bg-dark">Prescription</th>
                                            <th class="largecell text-bg-dark">Treatment</th> 
                                            <th class="largecell text-bg-dark">Remarks</th> 
                                            <th class="medcell text-bg-dark">Veterinarian</th>
                                            <th class="largecell bg-dark"></th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $data): ?>
                                            <tr>
                                                <td class="medcell"><?php echo $data['date']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['clinicalSign']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['tentativeDiagnosis']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['prescription']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['treatment']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['remarks']; ?></td>
                                                <td class="medcell"><?php echo $data['veterinarian']; ?></td>
                                                <td class="largecell d-flex justify-content-center align-items-center" >
                                                    <a href="Update-Health-History-Form.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                    <a href="functions/delete-mh.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }elseif($type=="Vaccination"){?>
                                <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                    <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                        <thead>
                                            <th class="medcell text-bg-dark">Date</th>
                                            <th class="largecell text-bg-dark">Disease</th> 
                                            <th class="largecell text-bg-dark">Vaccine Used</th> 
                                            <th class="largecell text-bg-dark">Batch/Lot No.</th>
                                            <th class="largecell text-bg-dark">Vaccine Source</th> 
                                            <th class="largecell text-bg-dark">Remarks</th> 
                                            <th class="medcell text-bg-dark">Veterinarian</th>
                                            <th class="largecell bg-dark"></th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $data): ?>
                                            <tr>
                                                <td class="medcell"><?php echo $data['date']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['disease']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['name']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['batchNumber']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['source']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['remarks']; ?></td>
                                                <td class="medcell"><?php echo $data['veterinarian']; ?></td>
                                                <td class="largecell d-flex justify-content-center align-items-center" >
                                                    <a href="Update-Health-History-Form.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                    <a href="functions/delete-mh.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php }elseif($type=="Routine Service"){?> 
                                <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                    <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                        <thead>
                                            <th class="medcell text-bg-dark">Date</th>
                                            <th class="largecell text-bg-dark">Clinical Sign</th> 
                                            <th class="largecell text-bg-dark">Activity</th> 
                                            <th class="largecell text-bg-dark">Medication</th>
                                            <th class="largecell text-bg-dark">Remarks</th> 
                                            <th class="medcell text-bg-dark">Veterinarian</th>
                                            <th class="largecell bg-dark"></th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $data): ?>
                                            <tr>
                                                <td class="medcell"><?php echo $data['date']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['clinicalSign']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['activity']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['medication']; ?></td>
                                                <td class="largecell celltextsmall"><?php echo $data['remarks']; ?></td>
                                                <td class="medcell"><?php echo $data['veterinarian']; ?></td>
                                                <td class="largecell d-flex justify-content-center align-items-center" >
                                                    <a href="Update-Health-History-Form.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                    <a href="functions/delete-mh.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
        </div>
    </div>

    <div class="modal fade" id="AH" tabindex="-1" aria-labelledby="animal_healthLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-3 " id="animal_healthLabel"><i class="fa-solid fa-notes-medical fa-lg"></i> Animal Health</h1>
                </div>
                <form method="POST" action="functions/add-mh.php">
                    <div class="modal-body">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="hidden" name="animalID" value="<?php echo $animalID; ?>">
                        <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="date">Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="clinicalSign">Clinical Sign</label>
                            <textarea name="clinicalSign" id="clinicalSign" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
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
                            <label class="form-label m-0" for="vetID">Veterinarian</label>
                            <select class="form-select m-0 inputbox" id="vetID" name="vetID">   
                                <?php 
                                $query="SELECT vetID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM veterinarian ORDER BY name ASC";
                                $result = mysqli_query($conn,$query);
                                foreach($result as $data) :
                                ?>                             
                                    <option value="<?php echo $data['vetID']; ?>"><?php echo $data['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" id="add-mh" name="add-mh"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="V" tabindex="-1" aria-labelledby="VaccinationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-3 " id="VaccinationLabel"><i class="fa-solid fa-notes-medical fa-lg"></i> Vaccination</h1>
                </div>
                <form method="POST" action="functions/add-mh.php">
                    <div class="modal-body">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="hidden" name="animalID" value="<?php echo $animalID; ?>">
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
                            <label class="form-label m-0" for="vetID">Veterinarian</label>
                            <select class="form-select m-0 inputbox" id="vetID" name="vetID">   
                                <?php 
                                $query="SELECT vetID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM veterinarian ORDER BY name ASC";
                                $result = mysqli_query($conn,$query);
                                foreach($result as $data) :
                                ?>                             
                                    <option value="<?php echo $data['vetID']; ?>"><?php echo $data['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" id="add-mh" name="add-mh"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="RS" tabindex="-1" aria-labelledby="RoutineServiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-3 " id="RoutineServiceLabel"><i class="fa-solid fa-notes-medical fa-lg"></i> Routine Service</h1>
                </div>
                <form method="POST" action="functions/add-mh.php">
                    <div class="modal-body">
                        <input type="hidden" name="type" value="<?php echo $type; ?>">
                        <input type="hidden" name="animalID" value="<?php echo $animalID; ?>">
                        <input type="hidden" name="animalname" value="<?php echo $animalname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="date">Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="clinicalSign">Clinical Sign</label>
                            <textarea name="clinicalSign" id="clinicalSign" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="activty">Activity</label>
                            <input class="form-control m-0 inputbox" type="text" id="activity" name="activity" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="medication">Medication</label>
                            <input class="form-control m-0 inputbox" type="text" id="medication" name="medication" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="10" rows="2" class="form-control m-0 inputbox" placeholder="..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="vetID">Veterinarian</label>
                            <select class="form-select m-0 inputbox" id="vetID" name="vetID">   
                                <?php 
                                $query="SELECT vetID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM veterinarian ORDER BY name ASC";
                                $result = mysqli_query($conn,$query);
                                foreach($result as $data) :
                                ?>                             
                                    <option value="<?php echo $data['vetID']; ?>"><?php echo $data['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" id="add-mh" name="add-mh"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>