<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_purchase extends CI_Controller
{
    var $module_js = ['manage-purchase'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->is_logged_in()) {
            redirect('admin');
        }
    }

    public function is_logged_in()
    {
        return $this->session->userdata('logged_in') === TRUE;
    }

    private function _init()
    {
        $this->app_data['module_js'] = $this->module_js;
    }

    public function index()
    {
        $query_menu = [
            'select' => 'id_parent,name, icon, link, type, is_admin',
            'from' => 'app_menu',
            'where' => [
                'is_admin' => '1'
            ]
        ];

        $query_dropdown = [
            'select' => 'id_parent,name,link,icon, type, is_admin',
            'from' => 'app_menu',
            'where' => [
                'type' => '2',
                'is_admin' => '1'
            ]
        ];

        $query_child = [
            'select' => 'id_parent,name,link,icon, type, is_admin',
            'from' => 'app_menu',
            'where' => [
                'type' => '3',
                'is_admin' => '1'
            ]
        ];

        $user = [
            'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, b.name as akses',
            'from' => 'st_user a',
            'join' => [
                'app_credential b, b.id = a.id_credential'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.email' => $this->session->userdata('email')
            ]
        ];
        $this->app_data['get_menu'] = $this->data->get($query_menu)->result();
        $this->app_data['get_dropdown'] = $this->data->get($query_dropdown)->result();
        $this->app_data['get_child'] = $this->data->get($query_child)->result();
        $where = array('is_deleted' => '0');
        $this->app_data['select'] = $this->data->find('gallery_category', $where)->result();
        $this->app_data['user'] = $this->data->get($user)->row_array();
        $this->app_data['title'] = 'Kelola Pembelian';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_purchase', $this->app_data);
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $query = [
            'select' => 'a.id, a.id_pelanggan, a.id_produk, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, b.title, c.name  ',
            'from' => 'transaksi a',
            'join' => [
                'produk b, b.id = a.id_produk',
                'st_user c, c.id = a.id_pelanggan'
            ],
            'where' => [
                'a.is_deleted' => '0',
            ],
            'order_by' => 'a.id'
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'a.id, a.id_pelanggan, a.id_produk, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, b.title, c.name',
            'from' => 'transaksi a',
            'join' => [
                'produk b, b.id = a.id_produk',
                'st_user c, c.id = a.id_pelanggan'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.id' => $id
            ],
            'order_by' => 'a.id'
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }
    // private function cek_stok($id_barang, $jumlah)
    // {
    //     $query = [
    //         'select' => 'stok',
    //         'from' => 'supplier',
    //         'where' => [
    //             'id_barang' => $id_barang,
    //             'is_deleted' => '0'
    //         ]
    //     ];

    //     $result = $this->data->get($query)->row_array();
    //     if ($result) {
    //         return $result['stok'] >= $jumlah;
    //     }

    //     return false;
    // }

    // private function update_stok($id_barang, $jumlah, $operasi)
    // {
    //     $query = [
    //         'select' => 'stok',
    //         'from' => 'supplier',
    //         'where' => [
    //             'id_barang' => $id_barang,
    //             'is_deleted' => '0'
    //         ]
    //     ];

    //     $result = $this->data->get($query)->row_array();
    //     if ($result) {
    //         $stok_baru = ($operasi == 'kurang') ? $result['stok'] - $jumlah : $result['stok'] + $jumlah;
    //         $data_update = array(
    //             'stok' => $stok_baru
    //         );
    //         $where = array('id_barang' => $id_barang);
    //         $this->data->update('supplier', $where, $data_update);
    //     }
    // }
    public function edit_data()
    {
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'status_pengiriman' => $status,
                'updated_date' => $timestamp,
                'updated_by' => $data['user']['id'],
            );

            $where = array('id' => $id);
            $this->data->update('transaksi', $where, $data);

            $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });

                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi edit data Data berhasil diedit'
                  })
              });</script>";
        }
        echo json_encode($response);
    }
    public function delete_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id = $this->input->post('id');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'is_deleted' => '1',
            'deleted_date' => $timestamp,
            'deleted_by' => $data['user']['id'],
        );
        $where = array('id' => $id);

        $updated = $this->data->update('transaksi', $where, $data);
        if ($updated) {
            $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });

                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi edit data Data berhasil diedit'
                  })
              });</script>";
        }
        echo json_encode($response);
    }
}