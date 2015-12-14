CREATE TABLE IF NOT EXISTS Order_Details
(
    orderId INT(6) NOT NULL,
    itemId INT(2) NOT NULL, 
    quantity INT(2) NOT NULL DEFAULT 1,
    pizzaId INT(4) DEFAULT NULL
);

