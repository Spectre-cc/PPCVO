# SQL Queries

## Triggers

### Client-Animal deletion: Before Delete

```mysql
/*Delete animal records associated with the client*/
BEGIN
DELETE FROM animal
WHERE animal.clientID = OLD.clientID;
END
```

### Animal-MH Deletion: Before Delete

```mysql
/*Delete health history records associated with the animal*/
BEGIN
DELETE from medicalhistory
WHERE medicalhistory.animalID = OLD.animalID;
END
```

## Reports

### Animal Health Report

```mysql
/*Select columns*/
SELECT 
/*Client Information*/
client.barangay AS 'barangay', client.name AS 'name', client.sex AS 'gender', client.birthdate 'birthdate', client.contactNumber AS 'contactNumber', 

/*Animal Information*/
animal.species AS 'species', animal.sex AS 'sex', animal.birthdate AS 'age',

/*MH Information*/
medicalhistory.clinicalSign AS 'Clinical Sign', medicalhistory.remarks AS 'Remarks' 

/*Specify tables to retrieve columns*/
FROM client, animal, medicalhistory

/*Specify conditions on column selection*/
WHERE 
	medicalhistory.type = 'Animal Health' 
    AND
	client.clientID = animal.clientID 
    AND
    animal.animalID = medicalhistory.animalID
    AND
    (medicalhistory.date BETWEEN '2022-10-25' AND '2022-10-28') 
    
/*Order records in ASC order based on client's barangay*/
ORDER BY client.barangay ASC
```

### Vaccination Report

```mysql
/*Select columns*/
SELECT

/*Record date*/
medicalhistory.date AS 'date',

/*Client Information*/
client.barangay AS 'barangay', client.name AS 'name', client.sex AS 'gender', client.birthdate 'birthdate', client.contactNumber AS 'contactNumber', 

/*Animal Information*/
animal.species AS 'species', animal.sex AS 'sex', animal.birthdate AS 'age', animal.registrationNumber AS 'registrationNumber', animal.numberHeads AS 'No. of Heads', animal.color AS 'color', animal.name,

/*MH Information*/
medicalhistory.disease AS 'disease', medicalhistory.vaccineUsed AS 'vaccineUsed', medicalhistory.batchNumber AS 'batchNumber', medicalhistory.remarks

/*Specify tables to retrieve columns*/
FROM client, animal, medicalhistory

/*Specify conditions on column selection*/
WHERE 
	medicalhistory.type = 'Vaccination' 
    AND
	client.clientID = animal.clientID 
    AND
    animal.animalID = medicalhistory.animalID
    AND
    (medicalhistory.date BETWEEN '2022-10-25' AND '2022-10-28') 
    
/*Order records in ASC order based on client's barangay*/
ORDER BY client.barangay ASC
```

### Routine Services Report

```mysql
/*Select columns*/
SELECT

/*Record date*/
medicalhistory.date AS 'date',

/*Client Information*/
client.barangay AS 'barangay', client.name AS 'name', client.sex AS 'gender', client.birthdate 'birthdate', client.contactNumber AS 'contactNumber', 

/*Animal Information*/
animal.species AS 'species', animal.sex AS 'sex', animal.birthdate AS 'age', animal.name AS 'name', animal.numberHeads AS 'numberHeads', animal.registrationNumber AS 'registrationNumber', 

/*MH Information*/
medicalhistory.activity AS 'activity', medicalhistory.medication AS 'medication', medicalhistory.remarks

/*Specify tables to retrieve columns*/
FROM client, animal, medicalhistory

/*Specify conditions on column selection*/
WHERE 
	medicalhistory.type = 'Routine Service' 
    AND
	client.clientID = animal.clientID 
    AND
    animal.animalID = medicalhistory.animalID
    AND
    (medicalhistory.date BETWEEN '2022-10-25' AND '2022-10-28') 
    
/*Order records in ASC order based on client's barangay*/
ORDER BY client.barangay ASC
```

