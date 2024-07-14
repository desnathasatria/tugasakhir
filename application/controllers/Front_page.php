<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property data $data
 * @property db $db
 * @property session $session
 * @property input $input
 * @property form_validation $form_validation 
 * @property upload $upload
 * @property output $output
 */

class Front_page extends CI_Controller
{
    var $module_js = ['letter', 'history', 'message', 'profile', 'checkout'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    public function is_logged_in()
    {
        return $this->session->userdata('logged_in_user') === TRUE;
    }

    public function check_auth()
    {
        if (!$this->is_logged_in()) {
            $this->header();
        } else {
            $this->header_1();
        }
    }

    private function _init()
    {
        $this->app_data['module_js'] = $this->module_js;
    }

    public function header()
    {
        $where = array('id_company' => '1');
        $this->app_data['profile'] = $this->data->find('company_profile', $where)->result();
        $this->load->view('front_page/header', $this->app_data);
    }
    public function header_1()
    {
        $where = array('id_company' => '1');
        $this->app_data['profile'] = $this->data->find('company_profile', $where)->result();

        $query = [
            'select' => 'a.id, id_credential, name, email, phone_number, image, username, password, b.address, b.province, b.city',
            'from' => 'st_user a',
            'join' => [
                'address_user b, b.id_user = a.id AND b.is_active = 1, left',
            ],
            'where' => [
                'a.id' => $this->session->userdata('id_user')
            ]
        ];
        $this->app_data['user'] = $this->data->get($query)->row_array();


        $this->load->view('front_page/header_1', $this->app_data);
    }
    public function footer()
    {
        $where = array('id_company' => '1');
        $this->app_data['profile'] = $this->data->find('company_profile', $where)->result();
        $this->load->view('front_page/footer', $this->app_data);
    }
    public function index()
    {
        $this->check_auth();
        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product, a.weight, a.total_stok',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0
            ]
        ];

        $this->app_data['produk'] = $this->data->get($query)->result();
        $where = array('is_deleted' => '0');
        $this->app_data['carousel'] = $this->data->find('carousel_menu', $where)->result();
        $this->app_data['location'] = $this->data->get_all('company_profile')->result();

        $this->load->view('front_page/index', $this->app_data);
        $this->footer();
    }
    public function product()
    {
        $this->check_auth();
        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product, a.weight, a.total_stok',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0
            ]
        ];

        $this->app_data['produk'] = $this->data->get($query)->result();
        $where = array('is_deleted' => '0');
        $this->app_data['select'] = $this->data->find('kategori_produk', $where)->result();
        $this->load->view('front_page/product', $this->app_data);
        $this->footer();
    }
    public function product_detail($x)
    {
        $this->check_auth();
        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product, a.weight, a.total_stok',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0,
                'a.id' => $x
            ]
        ];

        $this->app_data['produk'] = $this->data->get($query)->result();
        $this->load->view('front_page/product_detail', $this->app_data);
        $this->footer();
        $this->load->view('js-custom', $this->app_data);
    }
    public function location()
    {
        $this->check_auth();
        $this->app_data['location'] = $this->data->get_all('company_profile')->result();
        $this->load->view('front_page/location', $this->app_data);
        $this->footer();
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_umkm()
    {
        $result = $this->data->get_all('company_profile')->result();
        echo json_encode($result);
    }

    public function checkout()
    {
        $this->check_auth();

        $id_produk = $this->input->post('id_produk');
        $jumlah = $this->input->post('jumlah');
        if ($this->session->userdata('logged_in_user')) {

            // First, get the product details including the total_stok
            $query = [
                'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product, a.total_stok',
                'from' => 'produk a',
                'join' => [
                    'kategori_produk b, b.id = a.id_category_product',
                ],
                'where' => [
                    'a.is_deleted' => 0,
                    'a.id' => $id_produk
                ]
            ];

            $product = $this->data->get($query)->row();

            // Check if the requested quantity exceeds the available stock
            if ($jumlah > $product->total_stok) {
                // If it exceeds, set an error message and redirect back
                $this->session->set_flashdata('error', 'Jumlah melebihi stok yang tersedia. Stok tersedia: ' . $product->total_stok);
                redirect('Front_page/product_detail/' . $id_produk); // Assuming you have a product detail page
            } else {
                // If stock is sufficient, proceed with checkout
                $this->app_data['jumlah'] = $jumlah;
                $this->app_data['produk'] = [$product]; // We already have the product, no need for another query
                $this->app_data['location'] = $this->data->get_all('company_profile')->result();
                $this->load->view('front_page/checkout', $this->app_data);
                $this->footer();
                $this->load->view('js-custom', $this->app_data);
            }
        } else {
            $this->session->set_flashdata('error_login', 'Anda belum <b>LOGIN</b>!!!');
            redirect('Front_page/product_detail/' . $id_produk); // Assuming you have a product detail page
        }
    }

    public function checkout_keranjang()
    {
        $jumlah = $this->input->post('jumlah_1');
        $id_produk = $this->input->post('id_produk_1');

        $product_ids = explode(',', $id_produk);
        $jumlah_array = explode(',', $jumlah);

        $this->app_data['jumlah'] = $jumlah_array;

        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product, a.total_stok',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0,
            ]
        ];

        $where_in = [];
        foreach ($product_ids as $id) {
            $where_in[] = $id;
        }

        $query['where_in'] = ['a.id' => $where_in];

        $products = $this->data->get($query)->result();

        // Memeriksa stok untuk setiap produk yang diminta
        $out_of_stock = [];
        foreach ($products as $index => $product) {
            // Mengambil jumlah yang diminta untuk produk ini
            $requested_quantity = isset($jumlah_array[$index]) ? intval($jumlah_array[$index]) : 0;

            // Memeriksa apakah jumlah yang diminta melebihi stok yang tersedia
            if ($requested_quantity > $product->total_stok) {
                // Menambahkan nama produk ke dalam daftar produk yang habis stok
                $out_of_stock[] = $product->title . " stok: " . $product->total_stok;
            }
        }

        if ($id_produk == "") {
            $response['empty'] = "Tidak ada produk dalam keranjang";
        }
        // Jika ada produk yang kehabisan stok
        else if (!empty($out_of_stock)) {
            // Menyimpan daftar produk yang habis stok ke dalam data aplikasi untuk digunakan di view
            $this->app_data['out_of_stock'] = $out_of_stock;
            $response['error'] = $out_of_stock;
        } else {
            $response['success'] = "berhasil";
            $response['id_produk'] = $id_produk;
            $response['jumlah'] = $jumlah;
        }
        echo json_encode($response);
    }

    public function checkout_keranjang_1()
    {
        $this->check_auth();
        $jumlah = $this->input->get('jumlah');
        $id_produk = $this->input->get('id_produk');
        $product_ids = explode(',', $id_produk);

        $jumlah_array = explode(',', $jumlah);
        $this->app_data['jumlah'] = $jumlah_array;

        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0,
            ]
        ];

        // Create the WHERE clause for multiple product IDs
        $where_in = [];
        foreach ($product_ids as $id) {
            $where_in[] = $id;
        }

        $query['where_in'] = ['a.id' => $where_in];
        $this->app_data['produk'] = $this->data->get($query)->result();
        $this->app_data['location'] = $this->data->get_all('company_profile')->result();
        $this->load->view('front_page/checkout', $this->app_data);
        $this->footer();
        $this->load->view('js-custom', $this->app_data);
    }
    public function keranjang()
    {
        if ($this->session->userdata('logged_in_user')) {
            $id_produk = $this->input->post('id_produk');
            $jumlah = $this->input->post('jumlah');
            $user_id = $this->session->userdata('id_user');

            $where = array(
                'product_id' => $id_produk,
                'user_id' => $user_id
            );
            $existing_item = $this->data->find('shopping_cart', $where)->row_array();

            if (isset($existing_item)) {
                $new_quantity = $existing_item['quantity'] + $jumlah;
                $data = array('quantity' => $new_quantity);
                $where = array('id' => $existing_item['id']);
                $this->data->update('shopping_cart', $where, $data);
                $response['success'] = "update data";
            } else {
                $insert_data = array(
                    'product_id' => $id_produk,
                    'quantity' => $jumlah,
                    'user_id' => $user_id
                );
                $this->data->insert('shopping_cart', $insert_data);
                $response['success'] = "insert data";
            }
        } else {
            $response['error'] = "Anda belum <b>LOGIN</b>!!!";
        }

        echo json_encode($response);
    }

    public function get_data_keranjang()
    {
        $user_id = $this->session->userdata('id_user');
        $query = [
            'select' => 'p.id as id_produk, sc.id, p.title, p.price, sc.quantity',
            'from' => 'shopping_cart sc',
            'join' => [
                'produk p, p.id = sc.product_id'
            ],
            'where' => [
                'sc.user_id' => $user_id,
            ],
            'order_by' => 'sc.id'
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function ubah_jumlah()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $keranjang = $this->data->find('shopping_cart', array('id' => $id))->row_array();

        if ($status == 'plus') {
            $jumlah = $keranjang['quantity'] + 1;
            $data = array(
                'quantity' => $jumlah,
            );
            $where = array('id' => $id);
            $this->data->update('shopping_cart', $where, $data);
            $response['tambah'] = "Berhasil menambah data";
        } else if ($status == 'minus') {
            if ($keranjang['quantity'] == 1) {
                $response['error'] = "Data tidak dapat berkurang lagi";
            } else {
                $jumlah = $keranjang['quantity'] - 1;
                $data = array(
                    'quantity' => $jumlah,
                );
                $where = array('id' => $id);
                $this->data->update('shopping_cart', $where, $data);
                $response['kurang'] = "Berhasil mengurangi data";
            }
        }
        echo json_encode($response);
    }

    public function delete_data_keranjang()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $deleted = $this->db->delete('shopping_cart');

        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    public function insert_data_keranjang()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id_transaksi = $this->input->post('id_transaksi');
        $id_produk = $this->input->post('id_produk');
        $produk_array = explode(',', $id_produk);
        $jml_produk = count($produk_array);

        for ($i = 0; $i < $jml_produk; $i++) {
            ${"id_produk" . ($i + 1)} = $produk_array[$i];

            $data_gabung = array(
                'id_produk' => ${"id_produk" . ($i + 1)}
            );
            $this->data->insert('detail_transaksi', $data_gabung);
        }
        $data = array(
            'id_transaksi' => $id_transaksi,
            'id_produk' => $id_produk,
        );
        $this->data->insert('detail_transaksi', $data);

        $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });

                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi tambah data Data berhasil dimasukkan'
                  })
              });</script>";

        echo json_encode($response);
    }

    public function gallery()
    {
        $where = array('is_deleted' => '0');
        $this->app_data['kategori'] = $this->data->find('gallery_category', $where)->result();

        $query_gallery = [
            'select' => 'a.title, a.description, a.image, b.name',
            'from' => 'gallery_image a',
            'join' => [
                'gallery_category b, b.id = a.id_category'
            ],
            'where' => [
                'a.is_deleted' => '0'
            ]
        ];
        $this->app_data['gambar'] = $this->data->get($query_gallery)->result();
        $this->check_auth();
        $this->load->view('front_page/gallery', $this->app_data);
        $this->footer();
    }

    public function get_data_message()
    {
        $query = [
            'select' => 'a.name, a.email, a.message, a.date_send, a.status, b.message as balasan, b.date_send as tgl_balasan',
            'from' => 'message_user a',
            'join' => [
                'reply_message b, b.id_message = a.id, left'
            ],
            'order_by' => 'a.id, DESC'
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function insert_message()
    {

        if ($this->session->userdata('logged_in_user')) {
            $this->form_validation->set_rules('nama_pengirim', 'Nama', 'required|trim');
            $this->form_validation->set_rules('email_pengirim', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');


            if ($this->form_validation->run() == false) {
                $response['errors'] = $this->form_validation->error_array();
            } else {
                $nama = $this->input->post('nama_pengirim');
                $email = $this->input->post('email_pengirim');
                $pesan = $this->input->post('pesan');

                $data = array(
                    'name' => $nama,
                    'email' => $email,
                    'message' => $pesan,
                );
                $this->data->insert('message_user', $data);

                $response['success'] = "Data successfully inserted!";
            }
        } else {
            $response['error'] = 'Anda belum <b>LOGIN</b>!!!';
        }

        echo json_encode($response);
    }
    public function get_data_history()
    {
        $where = array('email' => $this->session->userdata('email_user'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $query = [
            'select' => 'a.id, GROUP_CONCAT(b.title SEPARATOR ", ") as title, a.harga_transaksi, a.status_pengiriman, a.created_date',
            'from' => 'transaksi a',
            'join' => [
                'detail_transaksi c, c.id_transaksi = a.id',
                'produk b, b.id = c.id_produk'
            ],
            'where' => [
                'a.id_pelanggan' => $data['user']['id'],
                'a.is_deleted' => '0'
            ],
            'group_by' => 'a.id'
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }
    public function get_data_id()
    {
        $id = $this->input->post('id');
        $where = array('email' => $this->session->userdata('email_user'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $query = [
            'select' => 'a.id, GROUP_CONCAT(b.title SEPARATOR ", ") as title, a.harga_transaksi, a.status_pengiriman, a.created_date',
            'from' => 'transaksi a',
            'join' => [
                'detail_transaksi c, c.id_transaksi = a.id',
                'produk b, b.id = c.id_produk'
            ],
            'where' => [
                'a.id' => $id,
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function konfirmasi_pemesanan()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data = $this->data->find('st_user', $where)->row_array();
        $id = $this->input->post('id');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data = array(
            'status_pengiriman' => 'Selesai',
            'updated_date' => $timestamp,
            'updated_by' => $data['id'],
        );

        $where = array('id' => $id);
        $this->data->update('transaksi', $where, $data);
        $response['success'] = "Berhasil";
        echo json_encode($response);
    }

    public function profile()
    {
        if (!$this->is_logged_in()) {
            redirect('login');
        } else {
            $this->check_auth();
            $this->load->view('front_page/profile');
            $this->footer();
            $this->load->view('js-custom', $this->app_data);
        }
    }
    public function get_profile()
    {
        // $where = array('id' => $this->session->userdata('id_user'));
        // $result = $this->data->find('st_user', $where)->result();

        $query = [
            'select' => 'a.id, id_credential, name, email, phone_number, image, username, password, b.address, b.province, b.city',
            'from' => 'st_user a',
            'join' => [
                'address_user b, b.id_user = a.id AND b.is_active = 1, left',
            ],
            'where' => [
                'a.id' => $this->session->userdata('id_user')
            ]
        ];
        $result = $this->data->get($query)->result();

        echo json_encode($result);
    }

    public function get_data_address()
    {
        $query = [
            'select' => 'id, address, province, city, is_active',
            'from' => 'address_user',
            'where' => [
                'id_user' => $this->session->userdata('id_user')
            ],
            'order_by' => 'id'
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_address_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'id, address, province, city, is_active',
            'from' => 'address_user',
            'where' => [
                'id' => $id
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function insert_address()
    {
        $alamat1 = $this->input->post('alamat1');
        $provinsi = $this->input->post('provinsi');
        $kota = $this->input->post('kota');
        $this->form_validation->set_rules('alamat1', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('kota', 'Kota', 'required|trim');

        $where = array('id_user' => $this->session->userdata('id_user'), 'is_active' => '1');
        $data_alamat = $this->data->find('address_user', $where)->row_array();

        if (isset($data_alamat)) {
            $status_alamat = '0';
        } else {
            $status_alamat = '1';
        }

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $data = array(
                'id_user' => $this->session->userdata('id_user'),
                'address' => $alamat1,
                'province' => $provinsi,
                'city' => $kota,
                'is_active' => $status_alamat
            );
            $this->data->insert('address_user', $data);

            $response['success'] = "sukses";
        }
        echo json_encode($response);
    }

    public function edit_address()
    {
        $id_alamat = $this->input->post('id_alamat');
        $alamat1 = $this->input->post('alamat1');
        $provinsi = $this->input->post('provinsi');
        $kota = $this->input->post('kota');

        $this->form_validation->set_rules('alamat1', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('kota', 'Kota', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $data = array(
                'address' => $alamat1,
                'province' => $provinsi,
                'city' => $kota,
            );
            $where = array('id' => $id_alamat);
            $this->data->update('address_user', $where, $data);

            $response['success'] = "sukses";
        }
        echo json_encode($response);
    }

    public function edit_status_address()
    {
        $id = $this->input->post('id');
        $where = array('id_user' => $this->session->userdata('id_user'));
        $updated = $this->data->update('address_user', $where, array(
            'is_active' => '0',
        ));

        if ($updated) {
            $where1 = array('id' => $id);
            $updated = $this->data->update('address_user', $where1, array(
                'is_active' => '1',
            ));
            $response['success'] = "Data berhasil dihapus";
        } else {
            $response['error'] = "Gagal menghapus data mahasiswa";
        }
        echo json_encode($response);
    }

    public function delete_address()
    {
        $id = $this->input->post('id');
        $where = array('id' => $id);
        $data_alamat = $this->data->find('address_user', $where)->row_array();

        if ($data_alamat['is_active'] == '1') {
            $response['error'] = "Gagal, dikarenakan alamat utama";
        } else {
            $deleted_address = $this->data->delete('address_user', array('id' => $id));
            if ($deleted_address) {
                $response['success'] = "Data berhasil dihapus";
            } else {
                $response['error'] = "Gagal menghapus data mahasiswa";
            }
        }


        echo json_encode($response);
    }

    public function edit_profile()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('telepon', 'No HP', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required|trim');
        $this->form_validation->set_rules('kota', 'Kota', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password Baru', 'trim|min_length[8]');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $where = array('id' => $this->session->userdata('id_user'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $id = $this->input->post('id');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $username = $this->input->post('username');
            $password = $this->input->post('password1');
            $hash = hash("sha256", $password . config_item('encryption_key'));
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'name' => $nama,
                'email' => $email,
                'phone_number' => $telepon,
                'username' => $username,
                'updated_date' => $timestamp,
                'updated_by' => $data['user']['id'],
            );

            // if (!empty($password)) {
            //     $data1 = array('password' => $hash);
            //     $where = array('id' => $id);
            //     $update = $this->data->update('st_user', $where, $data1);
            // }

            $where = array('id' => $id);
            $updated = $this->data->update('st_user', $where, $data);



            if (!$updated) {
                $response['errors']['database'] = "Failed to update data in the database.";
            } else {
                if (!empty($_FILES['profil']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $username . ' - ' . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('profil')) {
                        $upload_data = $this->upload->data();
                        $file_name = $upload_data['file_name'];

                        $data = array('image' => $file_name);
                        $where = array('id' => $id);
                        $this->data->update('st_user', $where, $data);
                    } else {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
                    }
                }
                $response['success'] = "Data successfully updated!";
            }
        }
        echo json_encode($response);
    }
    public function history()
    {
        $this->check_auth();
        $this->load->view('front_page/history');
        $this->footer();
        $this->load->view('js-custom', $this->app_data);
    }
}
