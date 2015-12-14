<?php
    include_once('methods.php');
   
    //REMOVES THE INSERTED DATA AFTER TESTING HAS OCCURED.
    //If you wish to keep the data so that you can manually inspect the
    // data in the table, set this value to false. 
    $removeData = false;
    
    $studentId = "900537307";
    $studentHall = "7";
    $workerId = rand(0, 1) == 0 ? "1" : "2"; 

    $studentInfo = array("Johnny","Football","footballj@appstate.edu","7049950943");
    
    $toppingIds_pizza_1 = array(1, 4, 5, 8, 11);
    $toppingIds_pizza_2 = array(1, 3);
    $toppingIds_pizza_3 = array();

    $quantity_pizza_1 = 1;
    $quantity_pizza_2 = 4;
    $quantity_pizza_3 = 2;
    
    $items = array(2, 4, 6);    //Cheese Bread (12in),   Cinnamon Knots,   Ranch

    $quantity_item_1 = 2;
    $quantity_item_2 = 1;
    $quantity_item_3 = 3;


    //Create a student entry
    //                      bannerId      FirstName        LastName           Email         PhoneNumber
    $student = makeStudent($studentId, $studentInfo[0], $studentInfo[1], $studentInfo[2], $studentInfo[3]);
    echo "Creating student. Result: " . ($student ? "Success" : "Failure");
    echo "<br>";
    

    //Create an Order for Pickup.
    //If deliver, call like:   $orderId = makeOrder($studentId, $hallId, $workerId);
    //                    bannerId
    $orderId = makeOrder($studentId, $workerId, $studentHall);
    echo "Creating order.  Result: " . ($orderId != -1 ? "Success (id: {$orderId})" : "Failure") . "<br>";
    //echo "Creating order. Result: " . ($orderId ? "Success" : "Failure");
    echo "<br>";
    
    
    //Insert 3 custom pizzas and their toppings (as defined in the topping arrays above) 
    echo "Inserting Custom Pizzas...<br>";
    $pizza_1 = makeCustomPizza(1, $toppingIds_pizza_1);     //size(0= medium, 1=large)  toppingId array
    $pizza_2 = makeCustomPizza(0, $toppingIds_pizza_2);
    $pizza_3 = makeCustomPizza(1, $toppingIds_pizza_3); 
    echo "Pizza 1. result: " . ($pizza_1 != -1 ? "Success (id: {$pizza_1})" : "Failure") . "<br>";
    echo "Pizza 2. result: " . ($pizza_2 != -1 ? "Success (id: {$pizza_2})" : "Failure") . "<br>";
    echo "Pizza 3. result: " . ($pizza_3 != -1 ? "Success (id: {$pizza_3})" : "Failure") . "<br>";
    echo "<br>";


    //Create Order_Details for these 3 pizzas to connect them to the order
    echo "Making Details for the Pizzas<br>";
    $detail_1 =  makeOrderDetailPizza($orderId, $quantity_pizza_1, $pizza_1);
    $detail_2 =  makeOrderDetailPizza($orderId, $quantity_pizza_2, $pizza_2);
    $detail_3 =  makeOrderDetailPizza($orderId, $quantity_pizza_3, $pizza_3);
    echo "Pizza 1 detail result: " . ($detail_1 ? "Success" : "Failure") . "<br>";
    echo "Pizza 2 detail result: " . ($detail_2 ? "Success" : "Failure") . "<br>";
    echo "Pizza 3 detail result: " . ($detail_3 ? "Success" : "Failure") . "<br>";
    echo "<br>";
    

    //Create Order_Details for 3 items to connect them to the order
    echo "Making Details for the Items<br>";
    $detail_1 =  makeOrderDetailItem($orderId, $quantity_item_1, $items[0]);
    $detail_2 =  makeOrderDetailItem($orderId, $quantity_item_2, $items[1]);
    $detail_3 =  makeOrderDetailItem($orderId, $quantity_item_3, $items[2]);
    echo "Item 1 detail result: " . ($detail_1 ? "Success" : "Failure") . "<br>";
    echo "Item 2 detail result: " . ($detail_2 ? "Success" : "Failure") . "<br>";
    echo "Item 3 detail result: " . ($detail_3 ? "Success" : "Failure") . "<br>";
    echo "<br>";
 
 
    echo "totalcost: " . mysqli_fetch_array(mysqli_query($GLOBALS["conn"],
                                "SELECT totalCost FROM Orders WHERE orderId=" . $orderId . ";"))["totalCost"];
    
        
        
    if ($removeData)
    {  
        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Pizza_Toppings;");

        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Order_Details;");
        
        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Pizza_Toppings;");
        mysqli_query($GLOBALS["conn"], "DELETE FROM Pizza WHERE pizzaId > 9");

        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Orders;");
        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Student;");
    }
?>

