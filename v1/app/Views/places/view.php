<div class="container-fluid my-4 px-2 px-sm-3 px-lg-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-11">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">

                    <!-- Cabeçalho -->
                    <h3 class="mb-4 text-primary fw-bold text-center">
                        <i class="bi bi-geo-alt-fill"></i> <?= esc($place['pl_name']) ?>
                    </h3>

                    <div class="row g-3 g-xl-4">
                        <!-- Categoria -->
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="bi bi-tag"></i> Categoria</p>
                            <h6><?= esc($place['pl_category'] ?: '—') ?></h6>
                        </div>

                        <!-- Subcategoria -->
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="bi bi-diagram-3"></i> Subcategoria</p>
                            <h6><?= esc($place['pl_subcategory'] ?: '—') ?></h6>
                        </div>

                        <!-- Endereço -->
                        <div class="col-12">
                            <p class="text-muted mb-1"><i class="bi bi-house"></i> Endereço</p>
                            <h6><?= esc($place['pl_address'] ?: '—') ?></h6>
                        </div>

                        <!-- Bairro / Cidade -->
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="bi bi-geo"></i> Bairro</p>
                            <h6><?= esc($place['pl_bairro'] ?: '—') ?></h6>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="bi bi-building"></i> Cidade</p>
                            <h6><?= esc($place['pl_city'] ?: '—') ?></h6>
                        </div>

                        <!-- CEP -->
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="bi bi-envelope"></i> CEP</p>
                            <h6><?= esc($place['pl_cep'] ?: '—') ?></h6>
                        </div>

                        <!-- Avaliações -->
                        <div class="col-md-6">
                            <p class="text-muted mb-1"><i class="bi bi-star"></i> Avaliações</p>
                            <h6><?= esc($place['pl_avaliations']) ?></h6>
                        </div>

                        <!-- Descrição -->
                        <div class="col-12 mt-3">
                            <p class="text-muted mb-1"><i class="bi bi-card-text"></i> Descrição</p>
                            <p class="mb-0"><?= esc($place['pl_description'] ?: 'Nenhuma descrição disponível.') ?></p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Metadados -->
                    <div class="text-center small text-muted">
                        <p class="mb-1">ID Anônimo: <code><?= esc($place['pl_anon_id']) ?></code></p>
                        <p class="mb-0">
                            Criado em: <?= date('d/m/Y H:i', strtotime($place['created_at'])) ?><br>
                            Atualizado em: <?= date('d/m/Y H:i', strtotime($place['updated_at'])) ?>
                        </p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="<?= base_url('places') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
