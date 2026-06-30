<div class="container">
    <?php
        $group = $group ?? ['gr_name' => 'Questionario'];
        $questions = $questions ?? [];
        $placeData = $placeData ?? [];
        $navigation = $navigation ?? ['prevUrl' => null, 'nextUrl' => null, 'isLast' => true];
        $statusCode = (int) ($placeData['pl_status'] ?? 0);
        $statusMap = [
            0 => 'Em preenchimento',
            1 => 'Em avaliacao',
            2 => 'Avaliacao concluida',
            9 => 'Fim da avaliacao',
        ];
        $placeStatus = $statusMap[$statusCode] ?? 'Em preenchimento';
        $placeCep = preg_replace('/\D/', '', (string) ($placeData['pl_cep'] ?? ''));
        $placeCep = strlen($placeCep) === 8 ? substr($placeCep, 0, 5) . '-' . substr($placeCep, 5) : (string) ($placeData['pl_cep'] ?? '-');
    ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <h5 class="text-primary fw-bold mb-3">
                <i class="bi bi-geo-alt-fill"></i> Local em avaliacao
            </h5>

            <?php if (!empty($placeData['id_pl'])): ?>
                <div class="row g-2">
                    <div class="col-md-6"><strong>Local:</strong> <?= esc((string) ($placeData['pl_name'] ?? '-')) ?></div>
                    <div class="col-md-6"><strong>Status:</strong> <?= esc($placeStatus) ?></div>
                    <div class="col-md-6"><strong>Endereco:</strong> <?= esc((string) ($placeData['pl_address'] ?? '-')) ?></div>
                    <div class="col-md-3"><strong>Bairro:</strong> <?= esc((string) ($placeData['pl_bairro'] ?? '-')) ?></div>
                    <div class="col-md-3"><strong>CEP:</strong> <?= esc((string) $placeCep) ?></div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning mb-0">
                    Nenhum local vinculado foi encontrado para esta avaliacao.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3"><?= $timeline ?? '' ?></div>
        <div class="col-sm-9">

        <div class="card-body p-4">
            <h4 class="mb-4 text-primary fw-bold">
                <i class="bi bi-building"></i> Avaliação: <?= esc($group['gr_name']) ?>
            </h4>

            <?php $idPlace = (int) ($placeData['id_pl'] ?? 0); ?>

            <?php if ($idPlace <= 0): ?>
                <div class="alert alert-warning">
                    Nenhum local vinculado foi encontrado. Cadastre um local em <a href="<?= base_url('places') ?>">Locais</a> antes de responder o questionário.
                </div>
            <?php endif; ?>

            <div id="ajaxAnswerFeedback" class="small text-muted mb-3"></div>

            <form action="javascript:void(0);" method="post" id="questionarioForm" data-id-pl="<?= esc((string) $idPlace) ?>">
                <?php foreach ($questions as $q): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <input type="hidden" name="id_gr[]" value="<?= esc($q['id_gr']) ?>">

                        <p class="fw-semibold mb-2">
                            <?= esc($q['gr_name']) ?>
                        </p>

                        <div class="btn-group d-flex flex-wrap" role="group" aria-label="Resposta">
                            <?php
                            $respostas = ['Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica'];
                            foreach ($respostas as $r):
                                $idRadio = 'q' . $q['id_gr'] . '_' . strtolower(str_replace(' ', '_', $r));
                                $currentAnswer = (string) ($answersByQuestion[(int) $q['id_gr']] ?? '');
                            ?>
                                <input type="radio"
                                    class="btn-check"
                                    data-answer-radio="1"
                                    data-id-gr="<?= esc((string) $q['id_gr']) ?>"
                                    name="resposta[<?= $q['id_gr'] ?>]"
                                    id="<?= $idRadio ?>"
                                    value="<?= $r ?>"
                                    <?= $currentAnswer === $r ? 'checked' : '' ?>
                                    <?= $idPlace <= 0 ? 'disabled' : '' ?>
                                    required>
                                <label class="btn btn-outline-primary m-1 flex-fill" for="<?= $idRadio ?>">
                                    <?= $r ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                    <div>
                        <?php if (!empty($navigation['prevUrl'])): ?>
                            <a href="<?= esc((string) $navigation['prevUrl']) ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Voltar
                            </a>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if (!empty($navigation['nextUrl'])): ?>
                            <a href="<?= esc((string) $navigation['nextUrl']) ?>" class="btn btn-primary">
                                Avançar <i class="bi bi-arrow-right"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('form') ?>" class="btn btn-primary">
                                <i class="bi bi-check2"></i> Finalizar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

<script>
(() => {
    const form = document.getElementById('questionarioForm');
    if (!form) {
        return;
    }

    const idPl = Number(form.dataset.idPl || 0);
    const feedback = document.getElementById('ajaxAnswerFeedback');
    const saveUrl = '<?= base_url('form/answer-ajax') ?>';

    const showFeedback = (text, ok = true) => {
        if (!feedback) {
            return;
        }
        feedback.textContent = text;
        feedback.classList.remove('text-muted', 'text-success', 'text-danger');
        feedback.classList.add(ok ? 'text-success' : 'text-danger');
    };

    if (idPl <= 0) {
        return;
    }

    form.querySelectorAll('[data-answer-radio="1"]').forEach((radio) => {
        radio.addEventListener('change', async (event) => {
            const el = event.currentTarget;
            const idGr = Number(el.dataset.idGr || 0);
            const answer = String(el.value || '').trim();

            if (!idGr || !answer) {
                showFeedback('Nao foi possivel identificar a questao selecionada.', false);
                return;
            }

            const body = new URLSearchParams();
            body.append('id_pl', String(idPl));
            body.append('id_gr', String(idGr));
            body.append('answer', answer);

            showFeedback('Salvando resposta...');

            try {
                const response = await fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    },
                    body: body.toString(),
                });

                const json = await response.json();
                if (!response.ok || json.status !== 'ok') {
                    showFeedback(json.message || 'Erro ao salvar resposta.', false);
                    return;
                }

                showFeedback('Resposta salva.');
            } catch (error) {
                showFeedback('Falha de comunicacao ao salvar resposta.', false);
            }
        });
    });
})();
</script>