<?php

use Dompdf\Dompdf;
use Dompdf\Options;

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
            'select' => 'a.id, a.name, a.email, a.image, a.phone_number, c.address, b.name as akses',
            'from' => 'st_user a',
            'join' => [
                'app_credential b, b.id = a.id_credential',
                'address_user c, c.id_user = a.id AND c.is_active = 1, left',
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
                'a.is_deleted' => '0',
                'a.status_pengiriman' => 'Selesai'
            ],
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
            'select' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.rating, a.keterangan, a.created_date, a.status_pembayaran, a.status_pengiriman, GROUP_CONCAT(b.title SEPARATOR ", ") as title, c.name  ',
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
        $date1 = $this->input->get('date1');
        $date2 = $this->input->get('date2');

        $query = [
            'select' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, GROUP_CONCAT(b.title SEPARATOR ", ") as title, c.name',
            'from' => 'transaksi a',
            'join' => [
                'st_user c, c.id = a.id_pelanggan',
                'detail_transaksi d, d.id_transaksi = a.id',
                'produk b, b.id = d.id_produk'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.status_pengiriman' => 'Selesai'
            ],
            'order_by' => 'a.id',
            'group_by' => 'a.id, a.id_pelanggan, a.harga_transaksi, a.created_date, a.status_pembayaran, a.status_pengiriman, c.name'
        ];

        if (!empty($date1) && !empty($date2)) {
            $query['where']["DATE(a.created_date) >="] = $date1;
            $query['where']["DATE(a.created_date) <="] = $date2;
        }

        $this->app_data['history'] = $this->data->get($query)->result();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $html = $this->load->view('menu-admin/pdf_history', $this->app_data, true);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("Laporan-data-history.pdf", array("Attachment" => 0));
    }
}
