<?php
    class Home_con extends CI_Controller {

        public function __construct(){
            parent::__construct();
            
            $this->load->model('cart_model');
            $this->load->helper('url');
            $this->load->library('session');
            $this->load->helper('security');
        }

        public function index() {
            if (!file_exists(APPPATH . 'views/home/index.php')) {
                show_404();
            }

            $data['title'] = 'Home Page';
            $data['categories'] = $this->home_model->get_categories();
            $data['child_books'] = $this->home_model->get_chil_books();
            $data['tech_books'] = $this->home_model->get_tech_books();

            $this->load->view('templates/header');
            $this->load->view('home/index', $data);
            $this->load->view('templates/footer');
        }

        public function load_books(){
            $data   =   $this->home_model->load_books();
            echo json_encode($data);
        }

        public function send_to_cart(){

            $session_id = $this->session->userdata('session_id');

            // Generate a new session ID if it doesn't exist
            if (!$session_id) {
                echo "No";
                // Generate a random session ID using numbers and letters
                $new_session_id = $this->generateRandomSessionId();

                // Set the new session ID in the browser
                $this->session->set_userdata('session_id', $new_session_id);

                // Use the new session ID
                $session_id = $new_session_id;
            }

            $result = $this->home_model->send_to_cart($session_id);
            
            if($result){
                redirect(base_url('Cart_con'));
            }else{
                echo "Not Done";
            }
        }

        // Helper method to generate a random session ID
        private function generateRandomSessionId($length = 32) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $randomString;
        }
    }

?>
