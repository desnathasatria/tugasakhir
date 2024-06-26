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
        $session = array('email' => $this->session->userdata('email_user'));
        $data = $this->data->find('st_user', $session)->row_array();

        $kondisi = array('id' => $data['id']);
        $this->app_data['user'] = $this->data->find('st_user', $kondisi)->row_array();
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
    }

    public function get_umkm()
    {
        $result = $this->data->get_all('company_profile')->result();
        echo json_encode($result);
    }

    public function checkout($x)
    {
        $this->check_auth();
        $jumlah = $this->input->post('jumlah');
        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.image, b.name, a.id_category_product',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0,
                'a.id' => $x
            ]
        ];
        $this->app_data['jumlah'] = $jumlah;
        $this->app_data['produk'] = $this->data->get($query)->result();
        $this->app_data['location'] = $this->data->get_all('company_profile')->result();
        $this->load->view('front_page/checkout', $this->app_data);
        $this->footer();
        $this->load->view('js-custom', $this->app_data);
    }
    public function keranjang()
    {
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
        $produk_array = explode(',',$id_produk);
        $jml_produk = count($produk_array);

        for ($i = 0; $i < $jml_produk; $i++){
            ${"id_produk" . ($i +1)} = $produk_array[$i];

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
    public function insert_message()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('pesan', 'pesan', 'required|trim');


        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $pesan = $this->input->post('pesan');

            $data = array(
                'name' => $nama,
                'email' => $email,
                'message' => $pesan,
            );
            $this->data->insert('message_user', $data);

            $response['success'] = "Data successfully inserted!";
        }
        echo json_encode($response);
    }
    public function get_data_history()
    {
        $where = array('email' => $this->session->userdata('email_user'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $query = [
            'select' => 'a.id, a.id_produk, b.name, a.harga_transaksi, a.status ',
            'from' => 'transaksi a',
            'join' => [
                'st_user b, b.id = a.id_pelanggan'
            ],
            'where' => [
                'a.id_pelanggan' => $data['user']['id'],
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
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
        $where = array('email' => $this->session->userdata('email_user'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();

        $where = array('id' => $data['user']['id']);
        $result = $this->data->find('st_user', $where)->result();
        echo json_encode($result);
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
            $where = array('email' => $this->session->userdata('email_user'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $id = $this->input->post('id');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $alamat = $this->input->post('alamat');
            $provinsi = $this->input->post('provinsi');
            $kota = $this->input->post('kota');
            $username = $this->input->post('username');
            $password = $this->input->post('password1');
            $hash = hash("sha256", $password . config_item('encryption_key'));
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'name' => $nama,
                'email' => $email,
                'phone_number' => $telepon,
                'address' => $alamat,
                'province' => $provinsi,
                'city' => $kota,
                'username' => $username,
                'updated_date' => $timestamp,
                'updated_by' => $data['user']['id'],
            );

            if (!empty($password)) {
                $data1 = array('password' => $hash);
                $where = array('id' => $id);
                $update = $this->data->update('st_user', $where, $data1);
            }

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
