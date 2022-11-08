<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php 
    $clientid = $_GET['clientid'];
    $clientname = $_GET['clientname'];
    if(empty($clientid) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $clientid=mysqli_real_escape_string($conn,$clientid);

        //prepare sql statement before execution
        $query="SELECT * FROM animal WHERE clientID=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $clientid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
        
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Animals Owned</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4 px-0">
                        <div class="container text-start px-0">
                            <div class="container-fluid text-center">
                                <h2>Animals owned by <?php echo $clientname; ?></h2>
                            </div>
                            <div class="container-fluid mb-2">
                                <form action="">
                                    <div class="form-group d-flex justify-content-center">
                                        <input class="form-control inputbox w-25 mx-1" type="search" name="search" id="search" placeholder="Search client name...">
                                        <input class="btn btn-primary" type="submit" id="submit" value="Search">
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid text-center mb-2">
                                <a href="Add-Animal-Form.php?clientid=<?php echo $clientid; ?>&clientname=<?php echo $clientname; ?>"><button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button></a>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start text-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="medcell text-bg-dark">Name</th>
                                        <th class="medcell text-bg-dark">Species</th>
                                        <th class="medcell text-bg-dark">Breed</th>
                                        <th class="medcell text-bg-dark">Color</th>
                                        <th class="smallcell text-bg-dark">Sex</th>
                                        <th class="medcell text-bg-dark">Birthdate</th>
                                        <th class="medcell text-bg-dark">No. of Heads</th>
                                        <th class="medcell text-bg-dark">Registration Date</th>
                                        <th class="medcell text-bg-dark">Registration Number</th>
                                        <th class="autocell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell"><?php echo $data['name']; ?></td>
                                            <td class="medcell"><?php echo $data['species']; ?></td>
                                            <td class="medcell"><?php echo $data['breed']; ?></td>
                                            <td class="medcell"><?php echo $data['color']; ?></td>
                                            <td class="smallcell"><?php echo $data['sex']; ?></td>
                                            <td class="medcell"><?php echo $data['birthdate']; ?></td>
                                            <td class="medcell"><?php echo $data['numberHeads']; ?></td>
                                            <td class="medcell"><?php echo $dateofregistration = $data['registrationDate']; ?></td>
                                            <td class="medcell"><?php echo $data['registrationNumber']; ?></td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <a href="Update-Animal-Form.php?animalid=<?php echo $data['animalID']; ?>&clientid=<?php echo $data['clientID']; ?>&clientname=<?php echo $clientname; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="View-Health-History-AH.php?animalid=<?php echo $data['animalID']; ?>&animalname=<?php echo $data['name']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-notes-medical"></i> View Health History</button> 
                                                <a href="functions/delete-animal.php?animalid=<?php echo $data['animalID']; ?>&clientid=<?php echo $data['clientID']; ?>&clientname=<?php echo $clientname; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php 
                                        endforeach;
                                        mysqli_stmt_close($stmt);
                                        mysqli_close($conn);
                                        ?>
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