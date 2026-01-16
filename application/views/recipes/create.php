<h1 class="h4 mb-3">Nova Receita</h1>
<?php if (!empty($error)) : ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form method="post">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Categoria</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Rendimento final (g)</label>
            <input type="number" step="0.01" name="yield_final_g" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Perdas (%)</label>
            <input type="number" step="0.01" name="loss_percent" class="form-control" value="0">
        </div>
        <div class="col-md-3">
            <label class="form-label">Porção padrão (g)</label>
            <input type="number" step="0.01" name="portion_g" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Porções por embalagem</label>
            <input type="number" step="0.01" name="servings_per_package" class="form-control" value="1">
        </div>
        <div class="col-12">
            <label class="form-label">Medida caseira</label>
            <input type="text" name="household_measure" class="form-control" placeholder="Ex.: 1 fatia (80 g)">
        </div>
    </div>

    <h2 class="h5 mt-4">Montagem da Receita</h2>
    <p class="text-muted">Adicione ingredientes e quantidades para ver os totais ao vivo.</p>

    <table class="table" id="items-table">
        <thead>
        <tr>
            <th>Ingrediente</th>
            <th>Quantidade (g/ml)</th>
            <th>Energia (kcal)</th>
            <th>Carb (g)</th>
            <th>Açúcares adic. (g)</th>
            <th>Sódio (mg)</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < 5; $i++) : ?>
            <tr>
                <td>
                    <select name="items[<?php echo $i; ?>][ingredient_id]" class="form-select ingredient-select">
                        <option value="">Selecione</option>
                        <?php foreach ($ingredients as $ingredient) : ?>
                            <option value="<?php echo $ingredient['id']; ?>"
                                    data-kcal="<?php echo $ingredient['kcal']; ?>"
                                    data-carbs="<?php echo $ingredient['carbs']; ?>"
                                    data-sugars_added="<?php echo $ingredient['sugars_added']; ?>"
                                    data-sodium="<?php echo $ingredient['sodium']; ?>">
                                <?php echo $ingredient['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="number" step="0.01" name="items[<?php echo $i; ?>][quantity_g]" class="form-control quantity-input"></td>
                <td class="kcal-cell">0</td>
                <td class="carbs-cell">0</td>
                <td class="sugars-cell">0</td>
                <td class="sodium-cell">0</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger remove-row">Remover</button></td>
            </tr>
        <?php endfor; ?>
        </tbody>
        <tfoot>
        <tr class="fw-bold">
            <td>Total</td>
            <td id="total-qty">0</td>
            <td id="total-kcal">0</td>
            <td id="total-carbs">0</td>
            <td id="total-sugars">0</td>
            <td id="total-sodium">0</td>
            <td></td>
        </tr>
        </tfoot>
    </table>

    <button class="btn btn-outline-secondary" type="button" id="add-row">Adicionar linha</button>
    <div class="mt-4">
        <button class="btn btn-success" type="submit">Salvar Receita</button>
        <a class="btn btn-secondary" href="/recipes">Cancelar</a>
    </div>
</form>

<script>
const tableBody = document.querySelector('#items-table tbody');
const totals = {
    qty: document.getElementById('total-qty'),
    kcal: document.getElementById('total-kcal'),
    carbs: document.getElementById('total-carbs'),
    sugars: document.getElementById('total-sugars'),
    sodium: document.getElementById('total-sodium'),
};

const updateTotals = () => {
    let totalQty = 0;
    let totalKcal = 0;
    let totalCarbs = 0;
    let totalSugars = 0;
    let totalSodium = 0;

    tableBody.querySelectorAll('tr').forEach((row) => {
        const select = row.querySelector('.ingredient-select');
        const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const option = select.options[select.selectedIndex];
        const kcal = parseFloat(option.dataset.kcal || 0) * qty / 100;
        const carbs = parseFloat(option.dataset.carbs || 0) * qty / 100;
        const sugars = parseFloat(option.dataset.sugars_added || 0) * qty / 100;
        const sodium = parseFloat(option.dataset.sodium || 0) * qty / 100;

        row.querySelector('.kcal-cell').textContent = kcal.toFixed(1);
        row.querySelector('.carbs-cell').textContent = carbs.toFixed(1);
        row.querySelector('.sugars-cell').textContent = sugars.toFixed(1);
        row.querySelector('.sodium-cell').textContent = sodium.toFixed(0);

        totalQty += qty;
        totalKcal += kcal;
        totalCarbs += carbs;
        totalSugars += sugars;
        totalSodium += sodium;
    });

    totals.qty.textContent = totalQty.toFixed(1);
    totals.kcal.textContent = totalKcal.toFixed(1);
    totals.carbs.textContent = totalCarbs.toFixed(1);
    totals.sugars.textContent = totalSugars.toFixed(1);
    totals.sodium.textContent = totalSodium.toFixed(0);
};

const bindRowEvents = (row) => {
    row.querySelector('.ingredient-select').addEventListener('change', updateTotals);
    row.querySelector('.quantity-input').addEventListener('input', updateTotals);
    row.querySelector('.remove-row').addEventListener('click', () => {
        row.remove();
        updateTotals();
    });
};

tableBody.querySelectorAll('tr').forEach(bindRowEvents);

const addRowBtn = document.getElementById('add-row');
addRowBtn.addEventListener('click', () => {
    const index = tableBody.querySelectorAll('tr').length;
    const template = tableBody.querySelector('tr').cloneNode(true);
    template.querySelectorAll('input').forEach((input) => {
        input.name = input.name.replace(/items\[\d+\]/, `items[${index}]`);
        input.value = '';
    });
    template.querySelector('select').name = template.querySelector('select').name.replace(/items\[\d+\]/, `items[${index}]`);
    template.querySelector('select').selectedIndex = 0;
    template.querySelectorAll('td.kcal-cell, td.carbs-cell, td.sugars-cell, td.sodium-cell').forEach((cell) => {
        cell.textContent = '0';
    });
    tableBody.appendChild(template);
    bindRowEvents(template);
});
</script>
