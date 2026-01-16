<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .nutrition-table h2 { font-size: 16px; margin-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        .lupa { border: 2px solid #000; border-radius: 50px; padding: 6px 10px; margin-bottom: 6px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>
<div class="nutrition-table">
    <h2>INFORMAÇÃO NUTRICIONAL</h2>
    <p>Porção de <?php echo $recipe['portion_g']; ?> g (<?php echo $recipe['household_measure']; ?>)</p>
    <p>Porções por embalagem: <?php echo $recipe['servings_per_package']; ?></p>
    <table>
        <thead>
        <tr>
            <th>Nutriente</th>
            <th>Quantidade por porção</th>
            <th>%VD</th>
            <th>Quantidade por 100 g</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $rows = [
            'kcal' => ['Valor energético', 'kcal'],
            'carbs' => ['Carboidratos', 'g'],
            'sugars_total' => ['Açúcares totais', 'g'],
            'sugars_added' => ['Açúcares adicionados', 'g'],
            'protein' => ['Proteínas', 'g'],
            'fat_total' => ['Gorduras totais', 'g'],
            'fat_saturated' => ['Gorduras saturadas', 'g'],
            'fat_trans' => ['Gorduras trans', 'g'],
            'fiber' => ['Fibra alimentar', 'g'],
            'sodium' => ['Sódio', 'mg'],
        ];
        foreach ($rows as $key => $info) :
            $vdValue = $nutrition['vd'][$key];
            ?>
            <tr>
                <td><?php echo $info[0]; ?></td>
                <td><?php echo $nutrition['per_portion'][$key]; ?> <?php echo $info[1]; ?></td>
                <td><?php echo $vdValue === null ? '-' : $vdValue . '%'; ?></td>
                <td><?php echo $nutrition['per_100g'][$key]; ?> <?php echo $info[1]; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p>*Percentual de valores diários fornecidos pela porção.</p>
</div>

<h3>Rotulagem Nutricional Frontal</h3>
<?php if (empty($nutrition['fop'])) : ?>
    <p>Nenhum selo aplicável.</p>
<?php else : ?>
    <?php foreach ($nutrition['fop'] as $label) : ?>
        <div class="lupa"><?php echo $label; ?></div>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
