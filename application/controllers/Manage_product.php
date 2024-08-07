<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_product extends CI_Controller
{
    var $module_js = ['manage-product'];
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
        $this->app_data['select'] = $this->data->find('kategori_produk', $where)->result();
        $this->app_data['user'] = $this->data->get($user)->row_array();
        $this->app_data['title'] = 'Kelola Produk';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_product', $this->app_data);
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.weight, a.image, b.name, a.id_category_product, a.total_stok, a.exp_date',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product',
            ],
            'where' => [
                'a.is_deleted' => 0
            ]
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'a.id, a.title, a.description, a.price, a.weight, a.image, b.name, a.id_category_product, a.total_stok, a.exp_date',
            'from' => 'produk a',
            'join' => [
                'kategori_produk b, b.id = a.id_category_product'
            ],
            'where' => [
                'a.id' => $id,
            ]
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function insert_data()
    {
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $harga = $this->input->post('harga');
        $berat = $this->input->post('berat');
        $kadaluarsa = $this->input->post('kadaluarsa');
        $kategori_product = $this->input->post('kategori');
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim|callback_check_unique_title');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
        $this->form_validation->set_rules('berat', 'Berat', 'required|trim');
        $this->form_validation->set_rules('kadaluarsa', 'Tanggal kadaluarsa', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($this->input->post('kategori'))) {
                $response['errors']['kategori'] = "Kategori harus dipilih";
            }
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto  harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();


            if (empty($this->input->post('kategori'))) {
                $response['errors']['kategori'] = "Kategori harus dipilih";
            }
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto harus diupload";
            } else {
                $data = array(
                    'title' => $judul,
                    'description' => $deskripsi,
                    'price' => $harga,
                    'weight' => $berat,
                    'exp_date' => $kadaluarsa,
                    'id_category_product' => $kategori_product,
                    'created_by' => $data['user']['id'],
                );

                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/product/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['file_name'] = "Product-" . $currentDateTime;
                    $config['max_size'] = 2048;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
                        echo json_encode($response);
                        return;
                    } else {
                        $uploaded_data = $this->upload->data();
                        $data['image'] = $uploaded_data['file_name'];
                        $this->data->insert('produk', $data);
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
                            title: 'Anda telah melakukan aksi tambah data Data berhasil dimasukkan'
                          })
                      });</script>";
            }
        }
        echo json_encode($response);
    }

    public function check_unique_title($judul)
    {
        $this->db->where('title', $judul);
        $this->db->where('is_deleted', '0');
        $query = $this->db->get('produk');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_title', 'Kolom {field} harus unik');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function edit_data()
    {
        $id = $this->input->post('id');
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $harga = $this->input->post('harga');
        $berat = $this->input->post('berat');
        $kategori_product = $this->input->post('kategori');
        $kadaluarsa = $this->input->post('kadaluarsa');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;
        $data_produk = $this->data->find('produk', array('id' => $id, 'is_deleted' => '0'))->row_array();

        if ($data_produk['title'] !== $judul) {
            $this->form_validation->set_rules('judul', 'Judul', 'required|trim|callback_check_unique_title');
        } else {
            $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        }
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
        $this->form_validation->set_rules('berat', 'Berat', 'required|trim');
        $this->form_validation->set_rules('kadaluarsa', 'Tanggal kadaluarsa', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($this->input->post('kategori'))) {
                $response['errors']['kategori'] = "Kategori harus dipilih";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();


            if (empty($this->input->post('kategori'))) {
                $response['errors']['kategori'] = "Kategori harus dipilih";
            } else {
                $data = array(
                    'title' => $judul,
                    'description' => $deskripsi,
                    'price' => $harga,
                    'weight' => $berat,
                    'exp_date' => $kadaluarsa,
                    'id_category_product' => $kategori_product,
                    'updated_date' => $timestamp,
                    'updated_by' => $data['user']['id'],
                );

                $where = array('id' => $id);
                $updated = $this->data->update('produk', $where, $data);

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

        $updated = $this->data->update('produk', $where, $data);
        if ($updated) {
            $response = "<script>$(document).ready(function () {
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

    function hapus_format_harga($harga)
    {
        $harga = str_replace("Rp. ", "", $harga);
        $harga = str_replace(".", "", $harga);
        $harga = (int)$harga;
        return $harga;
    }

    public function insert_promo()
    {
        $id = $this->input->post('id');
        $stok = $this->input->post('stok');
        $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

        $this->form_validation->set_rules('stok', 'stok', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data = $this->data->find('st_user', $where)->row_array();
            $data_produk = $this->data->find('produk', array('id' => $id))->row_array();
            $data_promo = $this->data->find('produk_promo', array('title' => $data_produk['title']))->row_array();

            if (isset($data_promo)) {
                $stok_baru = $data_promo['total_stok'] + $stok;
                $data = array(
                    'total_stok' => $stok_baru,
                    'updated_by' => $data['id'],
                    'updated_date' => $timestamp
                );
                $this->data->update('produk_promo', array('id' => $data_promo['id']), array('total_stok' => $stok_baru));
            } else {
                $harga_bersih = $this->hapus_format_harga($data_produk['price']);
                $presentase = 0.2 * $harga_bersih;
                $harga_baru = $this->hapus_format_harga($data_produk['price']) - $presentase;
                $data = array(
                    'id_category_product' => $data_produk['id_category_product'],
                    'title' => $data_produk['title'],
                    'description' => $data_produk['description'],
                    'price' => $harga_baru,
                    'weight' => $data_produk['weight'],
                    'image' => $data_produk['image'],
                    'total_stok' => $stok,
                    'created_by' => $data['id'],
                );
                $this->data->insert('produk_promo', $data);
            }

            $total_baru = $data_produk['total_stok'] - $stok;
            $this->data->update('produk', array('id' => $id), array('total_stok' => $total_baru));

            $response['success'] = "<script>$(document).ready(function () {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                          });

                        Toast.fire({
                            icon: 'success',
                            title: 'Anda berhasil memasukkan promo produk'
                          })
                      });</script>";
        }
        echo json_encode($response);
    }
}
