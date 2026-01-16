<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Recipe_model extends CI_Model
{
    public function all(): array
    {
        return $this->db->get('recipes')->result_array();
    }

    public function find(int $id): ?array
    {
        $recipe = $this->db->get_where('recipes', ['id' => $id])->row_array();
        return $recipe ?: null;
    }

    public function get_items(int $recipe_id): array
    {
        $this->db->select('recipe_items.*, ingredients.name as ingredient_name, ingredient_nutrients.*');
        $this->db->from('recipe_items');
        $this->db->join('ingredients', 'ingredients.id = recipe_items.ingredient_id');
        $this->db->join('ingredient_nutrients', 'ingredient_nutrients.ingredient_id = ingredients.id');
        $this->db->where('recipe_items.recipe_id', $recipe_id);
        return $this->db->get()->result_array();
    }

    public function create(array $data, array $items): int
    {
        $this->db->insert('recipes', [
            'name' => $data['name'],
            'category' => $data['category'],
            'yield_final_g' => $data['yield_final_g'],
            'loss_percent' => $data['loss_percent'],
            'portion_g' => $data['portion_g'],
            'household_measure' => $data['household_measure'],
            'servings_per_package' => $data['servings_per_package'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $recipe_id = (int) $this->db->insert_id();
        foreach ($items as $item) {
            $this->db->insert('recipe_items', [
                'recipe_id' => $recipe_id,
                'ingredient_id' => $item['ingredient_id'],
                'quantity_g' => $item['quantity_g'],
                'unit' => $item['unit'] ?? 'g',
            ]);
        }
        return $recipe_id;
    }

    public function calculate_nutrition(array $recipe, array $items, array $vdr_values, array $rounding_rules, array $thresholds): array
    {
        $nutrients = [
            'kcal' => 0,
            'carbs' => 0,
            'sugars_total' => 0,
            'sugars_added' => 0,
            'protein' => 0,
            'fat_total' => 0,
            'fat_saturated' => 0,
            'fat_trans' => 0,
            'fiber' => 0,
            'sodium' => 0,
        ];

        foreach ($items as $item) {
            $factor = $item['quantity_g'] / 100;
            foreach ($nutrients as $key => $value) {
                $nutrients[$key] += $item[$key] * $factor;
            }
        }

        $yield = max((float) $recipe['yield_final_g'], 1);
        $portion_g = max((float) $recipe['portion_g'], 1);

        $per_100g = [];
        $per_portion = [];
        $vd = [];

        foreach ($nutrients as $key => $value) {
            $per_100g[$key] = ($value / $yield) * 100;
            $per_portion[$key] = $per_100g[$key] * ($portion_g / 100);
            if (isset($vdr_values[$key]) && $vdr_values[$key]['vdr_value'] > 0) {
                $vd[$key] = ($per_portion[$key] / $vdr_values[$key]['vdr_value']) * 100;
            } else {
                $vd[$key] = null;
            }
        }

        $per_100g = $this->apply_rounding($per_100g, $rounding_rules);
        $per_portion = $this->apply_rounding($per_portion, $rounding_rules);
        $vd = $this->apply_vd_rounding($vd);

        $fop = $this->evaluate_fop($per_100g, $thresholds);

        return [
            'totals' => $nutrients,
            'per_100g' => $per_100g,
            'per_portion' => $per_portion,
            'vd' => $vd,
            'fop' => $fop,
        ];
    }

    private function apply_rounding(array $values, array $rules): array
    {
        $rounded = [];
        foreach ($values as $key => $value) {
            if (!isset($rules[$key])) {
                $rounded[$key] = $value;
                continue;
            }
            $rule = $rules[$key];
            if ($value < (float) $rule['significant_threshold']) {
                $rounded[$key] = 0;
                continue;
            }
            $rounded[$key] = $this->round_value($value, (int) $rule['decimals'], $rule['rounding_mode']);
        }
        return $rounded;
    }

    private function apply_vd_rounding(array $values): array
    {
        $rounded = [];
        foreach ($values as $key => $value) {
            if ($value === null) {
                $rounded[$key] = null;
                continue;
            }
            $rounded[$key] = round($value, 0);
        }
        return $rounded;
    }

    private function evaluate_fop(array $per_100g, array $thresholds): array
    {
        $labels = [];
        $map = [
            'sugars_added' => 'ALTO EM AÇÚCARES ADICIONADOS',
            'fat_saturated' => 'ALTO EM GORDURA SATURADA',
            'sodium' => 'ALTO EM SÓDIO',
        ];
        foreach ($map as $key => $label) {
            if (!isset($thresholds[$key])) {
                continue;
            }
            if ($per_100g[$key] >= $thresholds[$key]['threshold_value']) {
                $labels[] = $label;
            }
        }
        return $labels;
    }

    private function round_value(float $value, int $decimals, string $mode): float
    {
        if ($mode === 'down') {
            $factor = pow(10, $decimals);
            return floor($value * $factor) / $factor;
        }
        if ($mode === 'up') {
            $factor = pow(10, $decimals);
            return ceil($value * $factor) / $factor;
        }
        return round($value, $decimals);
    }
}
