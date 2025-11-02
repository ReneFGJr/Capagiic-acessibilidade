<!-- 🔹 Navbar CAPAGIIC - Acessibilidade -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <!-- Logo / Nome do sistema -->
    <a class="navbar-brand d-flex align-items-center fw-bold" href="<?= base_url('/') ?>">
      <i class="bi bi-universal-access me-2 fs-3"></i> CAPAGIIC
    </a>

    <!-- Botão para modo mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCAPAGIIC" aria-controls="navbarCAPAGIIC" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Itens da navbar -->
    <div class="collapse navbar-collapse" id="navbarCAPAGIIC">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

        <!-- Página inicial -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/') ?>">
            <i class="bi bi-house-door-fill me-1"></i> Início
          </a>
        </li>

        <!-- Avaliação -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('form') ?>">
            <i class="bi bi-clipboard-check me-1"></i> Avaliação
          </a>
        </li>

        <!-- Locais -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('places') ?>">
            <i class="bi bi-geo-alt-fill me-1"></i> Locais
          </a>
        </li>

        <!-- Banco de Imagens -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('images') ?>">
            <i class="bi bi-image me-1"></i> Banco de Imagens
          </a>
        </li>

        <!-- Sobre -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('about') ?>">
            <i class="bi bi-info-circle me-1"></i> Sobre
          </a>
        </li>

        <!-- Acessibilidade (modo alto contraste / fonte maior) -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarAcessibilidade" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-eye me-1"></i> Acessibilidade
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarAcessibilidade">
            <li><a class="dropdown-item" href="#" onclick="toggleContrast()">Alternar Alto Contraste</a></li>
            <li><a class="dropdown-item" href="#" onclick="increaseFont()">Aumentar Fonte</a></li>
            <li><a class="dropdown-item" href="#" onclick="decreaseFont()">Diminuir Fonte</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- 🔹 Funções JS simples para acessibilidade -->
<script>
function toggleContrast() {
  document.body.classList.toggle('high-contrast');
}

function increaseFont() {
  document.body.style.fontSize = 'larger';
}

function decreaseFont() {
  document.body.style.fontSize = 'smaller';
}
</script>

<style>
  /* 🔹 Tema de alto contraste */
  .high-contrast {
    background-color: #000 !important;
    color: #fff !important;
  }
  .high-contrast a, .high-contrast .nav-link {
    color: #ff0 !important;
  }
</style>
