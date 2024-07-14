<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_message extends CI_Controller
{
    var $module_js = ['manage-message'];
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
        $this->app_data['user'] = $this->data->get($user)->row_array();
        $this->app_data['title'] = 'Kelola kritik saran';
        $this->load->view('template-admin/start', $this->app_data);
        $this->load->view('template-admin/header', $this->app_data);
        $this->load->view('menu-admin/manage_message');
        $this->load->view('template-admin/footer');
        $this->load->view('template-admin/end');
        $this->load->view('js-custom', $this->app_data);
    }
    public function get_data()
    {
        $where = array('is_deleted' => '0');
        $result = $this->data->find('message_user', $where)->result();
        echo json_encode($result);
    }

    public function cek_message()
    {
        $id = $this->input->post('id');

        $data = array(
            'status' => '2',
        );
        $where = array('id' => $id);

        $updated = $this->data->update('message_user', $where, $data);
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
                    title: 'Anda telah melakukan aksi ubah status Status sudah dibaca'
                  })
              });</script>";
            echo json_encode($response);
        }
    }
    public function get_data_id()
    {
        $id = $this->input->post('id');
        $where = array('id' => $id);
        $result = $this->data->find('message_user', $where)->result();
        echo json_encode($result);
    }

    public function get_data_info()
    {
        $id = $this->input->post('id');
        $query = [
            'select' => 'a.id, a.name, a.email, a.message, a.date_send, b.message as reply_message, c.name, b.date_send as date_reply',
            'from' => 'message_user a',
            'join' => [
                'reply_message b, b.id_message = a.id',
                'st_user c, b.reply_by = c.id'
            ],
            'where' => [
                'a.id' => $id,
            ]
        ];
        $result = $this->data->get($query)->result();
        echo json_encode($result);
    }

    public function reply_message()
    {
        $this->form_validation->set_rules('reply', 'Reply', 'required|trim');

        if ($this->form_validation->run() == false) {
            $response['errors'] = $this->form_validation->error_array();
        } else {
            $where = array('email' => $this->session->userdata('email'));
            $data['user'] = $this->data->find('st_user', $where)->row_array();
            $id = $this->input->post('id');
            $reply = $this->input->post('reply');
            $data = array(
                'id_message' => $id,
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
