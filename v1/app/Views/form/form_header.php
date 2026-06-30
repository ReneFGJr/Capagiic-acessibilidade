<div class="container">
    <div class="row">
        <div class="col-12 col-sm-6 my-3">
            <p class="text-muted mb-1"><i class="bi bi-fonts"></i> Nome do Grupo</p>
            <h5><?= esc($group['gr_name'] ?? '—') ?></h5>
            <a href="<?= base_url('form') ?>" class="btn btn-outline-secondary btn-sm mt-2">
                <i class="bi bi-arrow-left"></i> Voltar para seleção de grupos
            </a>
        </div>
        <div class="col-12 col-sm-4 mb-3">
            <?= $group['images'] ?? '' ?>
        </div>
    </div>
</div>