<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ingredient_model extends CI_Model
{
    public function all(): array
    {
        $this->db->select('ingredients.*, ingredient_nutrients.kcal, ingredient_nutrients.carbs, ingredient_nutrients.sugars_total, ingredient_nutrients.sugars_added, ingredient_nutrients.protein, ingredient_nutrients.fat_total, ingredient_nutrients.fat_saturated, ingredient_nutrients.fat_trans, ingredient_nutrients.fiber, ingredient_nutrients.sodium');
        $this->db->from('ingredients');
        $this->db->join('ingredient_nutrients', 'ingredient_nutrients.ingredient_id = ingredients.id');
        return $this->db->get()->result_array();
    }

    public function find(int $id): ?array
    {
        $this->db->select('ingredients.*, ingredient_nutrients.kcal, ingredient_nutrients.carbs, ingredient_nutrients.sugars_total, ingredient_nutrients.sugars_added, ingredient_nutrients.protein, ingredient_nutrients.fat_total, ingredient_nutrients.fat_saturated, ingredient_nutrients.fat_trans, ingredient_nutrients.fiber, ingredient_nutrients.sodium');
        $this->db->from('ingredients');
        $this->db->join('ingredient_nutrients', 'ingredient_nutrients.ingredient_id = ingredients.id');
        $this->db->where('ingredients.id', $id);
        $row = $this->db->get()->row_array();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $this->db->insert('ingredients', [
            'name' => $data['name'],
            'brand' => $data['brand'] ?? null,
            'moisture' => $data['moisture'] ?? null,
            'density' => $data['density'] ?? null,
            'notes' => $data['notes'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $ingredient_id = (int) $this->db->insert_id();
        $this->db->insert('ingredient_nutrients', [
            'ingredient_id' => $ingredient_id,
            'kcal' => $data['kcal'] ?? 0,
            'carbs' => $data['carbs'] ?? 0,
            'sugars_total' => $data['sugars_total'] ?? 0,
            'sugars_added' => $data['sugars_added'] ?? 0,
            'protein' => $data['protein'] ?? 0,
            'fat_total' => $data['fat_total'] ?? 0,
            'fat_saturated' => $data['fat_saturated'] ?? 0,
            'fat_trans' => $data['fat_trans'] ?? 0,
            'fiber' => $data['fiber'] ?? 0,
            'sodium' => $data['sodium'] ?? 0,
        ]);
        return $ingredient_id;
    }
}
