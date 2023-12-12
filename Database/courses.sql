use StamfordUniversityBangladesh

create table course_assign(
course_code varchar(30) not null,
department varchar(10) not null,
semester varchar(50) not null,
batch varchar (10) not null
)

create table CRS_confirm(
course_code varchar(20) not null,
studentID varchar(50) not null,
semester varchar(50) not null
)