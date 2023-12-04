create database StamfordUniversityBangladesh;
use StamfordUniversityBangladesh;


create table students
(
    UID varchar(255) primary key,
    StudentId varchar(20) not null,
    FirstName varchar(30) not null,
    LastName varchar(30) not null,
    DateOfBirth varchar(255) not null,
    RegNo varchar(30), -- from HSC/SSC
    Email varchar(255) not null,
    Batch varchar(20) not null,
    Department varchar(255) not null,
    Program varchar(255) not null,
    Country varchar(50) not null,
    Semester varchar(20) not null,
    AdmissionDate varchar(255) not null,

    MotherName varchar(50) not null,
    FatherName varchar(50) not null,
    FatherOccupation varchar(50) not null,
    ParentName varchar(50) not null,
    ParentConnection varchar(50) not null,

    PermanentAddress varchar(255) not null,
    PresentAddress varchar(255) not null
)


create table student_login
(
    StudentId varchar(20) primary key,
    Batch varchar(255) not null,
    Department varchar(255) not null,
    Email varchar(255) not null,
    Password varchar(60) not null,
    SecurityQuestion varchar(255) not null,
    SecurityAnswer varchar(255) not null
)

create table phone
(
    Serial int primary key identity(1,1),
    StudentId varchar(20) not null,
    Phone varchar(255) not null,
    ConnectionType varchar(50) not null -- self/parent etc
)