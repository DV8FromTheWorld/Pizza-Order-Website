<?php
    include_once('methods.php');

    $removeData = false;
    $message = "Recieved:\n";

    $order;
    $student;
    $orderId;

    $order = json_decode($_POST['order']);
    foreach ($order as $value)
    {
        $message .= json_encode($value) . "\n";
    }
    $message .= "\n";
    
    $student = $order[0]; //banner, fname, lname, email, phone
    $result = makeStudent($student[0], $student[1], $student[2], $student[3], $student[4]);
    $message .= "Student: " . json_encode($student) . "\n";
    $message .= "Insert Status: " . ($result ? "Success" : "Failure") . "\n\n";
    
    $workerId = getLeastBusyWorker();
    
    //If count is more than 5, then we also have a hallId. Otherwise we will not insert a hallId
    if (count($student) > 5)
    {
        $orderId = makeOrder($student[0], $workerId, $student[5]); 
    }
    else
    {
        $orderId = makeOrder($student[0], $workerId);
    }
    if ($orderId == -2)
        respond(1);
    
    $message .= "Order:  Insert: " . ($orderId != -1 ? "Success, Id: {$orderId}" : "Failure") . "\n";
    $message .= "WorkerId: {$workerId}\n\n";

   
    $order = array_slice($order, 1); //Removes the student array order[0] from order. Moves all indexes forward.
    foreach ($order as $detail)
    {
        switch ($detail[0]) //Detail type.
        {
            case 0:             //Custom Pizza 
                $pizzaId = makeCustomPizza($detail[3], $detail[2]);  //Size, ToppingArray
                makeOrderDetailPizza($orderId, $detail[1], $pizzaId);//orderId, Quantity, pizzaId 
                break;
            case 1:             //Specialty Pizza
                makeOrderDetailPizza($orderId, $detail[1], $detail[2]);//orderId, Quantity, pizzaId
                break;
            case 2:             //Item
                makeOrderDetailItem($orderId, $detail[1], $detail[2]);//orderId, Quantity, pizzaId
                break;
        }    
    } 
    
    respond(0, $orderId);
    //echo $message;
    
    if ($removeData)
    {
        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Pizza_Toppings;");

        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Order_Details;");

        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Pizza_Toppings;");
        mysqli_query($GLOBALS["conn"], "DELETE FROM Pizza WHERE pizzaId > 9");

        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Orders;");
        mysqli_query($GLOBALS["conn"], "TRUNCATE TABLE Student;");
    }


    /**
     * Status Codes:
     *      0: Success. No issues.
     *      1: Student already has an order.
     *
     */ 
    function respond($statusCode, $orderId = -1)
    {
        echo JSON_encode(
                array(
                    "status" => $statusCode,
                    "orderId" => $orderId));
        exit();
    }
?>
