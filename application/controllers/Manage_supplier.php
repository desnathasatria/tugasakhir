<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_supplier extends CI_Controller
{
    var $module_js = ['manage-supplier'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->is_logged_in()) {
            redirect('auth');
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
        $this->app_data['user'] = $this->data->get($user)->row_array();

        $where = array('is_deleted' => '0');
        $this->app_data['select'] = $this->data->find('produk', $where)->result();

        $this->app_data['title'] = 'Kelola supplier';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_supplier');
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $query = [
            'select' => 'a.id, a.id_produk, a.nama_supplier, a.stok, b.title ',
            'from' => 'supplier a',
            'join' => [
                'produk b, b.id = a.id_produk'
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
            'select' => 'a.id, a.id_produk, a.nama_supplier, a.stok, b.title ',
            'from' => 'supplier a',
            'join' => [
                'produk b, b.id = a.id_produk'
            ],
            'where' => [
                'a.id' => $id,
            ]
        ];

        $result = $this->data->get($query)->result();        
        echo json_encode($result);
    }

    public function get_data_supplier()
{
    if ($this->input->get('searchTerm', TRUE)) {
        $input = $this->input->get('searchTerm', TRUE);
        $query = [
            'select' => 'id, title',
            'from' => 'supplier',
            'like' => [
                'title' => $input, // Mengubah 'name' menjadi 'title'
            ],
        ];
        $data = $this->data->get($query)->result();
    } else {
        $query = [
            'select' => 'id, title',
            'from' => 'supplier',
        ];
        $data = $this->data->get($query)->result();
    }

    $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
}

public function insert_data()
{
    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
    $this->form_validation->set_rules('stok', 'stok', 'required|trim');

    if ($this->form_validation->run() == false) {
        $response['errors'] = $this->form_validation->error_array();
    } else {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $judul = $this->input->post('nama');
        $nama_supplier = $this->input->post('nama_supplier');
        $stok = $this->input->post('stok');
        $cek_data = $this->data->find('supplier', array('id_produk' => $judul, 'is_deleted' => '0'))->row_array();
        if(isset($cek_data)){
            $response['errors']['nama'] = "data produk sudah ada";
        } else{
            $data_insert = array( 
                'id_produk' => $judul,
                'nama_supplier' => $nama_supplier,
                'stok' => $stok,
                'created_by' => $data['user']['id'],
            );
            $this->data->insert('supplier', $data_insert); // Menggunakan $data_insert untuk memasukkan data
    
            $response['success'] = "<script>$(document).ready(function () {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                  });
    
                Toast.fire({
                    icon: 'success',
                    title: 'Anda telah melakukan aksi tambah data. Data berhasil dimasukkan.'
                  })
              });</script>";
        }
    }
    echo json_encode($response);
}

public function edit_data()
{
    $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
    $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
    $this->form_validation->set_rules('stok', 'stok', 'required|trim');

    if ($this->form_validation->run() == false) {
        $response['errors'] = $this->form_validation->error_array();
    } else {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();

        $judul = $this->input->post('nama');
        $nama_supplier = $this->input->post('nama_supplier');
        $stok = $this->input->post('stok');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $data_update = array( // Mengubah variabel $data menjadi $data_update untuk menghindari konflik
            'id_produk' => $judul, // Mengubah 'title' menjadi 'judul'
            'nama_supplierk' => $nama_supplier, // Mengubah 'title' menjadi 'judul'
            'stok' => $stok,
            'updated_date' => $timestamp,
            'updated_by' => $data['user']['id'],
        );

        $id = $this->input->post('id'); // Mengambil nilai id dari inputan POST
        $where = array('id' => $id);
        $this->data->update('supplier', $where, $data_update); // Menggunakan $data_update untuk mengupdate data
        $response['success'] = "<script>$(document).ready(function () {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
              });

            Toast.fire({
                icon: 'success',
                title: 'Anda telah melakukan aksi edit data. Data berhasil diedit.'
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

    $data_update = array( // Mengubah variabel $data menjadi $data_update untuk menghindari konflik
        'is_deleted' => '1',
        'deleted_date' => $timestamp,
        'deleted_by' => $data['user']['id'],
    );
    $where = array('id' => $id);

    $updated = $this->data->update('supplier', $where, $data_update);
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
                title: 'Anda telah melakukan aksi hapus data. Data berhasil dihapus.'
              })
          });</script>";
    }
    echo json_encode($response);
}
}

