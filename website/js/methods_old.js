var postOrder = [];

  var names = ["Bacon & Cheddar", "Chicken Bacon Ranch", "Hawaiian", "Hot Wing", "Meat Lovers", "Steak & Cheese",
           "Supreme", "Veggie"];

  var descs = ["Bacon, cheddar, marinara and more cheddar.", 
           "Garlic butter base with ranch-marinated chicken, bacon, oregano and a ranch dressing drizzle.",
           "Ham and pineapple. Simple and delicious.", 
           "Hot sauce base with marinated chicken, cheese and a ranch dressing drizzle.", 
           "All your favorites - pepperoni, ham, beef, sausage and bacon.",
           "Steak and piles of cheese with a steak sauce drizzle.",
           "Pepperoni, sausage, beef, green peppers, onions, mushrooms and black olives.",
           "Veggie heaven - green peppers, onions, mushrooms, black olives and tomatoes."];



function buildDropdownRemove(index) {
  var selectedQuantity = postOrder[index][1];
  var divText = '<i onclick="removeOrderItem(' + index + ')" class="rmX glyphicon glyphicon-remove"></i><select id="quantity_' + index + '" class="dropdownNum">';
  for (j = 1; j < 11; j++) {
    if (selectedQuantity == j) {
      divText += '<option selected="selected" value="' + j + '">' + j + '</option>';
    }
    else 
      divText += '<option value="' + j + '">' + j + '</option>';
  }
  divText += '</select>';

  if (postOrder[index][0] == 0) //If this detail is a custom Pizza.
  {
    divText += '<select id="size_' + index + '" class="dropdownNum">';
    if (postOrder[index][3] == 0) //If size is medium
    {
        divText += '<option selected="selected" value="0">Medium</option>';
        divText += '<option value="1">Large</option>';
    }
    else
    {
        divText += '<option value="0">Medium</option>';
        divText += '<option selected="selected" value="1">Large</option>';
    }
    divText += '</select>';
  }
  return divText;
}

function specialList() {
  document.getElementById("modalSize").className = "modal-dialog-double";
  document.getElementById("myModalLabel").innerHTML = "Choose your specialty pizza";
  document.getElementById("dropchoice").style.visibility='hidden';

  var str = '<div class="modalColLeft">';

  for (i = 0; i < names.length; i++)
    {

      if (i == names.length / 2) {
         str += '</div><div class="modalColRight">';
      }

      str += '<a class="specLinks"><div class="panel panel-default specLinks" id="spec_' + (i + 2) + '" onclick="selectedSpec(' + (i + 2) + ')"' 
        + '><div class="panel-heading"><h3 class="panel-title">' 
        + names[i] 
        + '</h3></div><div class="panel-body"><img class="pizzaPic" src="images/pizzas/' + names[i] + '.png">'
    + descs[i] + '</div></div></a>';
    }

    str += '</div>';

    document.getElementById("itemContents").innerHTML = str;
}

    function toppingList(moreTop) {
      document.getElementById("dropchoice").style.visibility='hidden';
      document.getElementById("myModalLabel").innerHTML = "Choose Toppings";
      document.getElementById("submitButton").innerHTML = "Add Items";
        bob = "<p>For cheese only, select no toppings.</p>";
      //bob = '<form id="confirmationForm"><label class="radioLabel"><input onchange="setSelectable()" class="yesNoRadio" id="yes" type="radio" name="radio" value="yes" checked>Custom Pizza</label><label class="radioLabel"><input onchange="setSelectable()" class="yesNoRadio" id="no" type="radio" name="radio" value="no">Cheese Only</label></form>';
      
      bob += '<form id="toppingForm"><div id="hideSelections" class="disabledInactive"><div class="modalColLeft">';
      for(i = 0; i < moreTop.length; i++) {

        if (i == moreTop.length / 2) {
      bob += '</div><div class="modalColRight">';
    }


        bob += '<label><input class="toppingCheckbox" type="checkbox" value="top_' + moreTop[i][0] + '" >&nbsp;' + moreTop[i][1] + '</input></label><br>';
      } 
      bob += '</div></div></form>';
      document.getElementById("itemContents").innerHTML=bob;
    }

function custInfoList() {
  var form = '<p>Please fill out your information so that we may complete the purchase and adequately deliver the pizza. Note that if you choose to edit your order at this point, you will lose any information entered into this form.</p>';
  form += '<form role="form" id="custInfoForm" data-toggle="validator"><div class="input-group form-group" id="fnameCheck"><span class="input-group-addon" id="basic-addon1">First Name</span><input type="text" class="form-control" name="fname" placeholder="First Name" aria-describedby="basic-addon1" required></div></div>';
  form += '<div class="input-group form-group" id="lnameCheck"><span class="input-group-addon" id="basic-addon1">Last Name</span><input type="text" class="form-control" name="lname" placeholder="Last Name" aria-describedby="basic-addon1"></div>';
  form += '<div class="input-group form-group" id="bannerCheck"><span class="input-group-addon" id="basic-addon1">Banner ID</span><input type="text" class="form-control" name="banner" placeholder="900XXXXXX" aria-describedby="basic-addon1"></div>';
  form += '<div class="input-group form-group" id="emailCheck"><input type="text" class="form-control" name="email" placeholder="Appalachian State Email Address" aria-describedby="basic-addon2"><span class="input-group-addon" id="basic-addon2">@appstate.edu</span></div>';
  form +=  '<div class="input-group form-group" id="phoneCheck"><input type="text" class="form-control bfh-phone" name="phone" placeholder="(999) 999-9999" data-format="(ddd) ddd-dddd" data-minlength="10" required></div>';
  form += '<input name="del" type="checkbox" id="delivery">Delivery?</input>';
  form += '<select class="form-control" id="deliveryDropdown" disabled><option value="" disabled selected>Residence Hall</option>';
  for (i = 1; i < dorms.length; i++) {
    form += '<option value="' + dorms[i][0] + '">' + dorms[i][1] + '</option>';
  }
  form += '</select></form>';
  document.getElementById("customer-modal-body").innerHTML = form;
}

function submitPurchase() {
    $.ajax({
        'url'       : 'submit.php',
        'type'      : 'POST',
        //'dataType'  : 'json',
        'data'      : {order: JSON.stringify(postOrder)},
        'beforeSend': function()
        {
            //alert("sending variable");
        },
        'success'   : function(data)
        {
            alert("We recieved the following as a return: " + data); //JSON.stringify(data));
        },
        'error'     : function()
        {

        }

    });
}

function resetDropdown() {
  document.getElementById("submitButton").innerHTML = "Add Item";
  document.getElementById("myModalLabel").innerHTML = "New Item";
  document.getElementById("itemContents").innerHTML = "";
  document.getElementById("dropchoice").style.visibility='visible';
  document.getElementById("modalSize").className = "modal-dialog";
}

function selectedSpec(idNo) {

  for (i = 0; i < 8; i++)
  {
      if (document.getElementById("spec_" + (i + 2)).classList.contains("specLinksChosen")) {
          document.getElementById("spec_" + (i + 2)).className = 
              document.getElementById("spec_" + (i + 2)).className.replace(/\bspecLinksChosen\b/, "specLinks");
      }
  }

  document.getElementById("spec_" + idNo).className =
     document.getElementById("spec_" + idNo).className.replace(/\bspecLinks\b/, "specLinksChosen");
}

function confirmCancel() {
  if(confirm("Are you sure you would like to cancel your order?")) {
    window.location.href="order.php";
  }
}

function DIE() {
  $('#myModal').modal('hide');
}

function addCustom(customToppings) {
  for(i = 0; i < postOrder.length; i++) {
    if (postOrder[i][0] == 0 && postOrder[i][2].every(function(element, index) { return element === customToppings[index]; }))
    {
      alert("This custom pizza has already been added; please use the dropdown box to change quantity.");      
      DIE();
      return;
    }
  }
  postOrder.push(new Array(0, 1, customToppings, 0)); //Id: customPizza, Quantity: 1, toppingArray, size: medium
    buildOrderSummary();
}

function addSpec(specId) {
  for (i= 0; i < postOrder.length; i++)
  {
    if (postOrder[i][0] == 1 && postOrder[i][2] == specId)
    {
      alert("This specialty pizza has already been added; please use the dropdown box to change quantity.");      
      DIE();
      return;
    }
  }
  postOrder.push(new Array(1, 1, specId));
  buildOrderSummary();
}

function addExtra(extraId) {
  for (i= 0; i < postOrder.length; i++)
  {
    if (postOrder[i][0] == 2 && postOrder[i][2] == extraId)
      {
    alert("This item has already been added; please use the dropdown box to change quantity.");
    DIE();
    return;
      }
  }
  postOrder.push(new Array(2, 1, extraId));
  buildOrderSummary();
}

function removeOrderItem(index) {
  postOrder.splice(index, 1);
  buildOrderSummary();
}

function collectCustInfo() {
  var customerForm = '';
}

function setSelectable() {
  var radio = document.getElementById("yes");
  var checkArray = document.getElementsByClassName("toppingCheckbox");
  if (radio.checked)
    for(i = 0; i < checkArray.length; i++) {
      checkArray[i].disabled = false;
      document.getElementById("hideSelections").className='disabledInactive';
    }
  else
    for (i = 0; i < checkArray.length; i++) {
      checkArray[i].disabled = true;
      document.getElementById("hideSelections").className='disabledActive';
    }
}

function buildOrderSummary() {
  var toWrite = '';
  for(i = 0; i < postOrder.length; i++) {
    toWrite += ('<div id="row_' + i + '" class="orderItem">');
    switch(postOrder[i][0]) {
    case 0: 
      toWrite += 'Custom Pizza: ';
      if (postOrder[i][2].length == 1 && postOrder[i][2][0] == -1) {
    toWrite += "Cheese Only";
      }
      else {
    for (k = 0; k < postOrder[i][2].length; k++) {
      toWrite += moreTop[postOrder[i][2][k] - 1][1];
      if (k != postOrder[i][2].length - 1) {
        toWrite += ', ';
      }
    }
      }
      break;
    case 1: 
      toWrite += names[postOrder[i][2] - 2];
      break;
    case 2: 
      toWrite += items[postOrder[i][2] - 1][1];
      break;
    }
    toWrite += buildDropdownRemove(i) + '</div>';
    
  }
   
  document.getElementById("order-summary").innerHTML = toWrite;
  if (postOrder.length > 0) {
    document.getElementById("orderButtons").innerHTML = '<button type="button" class="btn btn-success finalizeOrder" id="finalizeOrder" data-toggle="modal" data-target="#customerModal" onclick="custInfoList()">Finalize Order</button><button class="btn btn-danger cancelOrder" onclick="confirmCancel()" type="button">Cancel Order</button>';
  }
  else 
  {
    document.getElementById("orderButtons").innerHTML = '';
  }
  
  DIE();

}


var toppingItems = [];

$('#submitButton').click(function() {
    toppingItems = [];
    var selectedSpecial = $(".specLinksChosen").attr('id');
   
    if ($('#toppingForm :checked').length > 0) {
        $('#toppingForm :checked').each(function() {
            toppingItems.push(parseInt($(this).val().slice(4), 10));
        });
        addCustom(toppingItems);
    }
    else if (typeof selectedSpecial === "undefined") {
      addCustom([-1]);
    }
    else {
      selectedSpecial = parseInt(selectedSpecial.slice(5), 10);
      addSpec(selectedSpecial);
    }
  }); 

$(document).on('change', 'select', function() {
    if (this.id.indexOf('quantity_') != -1)
      postOrder[this.id.slice(9)][1] = parseInt(this.value);
    if (this.id.indexOf('size_') != -1)
      postOrder[this.id.slice(5)][3] = parseInt(this.value);
  });

$(document).on('change', '#delivery', function() {
    if ($('#delivery').is(':checked')) {
      $('#deliveryDropdown').prop('disabled', false);
    }
    else {
      $('#deliveryDropdown').prop('disabled', true);
    }
  });

var insertedStudent = false;
$('#completeOrder').click(function() {
    if (!insertedStudent) {
    postOrder.splice(0, 0, new Array()); 
    postOrder[0].push($('input[name="banner"]').val());
    postOrder[0].push($('input[name="fname"]').val());
    postOrder[0].push($('input[name="lname"]').val());
    postOrder[0].push($('input[name="email"]').val());
    postOrder[0].push($('input[name="phone"]').val());
    if ($('#delivery').is(':checked'))
      postOrder[0].push(parseInt($('#deliveryDropdown option:selected').val(), 10));
    insertedStudent = true;
    }
    submitPurchase();    
  });

$(document).on('input', #custInfoForm.childNodes, function() {
    if (this.id.val().length < 2) {
        alert('butt');
        //$('#fnameCheck').addClass('has-error');
        //$('#fnameCheck').removeClass('has-success');
    }
    else {
        alert('secks');
        //$('#fnameCheck').removeClass('has-error');
        //$('#fnameCheck').addClass('has-success');
    }
    });
