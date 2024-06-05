<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Front_page extends CI_Controller
{
    var $module_js = ['letter', 'history', 'message', 'profile'];
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
    }
    public function location()
    {
        $this->check_auth();
        $this->app_data['location'] = $this->data->get_all('company_profile')->result();
        $this->load->view('front_page/location', $this->app_data);
        $this->footer();
    }
    public function checkout($x)
    {
        $this->check_auth();
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

        $this->app_data['produk'] = $this->data->get($query)->result();
        $this->load->view('front_page/checkout', $this->app_data);
        $this->footer();
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
        $where = array('email' => $this->session->userdata('email'));
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
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password Baru', 'trim|min_length[8]');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $id = $this->input->post('id');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $alamat = $this->input->post('alamat');
            $username = $this->input->post('username');
            $password = $this->input->post('password1');
            $hash = hash("sha256", $password . config_item('encryption_key'));
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'name' => $nama,
                'email' => $email,
                'phone_number' => $telepon,
                'address' => $alamat,
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

                if (!empty($_FILES['ktp']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/user/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = $username . ' - ' . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('ktp')) {
                        $upload_data = $this->upload->data();
                        $file_name = $upload_data['file_name'];

                        $data = array('card_image' => $file_name);
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
