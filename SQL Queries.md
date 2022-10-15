# SQL Queries

## Triggers

### Client-Animal deletion: Before Delete

```mysql
BEGIN
DELETE FROM animal
WHERE animal.clientID = OLD.clientID;
END
```

### Animal-MH Deletion: Before Delete

```mysql
BEGIN
DELETE from medicalhistory
WHERE medicalhistory.animalID = OLD.animalID;
END
```

## View  Queries

### View client list:

```mysql
SELECT name, clientID 
FROM `client` 
```

### View specific client record:

```mysql
SELECT name, address, barangay, birthdate, contactNumber, sex	
FROM `client` 
WHERE clientID = 'input client id here'
```

###  View animals owned by specific client:

```mysql
SELECT animal.name, animal.species, animal.breed, color, animal.sex, animal.age, client.name as 'owner'	
FROM `client`,`animal` 
WHERE client.clientID = animal.clientID
```

### View medical history of specific animal:

```mysql
SELECT medicalhistory.date, medicalhistory.caseHistory, medicalhistory.tentativeDiagnosis, medicalhistory.prescription, medicalhistory.treatment, medicalhistory.remarks 
FROM `animal`, `medicalhistory` 
WHERE animal.animalID = medicalhistory.animalID
```

### View users:

```mysql
SELECT name, email, password, contactNumber, address	
FROM `user` 
```

## Operations

### Insert new client record:

```mysql
INSERT INTO `client`(`name`, `address`, `barangay`, `birthdate`, `contactNumber`, `sex`) 
VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
```

### Update client record:

```mysql
UPDATE `client` 
SET `name`='[value-2]',`address`='[value-3]',`barangay`='[value-4]',`birthdate`='[value-5]',`contactNumber`='[value-6]',`sex`='[value-7]' 
WHERE clientID = 'input client ID here' 
```

### Delete client record:

```mysql
DELETE FROM `client` WHERE clientID = 'input client ID here'
```

### Insert new animal record:

```mysql
INSERT INTO `animal`(`name`, `species`, `breed`, `color`, `sex`, `age`, `clientID`) 
VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')
```

### Update animal record:

```mysql
UPDATE `animal` SET `name`='[value-2]',`species`='[value-3]',`breed`='[value-4]',`color`='[value-5]',`sex`='[value-6]',`age`='[value-7]',`clientID`='[value-8]' 
WHERE animalID = 'input animal ID here'
```

### Delete animal record:

```mysql
DELETE FROM `animal` WHERE animalID = 'input animal ID here'
```

### Insert new medical history record:

```mysql
INSERT INTO `medicalhistory`(`date`, `caseHistory`, `tentativeDiagnosis`, `prescription`, `treatment`, `remarks`, `animalID`) 
VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')
```

### Update medical history:

```mysql
UPDATE `medicalhistory` SET `date`='[value-2]',`caseHistory`='[value-3]',`tentativeDiagnosis`='[value-4]',`prescription`='[value-5]',`treatment`='[value-6]',`remarks`='[value-7]',`animalID`='[value-8]' 
WHERE mhID = 'input mh ID here'
```

### Delete medical history:

```mysql
DELETE FROM `medicalhistory` WHERE mhID = 'input mh ID here'
```

### Insert new user:

```mysql
INSERT INTO `user`(`name`, `email`, `password`, `contactNumber`, `address`) 
VALUES ('[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')
```

### Update user:

```mysql
UPDATE `user` SET `name`='[value-2]',`email`='[value-3]',`password`='[value-4]',`contactNumber`='[value-5]',`address`='[value-6]' 
WHERE userID = 'input user ID here'
```

### Delete user:

```mysql
DELETE FROM `user` WHERE userID = 'input user ID here'
```

### Select all client contact number:

```mysql
SELECT contactnumber
FROM `client` 
```

### Select all client email:

```mysql
SELECT email
FROM `client` 
```

### Select all user contact number:

```mysql
SELECT contactnumber
FROM `user` 
```

### Select all user email:

```mysql
SELECT email
FROM `user` 
```

