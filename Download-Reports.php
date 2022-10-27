<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php
    $type = "";
    if(isset($_POST['go'])){
        require('functions/config/config.php');
        require('functions/config/db.php');
        $type = mysqli_real_escape_string($conn,$_POST['type']);
        $from = mysqli_real_escape_string($conn,$_POST['from']);
        $to = mysqli_real_escape_string($conn,$_POST['to']);

        if($type == "Animal Health"){
            //prepare sql statement before execution
            $query="
            /*Select columns*/
            SELECT 
            /*Client Information*/
            client.barangay AS 'barangay', client.name AS 'clientName', client.sex AS 'gender', client.birthdate 'clientBirthdate', client.contactNumber AS 'contactNumber', 

            /*Animal Information*/
            animal.species AS 'species', animal.sex AS 'sex', animal.birthdate AS 'animalBirthdate',

            /*MH Information*/
            medicalhistory.clinicalSign AS 'clinicalSign', medicalhistory.remarks AS 'remarks' 

            /*Specify tables to retrieve columns*/
            FROM client, animal, medicalhistory

            /*Specify conditions on column selection*/
            WHERE 
                medicalhistory.type = 'animal health' 
                AND
                client.clientID = animal.clientID 
                AND
                animal.animalID = medicalhistory.animalID
                AND
                (medicalhistory.date BETWEEN ? AND ?) 
                
            /*Order records in ASC order based on client's barangay*/
            ORDER BY client.barangay ASC;
            ";
        }
        elseif($type == "Vaccination"){

            //prepare sql statement before execution
            $query="
            /*Select columns*/
            SELECT

            /*Record date*/
            medicalhistory.date AS 'date',

            /*Client Information*/
            client.barangay AS 'barangay', client.name AS 'clientName', client.sex AS 'gender', client.birthdate AS 'clientBirthdate', client.contactNumber AS 'contactNumber', 

            /*Animal Information*/
            animal.species AS 'species', animal.sex AS 'sex', animal.birthdate AS 'animalBirthdate', animal.registrationNumber AS 'registrationNumber', animal.numberHeads AS 'numberHeads', animal.color AS 'color', animal.name AS 'animalName',

            /*MH Information*/
            medicalhistory.disease AS 'disease', medicalhistory.vaccineUsed AS 'vaccineUsed', medicalhistory.batchNumber AS 'batchNumber', medicalhistory.remarks AS 'remarks'

            /*Specify tables to retrieve columns*/
            FROM client, animal, medicalhistory

            /*Specify conditions on column selection*/
            WHERE 
                medicalhistory.type = 'vaccination' 
                AND
                client.clientID = animal.clientID 
                AND
                animal.animalID = medicalhistory.animalID
                AND
                (medicalhistory.date BETWEEN ? AND ?) 
                
            /*Order records in ASC order based on medical history date*/
            ORDER BY medicalhistory.date ASC;
            ";
        }
        elseif($type == "Routine Service"){
            //prepare sql statement before execution
            $query="
            /*Select columns*/
            SELECT

            /*Record date*/
            medicalhistory.date AS 'date',

            /*Client Information*/
            client.barangay AS 'barangay', client.name AS 'clientName', client.sex AS 'gender', client.birthdate AS 'clientBirthdate', client.contactNumber AS 'contactNumber', 

            /*Animal Information*/
            animal.species AS 'species', animal.sex AS 'sex', animal.birthdate AS 'animalBirthdate', animal.name AS 'animalName', animal.numberHeads AS 'numberHeads', animal.registrationNumber AS 'registrationNumber', 

            /*MH Information*/
            medicalhistory.activity AS 'activity', medicalhistory.medication AS 'medication', medicalhistory.remarks AS 'remarks'

            /*Specify tables to retrieve columns*/
            FROM client, animal, medicalhistory

            /*Specify conditions on column selection*/
            WHERE 
                medicalhistory.type = 'routine service' 
                AND
                client.clientID = animal.clientID 
                AND
                animal.animalID = medicalhistory.animalID
                AND
                (medicalhistory.date BETWEEN ? AND ?) 
                
            /*Order records in ASC order based on medical history date*/
            ORDER BY medicalhistory.date ASC;
            ";
        }
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <title>Download Records</title>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container">
                        <div class="container text-center pt-3">
                            <h2>Download Report</h2>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="container-fluid justify-content-center align-items-center text-center m-0 p-0">
                                    <div class="container-fluid p-0 m-0">
                                        <table class="table table-condensed table-hover text-center p-0 m-0">
                                            <tbody>
                                                <tr >
                                                    <td class="text-end" style="width: 11%;">Report type:</td>
                                                    <td>
                                                        <select class="form-control m-0 inputbox text-center" id="type" name="type">
                                                            <option value="...">...</option>
                                                            <option value="Animal Health">Animal Health</option>
                                                            <option value="Vaccination">Vaccination</option>                                                        
                                                            <option value="Routine Service">Routine Service</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-end" style="width: 5%;">From:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="from" name="from" required></td>
                                                    <td class="text-end" style="width: 5%;">To:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="to" name="to" required></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <input class="btn btn-primary w-25" type="submit" id="go" name="go" value="GO">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="container-fluid d-flex justify-content-center align-items-center text-center pt-2 mb-2">
                                        <button class="btn btn-primary" onclick="ExportToExcel('xlsx')"><i class="fa-solid fa-file-export"></i> Export to Excel</button>
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                
                                <?php if($type=="Animal Health"){ ?>
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start" id="tbl_exporttable_to_xls">
                                    <thead>
                                        <tr>
                                            <th class="text-bg-dark" colspan="5">Client Information</th>
                                            <th class="text-bg-dark" colspan="4">Animal Information</th>
                                            <th class="largecell text-bg-dark" rowspan="2">Clinical Sign</th>
                                            <th class="largecell text-bg-dark" rowspan="2">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark">Barangay</th>
                                            <th class="medcell text-bg-dark">Name</th> 
                                            <th class="medcell text-bg-dark">Gender</th> 
                                            <th class="medcell text-bg-dark">Birthdate</th>
                                            <th class="medcell text-bg-dark">Contact No.</th> 
                                            <th class="medcell text-bg-dark">Species</th>
                                            <th class="medcell text-bg-dark">Sex</th>
                                            <th class="medcell text-bg-dark">Age</th>   
                                            <th class="medcell text-bg-dark">Population</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['barangay']; ?></td>
                                            <td class="medcell"><?php echo $data['clientName']; ?></td>
                                            <td class="medcell"><?php echo $data['gender']; ?></td>
                                            <td class="medcell"><?php echo $data['clientBirthdate']; ?></td>
                                            <td class="medcell"><?php echo $data['contactNumber']; ?></td>
                                            <td class="medcell"><?php echo $data['species']; ?></td>
                                            <td class="medcell"><?php echo $data['sex']; ?></td>
                                            <td class="medcell"><?php echo $data['animalBirthdate']; ?></td>
                                            <td class="medcell">0</td>
                                            <td class="largecell celltextsmall"><?php echo $data['clinicalSign']; ?></td>
                                            <td class="largecell celltextsmall"><?php echo $data['remarks']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php }elseif($type=="Vaccination"){ ?>
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start" id="tbl_exporttable_to_xls">
                                    <thead>
                                        <tr>
                                            <th class="medcell text-bg-dark" rowspan="2">Date</th>
                                            <th class="medcell text-bg-dark" rowspan="2">Barangay</th>
                                            <th class="text-bg-dark" colspan="4">Client Information</th>
                                            <th class="text-bg-dark" colspan="7">Animal Information</th>
                                            <th class="text-bg-dark" colspan="3">Vaccine Information</th>
                                            <th class="largecell text-bg-dark" rowspan="2">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark">Name</th> 
                                            <th class="medcell text-bg-dark">Gender</th>
                                            <th class="medcell text-bg-dark">Birthdate</th> 
                                            <th class="medcell text-bg-dark">Contact No.</th>
                                            <th class="medcell text-bg-dark">Species</th>
                                            <th class="medcell text-bg-dark">Sex</th>
                                            <th class="medcell text-bg-dark">Age</th>
                                            <th class="medcell text-bg-dark">Animal Registered</th>
                                            <th class="medcell text-bg-dark">No. of Heads</th>
                                            <th class="medcell text-bg-dark">Color</th>
                                            <th class="medcell text-bg-dark">Name</th>   
                                            <th class="medcell text-bg-dark">Disease</th>
                                            <th class="medcell text-bg-dark">Vaccine Used</th>
                                            <th class="medcell text-bg-dark">Batch/Lot No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['date']; ?></td>
                                            <td class="medcell"><?php echo $data['barangay']; ?></td>
                                            <td class="medcell"><?php echo $data['clientName']; ?></td>
                                            <td class="medcell"><?php echo $data['gender']; ?></td>
                                            <td class="medcell"><?php echo $data['clientBirthdate']; ?></td>
                                            <td class="medcell"><?php echo $data['contactNumber']; ?></td>
                                            <td class="medcell"><?php echo $data['species']; ?></td>
                                            <td class="medcell"><?php echo $data['sex']; ?></td>
                                            <td class="medcell"><?php echo $data['animalBirthdate']; ?></td>
                                            <td class="medcell"><?php echo $data['registrationNumber']; ?></td>
                                            <td class="medcell"><?php echo $data['numberHeads']; ?></td>
                                            <td class="medcell"><?php echo $data['color']; ?></td>
                                            <td class="medcell"><?php echo $data['animalName']; ?></td>
                                            <td class="medcell"><?php echo $data['disease']; ?></td>
                                            <td class="medcell"><?php echo $data['vaccineUsed']; ?></td>
                                            <td class="medcell"><?php echo $data['batchNumber']; ?></td>
                                            <td class="largecell"><?php echo $data['remarks']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php }elseif($type=="Routine Service"){ ?>
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start" id="tbl_exporttable_to_xls">
                                <thead>
                                        <tr>
                                            <th class="medcell text-bg-dark" rowspan="2">Date</th>
                                            <th class="medcell text-bg-dark" rowspan="2">Barangay</th>
                                            <th class="text-bg-dark" colspan="4">Client Information</th>
                                            <th class="text-bg-dark" colspan="6">Animal Information</th>
                                            <th class="largecell text-bg-dark" rowspan="2">Activity</th>
                                            <th class="largecell text-bg-dark" rowspan="2">Medication</th>
                                            <th class="largecell text-bg-dark" rowspan="2">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark">Name</th> 
                                            <th class="medcell text-bg-dark">Gender</th>
                                            <th class="medcell text-bg-dark">Birthdate</th> 
                                            <th class="medcell text-bg-dark">Contact No.</th>
                                            <th class="medcell text-bg-dark">Species</th>
                                            <th class="medcell text-bg-dark">Sex</th>
                                            <th class="medcell text-bg-dark">Age</th>
                                            <th class="medcell text-bg-dark">Name</th>
                                            <th class="medcell text-bg-dark">No. of Heads</th>  
                                            <th class="medcell text-bg-dark">Animal Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['date']; ?></td>
                                            <td class="medcell"><?php echo $data['barangay']; ?></td>
                                            <td class="medcell"><?php echo $data['clientName']; ?></td>
                                            <td class="medcell"><?php echo $data['gender']; ?></td>
                                            <td class="medcell"><?php echo $data['clientBirthdate']; ?></td>
                                            <td class="medcell"><?php echo $data['contactNumber']; ?></td>
                                            <td class="medcell"><?php echo $data['species']; ?></td>
                                            <td class="medcell"><?php echo $data['sex']; ?></td>
                                            <td class="medcell"><?php echo $data['animalBirthdate']; ?></td>
                                            <td class="medcell"><?php echo $data['animalName']; ?></td>
                                            <td class="medcell"><?php echo $data['numberHeads']; ?></td>
                                            <td class="medcell"><?php echo $data['registrationNumber']; ?></td>
                                            <td class="largecell"><?php echo $data['activity']; ?></td>
                                            <td class="largecell"><?php echo $data['medication']; ?></td>
                                            <td class="largecell"><?php echo $data['remarks']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
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

<script>

    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'type' }) :
            XLSX.writeFile(wb, fn || ('Report.' + (type || 'xlsx')));
    }

</script>