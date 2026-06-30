<?php
    $summary = $summary ?? ['total_answers' => 0, 'total_places' => 0, 'total_questions_answered' => 0];
    $totalQuestionsBank = (int) ($totalQuestionsBank ?? 0);
    $answersByType = $answersByType ?? [];
    $topGroups = $topGroups ?? [];
    $placePerformance = $placePerformance ?? [];
    $statusMap = [
        0 => 'Em preenchimento',
        1 => 'Em avaliacao',
        2 => 'Avaliacao concluida',
        9 => 'Fim da avaliacao',
    ];
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h1 class="h3 fw-bold mb-0">
            <i class="bi bi-bar-chart-line me-2 text-success"></i> Painel BI
        </h1>
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Voltar para inicio
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Total de respostas</div>
                    <div class="fs-4 fw-bold"><?= (int) ($summary['total_answers'] ?? 0) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Locais avaliados</div>
                    <div class="fs-4 fw-bold"><?= (int) ($summary['total_places'] ?? 0) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Questoes respondidas</div>
                    <div class="fs-4 fw-bold"><?= (int) ($summary['total_questions_answered'] ?? 0) ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Banco de questoes</div>
                    <div class="fs-4 fw-bold"><?= (int) $totalQuestionsBank ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Distribuicao por resposta</h5>
                    <?php if (empty($answersByType)): ?>
                        <div class="alert alert-light border mb-0">Sem dados para exibir.</div>
                    <?php else: ?>
                        <?php foreach ($answersByType as $row): ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span><?= esc((string) ($row['qpa_answer'] ?? '-')) ?></span>
                                    <span><?= (int) ($row['total'] ?? 0) ?> (<?= number_format((float) ($row['percent'] ?? 0), 2, ',', '.') ?>%)</span>
                                </div>
                                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= (float) ($row['percent'] ?? 0) ?>">
                                    <div class="progress-bar" style="width: <?= (float) ($row['percent'] ?? 0) ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Top questoes com mais respostas</h5>
                    <?php if (empty($topGroups)): ?>
                        <div class="alert alert-light border mb-0">Sem dados para exibir.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 90px;">ID</th>
                                        <th>Questao</th>
                                        <th class="text-end" style="width: 120px;">Respostas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topGroups as $row): ?>
                                        <tr>
                                            <td><?= (int) ($row['id_gr'] ?? 0) ?></td>
                                            <td><?= esc((string) ($row['gr_name'] ?? '-')) ?></td>
                                            <td class="text-end"><?= (int) ($row['total'] ?? 0) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Desempenho por local</h5>
            <?php if (empty($placePerformance)): ?>
                <div class="alert alert-light border mb-0">Sem dados para exibir.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Local</th>
                                <th>Status</th>
                                <th class="text-end">Respondidas</th>
                                <th class="text-end">Conclusao (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($placePerformance as $place): ?>
                                <?php
                                    $statusCode = (int) ($place['pl_status'] ?? 0);
                                    $statusLabel = $statusMap[$statusCode] ?? 'Em preenchimento';
                                ?>
                                <tr>
                                    <td><?= esc((string) ($place['pl_name'] ?? '-')) ?></td>
                                    <td><?= esc($statusLabel) ?></td>
                                    <td class="text-end"><?= (int) ($place['answered_questions'] ?? 0) ?></td>
                                    <td class="text-end"><?= number_format((float) ($place['completion_percent'] ?? 0), 2, ',', '.') ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
