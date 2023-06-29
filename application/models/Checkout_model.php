<?php
class Checkout_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    // Retrieving cart details according to the session ID
    public function get_cart_details($session_id){

        $query = $this->db->query("SELECT cart_main.*
                                    FROM cart_main
                                    WHERE cart_main.session_id = '$session_id' AND cart_main.checked_out = '1'");
        return $query->result_array();
    }

    public function get_cart_item_details($cart_id){

        $query = $this->db->query("SELECT cart_items.*, book.book_name, book.stock, category.category_id, category.category_name
                                    FROM cart_items
                                    LEFT JOIN book ON cart_items.book_id = book.book_id
                                    LEFT JOIN category ON book.category_id = category.category_id
                                    WHERE cart_items.cart_id = '$cart_id'");
        return $query->result_array();
    }

    // To save the time, only used the cart table as the checkout table. checked_out column will used to identify whether this is used in the checkout.
    // If the cart is used in checkout, in cart, it will be removed. 
    public function send_to_checkout(){
        $date = date('Y-m-d');

        $this->db->trans_start();

            $cart_id = $this->input->post('cart_id');

            $whereArr = array(
                'cart_id' => $cart_id
            );
            $data1 = array(
                'total_amount' => $this->input->post('total_amount'),
                'total_items' => $this->input->post('total_items'),
                'checked_out' => 1,
                'checked_out_date' => $date,
                'child_books_total_amount' => $this->input->post('child_books_total_amount'),
                'tech_books_total_amount' => $this->input->post('tech_books_total_amount'),
                'child_books_total_items' => $this->input->post('child_books_total_items'),
                'tech_books_total_items' => $this->input->post('tech_books_total_items'),
                'child_books_total_amount_no_disc' => $this->input->post('child_books_total_amount_no_disc'),
                'total_amount_no_disc' => $this->input->post('total_amount_no_disc'),
            );
            $this->db->update('cart_main', $data1, $whereArr);

            $this->db->query("DELETE FROM cart_items WHERE cart_id = '$cart_id'");

            $table_rows = $this->input->post('table_rows');

            for($i=0; $i<$table_rows; $i++){
                $baught_amount = $this->input->post('amount_' . $i);

                //If the row is removed, this will be empty
                if($baught_amount){
                    if($baught_amount > 0){
                        $book_id = $this->input->post('book_id_' . $i);
                        $price = $this->input->post('price_' . $i);
                        $final_price = $this->input->post('final_price_' . $i);
    
                        // Save the items baught
                        $data2 = array(
                            'cart_id' => $cart_id,
                            'book_id' => $book_id,
                            'price' => $price,
                            'total' => $final_price,
                            'ordered_items' => $baught_amount,
                        );
    
                        $this->db->insert('cart_items', $data2);
    
                        // Update the Stocks in books
                        $books_actual_stock_array = $this->db->query("SELECT stock From book Where book_id='$book_id'")->result();
    
                        $books_actual_stock = $books_actual_stock_array[0]->stock;
    
                        $books_actual_stock -= $baught_amount;
    
                        $whereArr = array(
                            'book_id' => $book_id
                        );
                        $data3 = array(
                            'stock' => $books_actual_stock
                        );
                        $this->db->update('book', $data3, $whereArr);
    
                    }
                }
            }

        return $this->db->trans_complete();

    }

    public function check_coupan(){
        $cart_id = $this->input->post('cart_id');

        $whereArr = array(
            'cart_id' => $cart_id
        );
        $data1 = array(
            'coupan' => '1',
        );
        $this->db->update('cart_main', $data1, $whereArr);

        return 'success';
    }
}