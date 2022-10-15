<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Health History</title>
</head>
<body>
    <div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex h-100">
            <?php require('inc\sidenav.php'); ?>
            <div class="content container bg-light rounded-4 m-lg-2 min-vh-100 min-w-100">
                <div class="containter-fluid d-flex justify-content-center align-items-center">
                    <div class="container pt-4">
                        <div class="container text-start px-1">
                            <div class="container-fluid text-center">
                                <h2>Health History of Buck</h2>
                            </div>
                            <div class="container-fluid text-center mb-2">
                                <button class="btn btn-success"><i class="fa-solid fa-plus"></i> Add</button>
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
                                        <th class="autocell bg-dark"></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="medcell">09/36/2022</td>
                                            <td class="largecell celltextsmall">...........</td>
                                            <td class="largecell celltextsmall">...........</td>
                                            <td class="largecell celltextsmall">...........</td>
                                            <td class="largecell celltextsmall">...........</td>
                                            <td class="largecell celltextsmall">...........</td>
                                            <td class="medcell">Dr. John Doe</td>
                                            <td class="autocell d-flex justify-content-center align-items-center" >
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-pen-to-square"></i> Update</button> 
                                                <button class="btn btn-primary mx-1"><i class="fa-solid fa-notes-medical"></i> View Health History</button> 
                                                <button class="btn btn-danger mx-1"><i class="fa-solid fa-trash"></i></button>
                                            </td>
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