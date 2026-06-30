<div class="container my-5">
    <?php $forms = $forms ?? []; ?>
    <?php $progressByGroup = $progressByGroup ?? []; ?>
    <div class="row g-4 justify-content-center">
        <?php foreach ($forms as $index => $step): ?>
            <?php
                $grGroup = (int) ($step['gr_group'] ?? 0);
                $progress = $progressByGroup[$grGroup] ?? ['answered' => 0, 'missing' => 0, 'total' => 0];
                $isCompleted = (int) $progress['total'] > 0 && (int) $progress['missing'] === 0;
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-2 h-100 rounded-4 hover-card text-center <?= $isCompleted ? 'group-complete' : '' ?>">
                    <div class="">
                        <div class="mb-3">
                            <?= $step['image']; ?>
                        </div>
                        <h5 class="card-title text-primary fw-semibold mb-3">
                            <?= esc($step['gr_name']); ?>
                        </h5>
                        <div class="p-4">
                            <a href="<?=base_url('form/'.substr($step['gr_class'], 0, 2).'/01'); ?>" class="btn btn-outline-primary w-100 fw-semibold">
                                <i class="bi bi-clipboard-check"></i> Selecionar
                            </a>
                            <div class="small text-muted mt-2">
                                Respondidas: <?= (int) $progress['answered'] ?>
                                | Faltam: <?= (int) $progress['missing'] ?>
                                | Total: <?= (int) $progress['total'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
</style>

<style>
    .group-complete {
        background-color: #d1e7dd;
        border-color: #8fd19e !important;
    }
</style>