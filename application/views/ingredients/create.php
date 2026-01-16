<h1 class="h4 mb-3">Novo Ingrediente</h1>
<?php if (!empty($error)) : ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<form method="post" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nome</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Marca</label>
        <input type="text" name="brand" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Umidade (%)</label>
        <input type="number" step="0.01" name="moisture" class="form-control">
    </div>
    <div class="col-md-3">
        <label class="form-label">Densidade (g/ml)</label>
        <input type="number" step="0.001" name="density" class="form-control">
    </div>
    <div class="col-12">
        <label class="form-label">Notas</label>
        <textarea name="notes" class="form-control" rows="2"></textarea>
    </div>
    <div class="col-12">
        <h2 class="h6">Nutrientes por 100 g</h2>
    </div>
    <div class="col-md-3"><label class="form-label">Energia (kcal)</label><input type="number" step="0.01" name="kcal" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Carboidratos (g)</label><input type="number" step="0.01" name="carbs" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Açúcares totais (g)</label><input type="number" step="0.01" name="sugars_total" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Açúcares adicionados (g)</label><input type="number" step="0.01" name="sugars_added" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Proteínas (g)</label><input type="number" step="0.01" name="protein" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Gorduras totais (g)</label><input type="number" step="0.01" name="fat_total" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Gorduras saturadas (g)</label><input type="number" step="0.01" name="fat_saturated" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Gorduras trans (g)</label><input type="number" step="0.01" name="fat_trans" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Fibra alimentar (g)</label><input type="number" step="0.01" name="fiber" class="form-control"></div>
    <div class="col-md-3"><label class="form-label">Sódio (mg)</label><input type="number" step="0.01" name="sodium" class="form-control"></div>
    <div class="col-12">
        <button class="btn btn-success" type="submit">Salvar</button>
        <a class="btn btn-secondary" href="<?php echo site_url('ingredients'); ?>">Cancelar</a>
    </div>
</form>
