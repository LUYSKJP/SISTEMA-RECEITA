<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Regulatory_model extends CI_Model
{
    public function get_active_version(): ?array
    {
        $version = $this->db->get_where('regulatory_versions', ['is_active' => 1])->row_array();
        return $version ?: null;
    }

    public function get_vdr_values(int $version_id): array
    {
        $rows = $this->db->get_where('vdr_values', ['regulatory_version_id' => $version_id])->result_array();
        $values = [];
        foreach ($rows as $row) {
            $values[$row['nutrient_key']] = $row;
        }
        return $values;
    }

    public function get_thresholds(int $version_id): array
    {
        $rows = $this->db->get_where('fop_thresholds', ['regulatory_version_id' => $version_id])->result_array();
        $values = [];
        foreach ($rows as $row) {
            $values[$row['nutrient_key']] = $row;
        }
        return $values;
    }

    public function get_rounding_rules(int $version_id): array
    {
        $rows = $this->db->get_where('label_rounding_rules', ['regulatory_version_id' => $version_id])->result_array();
        $values = [];
        foreach ($rows as $row) {
            $values[$row['nutrient_key']] = $row;
        }
        return $values;
    }
}
