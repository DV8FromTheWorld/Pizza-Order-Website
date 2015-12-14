<head>
    <title>Worker Interface</title>
</head>

<?php
    

?>

<div id="orders"> </div>


<script type="text/javascript">
    var orders = "http://student.cs.appstate.edu/classes/3430/151/team2/orders.php";    
    var timer = setInterval(function() {updateOrderList();}, 3000);
    updateOrderList();
    function updateOrderList()
    {
        document.getElementById("orders").innerHTML='<iframe id="page" src="' + orders  
               + '" width="100%" height="4000" frameborder="0" scrolling="no"></iframe>';        
    }
</script>
