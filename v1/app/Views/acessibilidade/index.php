<?php
    $summary = $summary ?? ['total_answers' => 0, 'total_places' => 0, 'total_questions_answered' => 0];
    $topGroups = $topGroups ?? [];
    $totalQuestionsBank = (int) ($totalQuestionsBank ?? 0);
?>

<div class="container-fluid my-4 px-2 px-sm-3 px-lg-4">
  <div class="row justify-content-center">
    <div class="col-12 col-xxl-11">
      <div class="card border-0 shadow rounded-4 mb-4">
        <div class="card-body p-3 p-md-4 p-xl-5">
          <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
            <div>
              <h1 class="h3 fw-bold text-primary mb-2">
                <i class="bi bi-universal-access me-2"></i> Acessibilidade do site
              </h1>
              <p class="mb-0 text-muted">
                O CAPAGIIC foi desenvolvido com foco em inclusão, usabilidade e melhoria contínua da experiência de navegação.
              </p>
            </div>
            <a href="<?= base_url('reports') ?>" class="btn btn-outline-primary align-self-start">
              <i class="bi bi-bar-chart-line me-1"></i> Ver relatórios
            </a>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-3">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="text-muted small">Respostas registradas</div>
                  <div class="fs-4 fw-bold"><?= (int) ($summary['total_answers'] ?? 0) ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="text-muted small">Locais avaliados</div>
                  <div class="fs-4 fw-bold"><?= (int) ($summary['total_places'] ?? 0) ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="text-muted small">Questões respondidas</div>
                  <div class="fs-4 fw-bold"><?= (int) ($summary['total_questions_answered'] ?? 0) ?></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <div class="text-muted small">Banco de questões</div>
                  <div class="fs-4 fw-bold"><?= (int) $totalQuestionsBank ?></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row g-4 mb-4">
            <div class="col-lg-7">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h2 class="h5 fw-bold mb-3">Compromisso com acessibilidade</h2>
                  <p class="mb-3">
                    O CAPAGIIC foi concebido para evoluir com base em princípios reconhecidos internacionalmente de acessibilidade digital, com foco em percepção, operabilidade, compreensão e robustez. Isso significa priorizar navegação por teclado, hierarquia visual clara, linguagem objetiva, compatibilidade com leitores de tela e componentes que preservem contraste, foco visível e consistência de interação.
                  </p>
                  <p class="mb-3 text-muted">
                    Como referência de boas práticas, a plataforma procura se alinhar às diretrizes da W3C, especialmente as WCAG, que orientam requisitos como texto alternativo, contraste suficiente, navegação sem barreiras e uso previsível da interface. Quando aplicável, também observamos recomendações adotadas em padrões internacionais de contratação e conformidade, como ABNT NBR ISO e EN 301 549, sempre traduzindo essas orientações para melhorias práticas no sistema.
                  </p>
                  <div class="bg-light border rounded-3 p-3">
                    <h3 class="h6 fw-bold mb-2">O que isso representa na prática</h3>
                    <ul class="mb-0 text-muted">
                      <li>conteúdo legível e estruturado para diferentes tecnologias assistivas;</li>
                      <li>componentes operáveis por teclado e com foco perceptível;</li>
                      <li>contraste reforçado e redução de ambiguidade visual;</li>
                      <li>mensagens e formulários pensados para orientar o usuário com clareza;</li>
                      <li>revisão contínua a partir dos dados gerados pelas avaliações e pelos relatos recebidos.</li>
                    </ul>
                  </div>
                  <p class="mb-0 mt-3 text-muted">
                    As avaliações coletadas na plataforma ajudam a priorizar melhorias em ambientes físicos e digitais, apoiando decisões com base em dados e fortalecendo o compromisso institucional com a inclusão.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h2 class="h5 fw-bold mb-3">Principais grupos avaliados</h2>
                  <?php if (empty($topGroups)) : ?>
                    <div class="alert alert-light border mb-0">Ainda não há dados suficientes para exibir tendências.</div>
                  <?php else : ?>
                    <div class="list-group list-group-flush">
                      <?php foreach ($topGroups as $row) : ?>
                        <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                          <span><?= esc((string) ($row['gr_name'] ?? '-')) ?></span>
                          <span class="badge bg-primary rounded-pill"><?= (int) ($row['total'] ?? 0) ?></span>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row g-4">
            <div class="col-lg-5">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h2 class="h5 fw-bold mb-3">Como reportar barreiras</h2>
                  <p class="mb-3">
                    Se você encontrou uma barreira de acessibilidade, descreva a situação abaixo. O relato será registrado para análise pela equipe responsável.
                  </p>
                  <ul class="mb-0 text-muted">
                    <li>Informe a página ou ambiente afetado.</li>
                    <li>Descreva o problema com o máximo de detalhe possível.</li>
                    <li>Se desejar retorno, deixe um contato opcional.</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h2 class="h5 fw-bold mb-3">Enviar relato</h2>

                  <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger"><?= esc((string) session()->getFlashdata('error')) ?></div>
                  <?php endif; ?>
                  <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-success"><?= esc((string) session()->getFlashdata('msg')) ?></div>
                  <?php endif; ?>

                  <form method="post" action="<?= base_url('acessibilidade/reportar') ?>" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-md-6">
                      <label for="nome" class="form-label fw-semibold">Nome</label>
                      <input type="text" id="nome" name="nome" class="form-control" value="<?= esc(old('nome') ?? '') ?>" placeholder="Opcional">
                    </div>
                    <div class="col-md-6">
                      <label for="email" class="form-label fw-semibold">Email</label>
                      <input type="email" id="email" name="email" class="form-control" value="<?= esc(old('email') ?? '') ?>" placeholder="Opcional">
                    </div>
                    <div class="col-12">
                      <label for="pagina" class="form-label fw-semibold">Página ou área afetada</label>
                      <input type="text" id="pagina" name="pagina" class="form-control" value="<?= esc(old('pagina') ?? current_url()) ?>" placeholder="Ex.: formulário de avaliação">
                    </div>
                    <div class="col-12">
                      <label for="barreira" class="form-label fw-semibold">Descreva a barreira encontrada</label>
                      <textarea id="barreira" name="barreira" class="form-control" rows="5" required><?= esc(old('barreira') ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                      <label for="contato" class="form-label fw-semibold">Contato para retorno</label>
                      <input type="text" id="contato" name="contato" class="form-control" value="<?= esc(old('contato') ?? '') ?>" placeholder="Telefone, email ou outro meio de contato">
                    </div>
                    <div class="col-12 d-flex flex-column flex-sm-row gap-2">
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> Enviar relato
                      </button>
                      <a class="btn btn-outline-secondary" href="<?= base_url('about') ?>">
                        <i class="bi bi-info-circle me-1"></i> Sobre o sistema
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>