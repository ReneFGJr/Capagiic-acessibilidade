<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-6">
      <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">
          <h4 class="text-center text-primary fw-bold mb-4">
            <i class="bi bi-person-plus"></i> Cadastrar-se
          </h4>

          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
          <?php endif; ?>

          <form method="post" action="<?= base_url('cadastro') ?>">
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Nome completo</label>
              <input type="text" id="name" name="name" class="form-control" value="<?= old('name') ?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Senha</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password_confirm" class="form-label fw-semibold">Confirmar senha</label>
              <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary btn-lg">Criar conta</button>
            </div>
          </form>

          <div class="text-center small">
            Já tem conta?
            <a href="<?= base_url('login') ?>" class="text-decoration-none">Entrar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
