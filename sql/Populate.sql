INSERT INTO Items (itemId, name, cost) VALUES
    (1, "Pizza",                  -1),
    (2, "Cheese Bread (12in)",  5.99),
    (3, "Cheese Bread (16in)",  7.99),
    (4, "Cinnamon Knots",       4.99),
    (5, "Ranch",                0.99),
    (6, "Marinara",             0.99);

INSERT INTO Toppings (toppingId, name) VALUES
    (1,  "Bacon"),
    (2,  "Beef"),
    (3,  "Chicken"),
    (4,  "Ham"),
    (5,  "Pepperoni"),
    (6,  "Pork"),
    (7,  "Mozzarella Cheese"),
    (8,  "Black Olives"),
    (9,  "Green Peppers"),
    (10, "Mushrooms"),
    (11, "Onions"),
    (12, "Pineapple"),
    (13, "Tomatoes"),
    (14, "Extra Cheese"),
    (15, "Extra Pepperoni"),
    (16, "Extra Sauce");

INSERT INTO Pizza (pizzaId, name, cost) VALUES
    (1, "Invalid Pizza",        -1.00),
    (2, "Bacon and Cheddar",    14.63),
    (3, "Chicken Bacon Ranch",  16.95),
    (4, "Hawaiian",             16.95),
    (5, "Hot Wing Chicken",     16.95),
    (6, "Meat Lovers",          16.95),
    (7, "Steak and Cheese",     16.95),
    (8, "Supreme",              16.95),
    (9, "Veggie",               16.95);

UPDATE Pizza SET inStock=0 WHERE pizzaId=1;

INSERT INTO Worker (nameFirst, nameLast, hours, hireDate) VALUES
    ("John", "Smith", 30, "2012-04-05"),
    ("Jane", "Wade", 15, "2013-08-09");

INSERT INTO ResidenceHall (hallId, name, address) VALUES
   (1,  "Invalid Hall", "Narnia"),
   (2,  "Appalachian Heights", "536 Bodenheimer Drive"),
   (3,  "Appalachian Panhellenic Hall (APH)", "949 Blowing Rock Rd"),
   (4,  "Belk", "324 Stadium Heights Drive"),
   (5,  "Bowie", "418 Stadium Heights Drive"),
   (6,  "Cannon", "286 Hardin Street"),
   (7,  "Coltrane", "193 Stadium Drive"),
   (8,  "Cone", "135 Brown Street"),
   (9,  "Doughton", "949 Blowing Rock Rd"),
   (10, "Eggers", "388 Stadium Heights Dr"),
   (11, "Frank", "342 Stadium Heights Dr"),
   (12, "Gardner", "191 Stadium Dr"),
   (13, "Hoey", "230 Hardin St"),
   (14, "Justice", "189 Stadium Dr"),
   (15, "Living Learning Center (LLC)", "301 Bodenheimer Dr"),
   (16, "Lovill", "170 Locust St"),
   (17, "Mountaineer", "116 Mountaineer Dr"),
   (18, "Newland", "657 Rivers St"),
   (19, "Summit", "140 Brown St"),
   (20, "White", "140 Brown St");
