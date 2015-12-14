function writeReceipt() {
    var toWrite = '<head>'
                +   '<title>Receipt for Order #' + orderInfo[0][0] + '</title>'
                + '</head>'
                + '<body>'
                +   '<h2>Receipt for Order #' + orderInfo[0][0] + '</h2>'
                +   '<p>This is the receipt for the order that was recently submitted.  If you would like to cancel or modify this order,  please call us at 828-262-2101.</p>'
                +   'Date/Time Ordered: ' + orderInfo[0][1] + '<br>'
                +   'Name: ' + orderInfo[1][0] + ' ' + orderInfo[1][1] + '<br>'
                +   'Total Cost: $' + calcTotal() + '<br>'
                +   'Delivery?: ' + isOrderDelivery() + '<br><br>'
                +   'Order Status: ' + (orderInfo[0][4] == 1 ? 'In-Progress' : 'Completed') + '<br><br>'
                +   '<table id="t01">'
                +     '<tbody>'
                +       '<tr>'
                +         '<th>Item</th>'
                +         '<th>Quantity</th>'
                +         '<th>Cost</th>'
                +       '<tr>';
                                
                for (var i = 2; i < orderInfo.length; i++)
                {
                    var cost = orderInfo[i][1];
                    var quantity = orderInfo[i][2];
                   toWrite += '<tr>'
                            +   '<td>' + getName(i) + '</td>'
                            +   '<td>' + quantity + 'x $' + cost + '</td>'
                            +   '<td>$'  + (((cost * 100)  * quantity) / 100).toFixed(2) + '</td>'
                            + '<tr>';
                }
       toWrite +=     '</tbody>'
                +   '</table>';
                + '</body>';

    document.getElementById('receiptItems').innerHTML = toWrite;
}

function calcTotal()
{
    var total = 0;
    for (var k = 2; k < orderInfo.length; k++)
    {
        total += (orderInfo[k][1] * 100) * orderInfo[k][2];
    }
    return (total / 100).toFixed(2);
}

function isOrderDelivery()
{
    if(orderInfo[0][3] != 1)
    {
        return "Yes:  Deliver to " + orderInfo[0][3];
    }
    else
    {
        return "No:  This order is for pickup.";
    }
}

function getName(index)
{
    if (orderInfo[index].length > 3)
    {
        var name = "Custom Pizza: [" + orderInfo[index][3] + "]<br><pre>";
        if (orderInfo[index][4].length == 0)
        {
            name += "-   Cheese Only<br>";
        }
        else
        {
            for (var j = 0; j < orderInfo[index][4].length; j++)
            {
                name += "-   " + orderInfo[index][4][j] + "<br>";
            }
        }
        name += '</pre>';
        return name;
    }
    else
    {
        return orderInfo[index][0];
    }

}

$(document).ready(function() {
	if (orderInfo == null) {
	    var errorCode = '<head>'
                      +   '<title>Oops! An error!</title>'
                      + '</head>'
                      + '<body>'
                      +   '<h1>We\'ve encountered an error processing your order!</h1>'
                      +   '<p>If you just completed an order and have received this message in error, please call us at 828-262-2101</p>'
                      + '</body>';
	    document.getElementById('receiptItems').innerHTML = errorCode;
	}
	else {
        
	    writeReceipt();
	}
});
