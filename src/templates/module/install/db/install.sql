CREATE TABLE `test_table` (
        `ID` INT(11) NOT NULL AUTO_INCREMENT,
        `TITLE` VARCHAR(65536) NOT NULL,
        `SORT` INT(11) DEFAULT 500,
        `CREATED` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY(ID)
    );