<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    class Cart_con extends CI_Controller {
        public function __construct(){
            parent::__construct();
            
            $this->load->model('cart_model');
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->helper('security');
        }

        public function index() {
            if (!file_exists(APPPATH . 'views/cart/index.php')) {
                show_404();
            }

            $session_id = $this->session->userdata('session_id');

            $data['title'] = 'Your Cart';
            $data['cart_main_details'] = $this->cart_model->get_cart_details($session_id);
            if($data['cart_main_details']){
                $data['cart_item_details'] = $this->cart_model->get_cart_item_details($data['cart_main_details'][0]['cart_id']);
            }
            
            $this->load->view('templates/header');
            $this->load->view('cart/index', $data);
            $this->load->view('templates/footer');
        }

        public function send_to_checkout(){

            $result = $this->cart_model->send_to_checkout();
            
            if($result){
                redirect(base_url('Checkout_con'));
            }else{
                echo "Not Done";
            }
        }
        
    }

?>
