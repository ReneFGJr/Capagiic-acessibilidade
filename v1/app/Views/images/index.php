<?php
    $groups = $groups ?? [];
    $activeGroup = $activeGroup ?? '';
    $images = $images ?? [];
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="text-primary fw-bold mb-4">
                        <i class="bi bi-images"></i> Banco de Imagens por Categoria
                    </h3>

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
                                    <div class="col-md-6 col-lg-4">
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
