<div class="container">
    <div class="row">
        <div class="col-sm-3"><?= $group['etapa'] ?? '' ?></div>
        <div class="col-sm-9">

        <div class="card-body p-4">
            <h4 class="mb-4 text-primary fw-bold">
                <i class="bi bi-building"></i> Avaliação: Entorno do prédio
            </h4>

            <form action="<?= base_url('question_group/save') ?>" method="post">
                <?php foreach ($questions as $q): ?>
                    <div class="mb-4 border-bottom pb-3">
                        <input type="hidden" name="id_gr[]" value="<?= esc($q['id_gr']) ?>">

                        <p class="fw-semibold mb-2">
                            <span class="text-secondary small"><?= esc($q['gr_class']) ?></span><br>
                            <?= esc($q['gr_name']) ?>
                        </p>

                        <div class="btn-group d-flex flex-wrap" role="group" aria-label="Resposta">
                            <?php
                            $respostas = ['Sim', 'Não', 'Parcialmente', 'Em implantação', 'Não se aplica'];
                            foreach ($respostas as $r):
                                $idRadio = 'q' . $q['id_gr'] . '_' . strtolower(str_replace(' ', '_', $r));
                            ?>
                                <input type="radio"
                                    class="btn-check"
                                    name="resposta[<?= $q['id_gr'] ?>]"
                                    id="<?= $idRadio ?>"
                                    value="<?= $r ?>"
                                    required>
                                <label class="btn btn-outline-primary m-1 flex-fill" for="<?= $idRadio ?>">
                                    <?= $r ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-send"></i> Enviar Avaliação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>