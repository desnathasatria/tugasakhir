<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_carousel extends CI_Controller
{
    var $module_js = ['manage-carousel'];
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
        $this->app_data['user'] = $this->data->get($user)->row_array();

        $this->app_data['title'] = 'Kelola carousel';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_carousel');
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $where = array('is_deleted' => '0');
        $result = $this->data->find('carousel_menu', $where)->result();
        echo json_encode($result);
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $where = array('id' => $id);
        $result = $this->data->find('carousel_menu', $where)->result();
        echo json_encode($result);
    }

    public function insert_data()
    {
        $judul = $this->input->post('judul');
        $sub = $this->input->post('sub');

        $this->form_validation->set_rules('judul', 'Judul', 'required|trim|callback_check_unique_title');
        $this->form_validation->set_rules('sub', 'Sub', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();


            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            } else {
                $data = array(
                    'title' => $judul,
                    'sub_title' => $sub,
                    'created_by' => $data['user']['id'],
                );

                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/carousel/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['file_name'] = "Carousel-" . $currentDateTime;
                    $config['max_size'] = 2048;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        $response['errors']['image'] = strip_tags($this->upload->display_errors());
                    } else {
                        $uploaded_data = $this->upload->data();

                        $targetWidth = 1920;
                        $targetHeight = 930;

                        $sourcePath = $uploaded_data['full_path'];
                        $imageInfo = getimagesize($sourcePath);
                        $sourceWidth = $imageInfo[0];
                        $sourceHeight = $imageInfo[1];

                        if (($sourceWidth / $sourceHeight) != ($targetWidth / $targetHeight)) {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $sourcePath;
                            $config['maintain_ratio'] = FALSE;
                            $config['width'] = $targetWidth;
                            $config['height'] = $targetHeight;

                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();

                            $data['image'] = $config['file_name'] . $uploaded_data['file_ext'];

                        } else {
                            $data['image'] = $uploaded_data['file_name'];
                        }
                        $this->data->insert('carousel_menu', $data);
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
        $query = $this->db->get('carousel_menu');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_title', 'Kolom {field} harus unik');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function edit_data()
    {
        $judul = $this->input->post('judul');
        $id = $this->input->post('id');
        $title = $this->data->find('carousel_menu', array('id' => $id, 'is_deleted' => '0'))->row_array();

        if ($title['title'] !== $judul) {
            $this->form_validation->set_rules('judul', 'Judul', 'required|trim|callback_check_unique_title');
        } else {
            $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        }

        $this->form_validation->set_rules('sub', 'Sub', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();

        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $sub = $this->input->post('sub');
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'title' => $judul,
                'sub_title' => $sub,
                'updated_date' => $timestamp,
                'updated_by' => $data['user']['id'],
            );

            $where = array('id' => $id);
            $updated = $this->data->update('carousel_menu', $where, $data);

            if (!$updated) {
                $response['errors']['database'] = "Failed to update data in the database.";
            } else {
                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/carousel/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = "Carousel-" . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();

                        $targetWidth = 1920;
                        $targetHeight = 930;

                        $sourcePath = $upload_data['full_path'];
                        $imageInfo = getimagesize($sourcePath);
                        $sourceWidth = $imageInfo[0];
                        $sourceHeight = $imageInfo[1];

                        if (($sourceWidth / $sourceHeight) != ($targetWidth / $targetHeight)) {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = $sourcePath;
                            $config['maintain_ratio'] = FALSE;
                            $config['width'] = $targetWidth;
                            $config['height'] = $targetHeight;

                            $this->load->library('image_lib', $config);
                            $this->image_lib->resize();

                            $file_name = $config['file_name'] . $upload_data['file_ext'];
                        } else {
                            $file_name = $upload_data['file_name'];
                        }

                        $data = array('image' => $file_name);
                        $where = array('id' => $id);
                        $this->data->update('carousel_menu', $where, $data);
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

        $updated = $this->data->update('carousel_menu', $where, $data);
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