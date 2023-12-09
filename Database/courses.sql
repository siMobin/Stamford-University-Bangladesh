use StamfordUniversityBangladesh
create table course_info(
code varchar (30) primary key,
course_name varchar (255) not null,
credit_hour float not null,
pre_req varchar (30)
)
create table course_assign(
course_code varchar(30) not null,
department varchar(10) not null,
semester varchar(50) not null,
batch varchar (10) not null
)