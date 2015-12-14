<head>
    <title>Order Listing</title>
<head>

<?php
    include_once('connect.php');

    $items = array();
    $itemQuery = mysqli_query($GLOBALS['conn'],
            "SELECT name FROM Items;");
    while ($value = mysql_fetch_array($itemQuery))
    {
        $items[] = $value;
    }
    
    $pizzas = array();
    $pizzaQuery = mysqli_query($GLOBALS['conn'],
            "SELECT name FROM Pizza WHERE pizzaId < 10;");
    while($value = mysql_fetch_array($pizzaQuery))
    {
        $pizzas[] = $value;
    }


    echo "I am le orders<br><br>";
    getOrderList(); 

    function getOrderList()
    {
        $details = "<pre>   ";
        $order = mysqli_query($GLOBALS['conn'],
                "SELECT orderId FROM Orders;");

        while ($row = mysqli_fetch_array($order))
        {
            echo 'orderId: ' . $row['orderId'] . "<br>";
            $order_details = mysqli_query($GLOBALS['conn'],
                "SELECT itemId, quantity, pizzaId FROM Order_Details
                    WHERE orderId={$row['orderId']} ORDER BY itemId ASC;");
            
            while ($row2 = mysqli_fetch_array($order_details))
            {
                if ($row2['itemId'] == 1)
                {
                    $pizza = mysqli_fetch_array(mysqli_query($GLOBALS['conn'], 
                        "SELECT name,cost,pizzaSize FROM Pizza WHERE pizzaId={$row2['pizzaId']};"));
                    echo sprintf("<pre> %s, \$%.2f, %s, Quantity: %d",
                        $pizza['name'],
                        $pizza['cost'],
                        ($pizza['pizzaSize'] == 0 ? "Medium" : "Large"),
                        $row2['quantity']);
                    echo "<br>";
                }
                else
                {
                    
                }
            }
            echo '<pre>   stuff here<br><br>';
        }
    }
?>
