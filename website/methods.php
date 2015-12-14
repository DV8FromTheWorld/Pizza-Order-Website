<?php

    /**
     * File Documentation.
     *
     * This file contains all method needed to interface with the MySQL Database
     * for inserting all nessessary information for an order.
     *
     *
     * Methods:
     *
     *  makeStudent(String bannerId, String firstName, String lastName, String email, String phoneNumber)
     *      Required parameters: ALL
     *      Return: boolean value based on successful insert.
     *
     *  makeOrder(String bannerId, int workerId, int hallId)
     *      Required parameters: bannerId
     *      Return: orderId as an Int. If fail, returns -1.
     *
     *  makeCustomPizza(int size, int[] toppingIds)
     *      Required parameters: ALL
     *      Return: pizzaId as an Int. If fail, returns -1.
     *
     *  makeOrderDetailPizza(int orderId, int quantity, int pizzaId)
     *      Required parameters: ALL
     *      Return: boolean value based on successful insert.
     *
     *  makeOrderDetailItem(int orderId, int quantity, int itemId)
     *      Required paramters: ALL
     *      Return: boolean values based on successful insert.
     */
    require_once('connect.php');

    //String, String, String, String, String
    function makeStudent($bannerId, $firstName, $lastName, $email, $phoneNumber)
    {
        $query = mysqli_query($GLOBALS["conn"],
            'INSERT INTO Student
            (bannerId, firstName, lastName, email, phoneNumber)
             VALUES ("'
                . $bannerId . '", "' 
                . $firstName .'", " '
                . $lastName . '", "'
                . $email .    '", "'
                . $phoneNumber . '");');        
        //return mysqli_affected_rows($connection) == 1;
        return $query;  //If the query was sucessful, it returns true.
    }

    //String, int, int
    function makeOrder($bannerId, $workerId = 'NULL', $hallId = 1)
    {
        $orderExists = mysqli_fetch_all( mysqli_query($GLOBALS["conn"],
            'SELECT * FROM Orders WHERE studentId="' . $bannerId . '" AND active=1'));
        if (count($orderExists) > 0)
        {
            return -2;  //An order by this student already exists and is active.
        }

        $date = date("Y-m-d H:i:s");
        $query = mysqli_query($GLOBALS["conn"],
            'INSERT INTO Orders
            (timeOrdered, studentId, hallId, workerId)
            VALUES ("'
                . $date . '", "'                
                . $bannerId . '", '      //A lack of a " is intended. Check above comment about NULL.
                . $hallId . ', '         //This should have no surrounding "'s
                . $workerId . ');');     //Same with this.
        
        //TODO: Check if fail. return AUTO_INCREMENT on non-fail.
        return $query ? getAutoIncrementId() : -1;    
    }
    
    //int, int[]
    function makeCustomPizza($size, $toppingIds)
    {
        $cost = 0.0;
        $cost += ($size == 0) ? 7.99 : 11.25;
        $cost += count($toppingIds) * (($size == 0) ? 1.45 : 1.69); 
        $query = mysqli_query($GLOBALS["conn"], 'INSERT INTO Pizza (cost, pizzaSize) VALUES (' . $cost . ', ' . $size . ');');
        
        if (!$query) return -1;
         
        $pizzaId = getAutoIncrementId();
        for ($i = 0; $i < count($toppingIds); $i++)
        {
           $query2 = mysqli_query($GLOBALS["conn"], 'INSERT INTO Pizza_Toppings VALUES (' . $pizzaId . ', '
                                                                       . $toppingIds[$i] . ');');
           if (!$query) return -1;
        }
        return $pizzaId;
    }

    //int, int, int
    function makeOrderDetailPizza($orderId, $quantity, $pizzaId)
    {
        $row = mysqli_fetch_array(mysqli_query($GLOBALS["conn"], 'SELECT cost FROM Pizza WHERE pizzaId=' . $pizzaId . ';')); 
        return makeOrderDetail($orderId, 1, $quantity, $pizzaId, $row["cost"]);
    }

    //int, int, int
    function makeOrderDetailItem($orderId, $quantity, $itemId)
    {
        $row = mysqli_fetch_array(mysqli_query($GLOBALS["conn"], 'SELECT cost FROM Items WHERE itemId=' . $itemId . ';'));
        return makeOrderDetail($orderId, $itemId, $quantity, 1, $row["cost"]);
    }
    
    //------- Internal Methods, Dont use ---------
    //int, int, int, int, float
    function makeOrderDetail($orderId, $itemId, $quantity, $pizzaId, $cost) 
    {
        $query = mysqli_query($GLOBALS["conn"],
            'INSERT INTO Order_Details
            (orderId, itemId, quantity, pizzaId)
            VALUES ('
                . $orderId  . ', '
                . $itemId   . ', '
                . $quantity . ', '
                . $pizzaId  . ');');
        if (!$query) return false;
        updateTotalCost($orderId, ($cost * $quantity));
        return true;
    }

    //int, float
    function updateTotalCost($orderId, $costToAdd)
    {
        $row = mysqli_fetch_array(mysqli_query($GLOBALS["conn"],
                "SELECT totalCost FROM Orders WHERE orderId=" . $orderId . ";"));
        if (!$row) return false;
        
        $query = mysqli_query($GLOBALS["conn"],
                'UPDATE Orders SET totalCost='
                    . ($row["totalCost"] + $costToAdd)
                    . " WHERE orderId={$orderId};");
        return $query;
    }
    
    function getLeastBusyWorker()
    {
        $workers = mysqli_fetch_all(mysqli_query($GLOBALS["conn"],
                "Select Worker.workerId " .
                "FROM Worker " .
                "LEFT JOIN Orders " .
                "ON Worker.workerId = Orders.workerId AND active = 1 " .
                "GROUP BY workerId " .
                "ORDER BY COUNT(Orders.workerId) ASC, workerId ASC"));
        return intval($workers[0][0]); 
    }
    

    function getAutoIncrementId()
    {
        return mysqli_insert_id($GLOBALS["conn"]);
    }
?>
