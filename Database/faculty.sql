use StamfordUniversityBangladesh
create table Faculty(
    UID varchar(255) primary key,
    FacultyId varchar(20) not null,
    FirstName varchar(30) not null,
    LastName varchar(30) not null,
    DateOfBirth date not null,
	Gender varchar(20) not null,
    Email varchar(255) not null,
    Department varchar(255) not null,
    Position varchar(255) not null,
	Certification varchar(255) not null,
    Country varchar(50) not null,
    HireDate date not null,
	Work_experience varchar(50) not null, --(X years)
	Specialization varchar(50) not null,
    PermanentAddress varchar(255) not null,
    PresentAddress varchar(255) not null,
    
)

create table Faculty_login
(
    FacultyId varchar(20) primary key,
    Department varchar(255) not null,
    Email varchar(255) not null,
    Password varchar(60) not null,
    SecurityQuestion varchar(255) not null,
    SecurityAnswer varchar(255) not null
)

create table Faculty_phone
(
    Serial int primary key identity(1,1),
    FacultyId varchar(20) not null,
    Phone varchar(255) not null,
)


-- TODO: 
-- Check "https://www.stamforduniversity.edu.bd/index.php/stamford/details/72"
-- Before confirming
create table details
(
    Serial int primary key identity(1,1),
    Id varchar(20) not null,
    Email varchar(255),
    details varchar(255),
    ResearchAndAwards varchar(255),
    Publication varchar(255),
    Others varchar(255),
    UpdateTimeStamp DATETIME DEFAULT CURRENT_TIMESTAMP
)

CREATE TRIGGER update_timestamp ON details
    AFTER UPDATE AS
    BEGIN
        UPDATE details
            SET UpdateTimeStamp = CURRENT_TIMESTAMP FROM details
                INNER JOIN inserted ON details.id = inserted.id;
    END;
