<?php include('functions/alert.php'); ?>
<?php include('functions/checksession-personel.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
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
                                <form method="POST" action="" class="container-fluid justify-content-center align-items-center text-center m-0 p-0">
                                    <div class="container-fluid p-0 m-0">
                                        <table class="table table-condensed table-hover text-center p-0 m-0">
                                            <tbody>
                                                <tr >
                                                    <td class="text-end" style="width: 11%;">Report type:</td>
                                                    <td>
                                                        <select class="form-control m-0 inputbox text-center" id="type" name="type">
                                                            <option value="Animal Health">Animal Health</option>                                                        <option value="Vaccination">Vaccination</option>
                                                            <option value="Routine Services">Routine Services</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-end" style="width: 5%;">From:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="from" name="from"></td>
                                                    <td class="text-end" style="width: 5%;">To:</td>
                                                    <td><input class="form-control m-0 inputbox text-center" type="date" id="to" name="to"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="container-fluid d-flex justify-content-center align-items-center text-center pt-2 m-0">
                                        <input class="btn btn-primary w-25 mb-2" type="submit" id="go" name="go" value="GO">
                                    </div>
                                </form>
                            </div>
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
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="medcell">1</td>
                                        </tr>
                                        <tr>
                                            <td class="medcell">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="largecell celltextsmall">1</td>
                                            <td class="medcell">1</td>
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