DROP TABLE if EXISTS email

-- create the email entity
CREATE TABLE email (
emailId INT UNSIGHNED AUTO_INCREMENT NOT NULL,
emailTimeSent TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
emailAddressSent VARCHAR(50) NOT NULL,
PRIMARY KEY (emailId)
);