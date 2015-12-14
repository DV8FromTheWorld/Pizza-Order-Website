<?php
    include_once('includes/header.php');
    include_once('includes/sitenav.php');
    include_once('includes/sidebar.php'); 
    include_once('connect.php');
    include_once('constants.php');
?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="styles/index.css" />


<div id="content">
  <div class="box">
    <h1>The Pizzeria Order Form</h1>
  </div>
  <div id="maintext">
	<title>Pizzeria Order Form</title>
	<center>
	<p style="font-size:16px">

        </p>
    <div style="padding-top:50%; height:260px; background: url(http://foodservices.appstate.edu/sites/foodservices.appstate.edu/files/images/thepizzeria.web_.jpg) 50% 50% no-repeat;" />
    </center>

    <center>
<div class="order_contain">
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" onclick="resetDropdown()">
  Click to add an item!
</button>

<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" id="modalSize">
    <div class="modal-content">
      <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Item</h4>
      </div>
      <div class="modal-body">
       <div id="itemContents"></div>
        <div class="dropdown" id="dropchoice">
          <button class="btn btn-primary" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Select your item
<span class="caret">
</span>


      </button>
    <ul class="dropdown-menu">
      <li onclick="specialList()">Specialty Pizza</li>
      <li onclick="toppingList(moreTop)">Create Your Own Pizza </li>
      <li class="divider"></li>
      <li onclick="addExtra(2)">Cheese Bread</li>
      <li onclick="addExtra(4)">Cinnamon Knots</li>
      <li class="divider"></li>
      <li onclick="addExtra(5)">Ranch</li>
      <li onclick="addExtra(6)">Marinara</li>
    </ul>
    </div>
       
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="submitButton">Add Item</button>
      </div>
    </div>
  </div>
</div>
</div>
</center>
<div class="order-summary" id="order-summary"> 

</div>
<div id="orderButtonsContain">
  <div id="costContain" class="costContain"></div>
  <div id="orderButtons" class="orderButtons"></div>
</div>


<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="cutomerModalLabel">Finalize Order</h4>
      </div>
    <center>
      <div id="customer-modal-body" class="customer-modal-body custInfoForm">

      </div>
</center>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Edit Order</button>
        <button type="button" id="completeOrder" class="btn btn-primary">Complete Purchase</button>
      </div>
    </div>
  </div>
</div>


<?php include_once('includes/footer.php'); ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="bootstrap/js/jquery.maskedinput.js"></script>
<script src="js/methods.js"></script>
<script src="bootstrap/js/spin.min.js"></script>
