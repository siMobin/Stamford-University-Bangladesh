use StamfordUniversityBangladesh

CREATE TABLE library_shelf (
    serial INT PRIMARY KEY NOT NULL IDENTITY(1,1),
    timeStamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ISBN VARCHAR(255) NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    publishYear INT,
    edition VARCHAR(255),
    Publisher VARCHAR(255),
    barCode VARCHAR(255),
    shelfNumber VARCHAR(255),
    department VARCHAR(255),
    quantity INT NOT NULL
)


CREATE TABLE Book_status (
    serial INT PRIMARY KEY NOT NULL IDENTITY(1,1),
    timeStamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ISBN VARCHAR(255) NOT NULL,
    department VARCHAR(255),
    borrowerID VARCHAR(255),
    borrowDate DATE,
    returnDate DATE,
    CONSTRAINT CK_Dates CHECK (borrowDate <= returnDate) -- Assuming borrowDate should be less than or equal to returnDate
)