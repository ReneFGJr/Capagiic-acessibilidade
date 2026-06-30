<style>
    /* ===== Estilo personalizado ===== */
    body {
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    }

    .hero {
        background: url('<?=$image['image']?>') center/cover no-repeat;
        color: #fff;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
        border-radius: 1rem;
        padding: 4rem 2rem;
    }

    .hero h1 {
        font-weight: 700;
    }

    .card-action {
        transition: all 0.3s ease;
        border-radius: 1rem;
    }

    .card-action:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 20px rgba(33, 150, 243, 0.3);
    }

    footer {
        margin-top: 3rem;
        text-align: center;
        color: #555;
    }
</style>

<div class="container py-5">

    <!-- Hero principal -->
    <div class="hero text-center mb-5">
        <h1 class="display-5 mb-3">
            <i class="bi bi-universal-access"></i> Projeto de Acessibilidade
        </h1>
        <p class="lead">
            Instrumento para avaliação das condições de acessibilidade em prédios públicos.
        </p>
        <a href="<?= base_url('avaliations/') ?>" class="btn btn-light btn-lg mt-3" style="font-size: 3.0rem;">
            <i class="bi bi-clipboard-check"></i> Iniciar Avaliação
        </a>
    </div>

    <!-- Cartões de ações -->
    <div class="row g-4 justify-content-center">
        <div class="col-md-5">
            <div class="card card-action shadow-sm border-0 text-center h-100">
                <div class="card-body py-4">
                    <i class="bi bi-geo-alt text-primary display-5 mb-3"></i>
                    <h5 class="card-title fw-bold">Gerenciar Locais</h5>
                    <p class="card-text text-muted">
                        Cadastre e mantenha atualizadas as informações dos locais avaliados.
                    </p>
                    <a href="<?= base_url('avaliations/') ?>" class="btn btn-outline-primary">
                        <i class="bi bi-pencil-square"></i> Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-action shadow-sm border-0 text-center h-100">
                <div class="card-body py-4">
                    <i class="bi bi-bar-chart-line text-success display-5 mb-3"></i>
                    <h5 class="card-title fw-bold">Relatórios e Indicadores</h5>
                    <p class="card-text text-muted">
                        Consulte resultados das avaliações e indicadores de acessibilidade.
                    </p>
                    <a href="<?= base_url('reports/') ?>" class="btn btn-outline-success">
                        <i class="bi bi-graph-up"></i> Visualizar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="mt-5">
        <small>© <?= date('Y') ?> Projeto de Acessibilidade — Desenvolvido com ❤️ pela UFRGS</small>
    </footer>
</div>
