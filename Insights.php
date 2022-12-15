<?php require('./functions/config/config.php'); ?>
<?php require('./functions/config/db.php'); ?>
<?php include('./functions/checksession-admin.php'); ?>
<?php include('./functions/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('./inc/links.php'); ?>
    <script type="text/javascript" src="functions/html2excel/tableToExcel.js"></script>
    <script>
        function ExportToExcel(t){
            TableToExcel.convert(document.getElementById(t), {
                name: t+".xlsx",
                sheet: {
                    name: t
                }
            });
        }
     </script>
    <title>Insights</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('./inc/sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="container-fluid">
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <div class="container-fluid  border-bottom border-danger d-flex justify-content-between">
                        <?php 
                            if(isset($_POST['RA'])){
                                $date01 = mysqli_real_escape_string($conn,$_POST['date']);
                                $query01 = "
                                Select 
                                    brgy_name, 
                                    count(case when classifications.species LIKE  '%canine%' AND animals.regNumber IS NOT NULL AND MONTHNAME(animals.regDate) = MONTHNAME(?) AND YEAR(animals.regDate) = YEAR(?) then animalid else null end) as 'NumberOfDogs', 
                                    
                                    count(case when classifications.species LIKE  '%feline%' AND animals.regNumber IS NOT NULL AND MONTHNAME(animals.regDate) = MONTHNAME(?) AND YEAR(animals.regDate) = YEAR(?) then animalid else null end) as 'NumberOfCats'
                                From 
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals
                                                            ON clients.clientID = animals.clientID
                                                                INNER JOIN classifications
                                                                    ON animals.classificationID = classifications.classificationID
                                where 
                                    classifications.species LIKE  '%canine%' 
                                    OR 
                                    classifications.species LIKE  '%feline%'
                                    AND animals.regNumber IS NOT NULL
                                    AND animals.regDate > DATE_SUB(NOW(),INTERVAL 1 YEAR)
                                group by 
                                    barangays.brgy_name;
                                ";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $query01)){
                                    $alertmessage = urlencode("SQL error!");
                                    header('Location: Analytics.php?alertmessage='.$alertmessage);
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "ssss", $date01, $date01, $date01, $date01);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                }
                            }else{
                                $query01 = "
                                Select 
                                    brgy_name, 
                                    count(case when classifications.species LIKE  '%canine%' AND animals.regNumber IS NOT NULL AND animals.regDate > DATE_SUB(NOW(),INTERVAL 1 YEAR) then animalid else null end) as 'NumberOfDogs', 
                                    count(case when classifications.species LIKE  '%feline%' AND animals.regNumber IS NOT NULL AND animals.regDate > DATE_SUB(NOW(),INTERVAL 1 YEAR) then animalid else null end) as 'NumberOfCats'
                                From 
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals
                                                            ON clients.clientID = animals.clientID
                                                                INNER JOIN classifications
                                                                    ON animals.classificationID = classifications.classificationID
                                where 
                                    classifications.species LIKE  '%canine%' 
                                    OR 
                                    classifications.species LIKE  '%feline%'
                                    AND animals.regNumber IS NOT NULL
                                    AND animals.regDate > DATE_SUB(NOW(),INTERVAL 1 YEAR)
                                group by 
                                    barangays.brgy_name;
                                ";
                                $result = mysqli_query($conn, $query01);
                            }
                        ?>
                            <div>
                                <div class="d-flex justify-content-start">
                                    <h3 class="m-0">Number of Registered Animals</h3>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle mx-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-file-export"></i>
                                            Export Graph...
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="downloadIMG('RegisteredAnimalsChart')"><i class="fa-solid fa-image"></i> Image</li>
                                            <li><a class="dropdown-item" href="#" onclick="ExportToExcel('RAChartData')"><i class="fa-solid fa-file-excel"></i> Data</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                    if(isset($_POST['RA'])){
                                        echo '<p class="text-secondary m-0">for the month of '.date('F', strtotime($date01)).', '.date('Y', strtotime($date01));
                                    }
                                ?>
                            </div>
                            <div>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-flex justify-content-end m-1">
                                    <input type="date" name="date" value="<?php echo $date01;?>" class="form-control mx-2" required>
                                    <button class="btn btn-primary btn-sm" type="submit" name="RA"><i class="fa-solid fa-rotate-right"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="RegisteredAnimalsChart" ></canvas>
                            <table data-cols-width="13,13,13" class="table table-condensed table-bordered table-hover table-responsive text-start d-none" id="RAChartData">
                                <tr>
                                    <th class="text-bg-dark textCenter" colspan="3" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Number of Registered Animals</th>
                                </tr>
                                <tr>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Barangay</th>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Dogs</th>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Cats</th>
                                </tr>
                                <?php 
                                    if(mysqli_num_rows($result) > 0){
                                        $barangay = array();
                                        $NumberOfCats = array();
                                        $NumberOfDogs = array();
                                    }else{
                                        echo "No records matching your query were found.";
                                    }

                                    foreach ($result as $data): 
                                ?>
                                <tr>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['brgy_name']; ?></td>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['NumberOfCats']; ?></td>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['NumberOfDogs']; ?></td>
                                </tr>
                                <?php 
                                        $barangay[] = $data['brgy_name'];
                                        $NumberOfCats[] = $data['NumberOfCats'];
                                        $NumberOfDogs[] = $data['NumberOfDogs'];
                                    endforeach; 
                                ?>
                            </table>
                        </div>
                        <script>
                            const barangay01 =  <?php echo json_encode($barangay); ?>;
                            var NumberOfCats = <?php echo json_encode($NumberOfCats); ?>;
                            var NumberOfDogs = <?php echo json_encode($NumberOfDogs); ?>;

                            const data01 = {
                                labels: barangay01,
                                datasets: [
                                    {
                                        label: 'Cats',
                                        data: NumberOfCats,
                                        backgroundColor: ["RGBA(80,101,255,0.8)"],
                                        borderColor: ["RGBA(80,101,255,1)"],
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Dogs',
                                        data: NumberOfDogs,
                                        backgroundColor: ["RGBA(255,101,77,0.8)"],
                                        borderColor: ["RGBA(255,101,77,1)"],
                                        borderWidth: 1
                                    }
                                ]
                            };
                            const plugin = {
                                id: 'customCanvasBackgroundColor',
                                beforeDraw: (chart, args, options) => {
                                    const {ctx} = chart;
                                    ctx.save();
                                    ctx.globalCompositeOperation = 'destination-over';
                                    ctx.fillStyle = options.color || '#FFFFFF';
                                    ctx.fillRect(0, 0, chart.width, chart.height);
                                    ctx.restore();
                                }
                            };
                            const config01 = {
                                type: 'bar',
                                data: data01,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        },
                                    },
                                    plugins: {
                                        customCanvasBackgroundColor: {
                                            color: 'white',
                                        }
                                    }
                                },
                                plugins:[plugin]
                            };
                            const regAnimalsPerBarangay = new Chart(
                                document.getElementById('RegisteredAnimalsChart'),
                                config01
                            );
                        </script>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <?php 
                            if(isset($_POST['DCP'])){
                                $date02 = mysqli_real_escape_string($conn,$_POST['date']);
                                $query = "
                                Select 
                                    brgy_name, 
                                    count(case when classifications.species LIKE  '%canine%' AND MONTHNAME(animals.insertDate) = MONTHNAME(?) AND YEAR(animals.insertDate) = YEAR(?) then animalid else null end) as 'NumberOfDogs', 
                                    count(case when classifications.species LIKE  '%feline%' AND MONTHNAME(animals.insertDate) = MONTHNAME(?) AND YEAR(animals.insertDate) = YEAR(?) then animalid else null end) as 'NumberOfCats'
                                From 
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals
                                                            ON clients.clientID = animals.clientID
                                                                INNER JOIN classifications
                                                                    ON animals.classificationID = classifications.classificationID
                                where 
                                    classifications.species LIKE  '%canine%' 
                                    or 
                                    classifications.species LIKE  '%feline%'
                                group by 
                                    barangays.brgy_name;
                                ";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $query)){
                                    $alertmessage = urlencode("SQL error!");
                                    header('Location: Analytics.php?alertmessage='.$alertmessage);
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "ssss", $date02, $date02, $date02, $date02);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                }
                            }else{
                                $query = "
                                Select 
                                    brgy_name, 
                                    count(case when classifications.species LIKE  '%canine%' then animalid else null end) as 'NumberOfDogs', 
                                    count(case when classifications.species LIKE  '%feline%' then animalid else null end) as 'NumberOfCats'
                                From 
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals
                                                            ON clients.clientID = animals.clientID
                                                                INNER JOIN classifications
                                                                    ON animals.classificationID = classifications.classificationID
                                where 
                                    classifications.species LIKE  '%canine%' 
                                    or 
                                    classifications.species LIKE  '%feline%'
                                group by barangays.brgy_name
                                ORDER BY barangays.brgy_name ASC
                                ";
                                $result = mysqli_query($conn, $query);
                            }
                        ?>
                        <div class="container-fluid  border-bottom border-danger d-flex justify-content-between">
                            <div>
                                <div class="d-flex justify-content-start">
                                    <h3 class="m-0">Dog and Cat Population</h3>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle mx-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-file-export"></i>
                                            Export Graph...
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="downloadIMG('DogCatPopulationChart')"><i class="fa-solid fa-image"></i> Image</li>
                                            <li><a class="dropdown-item" href="#" onclick="ExportToExcel('DCPchartdata')"><i class="fa-solid fa-file-excel"></i> Data</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                    if(isset($_POST['DCP'])){
                                        echo '<p class="text-secondary m-0">for the month of '.date('F', strtotime($date02)).', '.date('Y', strtotime($date02));
                                    }
                                ?>
                            </div>
                            <div>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-flex justify-content-end m-1">
                                    <input type="date" name="date" value="<?php echo $date02;?>" class="form-control mx-2" required>
                                    <button class="btn btn-primary btn-sm" type="submit" name="DCP"><i class="fa-solid fa-rotate-right"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="DogCatPopulationChart" ></canvas>
                            <table data-cols-width="13,13,13" class="table table-condensed table-bordered table-hover table-responsive text-start d-none" id="DCPchartdata">
                                <tr>
                                    <th class="text-bg-dark textCenter" colspan="3" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Dog/Cat Population</th>
                                </tr>
                                <tr>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Barangay</th>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Dogs</th>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Cats</th>
                                </tr>
                                <?php 
                                    if(mysqli_num_rows($result) > 0){
                                        $barangay = array();
                                        $NumberOfCats = array();
                                        $NumberOfDogs = array();
                                    }else{
                                        echo "No records matching your query were found.";
                                    }

                                    foreach ($result as $data): 
                                ?>
                                <tr>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['brgy_name']; ?></td>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['NumberOfCats']; ?></td>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['NumberOfDogs']; ?></td>
                                </tr>
                                <?php 
                                        $barangay[] = $data['brgy_name'];
                                        $NumberOfCats[] = $data['NumberOfCats'];
                                        $NumberOfDogs[] = $data['NumberOfDogs'];
                                    endforeach; 
                                ?>
                            </table>
                        </div>
                        <script>
                            const barangay02 =  <?php echo json_encode($barangay); ?>;
                            var NumberOfCats = <?php echo json_encode($NumberOfCats); ?>;
                            var NumberOfDogs = <?php echo json_encode($NumberOfDogs); ?>;

                            const data02 = {
                                labels: barangay02,
                                datasets: [
                                    {
                                        label: 'Cats',
                                        data: NumberOfCats,
                                        backgroundColor: ["RGBA(80,101,255,0.8)"],
                                        borderColor: ["RGBA(80,101,255,1)"],
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Dogs',
                                        data: NumberOfDogs,
                                        backgroundColor: ["RGBA(255,101,77,0.8)"],
                                        borderColor: ["RGBA(255,101,77,1)"],
                                        borderWidth: 1
                                    }
                                ]
                            };

                            const config02 = {
                                type: 'bar',
                                data: data02,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        customCanvasBackgroundColor: {
                                            color: 'white',
                                        }
                                    }
                                },
                                plugins:[plugin]
                            };

                            const DogCatPopulation = new Chart(
                                document.getElementById('DogCatPopulationChart'),
                                config02
                            );
                        </script>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <?php 
                            if(isset($_POST['VA'])){
                                $date03 = mysqli_real_escape_string($conn,$_POST['date']);
                                $query = "
                                /*Number Of Vaccinated Animals*/
                                SELECT
                                    barangays.brgy_name,
                                    COUNT(animals.animalID) as 'NumberOfVaccinatedAnimals'
                                FROM
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals
                                                            ON clients.clientID = animals.clientID
                                                                INNER JOIN walk_in_transactions
                                                                    ON animals.animalID = walk_in_transactions.animalID
                                WHERE
                                    walk_in_transactions.ctID = 2
                                    AND
                                    walk_in_transactions.disease LIKE '%rabies%'
                                    AND 
                                    MONTHNAME(walk_in_transactions.date) = MONTHNAME(?) 
                                    AND 
                                    YEAR(walk_in_transactions.date) = YEAR(?)    
                                GROUP BY
                                    barangays.brgy_name
                                ";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $query)){
                                    $alertmessage = urlencode("SQL error!");
                                    header('Location: Analytics.php?alertmessage='.$alertmessage);
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "ss", $date03, $date03);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                }
                            }else{
                                $query = "
                                SELECT
                                    barangays.brgy_name,
                                    COUNT(animals.animalID) as 'NumberOfVaccinatedAnimals'
                                FROM
                                    clients
                                        INNER JOIN clients_addresses
                                            ON clients.addressID = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                                        INNER JOIN animals
                                                            ON clients.clientID = animals.clientID
                                                                INNER JOIN walk_in_transactions
                                                                    ON animals.animalID = walk_in_transactions.animalID
                                WHERE
                                    walk_in_transactions.ctID = 2   
                                    AND
                                    walk_in_transactions.disease LIKE  '%rabies%'
                                    AND
                                    walk_in_transactions.date > DATE_SUB(NOW(),INTERVAL 1 YEAR)
                                GROUP BY barangays.brgy_name 
                                ORDER BY barangays.brgy_name ASC
                                ";
                                $result = mysqli_query($conn, $query);
                            }
                        ?>
                        <div class="container-fluid  border-bottom border-danger d-flex justify-content-between">
                            <div>
                                <div class="d-flex justify-content-start">
                                    <h3 class="m-0">Number of Vaccinated Animals</h3>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle mx-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-file-export"></i>
                                            Export Graph...
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="downloadIMG('VaccinatedAnimalsChart')"><i class="fa-solid fa-image"></i> Image</li>
                                            <li><a class="dropdown-item" href="#" onclick="ExportToExcel('VAchartdata')"><i class="fa-solid fa-file-excel"></i> Data</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                    if(isset($_POST['VA'])){
                                        echo '<p class="text-secondary m-0">for the month of '.date('F', strtotime($date03)).', '.date('Y', strtotime($date03));
                                    }
                                ?>
                            </div>
                            <div>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-flex justify-content-end m-1">
                                    <input type="date" name="date" value="<?php echo $date03;?>" class="form-control mx-2" required>
                                    <button class="btn btn-primary btn-sm" type="submit" name="VA"><i class="fa-solid fa-rotate-right"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="VaccinatedAnimalsChart" ></canvas>
                            <table data-cols-width="13,20" class="table table-condensed table-bordered table-hover table-responsive text-start d-none" id="VAchartdata">
                                <tr>
                                    <th class="text-bg-dark textCenter" colspan="2" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Number of Vaccinated Animals</th>
                                </tr>
                                <tr>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Barangay</th>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Number of Animals</th>
                                </tr>
                                <?php 
                                    if(mysqli_num_rows($result) > 0){
                                        $barangay = array();
                                        $vaccAnimal = array();
                                    }else{
                                        echo "No records matching your query were found.";
                                    }

                                    foreach ($result as $data): 
                                ?>
                                <tr>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['brgy_name']; ?></td>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['NumberOfVaccinatedAnimals']; ?></td>
                                </tr>
                                <?php 
                                        $barangay[] = $data['brgy_name'];
                                        $VaccinatedAnimals[] = $data['NumberOfVaccinatedAnimals'];
                                    endforeach; 
                                ?>
                            </table>
                        </div>
                        <script>
                            const barangay03 =  <?php echo json_encode($barangay); ?>;
                            const VaccinatedAnimals = <?php echo json_encode($VaccinatedAnimals); ?>;

                            var backgroundcolor = [];
                            var bordercolor = [];

                            for (let i = 0; i< VaccinatedAnimals.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

                            const data03 = {
                                labels: barangay03,
                                datasets: [
                                    {
                                        label: 'Number of Vaccinated Animals',
                                        data: VaccinatedAnimals,
                                        backgroundColor: backgroundcolor,
                                        borderColor: bordercolor,
                                        borderWidth: 1
                                    }
                                ]
                            };

                            const config03 = {
                                type: 'bar',
                                data: data03,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        customCanvasBackgroundColor: {
                                            color: 'white',
                                        },
                                        legend: {
                                            display: false
                                        }
                                    }
                                },
                                plugins:[plugin]
                            };

                            const NumberOfVaccinatedAnimals = new Chart(
                                document.getElementById('VaccinatedAnimalsChart'),
                                config03
                            );
                        </script>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <?php 
                            if(isset($_POST['AA'])){
                                $date04 = mysqli_real_escape_string($conn,$_POST['date']);
                                $query = "
                                SELECT
                                    barangays.brgy_name,
                                    AVG(AnimalCount.NumberOfAnimals) AS 'avgNumber'
                                FROM
                                    ( 
                                        SELECT clients.clientID, clients.addressID as 'address', COUNT(case when animals.insertDate <= ? then animals.animalID else null end) AS 'NumberOfAnimals'
                                        FROM clients INNER JOIN animals ON clients.clientID = animals.clientID 
                                        GROUP BY clients.fname
                                    ) AnimalCount
                                        INNER JOIN clients_addresses
                                            ON  AnimalCount.address = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                GROUP BY barangays.brgy_name
                                ";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $query)){
                                    $alertmessage = urlencode("SQL error!");
                                    header('Location: Analytics.php?alertmessage='.$alertmessage);
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($stmt, "s", $date04);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                }

                            }else{
                                $query = "
                                SELECT
                                    barangays.brgy_name,
                                    AVG(AnimalCount.NumberOfAnimals) AS 'avgNumber'
                                FROM
                                    ( 
                                        SELECT clients.clientID, clients.addressID as 'address', COUNT(animals.animalID) AS 'NumberOfAnimals'
                                        FROM clients INNER JOIN animals ON clients.clientID = animals.clientID GROUP BY clients.fname
                                    ) AnimalCount
                                        INNER JOIN clients_addresses
                                            ON  AnimalCount.address = clients_addresses.addressID
                                                INNER JOIN barangays
                                                    ON clients_addresses.barangayID = barangays.barangayID
                                GROUP BY barangays.brgy_name
                                ORDER BY barangays.brgy_name ASC
                                ";
                                $result = mysqli_query($conn, $query);
                            }
                        ?>
                        <div class="container-fluid  border-bottom border-danger d-flex justify-content-between">
                            <div>
                                <div class="d-flex justify-content-start">
                                    <h3 class="m-0">Average number animals owned by clients</h3>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle mx-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-file-export"></i>
                                            Export Graph...
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" onclick="downloadIMG('AveragePetsOwnedChart')"><i class="fa-solid fa-image"></i> Image</li>
                                            <li><a class="dropdown-item" href="#" onclick="ExportToExcel('AAchartdata')"><i class="fa-solid fa-file-excel"></i> Data</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                                    if(isset($_POST['AA'])){
                                        echo '<p class="text-secondary m-0">as of '.date('F', strtotime($date04)).', '.date('Y', strtotime($date04));
                                    }
                                ?>
                            </div>
                            <div>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="d-flex justify-content-end m-1">
                                    <input type="date" name="date" value="<?php echo $date04;?>" class="form-control mx-2" required>
                                    <button class="btn btn-primary btn-sm" type="submit" name="AA"><i class="fa-solid fa-rotate-right"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="AveragePetsOwnedChart" ></canvas>
                            <table data-cols-width="13,30" class="table table-condensed table-bordered table-hover table-responsive text-start d-none" id="AAchartdata">
                                <tr>
                                    <th class="text-bg-dark textCenter" colspan="2" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Average no. of animals owned by clients</th>
                                </tr>
                                <tr>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Barangay</th>
                                    <th class="text-bg-dark textCenter medcell" data-a-h="center" data-f-bold="true" data-b-a-s="thin" data-b-a-c="000000">Average</th>
                                </tr>
                                <?php 
                                    if(mysqli_num_rows($result) > 0){
                                        $barangay = array();
                                        $avgNumber = array();
                                    }else{
                                        echo "No records matching your query were found.";
                                    }

                                    foreach ($result as $data): 
                                ?>
                                <tr>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['brgy_name']; ?></td>
                                    <td class="medcell" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="top" data-a-h="center"><?php echo $data['avgNumber']; ?></td>
                                </tr>
                                <?php 
                                        $barangay[] = $data['brgy_name'];
                                        $avgNumber[] = $data['avgNumber'];
                                    endforeach; 
                                ?>
                            </table>
                        </div>
                        <script>
                            const barangay04 =  <?php echo json_encode($barangay); ?>;
                            const avgNumber = <?php echo json_encode($avgNumber); ?>;

                            var backgroundcolor = [];
                            var bordercolor = [];

                            for (let i = 0; i< avgNumber.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

                            const data04 = {
                                labels: barangay04,
                                datasets: [
                                    {
                                        label: 'Average number of animals owned',
                                        data: avgNumber,
                                        backgroundColor: backgroundcolor,
                                        borderColor: bordercolor,
                                        borderWidth: 1
                                    }
                                ]
                            };

                            const config04 = {
                                type: 'bar',
                                data: data04,
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        customCanvasBackgroundColor: {
                                            color: 'white',
                                        },
                                        legend: {
                                            display: false
                                        }
                                    }
                                },
                                plugins:[plugin]
                            };

                            const averageN = new Chart(
                                document.getElementById('AveragePetsOwnedChart'),
                                config04
                            );
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    function downloadIMG(c){
        var imageLink = document.createElement('a');
        var canvas = document.getElementById(c);
        imageLink.download = c+'.png';
        imageLink.href = canvas.toDataURL('image/png',1);
        imageLink.click()
    }
</script>