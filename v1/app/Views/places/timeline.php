<style>
    .stepper {
        position: relative;
        margin: 20px 0;
        padding-left: 30px;
        border-left: 2px solid #dee2e6;
    }

    .step {
        position: relative;
        padding: 15px 0 15px 20px;
    }

    .step::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 22px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #0d6efd;
    }

    .step.active::before {
        background-color: #0d6efd;
    }

    .step small {
        color: #6c757d;
    }
</style>

<div class="stepper">
    <div class="step <?= $etapaAtual == 1 ? 'active' : '' ?>">
        <h6 class="mb-0 fw-bold <?= $etapaAtual == 1 ? 'text-primary' : 'text-muted' ?>">1. Informar Local</h6>
        <small><?= $etapaAtual == 1 ? 'Etapa atual' : 'Etapa inicial' ?></small>
    </div>

    <div class="step <?= $etapaAtual == 2 ? 'active' : '' ?>">
        <h6 class="mb-0 fw-bold <?= $etapaAtual == 2 ? 'text-primary' : 'text-muted' ?>">2. Informar CEP</h6>
        <small><?= $etapaAtual == 2 ? 'Etapa atual' : 'Etapa de Localização' ?></small>
    </div>

    <div class="step <?= $etapaAtual == 3 ? 'active' : '' ?>">
        <h6 class="mb-0 fw-bold <?= $etapaAtual == 3 ? 'text-primary' : 'text-muted' ?>">3. Editar dados</h6>
        <small><?= $etapaAtual == 3 ? 'Etapa atual' : 'Preencha as informações' ?></small>
    </div>

    <div class="step <?= $etapaAtual == 4 ? 'active' : '' ?>">
        <h6 class="mb-0 fw-bold <?= $etapaAtual == 4 ? 'text-primary' : 'text-muted' ?>">4. Confirmar endereço</h6>
        <small><?= $etapaAtual == 4 ? 'Etapa atual' : 'Revise antes de enviar' ?></small>
    </div>
</div>