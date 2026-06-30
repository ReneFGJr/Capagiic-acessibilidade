<div class="container-fluid px-2 px-sm-3 px-lg-4">
    <div class="row align-items-center g-3 my-3">
        <div class="col-12 col-lg-8">
            <p class="text-muted mb-1"><i class="bi bi-fonts"></i> Nome do Grupo</p>
            <h5><?= esc($group['gr_name'] ?? '—') ?></h5>
            <a href="<?= base_url('form') ?>" class="btn btn-outline-secondary btn-sm mt-2">
                <i class="bi bi-arrow-left"></i> Voltar para seleção de grupos
            </a>
        </div>
        <div class="col-12 col-lg-4 text-lg-end">
            <?= $group['images'] ?? '' ?>
        </div>
    </div>
</div>