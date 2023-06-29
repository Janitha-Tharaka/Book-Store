<center>
    <h1 class="main-heading"> <?php echo $title; ?> </h1>

    <?php 
        if($cart_main_details){
    ?>
        <h3> 
            Cart ID - <?php echo $cart_main_details[0]['cart_id']; ?> 
        </h3>
        <form name="addToCart" method="POST" action="<?php echo base_url('cart_con/send_to_checkout'); ?>" autocomplete="off">

            <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $cart_main_details[0]['cart_id']; ?> ">
            <div class="col-sm-12 card book_div">
                <div class="card-body">
                    <h5 class="card-title">Books You Have in the Cart</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Book Id</th>
                                <th scope="col">Book Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price (USD)</th>
                                <th scope="col">Add/Remove Items</th>
                                <th scope="col">Total (USD)</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="books_load_cart"> 
                            <?php
                                $i = 0;
                                foreach($cart_item_details as $cart){ 
                                    ?>
                                    <tr id="rowID_<?php echo $i; ?>">
                                        <td>
                                            <?php echo $cart['book_id']; ?>
                                            <input type='text' class='form-control hide' id='book_id_<?php echo $i; ?>' name='book_id_<?php echo $i; ?>' value='<?php echo $cart['book_id']; ?>'>
                                        </td>
                                        <td>
                                            <?php echo $cart['book_name']; ?>
                                        </td>
                                        <td>
                                            <input type='text' readonly class='form-control' id='stock_<?php echo $i; ?>' name='stock_<?php echo $i; ?>' value='<?php echo $cart['stock']; ?>'>
                                        </td>
                                        <td>
                                            <input type='text' readonly class='form-control text-end' id='price_<?php echo $i; ?>' name='price_<?php echo $i; ?>' value='<?php echo $cart['price']; ?>'>
                                        </td>
                                        <td class="flex">
                                            <button type='button' id='minusButton_<?php echo $i; ?>' onClick='changeAmountMinus(<?php echo $cart['category_id'] . ',' . $i; ?>)' class='btn btn-danger h-50'>-</button> 
                                            <input type='text' style='margin:0px 5px;' readonly class='form-control' id='amount_<?php echo $i; ?>' name='amount_<?php echo $i; ?>' value='<?php echo $cart['ordered_items']; ?>'> 
                                            <button type='button' id='plusButton_<?php echo $i; ?>'  onClick='changeAmountPlus(<?php echo $cart['category_id'] . ',' . $i; ?>)' class='btn btn-success h-50'>+</button>
                                        </td>
                                        <td>
                                            <input type='text' readonly class='form-control text-end' id='final_price_<?php echo $i; ?>' name='final_price_<?php echo $i; ?>' value='<?php echo $cart['total']; ?>'>
                                        </td>
                                        <td>
                                            <button type='button' id='removeButton<?php echo $i; ?>'  onClick='removeItem(<?php echo $cart['category_id'] . ',' . $i; ?>)' class='btn btn-danger h-50'>Remove</button>
                                        </td>
                                    </tr>
                            <?php    
                                    $i++;
                                }
                            ?>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><input type='text' readonly class='form-control' id='total_items' name='total_items' value='<?php echo $cart_main_details[0]['total_items']; ?>'></td>
                                <td><input type='text' readonly class='form-control text-end' name='total_amount' id='total_amount' value='<?php echo $cart_main_details[0]['total_amount']; ?>'></td>
                            </tr>

                            <input type="hidden" name="child_books_total_amount" id="child_books_total_amount" value="<?php echo $cart_main_details[0]['child_books_total_amount']; ?>">
                            <input type="hidden" name="tech_books_total_amount" id="tech_books_total_amount" value="<?php echo $cart_main_details[0]['tech_books_total_amount']; ?>">
                            <input type="hidden" name="child_books_total_items" id="child_books_total_items" value="<?php echo $cart_main_details[0]['child_books_total_items']; ?>">
                            <input type="hidden" name="tech_books_total_items" id="tech_books_total_items" value="<?php echo $cart_main_details[0]['tech_books_total_items']; ?>">
                            
                            <input type="hidden" name="child_books_total_amount_no_disc" id="child_books_total_amount_no_disc" value="<?php echo $cart_main_details[0]['child_books_total_amount_no_disc']; ?>">
                            <input type="hidden" name="total_amount_no_disc" id="total_amount_no_disc" value="<?php echo $cart_main_details[0]['total_amount_no_disc']; ?>">
                            
                        </tbody>
                    </table>
                    
                </div>
            </div>

            <input type="hidden" name="table_rows" id="table_rows" value="<?php echo $i; ?>">

            <button class="btn btn-primary buy_buton" type="submit"> Check Out </button>

        </form>
    <?php 
        }else{ ?>
            <h1>
                Please Add Books to the Cart.
            </h1>
    <?php    }
    ?>
</center>