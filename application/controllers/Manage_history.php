<?php

use Dompdf\Dompdf;

defined('BASEPATH') or exit('No direct script access allowed');

class Manage_history extends CI_Controller
{
    var $module_js = ['manage-history'];
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
        $this->app_data['title'] = 'Kelola History';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_history', $this->app_data);
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $startDate = $this->input->get('start_date');
        $endDate = $this->input->get('end_date');

        $query = [
            'select' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, GROUP_CONCAT(b.title SEPARATOR ", ") as title, c.name',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_pelanggan',
                'detail_transaksi d, d.id_transaksi = a.id',
                'produk b, b.id = d.id_produk'
            ],
            'where' => [
                'a.is_deleted' => '0'
            ],
            'order_by' => 'a.id',
            'group_by' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, c.name'
        ];

        if (!empty($startDate) && !empty($endDate)) {
            $query['where']["DATE(a.created_date) >="] = $startDate;
            $query['where']["DATE(a.created_date) <="] = $endDate;
        }

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }


    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, GROUP_CONCAT(b.title SEPARATOR ", ") as title, c.name  ',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_pelanggan',
                'detail_transaksi d, d.id_transaksi = a.id',
                'produk b, b.id = d.id_produk'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.id' => $id
            ],
            'order_by' => 'a.id',
            'group_by' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, c.name'
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }
    public function export_pdf()
    {
        $query = [
            'select' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, GROUP_CONCAT(b.title SEPARATOR ", ") as title, c.name  ',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_pelanggan',
                'detail_transaksi d, d.id_transaksi = a.id',
                'produk b, b.id = d.id_produk'
            ],
            'where' => [
                'a.is_deleted' => '0',
            ],
            'order_by' => 'a.id',
            'group_by' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, c.name'
        ];

        $data['history'] = $this->data->get($query)->result();

        $html = $this->load->view('pdf_history', $data, TRUE);

        $this->load->helper('dompdf_helper');
        pdf_create($html, 'History_Transaksi');
    }
}
