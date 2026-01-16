<h1 class="h4 mb-3">Config ANVISA - <?php echo $version['name']; ?></h1>
<form method="post">
    <h2 class="h5">Dimensões de exportação</h2>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">Largura do rótulo (px)</label>
            <input class="form-control" type="number" name="label[label_width]" value="<?php echo $version['label_width']; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Altura do rótulo (px)</label>
            <input class="form-control" type="number" name="label[label_height]" value="<?php echo $version['label_height']; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Largura da LUPA (px)</label>
            <input class="form-control" type="number" name="label[fop_width]" value="<?php echo $version['fop_width']; ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label">Altura da LUPA (px)</label>
            <input class="form-control" type="number" name="label[fop_height]" value="<?php echo $version['fop_height']; ?>">
        </div>
    </div>

    <h2 class="h5">Valores Diários de Referência (VDR)</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nutriente</th>
            <th>VDR</th>
            <th>Unidade</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vdr as $row) : ?>
            <tr>
                <td><?php echo $row['nutrient_key']; ?></td>
                <td><input class="form-control" type="number" step="0.01" name="vdr[<?php echo $row['id']; ?>][vdr_value]" value="<?php echo $row['vdr_value']; ?>"></td>
                <td><?php echo $row['unit']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="h5">Limites da LUPA (100 g/100 ml)</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nutriente</th>
            <th>Limite</th>
            <th>Unidade</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($thresholds as $row) : ?>
            <tr>
                <td><?php echo $row['nutrient_key']; ?></td>
                <td><input class="form-control" type="number" step="0.01" name="thresholds[<?php echo $row['id']; ?>][threshold_value]" value="<?php echo $row['threshold_value']; ?>"></td>
                <td><?php echo $row['unit']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="h5">Regras de arredondamento</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Nutriente</th>
            <th>Limite não significativo</th>
            <th>Casas decimais</th>
            <th>Modo</th>
            <th>Unidade</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rounding as $row) : ?>
            <tr>
                <td><?php echo $row['nutrient_key']; ?></td>
                <td><input class="form-control" type="number" step="0.0001" name="rounding[<?php echo $row['id']; ?>][significant_threshold]" value="<?php echo $row['significant_threshold']; ?>"></td>
                <td><input class="form-control" type="number" name="rounding[<?php echo $row['id']; ?>][decimals]" value="<?php echo $row['decimals']; ?>"></td>
                <td>
                    <select class="form-select" name="rounding[<?php echo $row['id']; ?>][rounding_mode]">
                        <option value="nearest" <?php echo $row['rounding_mode'] === 'nearest' ? 'selected' : ''; ?>>Mais próximo</option>
                        <option value="up" <?php echo $row['rounding_mode'] === 'up' ? 'selected' : ''; ?>>Para cima</option>
                        <option value="down" <?php echo $row['rounding_mode'] === 'down' ? 'selected' : ''; ?>>Para baixo</option>
                    </select>
                </td>
                <td><?php echo $row['unit']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <button class="btn btn-primary" type="submit">Salvar configurações</button>
</form>
