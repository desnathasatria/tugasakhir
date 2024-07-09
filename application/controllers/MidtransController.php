<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property input $input
 * @property midtrans $midtrans
 */
class MidtransController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Midtrans');
    }

    public function create_payment()
    {
        $order_id = $this->input->post('order_id');
        $gross_amount = $this->input->post('gross_amount');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $order_notes = $this->input->post('order_notes');
        $jumlah = $this->input->post('jumlah');
        $jumlah_produk = $this->input->post('jumlah_produk');

        // Ambil id_produk dari session

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
            'id' => $order_id,
            'id_pelanggan' => $id_pelanggan,
            'harga_transaksi' => $harga_transaksi,
            'jumlah' => $jumlah,
            'status_pembayaran' => 'Menunggu Pembayaran', // Set status awal
            'status_pengiriman' => 'Menunggu Pembayaran',
            'created_by' => $id_user
        ];

        $this->data->insert('transaksi', $data_transaksi);

        $id_produk = $this->input->post('id_produk');
        $id_produk_array = explode(',', $this->input->post('id_produk'));
        $jumlah_array = explode(',', $jumlah_produk);

        foreach ($id_produk_array as $index => $id_produk) {
            $data_detail = [
                'id_transaksi' => $order_id,
                'id_produk' => trim($id_produk),
                'jumlah' => trim($jumlah_array[$index]),
            ];

            $this->data->insert('detail_transaksi', $data_detail);
            $cek_keranjang = $this->data->find('shopping_cart', array('product_id' => trim($id_produk), 'user_id' => $this->session->userdata('id_user')))->row_array();
            if (isset($cek_keranjang)) {
                $this->data->delete('shopping_cart', array('product_id' => trim($id_produk), 'user_id' => $this->session->userdata('id_user')));
            }
        }


        $produk = $this->data->find('produk', array('id' => $id_produk))->row_array();
        $total = $produk['total_stok'] - $jumlah;


        $this->data->update('produk', array('id' => $id_produk), array('total_stok' => $total));

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
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    // public function notification()
    // {
    //     $notificationBody = $this->input->raw_input_stream;
    //     $notification = json_decode($notificationBody);

    //     $order_id = $notification->order_id;
    //     $transaction_status = $notification->transaction_status;

    //     $this->data->update('transaksi', array('id' => $order_id), array('status_pembayaran' => 'Telah Dibayar'));
    //     // Update status pembayaran berdasarkan transaction_status
    //     // $this->db->where('id', $order_id);
    //     // $this->db->update('transaksi', ['status_pembayaran' => $transaction_status]);


    //     // Kirim respons ke Midtrans
    //     $this->output->set_status_header(200);
    // }

    public function notification()
    {
        $order_id = $this->input->get('order_id');
        $status_code = $this->input->get('status_code');
        $transaction_status = $this->input->get('transaction_status');

        // Menyiapkan data untuk ditampilkan di view
        $data['order_id'] = $order_id;
        $data['status_code'] = $status_code;
        $data['transaction_status'] = $transaction_status;

        if ($data['transaction_status'] == 'settlement') {
            $status_pembayaran = 'Telah Dibayar';
            $status_pengiriman = 'Dikemas';
        } else {
            $status_pembayaran = 'Menunggu Pembayaran';
            $status_pengiriman = 'Menunggu Pembayaran';
        }

        $this->data->update('transaksi', array('id' => $order_id), array('status_pembayaran' => $status_pembayaran, 'status_pengiriman' => $status_pengiriman));

        $this->load->view('front_page/payment_status', $data);
    }
}
