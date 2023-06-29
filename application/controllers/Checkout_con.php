<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    class Checkout_con extends CI_Controller {

        public function __construct(){
            parent::__construct();
            
            $this->load->model('checkout_model');
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->helper('security');
        }

        public function index() {
            if (!file_exists(APPPATH . 'views/checkout/index.php')) {
                show_404();
            }

            $session_id = $this->session->userdata('session_id');

            $data['title'] = 'CheckOut Invoice';
            $data['cart_main_details'] = $this->checkout_model->get_cart_details($session_id);
            if($data['cart_main_details']){
                $data['cart_item_details'] = $this->checkout_model->get_cart_item_details($data['cart_main_details'][0]['cart_id']);
            }

            $this->load->library('session');
            $this->load->helper('security');
            $this->load->helper('url');
            $this->load->view('templates/header');
            $this->load->view('checkout/index', $data);
            $this->load->view('templates/footer');
        }

        public function send_to_checkout(){

            $result = $this->checkout_model->send_to_checkout();
            
            if($result){
                redirect(base_url('Checkout_con'));
            }else{
                echo "Not Done";
            }
        }

        public function check_coupan(){
            $result = $this->checkout_model->check_coupan();
            echo json_encode($result);

        }
        
    }

?>
