<?php
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
        $where = array('is_deleted' => '0');
        $result = $this->data->find('transaksi', $where)->result();
        echo json_encode($result);
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $where = array('id' => $id);
        $result = $this->data->find('transaksi', $where)->result();
        echo json_encode($result);
    }
    public function get_data_info()
    {
        $query = [
            'select' => 'a.id, a.id_produk, a.id_pelanggan, a.harga_transaksi, a.tgl_pembelian, b.title, b.price, c.name',
            'from' => 'transaksi a',
            'join' => [
                'produk b, b.id = a.id_produk',
                'st_user c, c.id = a.id_pelanggan'
            ],
            'where' => [
                'a.is_deleted' => '0',
            ]
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    // public function insert_data()
    // {
    //     $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
    //     $this->form_validation->set_rules('deskripsi', 'deskripsi', 'required|trim');

    //     if ($this->form_validation->run() == false) {
    //         $response['errors'] = $this->form_validation->error_array();
    //         if (empty($this->input->post('kategori'))) {
    //             $response['errors']['kategori'] = "Kategori harus dipilih";
    //         }
    //         if (empty($_FILES['image']['name'])) {
    //             $response['errors']['image'] = "Foto  harus diupload";
    //         }
    //     } else {
    //         $where = array('email' => $this->session->userdata('email'));
    //         $data['user'] = $this->data->find('st_user', $where)->row_array();

    //         $judul = $this->input->post('judul');
    //         $deskripsi = $this->input->post('deskripsi');
    //         $kategori = $this->input->post('kategori');

    //         if (empty($this->input->post('kategori'))) {
    //             $response['errors']['kategori'] = "Kategori harus dipilih";
    //         }
    //         if (empty($_FILES['image']['name'])) {
    //             $response['errors']['image'] = "Foto harus diupload";
    //         } else {
    //             $data = array(
    //                 'title' => $judul,
    //                 'description' => $deskripsi,
    //                 'id_category' => $kategori,
    //                 'created_by' => $data['user']['id'],
    //             );

    //             if (!empty($_FILES['image']['name'])) {
    //                 $currentDateTime = date('Y-m-d_H-i-s');
    //                 $config['upload_path'] = './assets/image/gallery/';
    //                 $config['allowed_types'] = 'gif|jpg|jpeg|png';
    //                 $config['file_name'] = "Gallery-" . $currentDateTime;
    //                 $config['max_size'] = 2048;

    //                 $this->load->library('upload', $config);

    //                 if (!$this->upload->do_upload('image')) {
    //                     $response['errors']['image'] = strip_tags($this->upload->display_errors());
    //                     echo json_encode($response);
    //                     return;
    //                 } else {
    //                     $uploaded_data = $this->upload->data();
    //                     $data['image'] = $uploaded_data['file_name'];
    //                     $this->data->insert('gallery_image', $data);
    //                 }
    //             }
    //             $response['success'] = "<script>$(document).ready(function () {
    //                     var Toast = Swal.mixin({
    //                         toast: true,
    //                         position: 'top-end',
    //                         showConfirmButton: false,
    //                         timer: 2000,
    //                       });

    //                     Toast.fire({
    //                         icon: 'success',
    //                         title: 'Anda telah melakukan aksi tambah data Data berhasil dimasukkan'
    //                       })
    //                   });</script>";
    //         }
    //     }
    //     echo json_encode($response);
    // }
    public function history()
    {

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();
            $id = $this->input->post('id');
            $reply = $this->input->post('reply');
            $data = array(
                'id' => $id,
                'message' => $reply,
                'reply_by' => $data['user']['id'],
            );
            $reply = $this->data->insert('reply_message', $data);

            if ($reply) {
                $data = array(
                    'status' => '3',
                );
                $where = array('id' => $id);
                $this->data->update('message_user', $where, $data);

                $response['success'] = "<script>$(document).ready(function () {
                    var Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                      });
    
                    Toast.fire({
                        icon: 'success',
                        title: 'Anda telah melakukan aksi balas pesan Pesan berhasil dibalas'
                      })
                  });</script>";
            }
        }
        echo json_encode($response);
    
    }
}