<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_user extends CI_Controller
{
    var $module_js = ['auth_user'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    private function _init()
    {
        $this->app_data['module_js'] = $this->module_js;
    }

    public function index()
    {
        if ($this->session->userdata('email_user')) {
            redirect('');
        }

        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim',
            ['required' => 'Username harus diisi']
        );
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus diisi']);

        if ($this->form_validation->run() == false) {
            $this->load->view('front_page/auth/login');
            $this->load->view('js-custom', $this->app_data);
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $hash = hash("sha256", $password . config_item('encryption_key'));

            $user = $this->db->where(['username' => $username, 'is_deleted' => '0', 'id_credential' => '3'])->get('st_user')->row_array();

            if ($user) {
                if ($hash == $user['password']) {
                    $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;
                    $ip_address = $this->input->ip_address();
                    $data = array(
                        'ip_address' => $ip_address,
                        'date' => $timestamp
                    );
                    $this->data->insert('st_log_login', $data);

                    $data = [
                        'id_user' => $user['id'],
                        'email_user' => $user['email'],
                        'name_user' => $user['name']
                    ];
                    $this->session->set_userdata($data);
                    $this->session->set_userdata('logged_in_user', TRUE);
                    redirect('');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <strong>ERROR,  </strong>Password yang anda masukkan salah
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ERROR,  </strong>Username yang anda masukkan tidak terdaftar
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
                redirect('login');
            }
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('telepon', 'No HP', 'required|trim|numeric');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[st_user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('password1', 'Ulangi', 'required|trim|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->load->view('front_page/auth/registration');
            $this->load->view('js-custom', $this->app_data);
        } else {
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $telepon = $this->input->post('telepon');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $hash = hash("sha256", $password . config_item('encryption_key'));

            $data = array(
                'name' => $nama,
                'email' => $email,
                'phone_number' => $telepon,
                'username' => $username,
                'password' => $hash,
                'id_credential' => '3'
            );
            $this->data->insert('st_user', $data);
            redirect('login');
        }
    }

    public function logout()
    {
        $data['user'] = $this->db->get_where('st_user', ['email' => $this->session->userdata('email')])->row_array();
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $where = array('id' => $data['user']['id']);
        $data = array('last_login' => $timestamp);
        $this->data->update('st_user', $where, $data);

        $this->session->unset_userdata('id_user');
        $this->session->unset_userdata('name_user');
        $this->session->unset_userdata('email_user');
        $this->session->unset_userdata('logged_in_user');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Anda telah logout,  </strong>Terima kasih sudah menggunakan sistem ini
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('login');
    }
}