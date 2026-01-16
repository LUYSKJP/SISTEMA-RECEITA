<div class="nutrition-table">
    <h2 class="h5">INFORMAÇÃO NUTRICIONAL</h2>
    <p>Porção de <?php echo $recipe['portion_g']; ?> g (<?php echo $recipe['household_measure']; ?>)</p>
    <p>Porções por embalagem: <?php echo $recipe['servings_per_package']; ?></p>
    <table class="table table-bordered">
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
    <p class="small">*Percentual de valores diários fornecidos pela porção.</p>
</div>
