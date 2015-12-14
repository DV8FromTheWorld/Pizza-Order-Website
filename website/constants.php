<?php
    include_once('connect.php');
    
    $toppings = array();
    $items = array();
    $dorms = array();
    $specCosts = array();

    populateArray(mysqli_query($GLOBALS["conn"], "SELECT toppingId, name FROM Toppings"), $toppings);
    populateArray(mysqli_query($GLOBALS["conn"], "SELECT itemId, name, cost FROM Items"), $items);
    populateArray(mysqli_query($GLOBALS["conn"], "SELECT hallId, name FROM ResidenceHall WHERE hallId != 1"), $dorms);
    populateArray(mysqli_query($GLOBALS["conn"], "SELECT cost, name FROM Pizza WHERE pizzaId < 10 AND pizzaId > 1"), $specCosts);

    function populateArray($query, &$array)
    {
        while($value = mysqli_fetch_array($query))
        {
            $array[] = $value;
        }
    }
?>

<script>
    var moreTop  = <?php echo json_encode($toppings); ?>;
    var items =  <?php echo json_encode($items); ?>;
    var dorms = <?php echo json_encode($dorms); ?>;
    var specCosts = <?php echo json_encode($specCosts); ?>;
</script>

