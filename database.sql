-- Create Tables
CREATE TABLE User (
	Uid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	LastName VARCHAR(30) NOT NULL,
	FirstName VARCHAR(30) NOT NULL,
	Email VARCHAR(50) NOT NULL,
	Salt VARCHAR(99) NOT NULL,
	Hash VARCHAR(99) NOT NULL,
	Gender CHAR(1) NOT NULL,
	Contact INT(8),
	District VARCHAR(100),
	Grade REAL,
	PRIMARY KEY (Uid));

CREATE TABLE Book (
	Bid INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	Bname VARCHAR(100) NOT NULL,
	Category INT(2) NOT NULL,
	ISBN INT(13) NOT NULL,
	Price FLOAT NOT NULL,
	Description VARCHAR(255),
	Seller INT(10) UNSIGNED NOT NULL,
	Status INT(1) NOT NULL,
	Buyer INT(10) UNSIGNED,
	WeeklyClickRate INT(7) NOT NULL,
	ClickRate INT(7) NOT NULL,
	PostTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (Bid),
	CONSTRAINT FK_Seller
		FOREIGN KEY(Seller) REFERENCES User(Uid)
			ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_Buyer
		FOREIGN KEY(Buyer) REFERENCES User(Uid)
			ON UPDATE CASCADE ON DELETE SET NULL);

CREATE TABLE Chat (
	Cid INT(50) UNSIGNED NOT NULL AUTO_INCREMENT,
	Sender INT(10) UNSIGNED,
	Receiver INT(10) UNSIGNED,
	Message VARCHAR(1000) NOT NULL,
	ChatTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (Cid),
	CONSTRAINT FK_Sender
		FOREIGN KEY(Sender) REFERENCES User(Uid)
			ON DELETE SET NULL ON UPDATE CASCADE,
	CONSTRAINT FK_Receiver
		FOREIGN KEY(Receiver) REFERENCES User(Uid)
			ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE Top10 (
	Book INT(10) UNSIGNED NOT NULL,
	ClickRate INT(7) NOT NULL,
	PRIMARY KEY (Book),
	CONSTRAINT FK_Top10Book
		FOREIGN KEY (Book) REFERENCES Book(Bid)
			ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE Follow (
	Follower INT(10) UNSIGNED NOT NULL,
	Followee INT(10) UNSIGNED NOT NULL,
	CONSTRAINT UC_Follow
		UNIQUE (Follower, Followee),
	CONSTRAINT FK_Follower
		FOREIGN KEY (Follower) REFERENCES User(Uid)
			ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT FK_Followee
		FOREIGN KEY (Followee) REFERENCES User(Uid)
			ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE Hashtag (
	Book INT(10) UNSIGNED NOT NULL,
	Tag VARCHAR(30) NOT NULL,
	CONSTRAINT UC_Hashtag
		UNIQUE (Book, Tag),
	CONSTRAINT FK_Hashtag
		FOREIGN KEY (Book) REFERENCES Book(Bid)
		ON DELETE CASCADE ON UPDATE CASCADE);

-- Insert new user
INSERT INTO User (LastName, FirstName, Email, Salt, Hash, Gender, Contact, District, Grade) 
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0.0)
$stmt = $conn->prepare($sql);
$stmt = bind_param("sssssiis", $lastname, $firstname, $email, $salt, $hash, $gender, $contact, $district);
$stmt->execute();

-- Update user
UPDATE User
	SET LastName=?, FirstName=?, Email=?, Hash=?, Gender=?, Contact=?, District=?
	WHERE Uid=?
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssiis", $lastname, $firstname, $email, $hash, $gender, $contact, $district);
$stmt->execute();

-- Retrieve User
SELECT LastName, FirstName, Email, Salt, Hash, Gender, Contact, District FROM Users WHERE Uid=?
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();

-- Login validation
SELECT Uid, Salt, Hash FROM Users WHERE Email=?
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

-- Insert new book
INSERT INTO Book (Bname, Category, ISBN, Price, Description, Seller, Status, WeeklyClickRate, ClickRate)
	VALUES(?, ?, ?, ?, ?, ?, 1, 0, 0)
$stmt = $conn->prepare($sql);
$stmt->bind_param("siidsi", $bname, $category, $isbn, $price, $description, $seller);
$stmt->execute();

-- Search book
SELECT Bid, Bname, Category, ISBN, Price, Description, Seller, Status, Buyer, WeeklyClickRate, ClickRate, PostTime
	FROM Book WHERE ?=?
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $criteria, $searchstr);
$stmt->execute;

-- Update book
UPDATE Book
	SET Bname=?, Category=?, ISBN=?, Price=?, Description=?, Status=?
	WHERE Bid=?
$stmt = $conn->prepare($sql);
$stmt->bind_param("siidsii", $bname, $category, $isbn, $price, $description, $status, $bid);
$stmt->execute();