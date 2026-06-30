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
                                    <?php
                                        $imageUrl = base_url((string) ($img['img_url'] ?? ''));
                                        $imageName = (string) ($img['img_name'] ?? 'Sem nome');
                                        $imageDescription = (string) ($img['img_descricao'] ?? 'Sem descricao');
                                        $imageGroup = (string) ($img['img_group'] ?? '-');
                                    ?>
                                    <div class="col-12 col-md-6 col-xl-4 col-xxl-3">
                                        <div class="card h-100 border-1 shadow-sm rounded-3">
                                            <button
                                                type="button"
                                                class="image-preview-trigger border-0 p-0 bg-transparent text-start"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imagePreviewModal"
                                                data-image-src="<?= esc($imageUrl) ?>"
                                                data-image-name="<?= esc($imageName) ?>"
                                                data-image-description="<?= esc($imageDescription) ?>"
                                                data-image-group="<?= esc($imageGroup) ?>"
                                            >
                                                <img
                                                    src="<?= esc($imageUrl) ?>"
                                                    alt="<?= esc($imageDescription ?: $imageName) ?>"
                                                    class="card-img-top"
                                                    style="object-fit: cover; aspect-ratio: 16 / 9;"
                                                >
                                            </button>
                                            <div class="card-body">
                                                <h6 class="card-title fw-bold mb-2">
                                                    <?= esc($imageName) ?>
                                                </h6>
                                                <p class="card-text small text-muted mb-2">
                                                    <?= esc($imageDescription) ?>
                                                </p>
                                                <div class="small text-secondary">
                                                    <strong>Grupo:</strong> <?= esc($imageGroup) ?>
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

<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content border-0 rounded-0">
            <div class="modal-header border-0 bg-dark text-white">
                <div>
                    <h5 class="modal-title mb-0" id="imagePreviewModalLabel">Visualização da imagem</h5>
                    <small id="imagePreviewModalGroup" class="text-white-50"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0 h-100">
                    <div class="col-12 col-lg-8 bg-black d-flex align-items-center justify-content-center image-preview-stage">
                        <img id="imagePreviewModalImage" src="" alt="Imagem selecionada" class="img-fluid w-100 h-100 object-fit-contain">
                    </div>
                    <div class="col-12 col-lg-4 bg-light d-flex flex-column">
                        <div class="p-4 p-xl-5 h-100 overflow-auto">
                            <h4 id="imagePreviewModalName" class="text-primary fw-bold mb-3"></h4>
                            <p class="lead mb-3" id="imagePreviewModalDescription"></p>
                            <div class="alert alert-secondary mb-0">
                                Use a tecla <strong>Esc</strong> para fechar ou o botão no canto superior.
                            </div>
                        </div>
                    </div>
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

    .image-preview-trigger {
        display: block;
        width: 100%;
    }

    .image-preview-trigger:focus-visible {
        outline: 3px solid #0d6efd;
        outline-offset: -3px;
    }

    .image-preview-stage {
        min-height: 50vh;
    }

    .object-fit-contain {
        object-fit: contain;
    }
</style>

<script>
(function () {
    const modal = document.getElementById('imagePreviewModal');
    if (!modal) {
        return;
    }

    const modalImage = document.getElementById('imagePreviewModalImage');
    const modalName = document.getElementById('imagePreviewModalName');
    const modalDescription = document.getElementById('imagePreviewModalDescription');
    const modalGroup = document.getElementById('imagePreviewModalGroup');

    modal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        if (!trigger) {
            return;
        }

        const imageSrc = trigger.getAttribute('data-image-src') || '';
        const imageName = trigger.getAttribute('data-image-name') || 'Imagem';
        const imageDescription = trigger.getAttribute('data-image-description') || '';
        const imageGroup = trigger.getAttribute('data-image-group') || '';

        if (modalImage) {
            modalImage.src = imageSrc;
            modalImage.alt = imageDescription || imageName;
        }

        if (modalName) {
            modalName.textContent = imageName;
        }

        if (modalDescription) {
            modalDescription.textContent = imageDescription || 'Sem descrição disponível.';
        }

        if (modalGroup) {
            modalGroup.textContent = imageGroup ? 'Grupo: ' + imageGroup : '';
        }
    });

    modal.addEventListener('hidden.bs.modal', function () {
        if (modalImage) {
            modalImage.src = '';
        }
    });
})();
</script>
