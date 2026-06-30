<?php
    $placeData = $placeData ?? [];
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-primary fw-bold text-center">
                        <i class="bi bi-check2-square"></i> Confirmar endereco
                    </h4>

                    <div class="row">
                        <div class="col-md-4">
                            <?= view('places/timeline', ['etapaAtual' => 4]) ?>
                        </div>

                        <div class="col-md-8">
                            <?php if (session()->getFlashdata('msg')) : ?>
                                <div class="alert alert-success mb-3"><?= esc(session()->getFlashdata('msg')) ?></div>
                            <?php endif; ?>

                            <p class="text-muted mb-3">Revise os dados do endereco abaixo.</p>

                            <div class="border rounded-3 p-3 bg-light-subtle mb-4">
                                <div class="mb-2"><strong>Local:</strong> <?= esc((string) ($placeData['pl_name'] ?? '-')) ?></div>
                                <div class="mb-2"><strong>Endereco:</strong> <?= esc((string) ($placeData['pl_address'] ?? '-')) ?></div>
                                <div class="mb-2"><strong>Bairro:</strong> <?= esc((string) ($placeData['pl_bairro'] ?? '-')) ?></div>
                                <div class="mb-2"><strong>CEP:</strong> <?= esc((string) ($placeData['pl_cep'] ?? '-')) ?></div>
                                <div><strong>Cidade (IBGE):</strong> <?= esc((string) ($placeData['pl_city'] ?? '-')) ?></div>
                            </div>

                            <div class="d-grid gap-2">
                                <a href="<?= base_url('places/2') ?>" class="btn btn-outline-secondary">
                                    <i class="bi bi-pencil"></i> Editar endereco
                                </a>
                                <a href="<?= base_url('places/confirm') ?>" class="btn btn-primary">
                                    <i class="bi bi-check2-circle"></i> Confirmar e voltar ao perfil
                                </a>
                            </div>

                            <div class="mt-4 text-muted small text-center">
                                Etapa <strong>4</strong> de <strong>4</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
