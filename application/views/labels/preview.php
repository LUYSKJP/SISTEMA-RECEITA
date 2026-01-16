<h1 class="h4 mb-3">Rótulo Nutricional - <?php echo $recipe['name']; ?></h1>
<div class="row">
    <div class="col-md-8">
        <?php $this->load->view('labels/table', ['recipe' => $recipe, 'nutrition' => $nutrition]); ?>
    </div>
    <div class="col-md-4">
        <h2 class="h5">Rotulagem Nutricional Frontal (LUPA)</h2>
        <?php if (empty($nutrition['fop'])) : ?>
            <p class="text-muted">Nenhum selo de lupa aplicável.</p>
        <?php else : ?>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($nutrition['fop'] as $label) : ?>
                    <div class="lupa">
                        <span><?php echo $label; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="d-grid gap-2 mt-3">
            <a class="btn btn-outline-primary" href="?format=pdf">Exportar PDF</a>
            <a class="btn btn-outline-secondary" href="/recipes/<?php echo $recipe['id']; ?>/fop?format=svg" target="_blank">Exportar SVG</a>
            <a class="btn btn-outline-secondary" href="/recipes/<?php echo $recipe['id']; ?>/fop?format=png" target="_blank">Exportar PNG</a>
        </div>
    </div>
</div>
