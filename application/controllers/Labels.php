<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;

class Labels extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->model('Recipe_model');
        $this->load->model('Regulatory_model');
    }

    public function preview(int $recipe_id)
    {
        $recipe = $this->Recipe_model->find($recipe_id);
        if (!$recipe) {
            show_404();
            return;
        }
        $items = $this->Recipe_model->get_items($recipe_id);
        $version = $this->Regulatory_model->get_active_version();
        $vdr = $version ? $this->Regulatory_model->get_vdr_values((int) $version['id']) : [];
        $rounding = $version ? $this->Regulatory_model->get_rounding_rules((int) $version['id']) : [];
        $thresholds = $version ? $this->Regulatory_model->get_thresholds((int) $version['id']) : [];

        $nutrition = $this->Recipe_model->calculate_nutrition($recipe, $items, $vdr, $rounding, $thresholds);

        $data = [
            'recipe' => $recipe,
            'nutrition' => $nutrition,
            'vdr' => $vdr,
            'version' => $version,
        ];

        $format = $this->input->get('format');
        if ($format === 'pdf') {
            $this->render_pdf($data);
            return;
        }

        $this->load->view('layouts/header');
        $this->load->view('labels/preview', $data);
        $this->load->view('layouts/footer');
    }

    public function fop(int $recipe_id)
    {
        $recipe = $this->Recipe_model->find($recipe_id);
        if (!$recipe) {
            show_404();
            return;
        }
        $items = $this->Recipe_model->get_items($recipe_id);
        $version = $this->Regulatory_model->get_active_version();
        $vdr = $version ? $this->Regulatory_model->get_vdr_values((int) $version['id']) : [];
        $rounding = $version ? $this->Regulatory_model->get_rounding_rules((int) $version['id']) : [];
        $thresholds = $version ? $this->Regulatory_model->get_thresholds((int) $version['id']) : [];

        $nutrition = $this->Recipe_model->calculate_nutrition($recipe, $items, $vdr, $rounding, $thresholds);

        $format = $this->input->get('format') ?? 'svg';
        $width = (int) ($version['label_width'] ?? 720);
        $height = (int) ($version['label_height'] ?? 540);

        if ($format === 'png') {
            $this->render_png($recipe, $nutrition, $width, $height);
            return;
        }

        $svg = $this->build_svg($recipe, $nutrition, $width, $height, (int) ($version['fop_width'] ?? 220), (int) ($version['fop_height'] ?? 80));
        $this->output->set_content_type('image/svg+xml')->set_output($svg);
    }

    private function render_pdf(array $data): void
    {
        if (!class_exists(Dompdf::class)) {
            show_error('Dompdf não instalado. Execute composer require dompdf/dompdf.');
            return;
        }
        $html = $this->load->view('labels/pdf', $data, true);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4');
        $dompdf->render();
        $dompdf->stream('rotulo.pdf', ['Attachment' => true]);
    }

    private function render_png(array $recipe, array $nutrition, int $width, int $height): void
    {
        $image = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        imagefill($image, 0, 0, $white);

        $y = 20;
        imagestring($image, 5, 20, $y, 'INFORMACAO NUTRICIONAL', $black);
        $y += 20;
        imagestring($image, 3, 20, $y, 'Porcao: ' . $recipe['portion_g'] . ' g', $black);
        $y += 15;
        imagestring($image, 3, 20, $y, 'Porcoes por embalagem: ' . $recipe['servings_per_package'], $black);
        $y += 25;

        $rows = [
            'kcal' => 'Valor energetico (kcal)',
            'carbs' => 'Carboidratos (g)',
            'sugars_total' => 'Acucares totais (g)',
            'sugars_added' => 'Acucares adicionados (g)',
            'protein' => 'Proteinas (g)',
            'fat_total' => 'Gorduras totais (g)',
            'fat_saturated' => 'Gorduras saturadas (g)',
            'fat_trans' => 'Gorduras trans (g)',
            'fiber' => 'Fibra alimentar (g)',
            'sodium' => 'Sodio (mg)',
        ];
        foreach ($rows as $key => $label) {
            $line = $label . ': ' . $nutrition['per_portion'][$key] . ' | ' . ($nutrition['vd'][$key] === null ? '-' : $nutrition['vd'][$key] . '%') . ' | ' . $nutrition['per_100g'][$key];
            imagestring($image, 2, 20, $y, $line, $black);
            $y += 15;
        }

        $y += 20;
        imagestring($image, 4, 20, $y, 'LUPA', $black);
        $y += 18;
        if (empty($nutrition['fop'])) {
            imagestring($image, 2, 20, $y, 'Nenhum selo aplicavel.', $black);
        } else {
            foreach ($nutrition['fop'] as $label) {
                imagestring($image, 3, 20, $y, $label, $black);
                $y += 16;
            }
        }

        $this->output->set_content_type('image/png');
        imagepng($image);
        imagedestroy($image);
    }

    private function build_svg(array $recipe, array $nutrition, int $width, int $height, int $fopWidth, int $fopHeight): string
    {
        $rows = [
            'kcal' => ['Valor energetico', 'kcal'],
            'carbs' => ['Carboidratos', 'g'],
            'sugars_total' => ['Acucares totais', 'g'],
            'sugars_added' => ['Acucares adicionados', 'g'],
            'protein' => ['Proteinas', 'g'],
            'fat_total' => ['Gorduras totais', 'g'],
            'fat_saturated' => ['Gorduras saturadas', 'g'],
            'fat_trans' => ['Gorduras trans', 'g'],
            'fiber' => ['Fibra alimentar', 'g'],
            'sodium' => ['Sodio', 'mg'],
        ];
        $y = 60;
        $rowHeight = 24;
        $tableX = 20;
        $tableWidth = $width - 40;
        $svgRows = '';
        foreach ($rows as $key => $info) {
            $svgRows .= '<text x="' . ($tableX + 10) . '" y="' . $y . '" font-size="12">' . $info[0] . '</text>';
            $svgRows .= '<text x="' . ($tableX + 220) . '" y="' . $y . '" font-size="12">' . $nutrition['per_portion'][$key] . ' ' . $info[1] . '</text>';
            $svgRows .= '<text x="' . ($tableX + 360) . '" y="' . $y . '" font-size="12">' . ($nutrition['vd'][$key] === null ? '-' : $nutrition['vd'][$key] . '%') . '</text>';
            $svgRows .= '<text x="' . ($tableX + 440) . '" y="' . $y . '" font-size="12">' . $nutrition['per_100g'][$key] . ' ' . $info[1] . '</text>';
            $y += $rowHeight;
        }

        $fopY = $y + 40;
        $fopItems = '';
        $fopOffset = 0;
        if (empty($nutrition['fop'])) {
            $fopItems .= '<text x="' . $tableX . '" y="' . ($fopY + 16) . '" font-size="12">Nenhum selo aplicavel.</text>';
        } else {
            foreach ($nutrition['fop'] as $label) {
                $fopItems .= '<rect x="' . $tableX . '" y="' . ($fopY + $fopOffset) . '" width="' . $fopWidth . '" height="' . $fopHeight . '" rx="40" ry="40" fill="white" stroke="black" stroke-width="2"></rect>';
                $fopItems .= '<text x="' . ($tableX + 10) . '" y="' . ($fopY + $fopOffset + ($fopHeight / 2) + 4) . '" font-size="12" font-weight="bold">' . $label . '</text>';
                $fopOffset += $fopHeight + 12;
            }
        }

        return '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '">' .
            '<rect x="0" y="0" width="' . $width . '" height="' . $height . '" fill="white" stroke="black" />' .
            '<text x="20" y="30" font-size="16" font-weight="bold">INFORMACAO NUTRICIONAL</text>' .
            '<text x="20" y="46" font-size="12">Porcao de ' . $recipe['portion_g'] . ' g (' . $recipe['household_measure'] . ')</text>' .
            '<text x="20" y="58" font-size="12">Porcoes por embalagem: ' . $recipe['servings_per_package'] . '</text>' .
            $svgRows .
            '<text x="20" y="' . ($y + 20) . '" font-size="14" font-weight="bold">LUPA</text>' .
            $fopItems .
            '</svg>';
    }

    private function require_login(): void
    {
        if (!$this->session->userdata('user_id')) {
            redirect('login');
        }
    }
}
