ALTER TABLE Orders ADD 
(
    CONSTRAINT order_studentId_fk FOREIGN KEY (studentId) REFERENCES Student (bannerId),
    CONSTRAINT order_hallId_fk FOREIGN KEY (hallId) REFERENCES ResidenceHall (hallId),
    CONSTRAINT order_workerId_fk FOREIGN KEY (workerId) REFERENCES Worker (workerId)
);

ALTER TABLE Pizza_Toppings ADD
(
    CONSTRAINT pizzaId_fk FOREIGN KEY (pizzaId) REFERENCES Pizza (pizzaId),
    CONSTRAINT toppindId_fk FOREIGN KEY (toppingId) REFERENCES Toppings (toppingId)
);

ALTER TABLE Order_Details ADD
(
    CONSTRAINT detail_orderId_fk FOREIGN KEY (orderId) REFERENCES Orders (orderId),
    CONSTRAINT detail_itemId_fk FOREIGN KEY (itemId) REFERENCES Items (itemId),
    CONSTRAINT detail_pizzaId_fk FOREIGN KEY (pizzaId) REFERENCES Pizza (pizzaId)
);
