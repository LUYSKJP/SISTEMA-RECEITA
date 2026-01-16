<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Config extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model('Regulatory_model');
    }

    public function index()
    {
        $version = $this->Regulatory_model->get_active_version();
        if (!$version) {
            show_error('Nenhuma versão regulatória ativa.');
            return;
        }

        if ($this->input->method() === 'post') {
            $this->update_values((int) $version['id']);
            redirect('config-anvisa');
            return;
        }

        $data = [
            'version' => $version,
            'vdr' => $this->Regulatory_model->get_vdr_values((int) $version['id']),
            'thresholds' => $this->Regulatory_model->get_thresholds((int) $version['id']),
            'rounding' => $this->Regulatory_model->get_rounding_rules((int) $version['id']),
        ];

        $this->load->view('layouts/header');
        $this->load->view('config/index', $data);
        $this->load->view('layouts/footer');
    }

    private function update_values(int $version_id): void
    {
        $label = $this->input->post('label');
        if (is_array($label)) {
            $this->db->where('id', $version_id)->update('regulatory_versions', [
                'label_width' => $label['label_width'] ?? 720,
                'label_height' => $label['label_height'] ?? 540,
                'fop_width' => $label['fop_width'] ?? 220,
                'fop_height' => $label['fop_height'] ?? 80,
            ]);
        }
        $vdr = $this->input->post('vdr');
        if (is_array($vdr)) {
            foreach ($vdr as $id => $row) {
                $this->db->where('id', $id)->where('regulatory_version_id', $version_id)->update('vdr_values', [
                    'vdr_value' => $row['vdr_value'],
                ]);
            }
        }
        $thresholds = $this->input->post('thresholds');
        if (is_array($thresholds)) {
            foreach ($thresholds as $id => $row) {
                $this->db->where('id', $id)->where('regulatory_version_id', $version_id)->update('fop_thresholds', [
                    'threshold_value' => $row['threshold_value'],
                ]);
            }
        }
        $rounding = $this->input->post('rounding');
        if (is_array($rounding)) {
            foreach ($rounding as $id => $row) {
                $this->db->where('id', $id)->where('regulatory_version_id', $version_id)->update('label_rounding_rules', [
                    'significant_threshold' => $row['significant_threshold'],
                    'decimals' => $row['decimals'],
                    'rounding_mode' => $row['rounding_mode'],
                ]);
            }
        }
    }

    private function require_login(): void
    {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
}
