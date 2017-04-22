DROP TABLE if EXISTS email

-- create the email entity
CREATE TABLE email (
emailTimeSent TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
emailAddressSent VARCHAR NOT NULL,
PRIMARY KEY (email)
);