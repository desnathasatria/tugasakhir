<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_struktur extends CI_Controller
{
    var $module_js = ['manage-struktur'];
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
        $this->app_data['select'] = $this->data->find('jabatan', $where)->result();

        $this->app_data['title'] = 'Kelola struktur';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_struktur');
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }

    public function get_data()
    {
        $query = [
            'select' => 'a.id, a.name, a.image, a.address, a.NIP, b.name_jabatan',
            'from' => 'employee a',
            'join' => [
                'jabatan b, b.id_jabatan = a.id_bridge'
            ],
            'where' => [
                'a.is_deleted' => '0'
            ],
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function get_data_jabatan()
    {
        if ($this->input->get('searchTerm', TRUE)) {
            $input = $this->input->get('searchTerm', TRUE);
            $query = [
                'select' => 'id, name',
                'from' => 'jabatan',
                'like' => [
                    'name' => "$input, both"
                ],
            ];
            $data = $this->data->get($query)->result();
        } else {
            $query = [
                'select' => 'id, name',
                'from' => 'jabatan',
            ];
            $data = $this->data->get($query)->result();
        }

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function get_data_id()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'a.id, a.name, a.image, a.address, a.NIP, b.id_jabatan , b.name_jabatan',
            'from' => 'employee a',
            'join' => [
                'jabatan b, b.id_jabatan = a.id_bridge'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.id' => $id
            ]
        ];

        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function insert_data()
    {
        $this->form_validation->set_rules('jabatan', 'jabatan', 'required|trim');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('NIP', 'NIP', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();

            $jabatan = $this->input->post('jabatan');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $nip = $this->input->post('NIP');

            $data = array(
                'id_bridge' => $jabatan,
                'name' => $name,
                'address' => $address,
                'NIP' => $nip,
                'created_by' => $data['user']['id'],
            );
            if (!empty($_FILES['image']['name'])) {
                $currentDateTime = date('Y-m-d_H-i-s');
                $config['upload_path'] = './assets/image/employee/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['file_name'] = "Employee-" . $currentDateTime;
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('image')) {
                    $response['errors']['image'] = strip_tags($this->upload->display_errors());
                    echo json_encode($response);
                    return;
                } else {
                    $uploaded_data = $this->upload->data();

                    $targetWidth = 300;
                    $targetHeight = 400;

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
                    $this->data->insert('employee', $data);
                }
            }
            $response['success'] = "Data successfully inserted!";
        }
        echo json_encode($response);
    }

    public function edit_data()
    {
        $this->form_validation->set_rules('jabatan', 'jabatan', 'required');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('NIP', 'NIP', 'required|trim');
        $this->form_validation->set_rules('address', 'Address', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
            if (empty($_FILES['image']['name'])) {
                $response['errors']['image'] = "Foto profil harus diupload";
            }
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();
            $id = $this->input->post('id');
            $jabatan = $this->input->post('jabatan');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $nip = $this->input->post('NIP');
            $timestamp = $this->db->query("SELECT NOW() as timestamp")->row()->timestamp;

            $data = array(
                'id_bridge' => $jabatan,
                'name' => $name,
                'address' => $address,
                'NIP' => $nip,
                'updated_date' => $timestamp,
                'updated_by' => $data['user']['id'],
            );

            $where = array('id' => $id);
            $updated = $this->data->update('employee', $where, $data);

            if (!$updated) {
                $response['errors']['database'] = "Failed to update data in the database.";
            } else {
                if (!empty($_FILES['image']['name'])) {
                    $currentDateTime = date('Y-m-d_H-i-s');
                    $config['upload_path'] = './assets/image/employee/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048;
                    $config['file_name'] = "Employee-" . $currentDateTime;
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();

                        $targetWidth = 300;
                        $targetHeight = 400;

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
                        $this->data->update('employee', $where, $data);
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

        return $this->data->update('employee', $where, $data);
    }
}
