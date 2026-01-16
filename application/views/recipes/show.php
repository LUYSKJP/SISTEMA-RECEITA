<h1 class="h4 mb-3"><?php echo $recipe['name']; ?></h1>
<div class="mb-3">
    <span class="badge bg-secondary"><?php echo $recipe['category']; ?></span>
</div>
<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Rendimento final:</strong> <?php echo $recipe['yield_final_g']; ?> g</li>
    <li class="list-group-item"><strong>Perdas:</strong> <?php echo $recipe['loss_percent']; ?>%</li>
    <li class="list-group-item"><strong>Porção padrão:</strong> <?php echo $recipe['portion_g']; ?> g</li>
    <li class="list-group-item"><strong>Medida caseira:</strong> <?php echo $recipe['household_measure']; ?></li>
</ul>

<h2 class="h5">Ingredientes</h2>
<table class="table">
    <thead>
    <tr>
        <th>Ingrediente</th>
        <th>Quantidade (g/ml)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item) : ?>
        <tr>
            <td><?php echo $item['ingredient_name']; ?></td>
            <td><?php echo $item['quantity_g']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a class="btn btn-success" href="/recipes/<?php echo $recipe['id']; ?>/label">Gerar rótulo</a>
