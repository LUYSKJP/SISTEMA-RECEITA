<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_Tables extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'username' => ['type' => 'VARCHAR', 'constraint' => 50],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('users', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'brand' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'moisture' => ['type' => 'DECIMAL', 'constraint' => '6,2', 'null' => true],
            'density' => ['type' => 'DECIMAL', 'constraint' => '6,3', 'null' => true],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('ingredients', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'ingredient_id' => ['type' => 'INT', 'constraint' => 11],
            'kcal' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'carbs' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'sugars_total' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'sugars_added' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'protein' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'fat_total' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'fat_saturated' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'fat_trans' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'fiber' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
            'sodium' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'default' => 0],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('ingredient_id');
        $this->dbforge->create_table('ingredient_nutrients', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('allergen_catalog', true);

        $this->dbforge->add_field([
            'ingredient_id' => ['type' => 'INT', 'constraint' => 11],
            'allergen_id' => ['type' => 'INT', 'constraint' => 11],
        ]);
        $this->dbforge->add_key(['ingredient_id', 'allergen_id'], true);
        $this->dbforge->create_table('ingredient_allergens', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'category' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'yield_final_g' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'loss_percent' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'portion_g' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'household_measure' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'servings_per_package' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('recipes', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'recipe_id' => ['type' => 'INT', 'constraint' => 11],
            'ingredient_id' => ['type' => 'INT', 'constraint' => 11],
            'quantity_g' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'unit' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'g'],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('recipe_id');
        $this->dbforge->create_table('recipe_items', true);

        $this->dbforge->add_field([
            'recipe_id' => ['type' => 'INT', 'constraint' => 11],
            'allergen_id' => ['type' => 'INT', 'constraint' => 11],
        ]);
        $this->dbforge->add_key(['recipe_id', 'allergen_id'], true);
        $this->dbforge->create_table('recipe_allergens', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'code' => ['type' => 'VARCHAR', 'constraint' => 80],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'label_width' => ['type' => 'INT', 'constraint' => 11, 'default' => 720],
            'label_height' => ['type' => 'INT', 'constraint' => 11, 'default' => 540],
            'fop_width' => ['type' => 'INT', 'constraint' => 11, 'default' => 220],
            'fop_height' => ['type' => 'INT', 'constraint' => 11, 'default' => 80],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('regulatory_versions', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'regulatory_version_id' => ['type' => 'INT', 'constraint' => 11],
            'nutrient_key' => ['type' => 'VARCHAR', 'constraint' => 50],
            'vdr_value' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'unit' => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('regulatory_version_id');
        $this->dbforge->create_table('vdr_values', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'regulatory_version_id' => ['type' => 'INT', 'constraint' => 11],
            'nutrient_key' => ['type' => 'VARCHAR', 'constraint' => 50],
            'threshold_value' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'unit' => ['type' => 'VARCHAR', 'constraint' => 20],
            'basis' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => '100g'],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('regulatory_version_id');
        $this->dbforge->create_table('fop_thresholds', true);

        $this->dbforge->add_field([
            'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
            'regulatory_version_id' => ['type' => 'INT', 'constraint' => 11],
            'nutrient_key' => ['type' => 'VARCHAR', 'constraint' => 50],
            'significant_threshold' => ['type' => 'DECIMAL', 'constraint' => '10,4', 'default' => 0],
            'decimals' => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'rounding_mode' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'nearest'],
            'unit' => ['type' => 'VARCHAR', 'constraint' => 20],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_key('regulatory_version_id');
        $this->dbforge->create_table('label_rounding_rules', true);
    }

    public function down()
    {
        $this->dbforge->drop_table('label_rounding_rules', true);
        $this->dbforge->drop_table('fop_thresholds', true);
        $this->dbforge->drop_table('vdr_values', true);
        $this->dbforge->drop_table('regulatory_versions', true);
        $this->dbforge->drop_table('recipe_allergens', true);
        $this->dbforge->drop_table('recipe_items', true);
        $this->dbforge->drop_table('recipes', true);
        $this->dbforge->drop_table('ingredient_allergens', true);
        $this->dbforge->drop_table('allergen_catalog', true);
        $this->dbforge->drop_table('ingredient_nutrients', true);
        $this->dbforge->drop_table('ingredients', true);
        $this->dbforge->drop_table('users', true);
    }
}
