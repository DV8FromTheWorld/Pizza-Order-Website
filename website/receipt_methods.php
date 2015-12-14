<?php
    include_once('connect.php');

    $orderInfo = null;
    if (isset($_GET['orderId']) && $_GET['orderId'] > 0)
    {
        $orderExists = count(mysqli_fetch_array(mysqli_query($GLOBALS["conn"],
                        sprintf("SELECT orderId FROM Orders WHERE orderId=%d",
                            $_GET["orderId"])))) > 0;
        if ($orderExists)
            getOrderInfo();
    }

    function getOrderInfo()
    {
        global $orderInfo;
        $orderInfo = array();
        $orderId =  $_GET["orderId"];
                
        $order = mysqli_fetch_array(mysqli_query($GLOBALS["conn"],
               sprintf("SELECT studentId, timeOrdered, totalCost, ResidenceHall.name, active " . 
               "FROM Orders, ResidenceHall WHERE orderId=%d AND Orders.hallId = ResidenceHall.hallId",
                    $orderId)));
                     
        $student = mysqli_fetch_array(mysqli_query($GLOBALS["conn"],
                sprintf("SELECT firstName, lastName FROM Student WHERE bannerId=%s",
                    $order['studentId'])));
        
        array_push($orderInfo, array($orderId, $order[1], $order[2], $order[3], $order[4]));
        array_push($orderInfo, array($student[0], $student[1]));
       
        
        $details = mysqli_fetch_all(mysqli_query($GLOBALS["conn"],
                sprintf("SELECT itemId, quantity, pizzaId FROM Order_Details WHERE orderId=%d",
                    $orderId)));
        foreach($details as $detail)
        {
            $itemId = intval($detail[0]);
            $quantity = intval($detail[1]);
            $pizzaId = intval($detail[2]);

            if ($itemId != 1)    //Is not a pizza (is an item)
            {
                $itemName = $GLOBALS["items"][$itemId - 1]["name"];
                $itemCost = floatval($GLOBALS["items"][$itemId - 1]["cost"]);
                
                array_push($orderInfo, array($itemName, $itemCost, $quantity));//Name, CostForOne , Quantity
            }
            else if ($pizzaId < 10)  //Is a specialty Pizza
            {
                $pizzaName = $GLOBALS["specCosts"][$pizzaId]["name"];
                $pizzaCost = floatval($GLOBALS["specCosts"][$pizzaId]["cost"]);
                
                array_push($orderInfo, array($pizzaName, $pizzaCost, $quantity));
            }
            else //Is a custom pizza.
            {
                $size = intval(mysqli_fetch_array(mysqli_query($GLOBALS["conn"],
                                sprintf("SELECT pizzaSize FROM Pizza WHERE pizzaId=%d",
                                    $pizzaId)))[0]);
                $size = ($size == 0 ? "Medium" : "Large");

                $toppings = mysqli_fetch_all(mysqli_query($GLOBALS["conn"],
                    sprintf("SELECT toppingId FROM Pizza_Toppings WHERE pizzaId=%d",
                        $pizzaId)));
                
                $toppingNames = array();
                foreach ($toppings as $topping)
                {
                    array_push($toppingNames, $GLOBALS["toppings"][intval($topping[0]) - 1]['name']);
                }

                $pizzaCost = ($size == 0 ? 7.99 : 11.25);
                $pizzaCost += ($size == 0 ? 1.45 : 1.69) * count($toppings);

                array_push($orderInfo, array("Custom Pizza", $pizzaCost, $quantity, $size, $toppingNames));
            }
        }
    }
?>

<script >
    var orderInfo = <?php echo json_encode($orderInfo); ?>;
</script>
