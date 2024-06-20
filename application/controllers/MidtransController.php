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
        $order_notes = $this->input->post('order_notes');
    
        // Ambil id_produk dari session
        $id_produk = $this->input->post('id_produk');
    
        // Ambil id_pelanggan dari session dan join dengan tabel st_user
        $id_user = $this->session->userdata('id_user');
        $this->db->select('id');
        $this->db->from('st_user');
        $this->db->where('id', $id_user);
        $query = $this->db->get();
        $row = $query->row();
        $id_pelanggan = $row->id;
    
        $harga_transaksi = $gross_amount;
    
        // Simpan data transaksi ke dalam tabel transaksi
        $data_transaksi = [
            'id_produk' => $id_produk,
            'id_pelanggan' => $id_pelanggan,
            'harga_transaksi' => $harga_transaksi,
            'alamat' => $order_notes,
            'status_pembayaran' => 'Menunggu Pembayaran', // Set status awal
            'status_pengiriman' => 'Dikemas',
            'created_by' => $id_user
        ];
    
        $this->db->insert('transaksi', $data_transaksi);
        $transaksi_id = $this->db->insert_id();
    
        // Lanjutkan dengan membuat permintaan pembayaran ke Midtrans
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
        $notificationBody = $this->input->raw_input_stream;
        $notification = json_decode($notificationBody);
    
        $order_id = $notification->order_id;
        $transaction_status = $notification->transaction_status;
    
        // Update status pembayaran berdasarkan transaction_status
        $this->db->where('id', $order_id);
        $this->db->update('transaksi', ['status_pembayaran' => $transaction_status]);
    
        // Kirim respons ke Midtrans
        $this->output->set_status_header(200);
    }
}
