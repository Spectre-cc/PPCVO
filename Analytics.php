<?php require('functions/config/config.php'); ?>
<?php require('functions/config/db.php'); ?>
<?php include('functions/checksession-admin.php'); ?>
<?php include('functions/alert.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require('inc\links.php'); ?>
    <title>Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container-fluid m-0 p-0">
        <div class="wrapper d-flex m-2">
            <?php require('inc\sidenav-admin.php'); ?>
            <div class="content container bg-light rounded-4 min-vh-100 px-0" style="max-width: 80vw;">
                <div class="container-fluid">
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <div class="container-fluid  border-bottom border-danger">
                            <h3>Number of Registered Animals</h3>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="ChartRegisteredAnimals" ></canvas>
                        </div>
                        <?php 
                            $query = "
                            SELECT 
                                barangays.brgy_name,
                                COUNT(animals.animalID) as 'regAnimals'
                            FROM
                                clients,
                                clients_addresses,
                                barangays,
                                animals
                            WHERE
                                clients.addressID = clients_addresses.addressID
                                AND
                                clients_addresses.barangayID = barangays.barangayID
                                AND
                                clients.clientID = animals.clientID
                                AND
                                animals.regNumber IS NOT NULL
                                AND
                                animals.regDate > DATE_SUB(NOW(),INTERVAL 1 YEAR)
                            GROUP BY barangays.brgy_name
                            ORDER BY barangays.brgy_name ASC
                            ";
                            $result = mysqli_query($conn, $query);

                            if(mysqli_num_rows($result) > 0){
                                $barangay = array();
                                $regAnimals = array();

                                foreach ($result as $data):
                                    $barangay[] = $data['brgy_name'];
                                    $regAnimals[] = $data['regAnimals'];
                                endforeach;
                            }else{
                                echo "No records matching your query were found.";
                            }
                        ?>
                        <script>
                            const barangay01 =  <?php echo json_encode($barangay); ?>;
                            const regAnimals = <?php echo json_encode($regAnimals); ?>;

                            var backgroundcolor = [];
                            var bordercolor = [];

                            for (let i = 0; i< regAnimals.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

                            const data01 = {
                                labels: barangay01,
                                datasets: [
                                    {
                                        label: 'Number of Registered Animals',
                                        data: regAnimals,
                                        backgroundColor: backgroundcolor,
                                        borderColor: bordercolor,
                                        borderWidth: 1
                                    }
                                ]
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
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    }
                                }
                            };

                            const regAnimalsPerBarangay = new Chart(
                                document.getElementById('ChartRegisteredAnimals'),
                                config01
                            );
                        </script>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <div class="container-fluid  border-bottom border-danger">
                            <h3>Dog and Cat Population</h3>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="DogCatPopulation" ></canvas>
                        </div>
                        <?php 
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

                            if(mysqli_num_rows($result) > 0){
                                $barangay = array();
                                $NumberOfCats = array();
                                $NumberOfDogs = array();

                                foreach ($result as $data):
                                    $barangay[] = $data['brgy_name'];
                                    $NumberOfCats[] = $data['NumberOfCats'];
                                    $NumberOfDogs[] = $data['NumberOfDogs'];
                                endforeach;
                            }else{
                                echo "No records matching your query were found.";
                            }
                        ?>
                        <script>
                            const barangay02 =  <?php echo json_encode($barangay); ?>;
                            const NumberOfCats = <?php echo json_encode($NumberOfCats); ?>;
                            const NumberOfDogs = <?php echo json_encode($NumberOfDogs); ?>;

                            var backgroundcolor = [];
                            var bordercolor = [];

                            for (let i = 0; i< barangay02.length; i++) {
                                let r = Math.floor(Math.random() * 255);
                                let g = Math.floor(Math.random() * 255);
                                let b = Math.floor(Math.random() * 255);
                                backgroundcolor.push('rgba('+r+','+g+','+b+',0.7)');
                                bordercolor.push('rgb('+r+','+g+','+b+')');
                            }

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
                                    }
                                }
                            };

                            const DogCatPopulation = new Chart(
                                document.getElementById('DogCatPopulation'),
                                config02
                            );
                        </script>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <div class="container-fluid  border-bottom border-danger">
                            <h3>Number of Vaccinated Animals</h3>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="VaccinatedAnimals" ></canvas>
                        </div>
                        <?php 
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

                            if(mysqli_num_rows($result) > 0){
                                $barangay = array();
                                $vaccAnimal = array();

                                foreach ($result as $data):
                                    $barangay[] = $data['brgy_name'];
                                    $VaccinatedAnimals[] = $data['NumberOfVaccinatedAnimals'];
                                endforeach;
                            }else{
                                echo "No records matching your query were found.";
                            }
                        ?>
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
                                        legend: {
                                            display: false
                                        }
                                    }
                                }
                            };

                            const NumberOfVaccinatedAnimals = new Chart(
                                document.getElementById('VaccinatedAnimals'),
                                config03
                            );
                        </script>
                    </div>
                    <div class="containter-fluid shadow justify-content-start align-items-start rounded-5 p-3 my-2">
                        <div class="container-fluid  border-bottom border-danger">
                            <h3>Average number animals owned by clients</h3>
                        </div>
                        <div class="w-100" style="height: 30vh">
                            <canvas id="avgNumber" ></canvas>
                        </div>
                        <?php 
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

                            if(mysqli_num_rows($result) > 0){
                                $barangay = array();
                                $avgNumber = array();

                                foreach ($result as $data):
                                    $barangay[] = $data['brgy_name'];
                                    $avgNumber[] = $data['avgNumber'];
                                endforeach;
                            }else{
                                echo "No records matching your query were found.";
                            }
                        ?>
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
                                        label: 'Number of Vaccinated Animals',
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
                                        legend: {
                                            display: false
                                        }
                                    }
                                }
                            };

                            const averageN = new Chart(
                                document.getElementById('avgNumber'),
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
