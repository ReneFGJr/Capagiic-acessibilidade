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

<div class="container-fluid my-4 px-2 px-sm-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3 mb-4">
                        <h4 class="text-primary fw-bold mb-0">
                            <i class="bi bi-clipboard-check"></i> Avaliacoes
                        </h4>
                        <a href="<?= base_url('places') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Cadastrar novo lugar
                        </a>
                    </div>

                    <?php if (!$isLoggedIn): ?>
                        <div class="alert alert-warning mb-0">
                            Faca login para visualizar os locais vinculados ao seu usuario.
                        </div>
                    <?php elseif (empty($places)): ?>
                        <div class="alert alert-light border mb-0">
                            Nenhum local vinculado ao seu usuario. Clique em <strong>Cadastrar novo lugar</strong> para cadastrar um local.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle w-100">
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
