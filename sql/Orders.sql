CREATE TABLE IF NOT EXISTS Orders
(
    orderId INT(6) AUTO_INCREMENT PRIMARY KEY,
    timeOrdered DATETIME NOT NULL,
    totalCost DECIMAL(6, 2) NOT NULL DEFAULT 0.00,
    active BOOLEAN NOT NULL DEFAULT 1,
    
    studentId CHAR(9) NOT NULL,
    hallId INT(4) DEFAULT NULL,
    workerId INT(4) DEFAULT NULL
);

