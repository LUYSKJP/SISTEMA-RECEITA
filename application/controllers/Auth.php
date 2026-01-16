<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function login()
    {
        $data = ['error' => null];
        if ($this->input->method() === 'post') {
            $this->load->model('User_model');
            $user = $this->User_model->authenticate(
                $this->input->post('username'),
                $this->input->post('password')
            );
            if ($user) {
                $this->session->set_userdata('user_id', $user['id']);
                redirect('recipes');
                return;
            }
            $data['error'] = 'Usuário ou senha inválidos.';
        }
        $this->load->view('auth/login', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
