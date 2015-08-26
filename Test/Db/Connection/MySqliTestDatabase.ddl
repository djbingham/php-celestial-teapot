CREATE TABLE guestbook
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    content VARCHAR(100),
    user VARCHAR(100),
    created DATETIME
);
