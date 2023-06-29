// First, I wanted to allow users to select products only choosing one category. Thats why I used the below JSON to get data
// But it was wrong. So created new one.

/* function loadBooks() {
    var category_id = document.getElementById('category_id').value;

    console.log("Selected Category is = " + category_id);

    $.ajax({
        url: 'http://localhost/book_store/home_con/load_books',
        type: 'POST',
        data: {
            "category_id": category_id,
        },
        success: function (data) {
            var json_value = JSON.parse(data);

            console.log(json_value);

            var hideElements = document.getElementsByClassName('hide_used');
            for (var i = 0; i < hideElements.length; i++) {
                hideElements[i].classList.remove('hide');
            }

            var tableElement = document.getElementById('books_load');

            // Clear existing data
            tableElement.innerHTML = '';

            var noStock = "";

            // Add rows to the table from JSON data
            for (var i = 0; i < json_value.length; i++) {

                if (json_value[i].stock == 0) {
                    noStock = "disabled";
                }

                var row = tableElement.insertRow();
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                cell1.innerHTML = json_value[i].book_id + "<input type='text' class='form-control hide' id='book_id_" + i + "' name='book_id_" + i + "' value='" + json_value[i].book_id + "'>";
                cell2.textContent = json_value[i].book_name;
                cell3.innerHTML = "<input type='text' readonly class='form-control' id='stock_" + i + "' name='stock_" + i + "' value='" + json_value[i].stock + "'>";
                cell4.innerHTML = "<input type='text' readonly class='form-control text-end' id='price_" + i + "' name='price_" + i + "' value='" + json_value[i].price + "'>";
                cell5.innerHTML = "<button type='button' disabled id='minusButton_" + i + "' onClick='changeAmountMinus(" + i + ")' class='btn btn-danger h-50'>-</button>" + "<input type='text' style='margin:0px 5px;' readonly class='form-control' id='amount_" + i + "' name='amount_" + i + "' value='0'>" + "<button type='button' " + noStock + " id='plusButton_" + i + "'  onClick='changeAmountPlus(" + i + ")' class='btn btn-success h-50'>+</button>";
                cell5.classList.add('flex');
                cell6.innerHTML = "<input type='text' readonly class='form-control text-end' id='final_price_" + i + "' name='final_price_" + i + "' value='0.00'>";
            }

            var row = tableElement.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            cell1.innerHTML = "";
            cell2.innerHTML = "";
            cell3.innerHTML = "";
            cell4.innerHTML = "";
            cell5.innerHTML = "<input type='text' readonly class='form-control' id='total_items' name='total_items' value='0'>";
            cell6.innerHTML = "<input type='text' readonly class='form-control text-end' name='total_amount' id='total_amount' value='0'>";



            document.getElementById('table_rows').value = json_value.length;

        }

    });

} */

function loadBooks() {
    var category_id = document.getElementById('category_id').value;
    console.log("Selected Category is = " + category_id);
    var child_books = document.getElementById('child_books');
    var tech_books = document.getElementById('tech_books');

    var hideElements = document.getElementsByClassName('hide_used');
    for (var i = 0; i < hideElements.length; i++) {
        hideElements[i].classList.remove('hide');
    }

    // Showing books only according to the category
    if (category_id == 1) {
        child_books.classList.remove('hide');
        tech_books.classList.add('hide');
    } else if (category_id == 2) {
        tech_books.classList.remove('hide');
        child_books.classList.add('hide');
    }

}

function changeAmountPlus(cat_ID, index) {
    // Increment amount and decrement stock
    var amountInput = document.getElementById('amount_' + index);
    var stockCell = document.getElementById('stock_' + index);
    var priceCell = document.getElementById('price_' + index);
    var finalPriceCell = document.getElementById('final_price_' + index);
    var total_amountCell = document.getElementById('total_amount');
    var total_itemsCell = document.getElementById('total_items');
    var total_amount_no_discCell = document.getElementById('total_amount_no_disc');

    var total_amount_childCell = document.getElementById('child_books_total_amount');
    var total_amount_child_no_discCell = document.getElementById('child_books_total_amount_no_disc');
    var total_amount_techCell = document.getElementById('tech_books_total_amount');
    var total_items_childCell = document.getElementById('child_books_total_items');
    var total_items_techCell = document.getElementById('tech_books_total_items');

    // Parse the values to integers or floats
    var amount = parseInt(amountInput.value);
    var stock = parseInt(stockCell.value);
    var price = parseFloat(priceCell.value);
    var final_price = parseFloat(finalPriceCell.value);
    var total_amount = parseFloat(total_amountCell.value);
    var total_items = parseFloat(total_itemsCell.value);
    var total_amount_no_disc = parseFloat(total_amount_no_discCell.value);

    var total_amount_child = parseFloat(total_amount_childCell.value);
    var total_amount_child_no_disc = parseFloat(total_amount_child_no_discCell.value);
    var total_amount_tech = parseFloat(total_amount_techCell.value);
    var total_items_child = parseFloat(total_items_childCell.value);
    var total_items_tech = parseFloat(total_items_techCell.value);

    // Verify the retrieved values
    // console.log("Amount = " + amount);
    // console.log("Stock = " + stock);
    // console.log("Price = " + price);
    // console.log("Final price = " + final_price);

    if (stock > 0) {
        amount += 1;
        stock -= 1;
        final_price += price;
        total_amount += price;
        total_amount_no_disc += price;
        total_items += 1;

        // Categorywise amount and item count calculated
        if (cat_ID == 1) {
            total_amount_child += price;
            total_amount_child_no_disc += price;
            total_items_child += 1;
        } else if (cat_ID == 2) {
            total_amount_tech += price;
            total_items_tech += 1;
        }

        amountInput.value = amount;
        stockCell.value = stock;
        finalPriceCell.value = final_price.toFixed(2);
        total_amountCell.value = total_amount.toFixed(2);
        total_itemsCell.value = total_items;
        total_amount_no_discCell.value = total_amount_no_disc.toFixed(2);

        total_amount_childCell.value = total_amount_child.toFixed(2);
        total_amount_child_no_discCell.value = total_amount_child_no_disc.toFixed(2);
        total_amount_techCell.value = total_amount_tech.toFixed(2);
        total_items_childCell.value = total_items_child;
        total_items_techCell.value = total_items_tech;

        // Remove 'disable' class from minusButton
        var minusButton = document.getElementById('minusButton_' + index);
        minusButton.disabled = false;

        // Category wise getting totals


    } else if (stock == 0) {
        // Remove 'disable' class from minusButton
        var plusButton = document.getElementById('plusButton_' + index);
        plusButton.disabled = true;
    }

    checkDiscounts();
}

function changeAmountMinus(cat_ID, index) {
    // Increment amount and decrement stock
    var amountInput = document.getElementById('amount_' + index);
    var stockCell = document.getElementById('stock_' + index);
    var priceCell = document.getElementById('price_' + index);
    var finalPriceCell = document.getElementById('final_price_' + index);
    var total_amountCell = document.getElementById('total_amount');
    var total_itemsCell = document.getElementById('total_items');
    var total_amount_no_discCell = document.getElementById('total_amount_no_disc');

    var total_amount_childCell = document.getElementById('child_books_total_amount');
    var total_amount_child_no_discCell = document.getElementById('child_books_total_amount_no_disc');
    var total_amount_techCell = document.getElementById('tech_books_total_amount');
    var total_items_childCell = document.getElementById('child_books_total_items');
    var total_items_techCell = document.getElementById('tech_books_total_items');

    // Parse the values to integers or floats
    var amount = parseInt(amountInput.value);
    var stock = parseInt(stockCell.value);
    var price = parseFloat(priceCell.value);
    var final_price = parseFloat(finalPriceCell.value);
    var total_amount = parseFloat(total_amountCell.value);
    var total_items = parseFloat(total_itemsCell.value);
    var total_amount_no_disc = parseFloat(total_amount_no_discCell.value);

    var total_amount_child = parseFloat(total_amount_childCell.value);
    var total_amount_child_no_disc = parseFloat(total_amount_child_no_discCell.value);
    var total_amount_tech = parseFloat(total_amount_techCell.value);
    var total_items_child = parseFloat(total_items_childCell.value);
    var total_items_tech = parseFloat(total_items_techCell.value);

    if (amount > 0) {
        amount -= 1;
        stock += 1;
        final_price -= price;
        total_amount -= price;
        total_amount_no_disc -= price;
        total_items -= 1;

        // Categorywise amount and item count calculated
        if (cat_ID == 1) {
            total_amount_child -= price;
            total_amount_child_no_disc -= price;
            total_items_child -= 1;
        } else if (cat_ID == 2) {
            total_amount_tech -= price;
            total_items_tech -= 1;
        }

        amountInput.value = amount;
        stockCell.value = stock;
        finalPriceCell.value = final_price.toFixed(2);
        total_amountCell.value = total_amount.toFixed(2);
        total_itemsCell.value = total_items;
        total_amount_no_discCell.value = total_amount_no_disc.toFixed(2);

        total_amount_childCell.value = total_amount_child.toFixed(2);
        total_amount_child_no_discCell.value = total_amount_child_no_disc.toFixed(2);
        total_amount_techCell.value = total_amount_tech.toFixed(2);
        total_items_childCell.value = total_items_child;
        total_items_techCell.value = total_items_tech;

        if (stock > 0) {
            // Remove 'disable' class from plusButton
            var plusButton = document.getElementById('plusButton_' + index);
            plusButton.disabled = false;
        }


    } else if (amount == 0) {
        // Remove 'disable' class from minusButton
        var minusButton = document.getElementById('minusButton_' + index);
        minusButton.disabled = true;
    }
    checkDiscounts();
}

function removeItem(cat_ID, index) {

    // var tableRows = document.getElementById('table_rows').value;
    // tableRows -= 1;
    // document.getElementById('table_rows').value = tableRows;

    var finalPriceCell = document.getElementById('final_price_' + index);
    var amountInput = document.getElementById('amount_' + index);
    var total_amountCell = document.getElementById('total_amount');
    var total_itemsCell = document.getElementById('total_items');

    var total_amount_no_discCell = document.getElementById('total_amount_no_disc');

    var total_amount_childCell = document.getElementById('child_books_total_amount');
    var total_amount_child_no_discCell = document.getElementById('child_books_total_amount_no_disc');
    var total_amount_techCell = document.getElementById('tech_books_total_amount');
    var total_items_childCell = document.getElementById('child_books_total_items');
    var total_items_techCell = document.getElementById('tech_books_total_items');

    var final_price = parseFloat(finalPriceCell.value);
    var amount = parseInt(amountInput.value);
    var total_amount = parseFloat(total_amountCell.value);
    var total_items = parseFloat(total_itemsCell.value);

    var total_amount_no_disc = parseFloat(total_amount_no_discCell.value);
    var total_amount_child = parseFloat(total_amount_childCell.value);
    var total_amount_child_no_disc = parseFloat(total_amount_child_no_discCell.value);
    var total_amount_tech = parseFloat(total_amount_techCell.value);
    var total_items_child = parseFloat(total_items_childCell.value);
    var total_items_tech = parseFloat(total_items_techCell.value);

    total_amount -= final_price;
    total_amount_no_disc -= final_price;

    total_items -= amount;

    // Categorywise amount and item count calculated
    if (cat_ID == 1) {
        total_amount_child -= final_price;
        total_amount_child_no_disc -= final_price;
        total_items_child -= 1;
    } else if (cat_ID == 2) {
        total_amount_tech -= final_price;
        total_items_tech -= 1;
    }

    total_amountCell.value = total_amount.toFixed(2);
    total_itemsCell.value = total_items;

    total_amount_child_no_discCell.value = total_amount_child_no_disc.toFixed(2);
    total_amount_childCell.value = total_amount_child.toFixed(2);
    total_amount_techCell.value = total_amount_tech.toFixed(2);
    total_items_childCell.value = total_items_child;
    total_items_techCell.value = total_items_tech;

    var row = document.getElementById('rowID_' + index);
    row.remove();

    checkDiscounts();

}

function checkDiscounts() {
    // Increment amount and decrement stock
    var total_amountCell = document.getElementById('total_amount');
    var total_amount_no_discCell = document.getElementById('total_amount_no_disc');

    var total_amount_childCell = document.getElementById('child_books_total_amount');
    var total_amount_child_no_discCell = document.getElementById('child_books_total_amount_no_disc');
    var total_amount_techCell = document.getElementById('tech_books_total_amount');
    var total_items_childCell = document.getElementById('child_books_total_items');
    var total_items_techCell = document.getElementById('tech_books_total_items');

    // Parse the values to integers or floats
    var total_amount = parseFloat(total_amount_no_discCell.value);

    var total_amount_child = parseFloat(total_amount_childCell.value);
    var total_amount_child_no_disc = parseFloat(total_amount_child_no_discCell.value);
    var total_amount_tech = parseFloat(total_amount_techCell.value);
    var total_items_child = parseFloat(total_items_childCell.value);
    var total_items_tech = parseFloat(total_items_techCell.value);

    // Children Books Discount. If children books are over 5
    if (total_items_child >= 5) {
        total_amount_child = total_amount_child_no_disc - (total_amount_child_no_disc * 10) / 100;
    } else {
        total_amount_child = total_amount_child_no_disc;
    }

    total_amount = total_amount_child + total_amount_tech;

    // Grand Discount. If each category has more than 10 books taken
    if (total_items_child >= 10 && total_items_tech >= 10) {
        total_amount = total_amount - (total_amount * 5) / 100;
    }

    total_amountCell.value = total_amount.toFixed(2);

    total_amount_childCell.value = total_amount_child.toFixed(2);
    total_amount_techCell.value = total_amount_tech.toFixed(2);
    total_items_childCell.value = total_items_child;
    total_items_techCell.value = total_items_tech;
}

function checkCoupanCode() {
    var coupan_code = document.getElementById('coupan_code').value;
    var cart_id = document.getElementById('cart_id').value;

    console.log("Coupan = " + coupan_code);

    if (coupan_code == '123') {
        $.ajax({
            url: 'http://localhost/book_store/checkout_con/check_coupan',
            type: 'POST',
            data: {
                "cart_id": cart_id,
            },
            success: function (data) {
                var json_value = JSON.parse(data);
                console.log(json_value);

                if (json_value == 'success') {
                    location.reload();
                } else {
                    alert("Error: " + json_value);
                }

            },
            error: function (xhr, status, error) {
                // Show error message
                var errorMessage = xhr.responseText;
                alert("Error: " + errorMessage);
            }

        });
    } else {
        alert("Invalid coupon code!");
    }

}