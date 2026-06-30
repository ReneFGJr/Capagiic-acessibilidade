<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-6">
      <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">
          <h4 class="text-center text-primary fw-bold mb-4">
            <i class="bi bi-key"></i> Recuperar senha
          </h4>

          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
          <?php endif; ?>

          <p class="text-muted small">Informe seu email e defina uma nova senha.</p>

          <form method="post" action="<?= base_url('recuperar-senha') ?>">
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email cadastrado</label>
              <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
              <label for="new_password" class="form-label fw-semibold">Nova senha</label>
              <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="new_password_confirm" class="form-label fw-semibold">Confirmar nova senha</label>
              <input type="password" id="new_password_confirm" name="new_password_confirm" class="form-control" required>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary btn-lg">Atualizar senha</button>
            </div>
          </form>

          <div class="text-center small">
            <a href="<?= base_url('login') ?>" class="text-decoration-none">Voltar para login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
