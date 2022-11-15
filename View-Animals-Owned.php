<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<?php include('functions/alert.php'); ?>

<?php 
    $clientID = $_GET['clientID'];
    $clientname = $_GET['clientname'];
    if(empty($clientID) || empty($clientname)){
        $alertmessage = urlencode("Invalid link! Logging out...");
        header('Location: functions/logout.php?alertmessage='.$alertmessage);
        exit();
    }
    else{
        //input
        $clientID=mysqli_real_escape_string($conn,$clientID);
        //prepare sql statement before execution
        $query="
            SELECT 
                animals.name as 'name', 
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
                animals.clientID  = ?
                AND 
                animals.classificationID = classifications.classificationID
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $clientID);
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
                                <h2><i class="fa-solid fa-paw fa-lg"></i>  Animals owned by <?php echo $clientname; ?></h2>
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
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddAnimal" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
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
                                            <td class="medcell"><?php echo $data['noHeads']; ?></td>
                                            <td class="medcell"><?php echo $dateofregistration = $data['regDate']; ?></td>
                                            <td class="medcell"><?php echo $data['regNumber']; ?></td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <a href="Update-Animal-Form.php?animalID=<?php echo $data['animalID']; ?>&clientID=<?php echo $data['clientID']; ?>&clientname=<?php echo $clientname; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="View-Health-History.php?animalID=<?php echo $data['animalID']; ?>&animalname=<?php echo $data['name']; ?>&type=Animal%20Health"><button class="btn btn-primary mx-1"><i class="fa-solid fa-notes-medical"></i> View Health History</button> 
                                                <a href="functions/delete-animal.php?animalID=<?php echo $data['animalID']; ?>&clientID=<?php echo $data['clientID']; ?>&clientname=<?php echo $clientname; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button>
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

    <div class="modal fade" id="AddAnimal" tabindex="-1" aria-labelledby="AddAnimalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-3 " id="AddAnimalLabel"><i class="fa-solid fa-paw fa-lg"></i> Animal</h1>
                </div>
                <form method="POST" action="functions/add-animal.php">
                    <div class="modal-body">
                        <input type="hidden" id="clientID" name="clientID" value="<?php echo $clientID; ?>">
                        <input type="hidden" id="clientname" name="clientname" value="<?php echo $clientname; ?>">
                        <div class="form-group">
                            <label class="form-label m-0" for="name">Name</label>
                            <input class="form-control m-0 inputbox" type="text" id="name" name="name" placeholder="Enter full name..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="species">Species</label>
                            <input class="form-control m-0 inputbox" type="text" id="species" name="species" placeholder="Enter species..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="breed">Breed</label>
                            <input class="form-control m-0 inputbox" type="text" id="breed" name="breed" placeholder="Enter breed..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="color">Color</label>
                            <input class="form-control m-0 inputbox" type="text" id="color" name="color" placeholder="Enter color..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="sex">Sex</label>
                            <select class="form-select m-0 inputbox" id="sex" name="sex">                                
                                <option value="Male" selected>Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="birthdate">Brthdate</label>
                            <input class="form-control m-0 inputbox" type="date" id="birthdate" name="birthdate" placeholder="Enter date of birth..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="noHeads">No.of Heads</label>
                            <input class="form-control m-0 inputbox" type="number" id="noHeads" name="noHeads" placeholder="Enter number of heads...">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="regDate">Registration Date</label>
                            <input class="form-control m-0 inputbox" type="date" id="regDate" name="regDate">
                        </div>
                        <div class="form-group">
                            <label class="form-label m-0" for="regNumber">Registration Number</label>
                            <input class="form-control m-0 inputbox" type="text" id="regNumber" name="regNumber" placeholder="Enter registration number...">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25"  type="submit" id="add-animal" name="add-animal"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>