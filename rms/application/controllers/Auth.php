<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('rms_model');
        $this->sess = $this->session->userdata('admin');
    }

    function index()
    {
        if (!$this->sess) {
            redirect(base_url() . 'auth/login');
            exit();
        } else {
            header('Location: ' . base_url() . 'rms/dashboard');
            exit();
        }
    }
    function login()
    {
        if (!$this->sess) {
            $this->load->view('rms/auth/index');
        } else {
            redirect(base_url() . 'rms/dashboard');
            exit();
        }
    }

    function login_process()
    {
        $username = $this->input->post('uname');
        $password = $this->input->post('pwd');
        $pass = md5($password);
        if ($username != null and $password != null) {

            $src = $this->rms_model->Get_Auth($username, $pass);
            if ($src->num_rows() == 0) {
                $this->session->set_flashdata('status', 'failed');
                echo "users not exist wherever OR wrong password!";
            } else {
                $users = $src->row();
                $this->session->set_userdata('admin', $users);

                /*
                  $last_log = array(
                  'last_login' => date("Y-m-d H:i:s"),
                  );
                  $lastlog = $this->m_model->update('tbl_users', $last_log, $users->id_user);
                 */
                echo "1";
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'admin/');
    }
}
