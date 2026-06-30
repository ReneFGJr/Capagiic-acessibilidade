<style>
    .stepper {
        position: relative;
        margin: 20px 0;
        padding-left: 30px;
        border-left: 2px solid #dee2e6;
    }

    .step {
        position: relative;
        padding: 15px 0 15px 20px;
    }

    .step::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 22px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #0d6efd;
    }

    .step.active::before {
        background-color: #0d6efd;
    }

    .step small {
        color: #6c757d;
    }
</style>

<?php
    $etapa = $etapa ?? [];
    $etapaAtual = (int) ($etapaAtual ?? 1);
    $groupProgress = $groupProgress ?? [];
?>

<div class="stepper">
    <?php foreach ($etapa as $index => $step): ?>
        <?php
            $stepSub = (int) ($step['gr_group_sub'] ?? ($index + 1));
            $progress = $groupProgress[$stepSub] ?? ['answered' => 0, 'missing' => 0, 'total' => 0];
        ?>
        <div class="step <?= ($etapaAtual == ($index + 1)) ? 'active' : '' ?>">
            <a href="<?=base_url('form/'.substr($step['gr_class'],0,2).'/'.substr($step['gr_class'],3,2))?>" class="text-decoration-none">
                <h6 class="mb-0 fw-bold <?= ($etapaAtual == ($index + 1)) ? 'text-primary' : 'text-muted' ?>">
                    <?= ($index + 1) . '. ' . esc($step['gr_name']) ?>
                </h6>
                <small>
                    Respondidas: <?= (int) $progress['answered'] ?>
                    | Faltam: <?= (int) $progress['missing'] ?>
                    | Total: <?= (int) $progress['total'] ?>
                </small>
            </a>
        </div>
    <?php endforeach; ?>
</div>