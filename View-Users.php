<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-admin.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php 
    if(isset($_GET['type'])){
        $type = mysqli_real_escape_string($conn,$_GET['type']);
        $query="
        SELECT 
            user.userID,
            user.type, 
            CONCAT(user.fName,' ',user.mName,' ',user.lName) as 'name',
            user.email, 
            user.cNumber 
        FROM 
            user 
        WHERE 
            user.type= ?
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "s", $type);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }    
    }
    else{
        if(isset($_POST['search-user'])){
            $type = mysqli_real_escape_string($conn,$_POST['type']);
            $search = '%'.mysqli_real_escape_string($conn,$_POST['string']).'%';
    
            $query = "
                SELECT 
                    userA.userID,
                    userA.type, 
                    userA.name, 
                    userA.email, 
                    userA.cNumber  
                FROM 
                    (
                    SELECT 
                        user.userID,
                        user.type, 
                        CONCAT(user.fName,' ',mName,' ',user.lName) as 'name', 
                        user.email, 
                        user.cNumber  
                    FROM 
                        user
                    ) as userA
                WHERE 
                    userA.name LIKE ?
                    AND
                    userA.type= ?
                ";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $query)){
                $alertmessage = urlencode("SQL error!");
                header('Location: ../View-Client-List.php?alertmessage='.$alertmessage);
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "ss", $search, $type);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            }    
        }else{
            $alertmessage = urlencode("Invalid link, Please Log In!");
            header('Location: Index.php?alertmessage='.$alertmessage);
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <title><?php echo ucfirst($type); ?> Users</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2><i class="fa-solid fa-user fa-lg"></i> <?php echo ucfirst($type); ?></h2>
                            </div>
                            <div class="container-fluid d-flex justify-content-center text-center my-2">
                                <form class="w-50 d-flex justify-content-center" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="w-100 d-flex justify-content-center bg-white border border-secondary rounded-pill">
                                        <input class="form-control search bg-transparent" style="border:0;" type="search" name="string" id="string" placeholder="Search for user...">
                                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                                        <button class="btn btn-secondary text-light searchbtn border" type="submit" name="search-user" id="search-user"><i class="fa-sharp fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="container-fluid mb-2 text-center">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#AddUser" data-bs-whatever="@mdo"><i class="fa-solid fa-plus"></i> Add</button>
                            </div>
                            <div class="container-fluid d-flex justify-content-start align-items-start overflow-scroll">
                                <table class="table table-condensed table-bordered table-hover table-responsive text-start">
                                    <thead>
                                        <th class="largecell text-bg-dark">Name</th>
                                        <th class="medcell text-bg-dark">Email</th>
                                        <th class="largecell text-bg-dark">Contact Number</th>
                                        <th class="medcell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($result as $data) : ?>
                                        <tr>
                                            <td class="largecell"><?php echo $data['name']; ?></td>
                                            <td class="largecell"><?php echo $data['email']; ?></td>
                                            <td class="largecell"><?php echo $data['cNumber']; ?></td>
                                            <td class="med d-flex justify-content-center align-items-center" >
                                                <a href="Update-User-Form.php?userID=<?php echo $data['userID']; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button></a>
                                                <a href="functions/delete-user.php?userID=<?php echo $data['userID']; ?>&type=<?php echo $data['type']; ?>"><button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <?php 
                                        endforeach; 
                                        mysqli_free_result($result);
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

    <div class="modal fade" id="AddUser" tabindex="-1" aria-labelledby="AddUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center align-items-center bg-success text-light">
                    <h1 class="modal-title fs-3 " id="AddUserLabel"><i class="fa-solid fa-user fa-lg"></i> <?php echo ucfirst($type); ?></h1>
                </div>
                <form method="POST" action="functions/add-user.php">
                    <div class="modal-body">
                        <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="fName">First Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="fName" id="fName" placeholder="Enter first name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="mname">Middle Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="mName" id="mName" placeholder="Enter middle name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="lName">Last Name</label>
                            <input class="form-control m-0 inputbox" type="text" name="lName" id="lName" placeholder="Enter last name..." maxlength="45" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="email">Email</label>
                            <input class="form-control m-0 inputbox" type="email" name="email" id="email" placeholder="Enter email..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="password">Password</label>
                            <input class="form-control m-0 inputbox" type="password" name="password" id="password" placeholder="Enter password..." required>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label m-0" for="cNumber">Contact Number (Optional)</label>
                            <input class="form-control m-0 inputbox" type="text" name="cNumber" id="cNumber" placeholder="Enter contact number..." maxlength="50">
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-success w-25" type="submit" name="add-user" id="add-user"><i class="fa-solid fa-plus"></i> Add</button>
                        <button type="reset" class="btn btn-danger w-25" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>