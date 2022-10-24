<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $animalid = $_GET['animalid'];
    $animalname = $_GET['animalname'];
    if(empty($animalid) || empty($animalname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        require('functions/config/config.php');
        require('functions/config/db.php');

        //input
        $animalid=mysqli_real_escape_string($conn,$animalid);
        $animalname=mysqli_real_escape_string($conn,$animalname);

        //prepare sql statement before execution
        $query="SELECT * FROM medicalhistory WHERE animalID=? ORDER BY date DESC;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $animalid);
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
        <div class="wrapper d-flex h-auto">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100 min-w-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2>Health History of <?php echo $animalname; ?></h2>
                            </div>
                            <div class="container-fluid text-center mb-2">
                                <a href="Add-Health-History-Form.php?animalid=<?php echo $animalid; ?>&animalname=<?php echo $animalname; ?>"><button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button></a>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">Date</th>
                                        <th class="largecell text-bg-dark">Case / Complaint</th> 
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
                                            <td class="largecell celltextsmall"><?php echo $data['caseHistory']; ?></td>
                                            <td class="largecell celltextsmall"><?php echo $data['tentativeDiagnosis']; ?></td>
                                            <td class="largecell celltextsmall"><?php echo $data['prescription']; ?></td>
                                            <td class="largecell celltextsmall"><?php echo $data['treatment']; ?></td>
                                            <td class="largecell celltextsmall"><?php echo $data['remarks']; ?></td>
                                            <td class="medcell"><?php echo $data['veterinarian']; ?></td>
                                            <td class="largecell d-flex justify-content-center align-items-center" >
                                                <a href="Update-Health-History-Form.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="functions/delete-mh.php?mhid=<?php echo $data['mhID']; ?>&animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $animalname; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
                                            </td>
                                            <?php 
                                            endforeach;
                                            mysqli_stmt_close($stmt);
                                            mysqli_close($conn);
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>