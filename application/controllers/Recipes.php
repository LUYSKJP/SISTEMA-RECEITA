<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Recipes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model('Recipe_model');
        $this->load->model('Ingredient_model');
    }

    public function index()
    {
        $data['recipes'] = $this->Recipe_model->all();
        $this->load->view('layouts/header');
        $this->load->view('recipes/index', $data);
        $this->load->view('layouts/footer');
    }

    public function create()
    {
        $data['ingredients'] = $this->Ingredient_model->all();
        $data['error'] = null;
        if ($this->input->method() === 'post') {
            $items = $this->input->post('items');
            if (!$this->input->post('name') || empty($items)) {
                $data['error'] = 'Preencha os dados da receita e pelo menos um ingrediente.';
            } else {
                $items = array_filter($items, static function ($item) {
                    return !empty($item['ingredient_id']) && !empty($item['quantity_g']);
                });
                $recipe_id = $this->Recipe_model->create($this->input->post(), $items);
                redirect('recipes/' . $recipe_id);
                return;
            }
        }
        $this->load->view('layouts/header');
        $this->load->view('recipes/create', $data);
        $this->load->view('layouts/footer');
    }

    public function show(int $id)
    {
        $recipe = $this->Recipe_model->find($id);
        if (!$recipe) {
            show_404();
            return;
        }
        $data['recipe'] = $recipe;
        $data['items'] = $this->Recipe_model->get_items($id);
        $this->load->view('layouts/header');
        $this->load->view('recipes/show', $data);
        $this->load->view('layouts/footer');
    }

    private function require_login(): void
    {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
}
