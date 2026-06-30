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

    .step-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .step-link:hover h6 {
        text-decoration: underline;
    }
</style>

<?php $etapaAtual = $etapaAtual ?? 1; ?>

<div class="stepper">
    <div class="step <?= $etapaAtual == 1 ? 'active' : '' ?>">
        <a href="<?= base_url('places/1') ?>" class="step-link" aria-label="Abrir etapa 1 informar local">
            <h6 class="mb-0 fw-bold <?= $etapaAtual == 1 ? 'text-primary' : 'text-muted' ?>">1. Informar Local</h6>
            <small><?= $etapaAtual == 1 ? 'Etapa atual' : 'Etapa inicial' ?></small>
        </a>
    </div>

    <div class="step <?= $etapaAtual == 2 ? 'active' : '' ?>">
        <a href="<?= base_url('places/2') ?>" class="step-link" aria-label="Abrir etapa 2 informar CEP">
            <h6 class="mb-0 fw-bold <?= $etapaAtual == 2 ? 'text-primary' : 'text-muted' ?>">2. Informar CEP</h6>
            <small><?= $etapaAtual == 2 ? 'Etapa atual' : 'Etapa de Localização' ?></small>
        </a>
    </div>

    <div class="step <?= $etapaAtual == 4 ? 'active' : '' ?>">
        <a href="<?= base_url('places/4') ?>" class="step-link" aria-label="Abrir etapa 3 confirmar endereco">
            <h6 class="mb-0 fw-bold <?= $etapaAtual == 4 ? 'text-primary' : 'text-muted' ?>">3. Confirmar endereço</h6>
            <small><?= $etapaAtual == 4 ? 'Etapa atual' : 'Revise antes de enviar' ?></small>
        </a>
    </div>
</div>