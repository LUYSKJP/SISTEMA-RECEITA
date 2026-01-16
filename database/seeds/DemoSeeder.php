<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DemoSeeder extends CI_Seeder
{
    public function run()
    {
        $this->db->truncate('users');
        $this->db->truncate('ingredients');
        $this->db->truncate('ingredient_nutrients');
        $this->db->truncate('recipes');
        $this->db->truncate('recipe_items');
        $this->db->truncate('regulatory_versions');
        $this->db->truncate('vdr_values');
        $this->db->truncate('fop_thresholds');
        $this->db->truncate('label_rounding_rules');

        $this->db->insert('users', [
            'username' => 'admin',
            'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->insert('regulatory_versions', [
            'code' => 'RDC429_IN75_v1',
            'name' => 'RDC 429/2020 + IN 75/2020',
            'is_active' => 1,
            'label_width' => 720,
            'label_height' => 540,
            'fop_width' => 220,
            'fop_height' => 80,
        ]);
        $version_id = $this->db->insert_id();

        $vdr_values = [
            ['nutrient_key' => 'kcal', 'vdr_value' => 2000, 'unit' => 'kcal'],
            ['nutrient_key' => 'carbs', 'vdr_value' => 300, 'unit' => 'g'],
            ['nutrient_key' => 'protein', 'vdr_value' => 75, 'unit' => 'g'],
            ['nutrient_key' => 'fat_total', 'vdr_value' => 55, 'unit' => 'g'],
            ['nutrient_key' => 'fat_saturated', 'vdr_value' => 22, 'unit' => 'g'],
            ['nutrient_key' => 'fiber', 'vdr_value' => 25, 'unit' => 'g'],
            ['nutrient_key' => 'sodium', 'vdr_value' => 2000, 'unit' => 'mg'],
            ['nutrient_key' => 'sugars_added', 'vdr_value' => 50, 'unit' => 'g'],
        ];
        foreach ($vdr_values as $value) {
            $value['regulatory_version_id'] = $version_id;
            $this->db->insert('vdr_values', $value);
        }

        $thresholds = [
            ['nutrient_key' => 'sugars_added', 'threshold_value' => 15, 'unit' => 'g', 'basis' => '100g'],
            ['nutrient_key' => 'fat_saturated', 'threshold_value' => 6, 'unit' => 'g', 'basis' => '100g'],
            ['nutrient_key' => 'sodium', 'threshold_value' => 600, 'unit' => 'mg', 'basis' => '100g'],
        ];
        foreach ($thresholds as $threshold) {
            $threshold['regulatory_version_id'] = $version_id;
            $this->db->insert('fop_thresholds', $threshold);
        }

        $rounding_rules = [
            ['nutrient_key' => 'kcal', 'significant_threshold' => 0.5, 'decimals' => 0, 'rounding_mode' => 'nearest', 'unit' => 'kcal'],
            ['nutrient_key' => 'carbs', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'sugars_total', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'sugars_added', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'protein', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'fat_total', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'fat_saturated', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'fat_trans', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'fiber', 'significant_threshold' => 0.1, 'decimals' => 1, 'rounding_mode' => 'nearest', 'unit' => 'g'],
            ['nutrient_key' => 'sodium', 'significant_threshold' => 5, 'decimals' => 0, 'rounding_mode' => 'nearest', 'unit' => 'mg'],
        ];
        foreach ($rounding_rules as $rule) {
            $rule['regulatory_version_id'] = $version_id;
            $this->db->insert('label_rounding_rules', $rule);
        }

        $ingredients = [
            ['name' => 'Açúcar refinado', 'brand' => 'Genérico', 'nutrients' => ['kcal' => 387, 'carbs' => 99.6, 'sugars_total' => 99.6, 'sugars_added' => 99.6]],
            ['name' => 'Leite condensado', 'brand' => 'Marca A', 'nutrients' => ['kcal' => 321, 'carbs' => 55, 'sugars_total' => 55, 'sugars_added' => 45, 'protein' => 7, 'fat_total' => 8, 'fat_saturated' => 5, 'sodium' => 120]],
            ['name' => 'Creme de leite', 'brand' => 'Marca B', 'nutrients' => ['kcal' => 200, 'carbs' => 4, 'protein' => 2, 'fat_total' => 20, 'fat_saturated' => 12, 'sodium' => 50]],
            ['name' => 'Suco de maracujá', 'brand' => 'Natural', 'nutrients' => ['kcal' => 60, 'carbs' => 14, 'sugars_total' => 12, 'fiber' => 1]],
            ['name' => 'Ovos', 'brand' => 'Fazenda', 'nutrients' => ['kcal' => 143, 'protein' => 13, 'fat_total' => 10, 'fat_saturated' => 3, 'sodium' => 140]],
            ['name' => 'Farinha de trigo', 'brand' => 'Tipo 1', 'nutrients' => ['kcal' => 364, 'carbs' => 76, 'protein' => 10, 'fat_total' => 1, 'fiber' => 2.3]],
            ['name' => 'Manteiga', 'brand' => 'Marca C', 'nutrients' => ['kcal' => 717, 'fat_total' => 81, 'fat_saturated' => 51, 'fat_trans' => 3, 'sodium' => 11]],
            ['name' => 'Sal', 'brand' => 'Refinado', 'nutrients' => ['sodium' => 38758]],
            ['name' => 'Gelatina incolor', 'brand' => 'Marca D', 'nutrients' => ['kcal' => 335, 'protein' => 85]],
            ['name' => 'Água', 'brand' => 'Mineral', 'nutrients' => []],
        ];

        foreach ($ingredients as $ingredient) {
            $this->db->insert('ingredients', [
                'name' => $ingredient['name'],
                'brand' => $ingredient['brand'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $ingredient_id = $this->db->insert_id();
            $nutrients = array_merge([
                'ingredient_id' => $ingredient_id,
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
            ], $ingredient['nutrients']);
            $this->db->insert('ingredient_nutrients', $nutrients);
        }

        $this->db->insert('recipes', [
            'name' => 'Torta de Maracujá',
            'category' => 'Tortas',
            'yield_final_g' => 1200,
            'loss_percent' => 5,
            'portion_g' => 80,
            'household_measure' => '1 fatia (80 g)',
            'servings_per_package' => 15,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $recipe_id = $this->db->insert_id();

        $recipe_items = [
            ['ingredient_id' => 1, 'quantity_g' => 120],
            ['ingredient_id' => 2, 'quantity_g' => 395],
            ['ingredient_id' => 3, 'quantity_g' => 200],
            ['ingredient_id' => 4, 'quantity_g' => 150],
            ['ingredient_id' => 5, 'quantity_g' => 100],
            ['ingredient_id' => 6, 'quantity_g' => 200],
            ['ingredient_id' => 7, 'quantity_g' => 80],
            ['ingredient_id' => 8, 'quantity_g' => 5],
            ['ingredient_id' => 9, 'quantity_g' => 20],
            ['ingredient_id' => 10, 'quantity_g' => 20],
        ];
        foreach ($recipe_items as $item) {
            $item['recipe_id'] = $recipe_id;
            $item['unit'] = 'g';
            $this->db->insert('recipe_items', $item);
        }
    }
}
