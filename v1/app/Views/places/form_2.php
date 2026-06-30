<?php
    $placeData = $placeData ?? [];
    $storedAddress = (string) ($placeData['pl_address'] ?? '');
    $addressParts = array_map('trim', explode(',', $storedAddress));
    $storedLogradouro = $addressParts[0] ?? '';
    $storedNumero = $addressParts[1] ?? '';
    $storedComplemento = $addressParts[2] ?? '';
    $storedCep = (string) ($placeData['pl_cep'] ?? '');
    $storedCepDigits = preg_replace('/\D/', '', $storedCep);
    $storedCepFormatted = strlen($storedCepDigits) === 8
        ? substr($storedCepDigits, 0, 5) . '-' . substr($storedCepDigits, 5)
        : $storedCep;
    $storedBairro = (string) ($placeData['pl_bairro'] ?? '');
?>

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
                            <?= view('places/timeline', ['etapaAtual' => 2]) ?>
                        </div>

                        <!-- 🔹 Conteúdo da etapa -->
                        <div class="col-md-8">
                            <p class="text-muted">
                                Para cadastrar um local, é necessário informar o <strong>CEP</strong> do endereço.
                                Esses dados são importantes para localizar o local no mapa e facilitar a busca por outros usuários.
                            </p>

                            <hr class="my-4">

                            <div class="d-grid gap-3">
                                <button type="button" id="btnInformarCep" class="btn btn-primary btn-lg shadow-sm rounded-pill">
                                    <i class="bi bi-geo-alt"></i> Informar o CEP
                                </button>

                                <a href="https://buscacepinter.correios.com.br/app/endereco/index.php"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn btn-outline-secondary btn-lg shadow-sm rounded-pill">
                                    <i class="bi bi-question-circle"></i> Não sei o CEP
                                </a>
                            </div>

                            <div id="cepFormArea" class="mt-4 <?= $storedCep !== '' ? '' : 'd-none' ?>">
                                <label for="cepInput" class="form-label fw-bold">Digite o CEP</label>
                                <div class="input-group">
                                    <input type="text" id="cepInput" class="form-control" maxlength="9" value="<?= esc($storedCepFormatted) ?>" placeholder="Ex: 90010-150" inputmode="numeric">
                                    <button type="button" id="btnConsultarCep" class="btn btn-primary">
                                        Consultar
                                    </button>
                                </div>
                                <div id="cepFeedback" class="small mt-2 text-muted"></div>
                            </div>

                            <form id="enderecoForm" method="post" action="<?= base_url('places/save') ?>" class="mt-4 <?= $storedCep !== '' ? '' : 'd-none' ?>">
                                <input type="hidden" name="etapa" value="2">
                                <input type="hidden" id="cepHidden" name="pl_cep" value="<?= esc($storedCepDigits) ?>">
                                <input type="hidden" id="cidadeIbge" name="pl_city" value="<?= esc((string) ($placeData['pl_city'] ?? '')) ?>">
                                <input type="hidden" id="nomeLocalHidden" name="pl_name" value="<?= esc((string) ($placeData['pl_name'] ?? '')) ?>">

                                <div class="mb-3">
                                    <label for="logradouroInput" class="form-label fw-bold">Logradouro</label>
                                    <input type="text" id="logradouroInput" name="pl_logradouro" class="form-control" value="<?= esc($storedLogradouro) ?>" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="numeroInput" class="form-label fw-bold">Numero</label>
                                        <input type="text" id="numeroInput" name="pl_numero" class="form-control" value="<?= esc($storedNumero) ?>" required>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="complementoInput" class="form-label fw-bold">Complemento</label>
                                        <input type="text" id="complementoInput" name="pl_complemento" class="form-control" value="<?= esc($storedComplemento) ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="bairroInput" class="form-label fw-bold">Bairro</label>
                                        <input type="text" id="bairroInput" name="pl_bairro" class="form-control" value="<?= esc($storedBairro) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cidadeNomeInput" class="form-label fw-bold">Cidade</label>
                                        <input type="text" id="cidadeNomeInput" class="form-control" value="" placeholder="Cidade carregada pelo CEP" readonly>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="ufInput" class="form-label fw-bold">UF</label>
                                    <input type="text" id="ufInput" class="form-control" value="" placeholder="UF carregada pelo CEP" readonly>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg shadow-sm rounded-pill">
                                        <i class="bi bi-save"></i> Salvar endereco
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-muted small text-center">
                                Etapa <strong>2</strong> de <strong>4</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(() => {
    const toggleButton = document.getElementById('btnInformarCep');
    const formArea = document.getElementById('cepFormArea');
    const cepInput = document.getElementById('cepInput');
    const consultarButton = document.getElementById('btnConsultarCep');
    const feedback = document.getElementById('cepFeedback');
    const enderecoForm = document.getElementById('enderecoForm');
    const cepHidden = document.getElementById('cepHidden');
    const logradouroInput = document.getElementById('logradouroInput');
    const bairroInput = document.getElementById('bairroInput');
    const cidadeNomeInput = document.getElementById('cidadeNomeInput');
    const ufInput = document.getElementById('ufInput');
    const cidadeIbge = document.getElementById('cidadeIbge');

    if (!toggleButton || !formArea || !cepInput || !consultarButton || !feedback || !enderecoForm || !cepHidden) {
        return;
    }

    toggleButton.addEventListener('click', () => {
        formArea.classList.remove('d-none');
        cepInput.focus();
        feedback.textContent = 'Informe o CEP e clique em Consultar.';
        feedback.className = 'small mt-2 text-muted';
    });

    consultarButton.addEventListener('click', async () => {
        const cep = cepInput.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            feedback.textContent = 'CEP inválido. Digite 8 números.';
            feedback.className = 'small mt-2 text-danger';
            return;
        }

        feedback.textContent = 'Consultando CEP...';
        feedback.className = 'small mt-2 text-muted';

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            if (!response.ok || data.erro) {
                feedback.textContent = 'CEP nao encontrado.';
                feedback.className = 'small mt-2 text-danger';
                return;
            }

            if (logradouroInput) {
                logradouroInput.value = data.logradouro || '';
            }
            if (bairroInput) {
                bairroInput.value = data.bairro || '';
            }
            if (cidadeNomeInput) {
                cidadeNomeInput.value = data.localidade || '';
            }
            if (ufInput) {
                ufInput.value = data.uf || '';
            }
            if (cidadeIbge) {
                cidadeIbge.value = data.ibge || '';
            }

            cepHidden.value = cep;
            cepInput.value = `${cep.substring(0, 5)}-${cep.substring(5)}`;
            formArea.classList.remove('d-none');
            enderecoForm.classList.remove('d-none');
            feedback.textContent = 'CEP valido. Edite os dados do endereco e salve.';
            feedback.className = 'small mt-2 text-success';
            if (logradouroInput) {
                logradouroInput.focus();
            }
        } catch (error) {
            feedback.textContent = 'Falha ao consultar CEP. Tente novamente.';
            feedback.className = 'small mt-2 text-danger';
        }
    });

    enderecoForm.addEventListener('submit', (event) => {
        const cep = cepInput.value.replace(/\D/g, '');
        if (cep.length !== 8) {
            event.preventDefault();
            feedback.textContent = 'Informe um CEP valido antes de salvar.';
            feedback.className = 'small mt-2 text-danger';
            formArea.classList.remove('d-none');
            cepInput.focus();
            return;
        }

        cepHidden.value = cep;
    });

    if (cepInput.value.replace(/\D/g, '').length === 8 && !cidadeNomeInput.value) {
        consultarButton.click();
    }
})();
</script>