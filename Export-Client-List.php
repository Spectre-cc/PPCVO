<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-personel.php'); ?>
<?php include('./functions/alert.php'); ?>

<?php
    if(isset($_POST['go'])){
        $date = mysqli_real_escape_string($conn,$_POST['date']);
        $query="
        SELECT 
            * 
        FROM 
            clients
                INNER JOIN
                    clients_addresses
                        ON clients.addressID = clients_addresses.addressID
                            INNER JOIN barangays
                                ON clients_addresses.barangayID = barangays.barangayID
        WHERE
            MONTHNAME(clients.insertDate)=MONTHNAME(?)
            AND
            YEAR(clients.insertDate)=YEAR(?)
        ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $query)){
            $alertmessage = urlencode("SQL error!");
            header('Location: View-Client-List.php?alertmessage='.$alertmessage);
            exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $date, $date);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }
    }else{
        $date = date("Y-m-d");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <script type="text/javascript" src="functions/html2excel/tableToExcel.js"></script>
    <title>Export List of Clients</title>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container">
                        <div class="container text-center pt-3">
                            <h2>Export List of Clients</h2>
                            <div class="container-fluid d-flex justify-content-center align-items-center text-center">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="container-fluid justify-content-center align-items-center text-center m-0 p-0">
                                    <div class="container-fluid p-0 m-0">
                                        <table class="table table-condensed table-hover text-center p-0 m-0">
                                            <tbody>
                                                <tr >
                                                    <td class="text-end" style="width: 10%;">As Of:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="date" name="date" value="<?php echo $date; ?>" required></td>
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
                            <div class="container-fluid align-items-start overflow-scroll">
                                <script>
                                    function ExportToExcel(){
                                        TableToExcel.convert(document.getElementById("tableExport"), {
                                            name: "Client-List-<?php echo date('F', strtotime($date)).'-'.date('Y', strtotime($date));?>.xlsx",
                                            sheet: {
                                                name: "Client-List"
                                            }
                                        });
                                    }
                                </script>
                                
                                <?php if(isset($_POST['go'])){ ?>
                                <div class="container-fluid d-flex justify-content-center align-items-center text-center pt-2 mb-2">
                                            <button class="btn btn-primary" onclick="ExportToExcel()"><i class="fa-solid fa-file-export"></i> Export to Excel</button>
                                </div>
                                <table data-cols-width="13,13,13,13,13,30,13,13,15" class="table table-condensed table-bordered table-hover table-responsive text-start" id="tableExport">
                                    <tr>
                                        <th class="text-bg-dark textCenter" colspan="9" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Client List</th>
                                    </tr>
                                    <tr>
                                        <th class="text-bg-dark textCenter" colspan="9" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">As of: <?php echo date('F', strtotime($date)).', '.date('Y', strtotime($date));?></th>
                                    </tr>
                                    <tr>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">First Name</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Middle Name</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Last Name</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Birthdate</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Sex</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Address</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Barangay</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Contact No.</th>
                                        <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Email</th>
                                    </tr>
                                    <?php foreach ($result as $data): ?>
                                        <tr>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['fName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['mName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['lName']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['birthdate']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['sex']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['Specific_add']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['brgy_name']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['cNumber']; ?></td>
                                            <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top"><?php echo $data['email']; ?></td>
                                        </tr>
                                    <?php 
                                        endforeach; 
                                        mysqli_free_result($result);
                                        mysqli_close($conn);
                                    ?>
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

