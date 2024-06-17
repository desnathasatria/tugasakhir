<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property input $input
 * @property midtrans $midtrans
 */
class MidtransController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Midtrans');
    }

    public function create_payment() {
        $order_id = $this->input->post('order_id');
        $gross_amount = $this->input->post('gross_amount');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');

        $data = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'customer_details' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone' => $phone,
            ],
        ];

        try {
            $response = $this->midtrans->create_payment_link($data);

            if (isset($response->error)) {
                echo 'Error: ' . $response->error;
            } else {
                echo json_encode($response);
            }
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function notification() {
        $order_id = $this->input->get('order_id');
        $status_code = $this->input->get('status_code');
        $transaction_status = $this->input->get('transaction_status');

        // Menyiapkan data untuk ditampilkan di view
        $data['order_id'] = $order_id;
        $data['status_code'] = $status_code;
        $data['transaction_status'] = $transaction_status;

        // Memuat view status pembayaran dengan data yang diperlukan
        $this->load->view('front_page/payment_status', $data);
    }
}
