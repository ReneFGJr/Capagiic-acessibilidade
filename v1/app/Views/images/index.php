<?php
    $groups = $groups ?? [];
    $activeGroup = $activeGroup ?? '';
    $images = $images ?? [];
    $isLoggedIn = (bool) ($isLoggedIn ?? false);
    $flashMsg = session()->getFlashdata('msg');
    $flashError = session()->getFlashdata('error');
?>

<div class="container-fluid my-4 px-2 px-sm-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3 mb-4">
                        <h3 class="text-primary fw-bold mb-0">
                            <i class="bi bi-images"></i> Banco de Imagens por Categoria
                        </h3>
                        <?php if ($isLoggedIn): ?>
                            <a href="<?= base_url('images/upload') ?>" class="btn btn-primary">
                                <i class="bi bi-cloud-arrow-up"></i> Enviar imagem
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($flashMsg): ?>
                        <div class="alert alert-success">
                            <?= esc((string) $flashMsg) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($flashError): ?>
                        <div class="alert alert-danger">
                            <?= esc((string) $flashError) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($groups)): ?>
                        <div class="alert alert-warning mb-0">
                            Nenhuma categoria de imagem encontrada na tabela banco_imagens.
                        </div>
                    <?php else: ?>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <?php foreach ($groups as $group): ?>
                                <?php
                                    $groupName = (string) $group['name'];
                                    $isActive = $groupName === $activeGroup;
                                ?>
                                <a
                                    href="<?= base_url('images') . '?group=' . urlencode($groupName) ?>"
                                    class="btn <?= $isActive ? 'btn-primary' : 'btn-outline-primary' ?> btn-sm"
                                >
                                    <?= esc($groupName) ?>
                                    <span class="badge text-bg-light ms-1"><?= (int) $group['total'] ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <?php if (empty($images)): ?>
                            <div class="alert alert-light border mb-0">
                                Nenhuma imagem encontrada para a categoria selecionada.
                            </div>
                        <?php else: ?>
                            <div class="row g-4">
                                <?php foreach ($images as $img): ?>
                                    <div class="col-12 col-md-6 col-xl-4 col-xxl-3">
                                        <div class="card h-100 border-1 shadow-sm rounded-3">
                                            <img
                                                src="<?= base_url((string) ($img['img_url'] ?? '')) ?>"
                                                alt="<?= esc((string) ($img['img_descricao'] ?? $img['img_name'] ?? 'Imagem')) ?>"
                                                class="card-img-top"
                                                style="object-fit: cover; aspect-ratio: 16 / 9;"
                                            >
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold mb-2">
                                                    <?= esc((string) ($img['img_name'] ?? 'Sem nome')) ?>
                                                </h6>
                                                <p class="card-text small text-muted mb-2">
                                                    <?= esc((string) ($img['img_descricao'] ?? 'Sem descricao')) ?>
                                                </p>
                                                <div class="small text-secondary">
                                                    <strong>Grupo:</strong> <?= esc((string) ($img['img_group'] ?? '-')) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .container-fluid {
        max-width: 100%;
    }

    .card-img-top {
        width: 100%;
    }
</style>
