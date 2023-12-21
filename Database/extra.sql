use StamfordUniversityBangladesh

-- Create Table
CREATE TABLE profilePicture (
   id varchar(20) NOT NULL, -- student/faculty
   path varchar(255) NOT NULL,
   timeStamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TRIGGER update_timestamp_profilePicture
ON profilePicture
AFTER UPDATE
AS
BEGIN
    UPDATE profilePicture
    SET timeStamp = CURRENT_TIMESTAMP
    FROM profilePicture
    INNER JOIN inserted ON profilePicture.id = inserted.id;
END;
