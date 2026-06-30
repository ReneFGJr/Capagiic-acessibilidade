<?php
$session = session();

$isLoggedIn = (bool) (
  $session->get('isLoggedIn')
  ?? $session->get('logged_in')
  ?? $session->get('logado')
  ?? $session->get('user_id')
  ?? $session->get('usuario_id')
);

$userData = $session->get('user') ?? $session->get('usuario');
$userName = '';

if (is_array($userData)) {
  $userName = (string) ($userData['name'] ?? $userData['nome'] ?? $userData['first_name'] ?? $userData['primeiro_nome'] ?? '');
} elseif (is_object($userData)) {
  $userName = (string) ($userData->name ?? $userData->nome ?? $userData->first_name ?? $userData->primeiro_nome ?? '');
}

if ($userName === '') {
  $userName = (string) (
    $session->get('name')
    ?? $session->get('nome')
    ?? $session->get('first_name')
    ?? $session->get('primeiro_nome')
    ?? ''
  );
}

$userName = trim($userName);
$firstName = $userName !== '' ? explode(' ', $userName)[0] : 'Usuário';
?>

<!-- 🔹 Navbar CAPAGIIC - Acessibilidade -->
<nav class="navbar navbar-expand-lg navbar-dark cap-navbar shadow-sm">
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

        <!-- Banco de Imagens -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('images') ?>">
            <i class="bi bi-image me-1"></i> Banco de Imagens
          </a>
        </li>

        <!-- Lugares -->
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('avaliations') ?>">
            <i class="bi bi-geo-alt-fill me-1"></i> Lugares
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
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header text-white-50">Tamanho da fonte</h6></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(100)">100%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(125)">125%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(150)">150%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(175)">175%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(200)">200%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(225)">225%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(250)">250%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(275)">275%</a></li>
            <li><a class="dropdown-item" href="#" onclick="setFontScale(300)">300%</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="resetFontScale()">Fonte padrão</a></li>
          </ul>
        </li>

        <?php if ($isLoggedIn) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUserMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle me-1"></i> <?= esc($firstName) ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserMenu">
              <li><a class="dropdown-item" href="<?= base_url('perfil') ?>"><i class="bi bi-person me-1"></i> Perfil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-1"></i> Sair</a></li>
            </ul>
          </li>
        <?php else : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarGuestMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Opções de acesso">
              <i class="bi bi-person-circle me-1"></i> Entrar
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarGuestMenu">
              <li><a class="dropdown-item" href="<?= base_url('login') ?>"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a></li>
              <li><a class="dropdown-item" href="<?= base_url('cadastro') ?>"><i class="bi bi-person-plus me-1"></i> Cadastrar-se</a></li>
              <li><a class="dropdown-item" href="<?= base_url('recuperar-senha') ?>"><i class="bi bi-key me-1"></i> Recuperar senha</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- 🔹 Funções JS simples para acessibilidade -->
<script>
function toggleContrast() {
  document.body.classList.toggle('high-contrast');
}

function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
  document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';
}

function getCookie(name) {
  const prefix = name + '=';
  const parts = document.cookie ? document.cookie.split('; ') : [];

  for (const part of parts) {
    if (part.indexOf(prefix) === 0) {
      return decodeURIComponent(part.substring(prefix.length));
    }
  }

  return null;
}

function applyFontScale(scale) {
  const parsedScale = Number(scale);
  const safeScale = Number.isFinite(parsedScale) ? Math.min(300, Math.max(100, parsedScale)) : 100;
  document.documentElement.style.fontSize = safeScale + '%';
  return safeScale;
}

function setFontScale(scale) {
  const safeScale = applyFontScale(scale);
  setCookie('capagiic_font_scale', String(safeScale), 365);
}

function resetFontScale() {
  applyFontScale(100);
  setCookie('capagiic_font_scale', '100', 365);
}

function loadSavedFontScale() {
  const savedScale = getCookie('capagiic_font_scale');

  if (savedScale === null || savedScale === '') {
    applyFontScale(100);
    return;
  }

  applyFontScale(savedScale);
}

loadSavedFontScale();
</script>

<style>
  .cap-navbar {
    background-color: #0d2f53 !important;
  }

  .cap-navbar .navbar-brand,
  .cap-navbar .nav-link {
    color: #ffffff !important;
    font-weight: 600;
  }

  .cap-navbar .nav-link:hover,
  .cap-navbar .nav-link:focus-visible,
  .cap-navbar .navbar-brand:hover,
  .cap-navbar .navbar-brand:focus-visible {
    color: #ffffff !important;
    background-color: rgba(255, 255, 255, 0.18);
    border-radius: 0.4rem;
    outline: 2px solid #ffffff;
    outline-offset: 2px;
  }

  .cap-navbar .dropdown-menu {
    background-color: #123e6b;
    border: 1px solid rgba(255, 255, 255, 0.25);
  }

  .cap-navbar .dropdown-item {
    color: #ffffff;
    font-weight: 500;
  }

  .cap-navbar .dropdown-item:hover,
  .cap-navbar .dropdown-item:focus-visible {
    color: #ffffff;
    background-color: #1e5a93;
  }

  .cap-navbar .dropdown-divider {
    border-top-color: rgba(255, 255, 255, 0.35);
  }

  .cap-navbar .dropdown-header {
    font-weight: 700;
    letter-spacing: 0.03em;
  }

  .cap-navbar .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.65);
  }

  /* 🔹 Tema de alto contraste */
  .high-contrast {
    background-color: #000 !important;
    color: #fff !important;
  }
  .high-contrast a, .high-contrast .nav-link {
    color: #ff0 !important;
  }
</style>
