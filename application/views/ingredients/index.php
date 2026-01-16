<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4">Ingredientes</h1>
    <a class="btn btn-primary" href="/ingredients/create">Novo ingrediente</a>
</div>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Marca</th>
        <th>Energia (kcal)</th>
        <th>Carb (g)</th>
        <th>Açúcar adic. (g)</th>
        <th>Sódio (mg)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($ingredients as $ingredient) : ?>
        <tr>
            <td><?php echo $ingredient['name']; ?></td>
            <td><?php echo $ingredient['brand']; ?></td>
            <td><?php echo $ingredient['kcal']; ?></td>
            <td><?php echo $ingredient['carbs']; ?></td>
            <td><?php echo $ingredient['sugars_added']; ?></td>
            <td><?php echo $ingredient['sodium']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
