<center>
    <h1 class="main-heading"> <?php echo $title; ?> </h1>

    <p class="small_desc">
        Choose a category to choose a product..
    </p>

    <form name="addToCart" method="POST" action="<?php echo base_url('home_con/send_to_cart'); ?>" autocomplete="off">

        <div class="col-sm-3 category_div">
            <select id="category_id" name="category_id" class="form-control" onchange="loadBooks();">
                <option selected disabled> Select a Category.. </option>
                <?php 
                    foreach($categories as $cat){ ?>
                        <option value="<?php echo $cat['category_id']; ?>"> <?php echo $cat['category_name']; ?> </option>
                <?php    }
                ?>
            </select>
        </div>

        <div class="col-sm-12 card hide_used book_div hide">
            <div class="card-body">
                <h5 class="card-title">Books</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Book Id</th>
                            <th scope="col">Book Name</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Price (USD)</th>
                            <th scope="col">Add/Remove Items</th>
                            <th scope="col">Total (USD)</th>
                        </tr>
                    </thead>
                    <tbody class="hide" id="child_books"> 
                        <?php
                            $i = 0;
                            $total_rows = count($child_books) + count($tech_books);
                            foreach($child_books as $child){ 
                                ?>
                                <tr id="rowID_<?php echo $i; ?>">
                                    <td>
                                        <?php echo $child['book_id']; ?>
                                        <input type='text' class='form-control hide' id='book_id_<?php echo $i; ?>' name='book_id_<?php echo $i; ?>' value='<?php echo $child['book_id']; ?>'>
                                    </td>
                                    <td>
                                        <?php echo $child['book_name']; ?>
                                    </td>
                                    <td>
                                        <input type='text' readonly class='form-control' id='stock_<?php echo $i; ?>' name='stock_<?php echo $i; ?>' value='<?php echo $child['stock']; ?>'>
                                    </td>
                                    <td>
                                        <input type='text' readonly class='form-control text-end' id='price_<?php echo $i; ?>' name='price_<?php echo $i; ?>' value='<?php echo $child['price']; ?>'>
                                    </td>
                                    <td class="flex">
                                        <button type='button' disabled id='minusButton_<?php echo $i; ?>' onClick='changeAmountMinus(1,<?php echo $i; ?>)' class='btn btn-danger h-50'>-</button> 
                                        <input type='text' style='margin:0px 5px;' readonly class='form-control' id='amount_<?php echo $i; ?>' name='amount_<?php echo $i; ?>' value='0'> 
                                        <button type='button' id='plusButton_<?php echo $i; ?>'  onClick='changeAmountPlus(1,<?php echo $i; ?>)' class='btn btn-success h-50'>+</button>
                                    </td>
                                    <td>
                                        <input type='text' readonly class='form-control text-end' id='final_price_<?php echo $i; ?>' name='final_price_<?php echo $i; ?>' value='0'>
                                    </td>
                                    <td>
                                        <button type='button' id='removeButton<?php echo $i; ?>'  onClick='removeItem(1, <?php echo $i; ?>)' class='btn btn-danger h-50'>Remove</button>
                                    </td>
                                </tr>
                        <?php    
                                $i++;
                            }
                        ?>
                    </tbody>

                    <tbody class="hide" id="tech_books"> 
                        <?php
                            foreach($tech_books as $tech){ 
                                ?>
                                <tr id="rowID_<?php echo $i; ?>">
                                    <td>
                                        <?php echo $tech['book_id']; ?>
                                        <input type='text' class='form-control hide' id='book_id_<?php echo $i; ?>' name='book_id_<?php echo $i; ?>' value='<?php echo $tech['book_id']; ?>'>
                                    </td>
                                    <td>
                                        <?php echo $tech['book_name']; ?>
                                    </td>
                                    <td>
                                        <input type='text' readonly class='form-control' id='stock_<?php echo $i; ?>' name='stock_<?php echo $i; ?>' value='<?php echo $tech['stock']; ?>'>
                                    </td>
                                    <td>
                                        <input type='text' readonly class='form-control text-end' id='price_<?php echo $i; ?>' name='price_<?php echo $i; ?>' value='<?php echo $tech['price']; ?>'>
                                    </td>
                                    <td class="flex">
                                        <button type='button' disabled id='minusButton_<?php echo $i; ?>' onClick='changeAmountMinus(2,<?php echo $i; ?>)' class='btn btn-danger h-50'>-</button> 
                                        <input type='text' style='margin:0px 5px;' readonly class='form-control' id='amount_<?php echo $i; ?>' name='amount_<?php echo $i; ?>' value='0'> 
                                        <button type='button' id='plusButton_<?php echo $i; ?>'  onClick='changeAmountPlus(2,<?php echo $i; ?>)' class='btn btn-success h-50'>+</button>
                                    </td>
                                    <td>
                                        <input type='text' readonly class='form-control text-end' id='final_price_<?php echo $i; ?>' name='final_price_<?php echo $i; ?>' value='0'>
                                    </td>
                                    <td>
                                        <button type='button' id='removeButton<?php echo $i; ?>'  onClick='removeItem(2, <?php echo $i; ?>)' class='btn btn-danger h-50'>Remove</button>
                                    </td>
                                </tr>
                        <?php    
                                $i++;
                            }
                        ?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><input type='text' readonly class='form-control' id='total_items' name='total_items' value='0'></td>
                            <td><input type='text' readonly class='form-control text-end' name='total_amount' id='total_amount' value='0'></td>
                        </tr>

                        <input type="hidden" name="child_books_total_amount" id="child_books_total_amount" value="0">
                        <input type="hidden" name="tech_books_total_amount" id="tech_books_total_amount" value="0">
                        <input type="hidden" name="child_books_total_items" id="child_books_total_items" value="0">
                        <input type="hidden" name="tech_books_total_items" id="tech_books_total_items" value="0">
                        
                        <input type="hidden" name="child_books_total_amount_no_disc" id="child_books_total_amount_no_disc" value="0">
                        <input type="hidden" name="total_amount_no_disc" id="total_amount_no_disc" value="0">
                    </tfoot>

                </table>
                
            </div>
            
        </div>

        <input type="hidden" name="table_rows" id="table_rows" value="<?php echo $total_rows; ?>">

        <button class="hide_used btn btn-primary buy_buton hide" type="submit"> Send to Cart </button>

    </form>

</center>