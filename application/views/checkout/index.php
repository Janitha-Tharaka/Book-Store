<center>
    <h1 class="main-heading"> <?php echo $title; ?> </h1>

</center>
<div class="container mt-6 mb-7">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-7">
        <?php 
            if($data['cart_main_details']){
        ?>
            <div class="card">
                <div class="card-body p-5">
                    <h2>
                        Hey Reader,
                    </h2>
                    
                    <p class="fs-sm">
                        This is the receipt for a bill amount of <strong>$<?php echo $cart_main_details[0]['total_amount']; ?></strong> (USD) to be paid by you for your purchase.
                    </p>

                    <table class="table border-bottom border-gray-200 mt-3">
                        <thead>
                            <tr>
                                <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Book Name</th>
                                <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">Price (USD)</th>
                                <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">No of Items</th>
                                <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm text-end px-0">Total (USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 0;
                            $total = 0;
                            foreach($cart_item_details as $cart){ 
                                $total += $cart['total'];
                                ?>
                                <tr id="rowID_<?php echo $i; ?>">
                                    <td>
                                        <?php echo $cart['book_name']; ?>
                                    </td>
                                    <td class="">
                                        <?php echo $cart['price']; ?>
                                    </td>
                                    <td>
                                        <?php echo $cart['ordered_items']; ?>
                                    </td>
                                    <td class="text-end">
                                        <?php echo $cart['total']; ?>
                                    </td>
                                </tr>
                        <?php    
                                $i++;
                            }
                        ?>

                            <tr>
                                <td colspan="2"> </td>
                                <td class="text-end text-muted"> Subtotal: </td>
                                <td class="text-end"> <span><?php echo number_format($total, 2); ?></span> </td>
                            </tr>

                        <?php 
                            $total_amount_no_disc = $cart_main_details[0]['total_amount_no_disc'];
                            $coupan = $cart_main_details[0]['coupan'];

                            if($coupan == 0){
                        ?>
                            <?php 
                                $discountChild = $cart_main_details[0]['child_books_total_amount_no_disc'] - $cart_main_details[0]['child_books_total_amount'];
                                if($discountChild != 0 || $discountChild != null){ 
                            ?>
                                <tr>
                                    <td colspan="3" class="text-end text-muted"> Discount of 10% : </td>
                                    <td class="text-end"> <span><?php echo number_format($discountChild, 2); ?></span> </td>
                                </tr>
                            <?php } ?>

                            <?php 
                                $total_amount = $cart_main_details[0]['total_amount'];

                                if($discountChild != 0 || $discountChild != null){

                                    $tot = $discountChild+$total_amount;

                                    if($tot != $total_amount_no_disc){ ?>
                                        <tr>
                                            <td colspan="3" class="text-end text-muted"> Discount of 5% : </td>
                                            <td class="text-end"> <span><?php echo number_format($total_amount_no_disc - $tot, 2); ?></span> </td>
                                        </tr>
                            <?php        }
                                }else if($total_amount != $total_amount_no_disc){ ?>

                                        <tr>
                                            <td colspan="3" class="text-end text-muted"> Discount of 5% : </td>
                                            <td class="text-end"> <span><?php echo number_format($total_amount_no_disc - $total_amount, 2); ?></span> </td>
                                        </tr>

                        <?php    }
                            }else{ 
                                $coupan_discount = ($total_amount_no_disc * 12) / 100;
                                $total_amount =  $total_amount_no_disc - $coupan_discount;
                            ?>

                                <tr>
                                    <td colspan="3" class="text-end text-muted"> Coupan Discount 12%: </td>
                                    <td class="text-end"> <span><?php echo number_format($coupan_discount, 2); ?></span> </td>
                                </tr>
                        
                    <?php }

                        ?>

                        </tbody>
                    </table>

                    <div class="mt-5">
                        <div class="d-flex justify-content-end mt-3">
                            <h5 class="me-3"> Grand Total:</h5>
                            <h5 class="text-success"><?php echo number_format($total_amount, 2); ?></h5>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="d-flex justify-content-end mt-3">
                            <h7 class="me-3"> Add a Coupan Code</h7>
                            <div style="font-size:14px; display:flex">
                                <input type="text" id="coupan_code" value="" placeholder="Enter Coupan Code..." style="margin-right:5px;"> 
                                <button class="btn btn-info" onclick="checkCoupanCode()" style="font-size:14px;"> Coupan Submit </button> 
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#!" class="btn btn-dark btn-lg card-footer-btn justify-content-center text-uppercase-bold-sm hover-lift-light">
                    <span class="svg-icon text-white me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512"><title>ionicons-v5-g</title><path d="M336,208V113a80,80,0,0,0-160,0v95" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path><rect x="96" y="208" width="320" height="272" rx="48" ry="48" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></rect></svg>
                    </span>
                    Pay Now
                </a>

                <input type="hidden" id="cart_id" value="<?php echo $cart_main_details[0]['cart_id']; ?>" >
            </div>
        <?php 
            }else{ ?>
                <div class="card">
                    <div class="card-body p-5">
                        <h1>
                            Please proceed the Checkout process.
                        </h1>
                    </div>
                </div>
        <?php    }
        ?>
        </div>
    </div>
  </div>