<?php
class Home_model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function get_categories(){
        $query = $this->db->query("SELECT * FROM category");
        return $query->result_array();
    }

    public function get_chil_books(){
        $query = $this->db->query("SELECT * FROM book WHERE category_id = 1");
        return $query->result_array();
    }

    public function get_tech_books(){
        $query = $this->db->query("SELECT * FROM book WHERE category_id = 2");
        return $query->result_array();
    }

    public function load_books(){
        $category_id = $this->input->post("category_id");

        $result =   $this->db->query("SELECT *
                                        FROM book
                                        WHERE book.category_id = '$category_id' ")->result();

        return $result;
    }

    public function send_to_cart($session_id){

        $this->db->trans_start();

        $data1 = array(
            'session_id' => $session_id,
            'total_amount' => $this->input->post('total_amount'),
            'total_items' => $this->input->post('total_items'),
            'child_books_total_amount' => $this->input->post('child_books_total_amount'),
            'tech_books_total_amount' => $this->input->post('tech_books_total_amount'),
            'child_books_total_items' => $this->input->post('child_books_total_items'),
            'tech_books_total_items' => $this->input->post('tech_books_total_items'),
            'child_books_total_amount_no_disc' => $this->input->post('child_books_total_amount_no_disc'),
            'total_amount_no_disc' => $this->input->post('total_amount_no_disc'),
        );
        $this->db->insert('cart_main', $data1);
        $this->lastInsertID_ = $this->db->insert_id();

        $table_rows = $this->input->post('table_rows');

        for($i=0; $i<$table_rows; $i++){
            $baught_amount = $this->input->post('amount_' . $i);

            if($baught_amount > 0){
                $book_id = $this->input->post('book_id_' . $i);
                $price = $this->input->post('price_' . $i);
                $final_price = $this->input->post('final_price_' . $i);

                // Save the items baught
                $data2 = array(
                    'cart_id' => $this->lastInsertID_,
                    'book_id' => $book_id,
                    'price' => $price,
                    'total' => $final_price,
                    'ordered_items' => $baught_amount,
                );

                $this->db->insert('cart_items', $data2);

                // Update the Stocks in books
                $books_actual_stock_array = $this->db->query("Select stock From book Where book_id='$book_id'")->result();

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

        return $this->db->trans_complete();
    }
}