<?php
    $groups = $groups ?? [];
    $selectedGroupId = (string) old('group_id');
    $flashError = session()->getFlashdata('error');
?>

<div class="container-fluid my-4 px-2 px-sm-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card border-0 shadow rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3 mb-4">
                        <h3 class="text-primary fw-bold mb-0">
                            <i class="bi bi-cloud-arrow-up"></i> Enviar imagem
                        </h3>
                        <a href="<?= base_url('images') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar para o banco
                        </a>
                    </div>

                    <?php if ($flashError): ?>
                        <div class="alert alert-danger"><?= esc((string) $flashError) ?></div>
                    <?php endif; ?>

                    <?php if (empty($groups)): ?>
                        <div class="alert alert-warning mb-0">
                            Nenhum grupo de questionário foi encontrado para vincular a imagem.
                        </div>
                    <?php else: ?>
                        <form method="post" action="<?= base_url('images/upload') ?>" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="group_id" class="form-label fw-semibold">Grupo do questionário</label>
                                    <select name="group_id" id="group_id" class="form-select form-select-lg" required>
                                        <option value="">Selecione o grupo</option>
                                        <?php foreach ($groups as $group): ?>
                                            <option value="<?= esc((string) $group['id_gr']) ?>" <?= $selectedGroupId === (string) $group['id_gr'] ? 'selected' : '' ?>>
                                                <?= esc((string) $group['gr_name']) ?> - <?= esc((string) $group['gr_class']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">O arquivo será salvo em assets/img/[gr_class].</div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="image_file" class="form-label fw-semibold">Arquivo de imagem</label>
                                    <input type="file" name="image_file" id="image_file" class="form-control form-control-lg" accept="image/*" required>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="img_name" class="form-label fw-semibold">Nome da imagem</label>
                                    <input type="text" name="img_name" id="img_name" class="form-control form-control-lg" value="<?= esc((string) old('img_name')) ?>" placeholder="Ex: Rampa de acesso" required>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="img_descricao" class="form-label fw-semibold">Descrição</label>
                                    <input type="text" name="img_descricao" id="img_descricao" class="form-control form-control-lg" value="<?= esc((string) old('img_descricao')) ?>" placeholder="Descrição curta da imagem">
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-upload"></i> Salvar imagem
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>