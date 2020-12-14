-- Schema of database "interview_20201209".

CREATE TABLE airplanes
(
    `id`              INT(11)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `aircraft_type`   VARCHAR(30) NOT NULL,
    `sits_count`      INT(11)     NOT NULL,
    `rows`            INT(11)     NOT NULL,
    `row_arrangement` VARCHAR(60) NOT NULL
);

CREATE TABLE ticket_orders
(
    `id`          INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `person_name` VARCHAR(200) NOT NULL
);

CREATE TABLE tickets
(
    `id`              INT(11)    NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ticket_order_id` INT(11)    NOT NULL,
    `airplane_id`     INT(11)    NOT NULL,
    `row_number`      INT(11)    NOT NULL,
    `sit_number`      VARCHAR(1) NOT NULL
);
