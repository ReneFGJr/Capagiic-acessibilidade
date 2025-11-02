<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-primary fw-bold text-center">
                        <i class="bi bi-geo-alt-fill"></i> Cadastro de Local de Avaliação
                    </h4>

                    <div class="row">
                        <!-- 🔹 Timeline lateral -->
                        <div class="col-md-4">
                            <?= view('places/timeline', ['etapaAtual' => 1]) ?>
                        </div>

                        <!-- 🔹 Conteúdo da etapa -->
                        <div class="col-md-8">
                            <p class="text-muted">
                                Para cadastrar um local, é necessário informar o <strong>CEP</strong> do endereço.
                                Esses dados são importantes para localizar o local no mapa e facilitar a busca por outros usuários.
                            </p>

                            <hr class="my-4">

                            <div class="d-grid gap-3">
                                <button type="button" class="btn btn-primary btn-lg shadow-sm rounded-pill">
                                    <i class="bi bi-geo-alt"></i> Informar o CEP
                                </button>

                                <button type="button" class="btn btn-outline-secondary btn-lg shadow-sm rounded-pill">
                                    <i class="bi bi-question-circle"></i> Não sei o CEP
                                </button>
                            </div>

                            <div class="mt-4 text-muted small text-center">
                                Etapa <strong>1</strong> de <strong>3</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>