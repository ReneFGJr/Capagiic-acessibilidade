<?php $placeData = $placeData ?? []; ?>

<div class="container-fluid my-4 px-2 px-sm-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <h4 class="mb-4 text-primary fw-bold text-center">
                        <i class="bi bi-geo-alt-fill"></i> Cadastro de Local de Avaliação
                    </h4>

                    <div class="row">
                        <!-- 🔹 Timeline lateral -->
                        <div class="col-12 col-lg-4 col-xxl-3 mb-4 mb-lg-0">
                            <?= view('places/timeline', ['etapaAtual' => 1]) ?>
                        </div>

                        <!-- 🔹 Conteúdo da etapa -->
                        <div class="col-12 col-lg-8 col-xxl-9">
                            <p class="text-muted">
                                Comece informando o <strong>nome do local</strong> que será avaliado.
                                Essa informação permitirá localizar e identificar o espaço nas próximas etapas do cadastro.
                            </p>

                            <hr class="my-4">

                            <form method="post" action="<?= base_url('places/save') ?>">
                                <input type="hidden" name="etapa" value="1">
                                <div class="mb-4">
                                    <label for="nome_local" class="form-label fw-bold">Nome do local</label>
                                    <input
                                        type="text"
                                        name="nome_local"
                                        id="nome_local"
                                        class="form-control form-control-lg shadow-sm"
                                        value="<?= esc(old('nome_local', (string) ($placeData['pl_name'] ?? ''))) ?>"
                                        placeholder="Ex: Biblioteca Central da UFRGS"
                                        required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                        <i class="bi bi-arrow-right-circle"></i> Avançar >>>
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-muted small text-center">
                                Etapa <strong>1</strong> de <strong>4</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>