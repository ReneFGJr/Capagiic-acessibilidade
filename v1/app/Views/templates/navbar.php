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
$headerLevelEnabled = filter_var((string) env('header_level', 'false'), FILTER_VALIDATE_BOOL);
?>

<!-- 🔹 Navbar CAPAGIIC - Acessibilidade -->
<a class="skip-link" href="#conteudo">Pular para o conteúdo principal</a>
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
            <li><a class="dropdown-item" href="<?= base_url('acessibilidade') ?>">Sobre a acessibilidade do site</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="toggleContrast()">Alternar Alto Contraste</a></li>
            <?php if ($headerLevelEnabled) : ?>
              <li><a class="dropdown-item" href="#" onclick="toggleHeadingLevels()">Níveis: exibir H1-H6</a></li>
            <?php endif; ?>
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
  const nextState = !document.body.classList.contains('high-contrast');
  applyContrastMode(nextState);
  setCookie('capagiic_high_contrast', nextState ? '1' : '0', 365);
}

function applyContrastMode(enabled) {
  document.body.classList.toggle('high-contrast', Boolean(enabled));
}

function toggleHeadingLevels() {
  const nextState = !document.body.classList.contains('high-heading-levels');
  applyHeadingLevels(nextState);
  setCookie('capagiic_header_level', nextState ? '1' : '0', 365);
}

function applyHeadingLevels(enabled) {
  const isEnabled = Boolean(enabled);
  document.body.classList.toggle('high-heading-levels', isEnabled);
  syncHeadingLevels(isEnabled);
}

function scheduleHeadingLevels(enabled) {
  if (!enabled) {
    applyHeadingLevels(false);
    return;
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function onHeadingLevelsReady() {
      document.removeEventListener('DOMContentLoaded', onHeadingLevelsReady);
      applyHeadingLevels(true);
    });
    return;
  }

  applyHeadingLevels(true);
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

function loadSavedContrastMode() {
  const savedContrast = getCookie('capagiic_high_contrast');
  applyContrastMode(savedContrast === '1');
}

function syncHeadingLevels(enabled) {
  const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');

  headings.forEach((heading) => {
    const existingBadge = heading.querySelector(':scope > sup.heading-level-badge');

    if (!enabled) {
      if (existingBadge) {
        existingBadge.remove();
      }
      return;
    }

    const level = heading.tagName.substring(1);

    if (!existingBadge) {
      const badge = document.createElement('sup');
      badge.className = 'heading-level-badge';
      badge.setAttribute('aria-hidden', 'true');
      badge.textContent = 'H' + level;
      heading.appendChild(badge);
      return;
    }

    existingBadge.textContent = 'H' + level;
  });
}

function loadSavedHeadingLevels() {
  const savedHeadingLevels = getCookie('capagiic_header_level');
  scheduleHeadingLevels(savedHeadingLevels === '1');
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

loadSavedContrastMode();
<?php if ($headerLevelEnabled) : ?>
loadSavedHeadingLevels();
<?php endif; ?>
loadSavedFontScale();
</script>

<style>
  .skip-link {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    z-index: 1050;
    padding: 0.75rem 1rem;
    background: #ffffff;
    color: #0d2f53;
    font-weight: 700;
    border-radius: 0.5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.18);
    transform: translateY(-200%);
    transition: transform 0.2s ease;
  }

  .skip-link:focus,
  .skip-link:focus-visible {
    transform: translateY(0);
    outline: 3px solid #ffd54f;
    outline-offset: 3px;
  }

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
  .high-contrast,
  .high-contrast body,
  .high-contrast #conteudo {
    background-color: #000 !important;
    color: #fff !important;
  }

  .high-contrast *,
  .high-contrast *::before,
  .high-contrast *::after {
    text-shadow: none !important;
    box-shadow: none !important;
  }

  .high-contrast a,
  .high-contrast .nav-link,
  .high-contrast .navbar-brand,
  .high-contrast .dropdown-item,
  .high-contrast .btn-link {
    color: #ff0 !important;
  }

  .high-contrast a:hover,
  .high-contrast a:focus-visible,
  .high-contrast .nav-link:hover,
  .high-contrast .nav-link:focus-visible,
  .high-contrast .navbar-brand:hover,
  .high-contrast .navbar-brand:focus-visible,
  .high-contrast .dropdown-item:hover,
  .high-contrast .dropdown-item:focus-visible,
  .high-contrast .btn-link:hover,
  .high-contrast .btn-link:focus-visible {
    color: #000 !important;
    background-color: #ff0 !important;
    outline: 3px solid #ff0;
    outline-offset: 2px;
  }

  .high-contrast .cap-navbar,
  .high-contrast .cap-footer,
  .high-contrast .dropdown-menu,
  .high-contrast .card,
  .high-contrast .hero,
  .high-contrast .bg-light,
  .high-contrast .modal-content,
  .high-contrast .offcanvas,
  .high-contrast .list-group-item,
  .high-contrast .table,
  .high-contrast .table > :not(caption) > * > * {
    background-color: #000 !important;
    color: #fff !important;
    border-color: #fff !important;
  }

  .high-contrast .border,
  .high-contrast .border-top,
  .high-contrast .border-end,
  .high-contrast .border-bottom,
  .high-contrast .border-start {
    border-color: #fff !important;
  }

  .high-contrast .text-muted,
  .high-contrast .text-secondary,
  .high-contrast .small,
  .high-contrast small,
  .high-contrast .form-text,
  .high-contrast .card-text {
    color: #fff !important;
    opacity: 1 !important;
  }

  .high-contrast .btn,
  .high-contrast .btn-primary,
  .high-contrast .btn-secondary,
  .high-contrast .btn-success,
  .high-contrast .btn-danger,
  .high-contrast .btn-warning,
  .high-contrast .btn-info,
  .high-contrast .btn-light,
  .high-contrast .btn-dark,
  .high-contrast .btn-outline-primary,
  .high-contrast .btn-outline-secondary,
  .high-contrast .btn-outline-success,
  .high-contrast .btn-outline-danger,
  .high-contrast .btn-outline-warning,
  .high-contrast .btn-outline-info,
  .high-contrast .btn-outline-light,
  .high-contrast .btn-outline-dark {
    background-color: #000 !important;
    color: #ff0 !important;
    border: 2px solid #ff0 !important;
  }

  .high-contrast .btn:hover,
  .high-contrast .btn:focus-visible {
    background-color: #ff0 !important;
    color: #000 !important;
    border-color: #ff0 !important;
  }

  .high-contrast .form-control,
  .high-contrast .form-select,
  .high-contrast .input-group-text,
  .high-contrast .form-check-input,
  .high-contrast .custom-control-input,
  .high-contrast .custom-file-label {
    background-color: #000 !important;
    color: #fff !important;
    border-color: #fff !important;
  }

  .high-contrast .form-control::placeholder,
  .high-contrast .form-select,
  .high-contrast ::placeholder {
    color: #fff !important;
    opacity: 1 !important;
  }

  .high-contrast .card-header,
  .high-contrast .card-footer,
  .high-contrast .dropdown-header,
  .high-contrast .dropdown-divider,
  .high-contrast hr {
    background-color: #000 !important;
    border-color: #fff !important;
    color: #fff !important;
  }

  .high-contrast .badge,
  .high-contrast .alert,
  .high-contrast .progress,
  .high-contrast .progress-bar,
  .high-contrast .table-striped > tbody > tr:nth-of-type(odd) > * {
    background-color: #000 !important;
    color: #fff !important;
    border-color: #fff !important;
  }

  .high-heading-levels h1,
  .high-heading-levels h2,
  .high-heading-levels h3,
  .high-heading-levels h4,
  .high-heading-levels h5,
  .high-heading-levels h6,
  .high-heading-levels .h1,
  .high-heading-levels .h2,
  .high-heading-levels .h3,
  .high-heading-levels .h4,
  .high-heading-levels .h5,
  .high-heading-levels .h6 {
    display: inline-block;
    background: #fff3cd !important;
    color: #0d2f53 !important;
    border: 2px solid #0d2f53 !important;
    border-radius: 0.35rem;
    padding: 0.15rem 0.5rem;
    box-decoration-break: clone;
    -webkit-box-decoration-break: clone;
  }

  .high-heading-levels h1 .heading-level-badge,
  .high-heading-levels h2 .heading-level-badge,
  .high-heading-levels h3 .heading-level-badge,
  .high-heading-levels h4 .heading-level-badge,
  .high-heading-levels h5 .heading-level-badge,
  .high-heading-levels h6 .heading-level-badge,
  .high-heading-levels .h1 .heading-level-badge,
  .high-heading-levels .h2 .heading-level-badge,
  .high-heading-levels .h3 .heading-level-badge,
  .high-heading-levels .h4 .heading-level-badge,
  .high-heading-levels .h5 .heading-level-badge,
  .high-heading-levels .h6 .heading-level-badge {
    margin-left: 0.25rem;
  }

  .high-heading-levels .heading-level-badge {
    display: inline-block;
    margin-left: 0.35rem;
    font-size: 0.65em;
    line-height: 1;
    vertical-align: super;
    background: #ff0 !important;
    color: #000 !important;
    border: 1px solid #000 !important;
    border-radius: 0.25rem;
    padding: 0 0.25rem;
    font-weight: 800;
    box-shadow: none !important;
  }
</style>
