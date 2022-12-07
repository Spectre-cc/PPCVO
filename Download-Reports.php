<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php
    $type = "";
    if(isset($_POST['go'])){
        $type = mysqli_real_escape_string($conn,$_POST['type']);
        $personnelID = mysqli_real_escape_string($conn,$_POST['personnelID']);
        $from = mysqli_real_escape_string($conn,$_POST['from']);
        $to = mysqli_real_escape_string($conn,$_POST['to']);

        $query="SELECT CONCAT(fName, ' ', mName, ' ', lName) as name FROM personnel WHERE personnelID = ? LIMIT 1";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $personnelID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            foreach ($result as $data):
                $veterinarian=$data['name'];
            endforeach;
            mysqli_free_result($result);
        }

        if($type == "Animal Health"){
            //prepare sql statement before execution
            $query="
            /*Select columns*/
            SELECT 
                /*Client Information*/
                barangays.brgy_name AS 'barangay', 
                CONCAT(clients.fName, ' ', clients.mName, ' ', clients.lName) as 'clientName', 
                clients.sex AS 'gender', 
                clients.birthdate 'clientBirthdate', 
                clients.cNumber AS 'contactNumber', 
            
                /*Animal Information*/
                classifications.species AS 'species', 
                animals.sex AS 'sex', 
                animals.birthdate AS 'animalBirthdate',
            
                /*MH Information*/
                walk_in_transactions.clinicalSign AS 'clinicalSign', 
                walk_in_transactions.remarks AS 'remarks' 
            
            /*Specify tables to retrieve columns*/
            FROM 
                clients, 
                clients_addresses, 
                barangays, 
                animals, 
                classifications, 
                walk_in_transactions
            
            /*Specify conditions on column selection*/
            WHERE 
                walk_in_transactions.ctID = 1
                AND
                clients.addressID = clients_addresses.addressID
                AND
                clients_addresses.barangayID = barangays.barangayID
                AND
                clients.clientID = animals.clientID 
                AND
                animals.classificationID = classifications.classificationID
                AND
                animals.animalID = walk_in_transactions.animalID
                AND
                walk_in_transactions.personnelID = ?
                AND
                (walk_in_transactions.date BETWEEN ? AND ?) 
                            
            /*Order records in ASC order based on client's barangay*/
            ORDER BY 
                barangays.brgy_name ASC;
            ";
        }
        elseif($type == "Vaccination"){
            //prepare sql statement before execution
            $query="
            /*Select columns*/
            SELECT

                /*Record date*/
                walk_in_transactions    .date AS 'date',

                /*Client Information*/
                barangays.brgy_name AS 'barangay', 
                CONCAT(clients.fName, ' ', clients.mName, ' ', clients.lName) as 'clientName', 
                clients.sex AS 'gender', 
                clients.birthdate 'clientBirthdate', 
                clients.cNumber AS 'contactNumber',  

                /*Animal Information*/
                classifications.species AS 'species', 
                animals.sex AS 'sex', 
                animals.birthdate AS 'animalBirthdate', 
                animals.regNumber AS 'registrationNumber', 
                animals.noHeads AS 'numberHeads', 
                animals.color AS 'color', 
                animals.name AS 'animalName',

                /*MH Information*/
                walk_in_transactions.disease AS 'disease', 
                vaccines.name AS 'vaccineUsed', 
                vaccines.batchNumber AS 'batchNumber', 
                vaccines.source AS 'vaccineSource', 
                walk_in_transactions.remarks AS 'remarks'

            /*Specify tables to retrieve columns*/
            FROM 
                clients, 
                clients_addresses, 
                barangays, 
                animals, 
                classifications, 
                walk_in_transactions,
                vaccines

            /*Specify conditions on column selection*/
            WHERE 
                walk_in_transactions.ctID = 2
                AND
                clients.addressID = clients_addresses.addressID
                AND
                clients_addresses.barangayID = barangays.barangayID
                AND
                clients.clientID = animals.clientID 
                AND
                animals.classificationID = classifications.classificationID
                AND
                animals.animalID = walk_in_transactions.animalID
                AND
                walk_in_transactions.vaccineID = vaccines.vaccineID
                AND
                walk_in_transactions.personnelID = ?
                AND
                (walk_in_transactions.date BETWEEN ? AND ?)  
                            
            /*Order records in ASC order based on medical history date*/
            ORDER BY 
                walk_in_transactions.date ASC;
            ";
        }
        elseif($type == "Routine Service"){
            //prepare sql statement before execution
            $query="
            /*Select columns*/
            SELECT
                /*Record date*/
                field_visititations.date AS 'date',
            
                /*Client Information*/
                barangays.brgy_name AS 'barangay', 
                CONCAT(clients.fName, ' ', clients.mName, ' ', clients.lName) as 'clientName', 
                clients.sex AS 'gender', 
                clients.birthdate 'clientBirthdate', 
                clients.cNumber AS 'contactNumber',  
            
                /*Animal Information*/
                classifications.species AS 'species', 
                animals.sex AS 'sex', 
                animals.birthdate AS 'animalBirthdate', 
                animals.name AS 'animalName', 
                animals.noHeads AS 'numberHeads', 
                animals.regNumber AS 'registrationNumber', 
            
                /*MH Information*/
                field_visititations.activity AS 'activity', 
                field_visititations.medication AS 'medication', 
                field_visititations.remarks AS 'remarks'
            
            /*Specify tables to retrieve columns*/
            FROM 
                clients, 
                clients_addresses, 
                barangays, 
                animals, 
                classifications, 
                field_visititations
            
            /*Specify conditions on column selection*/
            WHERE 
                field_visititations.ctID = 3 
                AND
                clients.addressID = clients_addresses.addressID
                AND
                clients_addresses.barangayID = barangays.barangayID
                AND
                clients.clientID = animals.clientID 
                AND
                animals.classificationID = classifications.classificationID
                AND
                animals.animalID = field_visititations.animalID
                AND
                field_visititations.personnelID = ?
                AND
                (field_visititations.date BETWEEN ? AND ?) 
                            
            /*Order records in ASC order based on medical history date*/
            ORDER BY 
                field_visititations.date ASC;
            ";
        }
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "iss", $personnelID, $from, $to);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <script type="text/javascript" src="functions/html2excel/tableToExcel.js"></script>
    <title>Download Records</title>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
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
                                                        <select class="form-select m-0 inputbox text-center" id="type" name="type">
                                                            <option value="" disabled selected>Select your report type...</option>   
                                                            <option value="Animal Health">Animal Health</option>
                                                            <option value="Vaccination">Vaccination</option>                                                        
                                                            <option value="Routine Service">Routine Service</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-end" style="width: 11%;">Veterinarian:</td>
                                                    <td>
                                                        <select class="form-select m-0 inputbox text-center" id="personnelID" name="personnelID" required>
                                                            <option value="" disabled selected>Select your option</option>   
                                                            <?php 
                                                            $query="SELECT personnelID, CONCAT(fName, ' ', mName, ' ', lName) as name FROM personnel ORDER BY name ASC";
                                                            $result1 = mysqli_query($conn,$query);
                                                            foreach($result1 as $data) :
                                                            ?>                             
                                                                <option value="<?php echo $data['personnelID']; ?>"><?php echo $data['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <td class="text-end" style="width: 5%;">From:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="from" name="from" required></td>
                                                    <td class="text-end" style="width: 5%;">To:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="to" name="to" required></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <button class="btn btn-primary w-25" type="submit" id="go" name="go"><i class="fa-solid fa-eye"></i> Preview</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center pt-2 mb-2">
                                        <button class="btn btn-primary" onclick="ExportToExcel()"><i class="fa-solid fa-file-export"></i> Export to Excel</button>
                                    </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                
                                <?php if($type=="Animal Health"){ ?>
                                <table data-cols-width="13,13,13,13,13,13,13,13,13,13,13" class="table table-condensed table-bordered table-hover table-responsive text-start" id="tableExport">
                                    <thead>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="11" data-a-h="center" data-f-bold="true">Animal Health Monitoring Report</th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textStart" colspan="5" data-a-h="left" data-f-bold="true">Province: Palawan</th>
                                            <th class="text-bg-dark textEnd" colspan="6" data-a-h="right" data-f-bold="true">City: Puerto Princesa</th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textStart" colspan="5" data-a-h="left" data-f-bold="true">Period: <?php echo $from; ?> to <?php echo $to; ?></th>
                                            <th class="text-bg-dark textEnd" colspan="6" data-a-h="right" data-f-bold="true">Veterinarian: <?php echo $veterinarian; ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="11" data-a-h="center"></th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="5" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Client Information</th>
                                            <th class="text-bg-dark textCenter" colspan="4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Animal Information</th>
                                            <th class="largecell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Clinical Sign</th>
                                            <th class="largecell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Barangay</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Name</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Gender</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Birthdate</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Contact No.</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Species</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Sex</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Age</th>   
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Population</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['barangay']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clientName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['gender']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clientBirthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['contactNumber']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['species']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['sex']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['animalBirthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true">0</td>
                                            <td class="largecell celltextsmall" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clinicalSign']; ?></td>
                                            <td class="largecell celltextsmall" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['remarks']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php }elseif($type=="Vaccination"){ ?>
                                <table data-cols-width="13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13,13" class="table table-condensed table-bordered table-hover table-responsive text-start" id="tableExport">
                                    <thead>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="18" data-a-h="center" data-f-bold="true">Vaccination Report</th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textStart" colspan="9" data-a-h="left" data-f-bold="true">Province: Palawan</th>
                                            <th class="text-bg-dark textEnd" colspan="9" data-a-h="right" data-f-bold="true">City: Puerto Princesa</th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textStart" colspan="9" data-a-h="left" data-f-bold="true">Period: <?php echo $from; ?> to <?php echo $to; ?></th>
                                            <th class="text-bg-dark textEnd" colspan="9" data-a-h="right" data-f-bold="true">Veterinarian: <?php echo $veterinarian; ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="18" data-a-h="center"></th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Date</th>
                                            <th class="text-bg-dark textCenter" colspan="5" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-h="center">Client Information</th>
                                            <th class="text-bg-dark textCenter" colspan="7" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-h="center">Animal Information</th>
                                            <th class="text-bg-dark" colspan="4" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Vaccine Information</th>
                                            <th class="largecell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Barangay</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Name</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Gender</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Birthdate</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Contact No.</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Species</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Sex</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Age</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Animal Registered</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">No. of Heads</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Color</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Name</th>   
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Disease</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Vaccine Used</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Batch/Lot No.</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Vaccine Source</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['date']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['barangay']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clientName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['gender']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clientBirthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['contactNumber']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['species']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['sex']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['animalBirthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['registrationNumber']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['numberHeads']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['color']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['animalName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['disease']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['vaccineUsed']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['batchNumber']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['vaccineSource']; ?></td>
                                            <td class="largecell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['remarks']; ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php }elseif($type=="Routine Service"){ ?>
                                <table data-cols-width="13,13,13,13,13,13,13,13,13,13,13,13,13,13,13" class="table table-condensed table-bordered table-hover table-responsive text-start" id="tableExport">
                                    <thead>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="15" data-a-h="center" data-f-bold="true">Routine Service Report</th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textStart" colspan="7" data-a-h="left" data-f-bold="true">Province: Palawan</th>
                                            <th class="text-bg-dark textEnd" colspan="8" data-a-h="right" data-f-bold="true">City: Puerto Princesa</th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textStart" colspan="7" data-a-h="left" data-f-bold="true">Period: <?php echo $from; ?> to <?php echo $to; ?></th>
                                            <th class="text-bg-dark textEnd" colspan="8" data-a-h="right" data-f-bold="true">Veterinarian: <?php echo $veterinarian; ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-bg-dark textCenter" colspan="15" data-a-h="center"></th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Date</th>
                                            <th class="medcell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Barangay</th>
                                            <th class="text-bg-dark textCenter" colspan="4" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-h="center">Client Information</th>
                                            <th class="text-bg-dark textCenter" colspan="6" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-h="center">Animal Information</th>
                                            <th class="largecell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Activity</th>
                                            <th class="largecell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Medication</th>
                                            <th class="largecell text-bg-dark" rowspan="2" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Remarks</th>
                                        </tr>
                                        <tr>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Name</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Gender</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Birthdate</th> 
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Contact No.</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Species</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Sex</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Age</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Name</th>
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">No. of Heads</th>  
                                            <th class="medcell text-bg-dark" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true">Animal Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['date']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['barangay']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clientName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['gender']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['clientBirthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['contactNumber']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['species']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['sex']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['animalBirthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['animalName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['numberHeads']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['registrationNumber']; ?></td>
                                            <td class="largecell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['activity']; ?></td>
                                            <td class="largecell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['medication']; ?></td>
                                            <td class="largecell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true"><?php echo $data['remarks']; ?></td>
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
    function ExportToExcel(){
        TableToExcel.convert(document.getElementById("tableExport"), {
            name: "<?php echo $type?>-report.xlsx",
            sheet: {
                name: "<?php echo $type?>"
            }
        });
    }
</script>