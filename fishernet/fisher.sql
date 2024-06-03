
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50),
    Email VARCHAR(100),
    Password VARCHAR(255),
    ProfilePicture VARCHAR(255),
    UserType ENUM('Fisherman') DEFAULT 'Fisherman'
);
CREATE TABLE FishingZones (
    ZoneName VARCHAR(100) PRIMARY KEY,
    Description TEXT,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE CatchLogbook (
    LogID INT PRIMARY KEY AUTO_INCREMENT,
    ZoneName VARCHAR(100),
    Species VARCHAR(100),
    Quantity INT,
    DateTime DATETIME,
    UserID INT,
    FOREIGN KEY (ZoneName) REFERENCES FishingZones(ZoneName),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE FishMarketPrices (
    PriceID INT PRIMARY KEY AUTO_INCREMENT,
    Species VARCHAR(100),
    MarketPrice DECIMAL(10, 2),
    PriceDate DATE,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
CREATE TABLE Equipment (
    EquipID INT PRIMARY KEY AUTO_INCREMENT,
    EquipName VARCHAR(100),
    Quantity INT,
    UserID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE MaintenanceLog (
    MaintenanceID INT PRIMARY KEY AUTO_INCREMENT,
    EquipID INT,
    MaintenanceDate DATE,
    MaintenanceType VARCHAR(100),
    Cost DECIMAL(10, 2),
    Notes TEXT,
    FOREIGN KEY (EquipID) REFERENCES Equipment(EquipID)
);
