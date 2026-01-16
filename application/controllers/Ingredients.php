<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ingredients extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model('Ingredient_model');
    }

    public function index()
    {
        $data['ingredients'] = $this->Ingredient_model->all();
        $this->load->view('layouts/header');
        $this->load->view('ingredients/index', $data);
        $this->load->view('layouts/footer');
    }

    public function create()
    {
        $data = ['error' => null];
        if ($this->input->method() === 'post') {
            if (!$this->input->post('name')) {
                $data['error'] = 'Informe o nome do ingrediente.';
            } else {
                $this->Ingredient_model->create($this->input->post());
                redirect('ingredients');
                return;
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('ingredients/create', $data);
        $this->load->view('layouts/footer');
    }

    private function require_login(): void
    {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
}
