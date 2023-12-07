use StamfordUniversityBangladesh;

create table notice_board(
    serial int primary key identity(1,1),
    timeStamp varchar(255) not null,
    title varchar(60) not null,
    content varchar(max),
    fileName varchar(255),
    filePath  varchar(255), --path location in workspace folder
    fileType varchar(10)
)