<?php
    $places = $places ?? [];
    $isLoggedIn = (bool) ($isLoggedIn ?? false);
    $statusMap = [
        0 => 'Em preenchimento',
        1 => 'Em avaliacao',
        2 => 'Avaliacao concluida',
        9 => 'Fim da avaliacao',
    ];
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                        <h4 class="text-primary fw-bold mb-0">
                            <i class="bi bi-clipboard-check"></i> Avaliacoes
                        </h4>
                        <a href="<?= base_url('places') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nova avaliacao
                        </a>
                    </div>

                    <?php if (!$isLoggedIn): ?>
                        <div class="alert alert-warning mb-0">
                            Faca login para visualizar os locais vinculados ao seu usuario.
                        </div>
                    <?php elseif (empty($places)): ?>
                        <div class="alert alert-light border mb-0">
                            Nenhum local vinculado ao seu usuario. Clique em <strong>Nova avaliacao</strong> para cadastrar um local.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Local</th>
                                        <th>Status</th>
                                        <th>Atualizado em</th>
                                        <th class="text-end">Acoes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($places as $place): ?>
                                        <?php
                                            $statusCode = (int) ($place['pl_status'] ?? 0);
                                            $statusLabel = $statusMap[$statusCode] ?? 'Em preenchimento';
                                        ?>
                                        <tr>
                                            <td><?= esc((string) ($place['pl_name'] ?? '-')) ?></td>
                                            <td><?= esc($statusLabel) ?></td>
                                            <td><?= esc((string) ($place['updated_at'] ?? '-')) ?></td>
                                            <td class="text-end">
                                                <a href="<?= base_url('places') ?>" class="btn btn-sm btn-outline-secondary me-1">Editar local</a>
                                                <?php if ($statusCode !== 0): ?>
                                                    <a href="<?= base_url('form') ?>" class="btn btn-sm btn-outline-primary">Avaliar</a>
                                                <?php endif; ?>
                                            </td>
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
</div>
