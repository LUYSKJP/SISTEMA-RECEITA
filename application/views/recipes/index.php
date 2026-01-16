<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4">Receitas</h1>
    <a class="btn btn-primary" href="/recipes/create">Nova receita</a>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Porção</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($recipes as $recipe) : ?>
        <tr>
            <td><?php echo $recipe['name']; ?></td>
            <td><?php echo $recipe['category']; ?></td>
            <td><?php echo $recipe['portion_g']; ?> g</td>
            <td>
                <a class="btn btn-sm btn-outline-primary" href="/recipes/<?php echo $recipe['id']; ?>">Detalhes</a>
                <a class="btn btn-sm btn-outline-success" href="/recipes/<?php echo $recipe['id']; ?>/label">Gerar rótulo</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
