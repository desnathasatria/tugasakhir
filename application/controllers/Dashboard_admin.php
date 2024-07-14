<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_admin extends CI_Controller
{

	var $module_js = ['dashboard'];
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
		$this->app_data['user'] = $this->data->get($user)->row_array();
		$query_produk = [
			'select' => 'count(*) as jumlah',
			'from' => 'produk',
			'where' => [
				'is_deleted' => '0',
			]
		];
		$this->app_data['produk'] = $this->data->get($query_produk)->row_array();
		$query_kategori = [
			'select' => 'count(*) as jumlah',
			'from' => 'kategori_produk',
			'where' => [
				'is_deleted' => '0',
			]
		];
		$this->app_data['kategori'] = $this->data->get($query_kategori)->row_array();
		$query_transaksi = [
			'select' => 'count(*) as jumlah',
			'from' => 'transaksi',
			'where' => [
				'is_deleted' => '0',
				'status_pengiriman' => 'Selesai'
			]
		];
		$this->app_data['transaksi'] = $this->data->get($query_transaksi)->row_array();

		$query_user = [
			'select' => 'count(*) as jumlah',
			'from' => 'st_user',
			'where' => [
				'is_deleted' => '0'
			]
		];
		$this->app_data['jml_user'] = $this->data->get($query_user)->row_array();

		$query_total = [
			'select' => 'count(*) as jumlah',
			'from' => 'transaksi',
			'where' => [
				'is_deleted' => '0',
				'status_pengiriman' => 'selesai'
			]
		];
		$this->app_data['total_transaksi'] = $this->data->get($query_total)->row_array();

		$query_grafik = [
			'select' => 'a.title, SUM(CASE WHEN c.status_pengiriman = "Selesai" AND c.is_deleted = 0 THEN b.jumlah ELSE NULL END) AS jumlah_transaksi',
			'from' => 'produk a',
			'join' => [
				'detail_transaksi b, b.id_produk = a.id, left',
				'transaksi c, c.id = b.id_transaksi, left'
			],
			'where' => [
				'a.is_deleted' => 0
			],
			'group_by' => 'a.title',
			'order by' => 'jumlah_transaksi'
		];


		$this->app_data['grafik'] = $this->data->get($query_grafik)->result();

		$this->app_data['title'] = 'Dashboard';

		$this->load->view('template-admin/start', $this->app_data);
		$this->load->view('template-admin/header', $this->app_data);
		$this->load->view('menu-admin/dashboard', $this->app_data);
		$this->load->view('template-admin/footer');
		$this->load->view('template-admin/end');
		$this->load->view('template-admin/dashboard_js.php');
		$this->load->view('js-custom', $this->app_data);
	}
}
