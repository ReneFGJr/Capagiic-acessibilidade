<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-11 col-lg-9">
      <div class="card border-0 shadow rounded-4">
        <div class="card-body p-4">
          <h4 class="text-primary fw-bold mb-4"><i class="bi bi-person-badge"></i> Meu Perfil</h4>

          <?php
            $user = session()->get('user') ?? [];
            $name = $user['name'] ?? session()->get('name') ?? '-';
            $email = $user['email'] ?? session()->get('email') ?? '-';
          ?>

          <div class="mb-2"><strong>Nome:</strong> <?= esc((string) $name) ?></div>
          <div class="mb-3"><strong>Email:</strong> <?= esc((string) $email) ?></div>

          <hr class="my-4">

          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 text-primary fw-semibold"><i class="bi bi-geo-alt"></i> Meus Locais</h5>
            <a href="<?= base_url('places') ?>" class="btn btn-sm btn-primary">Novo local</a>
          </div>

          <?php $places = $places ?? []; ?>

          <?php if (empty($places)) : ?>
            <div class="alert alert-light border mb-4">
              Nenhum local vinculado ao seu login ainda.
            </div>
          <?php else : ?>
            <div class="table-responsive mb-4">
              <table class="table table-striped align-middle">
                <thead>
                  <tr>
                    <th>Local</th>
                    <th>Status</th>
                    <th>Atualizado em</th>
                    <th class="text-end">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($places as $place) : ?>
                    <?php
                      $statusCode = (int) ($place['pl_status'] ?? 0);
                      $statusMap = [
                        0 => 'Em preenchimento',
                        1 => 'Em avaliacao',
                        2 => 'Avaliacao concluida',
                        9 => 'Fim da avaliacao',
                      ];
                      $statusLabel = $statusMap[$statusCode] ?? 'Em preenchimento';
                    ?>
                    <tr>
                      <td><?= esc((string) ($place['pl_name'] ?? '-')) ?></td>
                      <td><?= esc($statusLabel) ?></td>
                      <td><?= esc((string) ($place['updated_at'] ?? '-')) ?></td>
                      <td class="text-end">
                        <?php if ($statusCode === 0) : ?>
                          <a href="<?= base_url('places') ?>" class="btn btn-sm btn-outline-secondary">Editar local</a>
                        <?php else : ?>
                          <a href="<?= base_url('places') ?>" class="btn btn-sm btn-outline-secondary me-1">Editar local</a>
                          <a href="<?= base_url('form') ?>" class="btn btn-sm btn-outline-primary">Continuar avaliacao</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>

          <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger">
            <i class="bi bi-box-arrow-right"></i> Sair
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
