<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>

<?php
    $type = "";
    if(isset($_POST['go'])){
        $type = $_POST['type'];
        $from = $_POST['from'];
        $to = $_POST['to'];
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
                                                            <option value="Routine Services">Routine Services</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-end" style="width: 5%;">From:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="from" name="from"></td>
                                                    <td class="text-end" style="width: 5%;">To:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="to" name="to"></td>
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
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                        </tr>
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
                                            <th class="text-bg-dark" colspan="4">Vaccine Information</th>
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
                                            <th class="medcell text-bg-dark">Vaccine Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php }elseif($type=="Routine Services"){ ?>
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
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
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

<script>

    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
            XLSX.writeFile(wb, fn || ('Animal Health Report.' + (type || 'xlsx')));
    }

</script>