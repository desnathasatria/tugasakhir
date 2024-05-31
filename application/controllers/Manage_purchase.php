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
            'select' => 'a.id, a.id_pelanggan, a.id_produk, a.id_supplier, a.harga_transaksi, a.tgl_pembelian, a.status, b.title ',
            'from' => 'transaksi a',
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
            'select' => 'a.id, a.id_pelanggan, a.id_produk, a.id_supplier, a.harga_transaksi, a.tgl_pembelian, a.status, b.title ',
            'from' => 'transaksi a',
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
    private function cek_stok($id_barang, $jumlah)
    {
        $query = [
            'select' => 'stok',
            'from' => 'supplier',
            'where' => [
                'id_barang' => $id_barang,
                'is_deleted' => '0'
            ]
        ];

        $result = $this->data->get($query)->row_array();
        if ($result) {
            return $result['stok'] >= $jumlah;
        }

        return false;
    }

    private function update_stok($id_barang, $jumlah, $operasi)
    {
        $query = [
            'select' => 'stok',
            'from' => 'supplier',
            'where' => [
                'id_barang' => $id_barang,
                'is_deleted' => '0'
            ]
        ];

        $result = $this->data->get($query)->row_array();
        if ($result) {
            $stok_baru = ($operasi == 'kurang') ? $result['stok'] - $jumlah : $result['stok'] + $jumlah;
            $data_update = array(
                'stok' => $stok_baru
            );
            $where = array('id_barang' => $id_barang);
            $this->data->update('supplier', $where, $data_update);
        }
    }
    public function edit_data()
    {
        $this->form_validation->set_rules('nama', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
        $this->form_validation->set_rules('ongkir', 'Ongkir', 'required|trim');
        $this->form_validation->set_rules('tanggal_pembelian', 'Tanggal Pembelian', 'required|trim');
        $this->form_validation->set_rules('status', 'status', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $judul = $this->input->post('nama');
            $pelanggan = $this->input->post('nama_pelanggan');
            $harga = $this->input->post('harga');
            $ongkir = $this->input->post('ongkir');
            $tanggal = $this->input->post('tgl_pembelian');
            $status = $this->input->post('status');
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

                $data_update = array(
                    'id_produk' => $judul,
                    'id_pelanggan' => $pelanggan,
                    'harga' => $harga,
                    'ongkir' => $ongkir,
                    'tgl_pembelian' => $tanggal,
                    'status' => $status,
                    'updated_date' => $timestamp,
                    'updated_by' => $data['user']['id'],
                );

                $id = $this->input->post('id');
                $where = array('id' => $id);
                $this->data->update('transaksi', $where, $data_update);

                if (!$updated) {
                    $response['errors']['database'] = "Failed to update data in the database.";
                } else {
                    if (!empty($_FILES['image']['name'])) {
                        $currentDateTime = date('Y-m-d_H-i-s');
                        $config['upload_path'] = './assets/image/product/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size'] = 2048;
                        $config['file_name'] = "Product-" . $currentDateTime;
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload('image')) {
                            $upload_data = $this->upload->data();
                            $file_name = $upload_data['file_name'];

                            $data = array('image' => $file_name);
                            $where = array('id' => $id);
                            $this->data->update('produk', $where, $data);
                        } else {
                            $response['errors']['image'] = strip_tags($this->upload->display_errors());
                        }
                    }
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
