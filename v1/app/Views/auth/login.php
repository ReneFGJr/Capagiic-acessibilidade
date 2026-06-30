<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-5">
      <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-4">
          <h4 class="text-center text-primary fw-bold mb-4">
            <i class="bi bi-box-arrow-in-right"></i> Entrar
          </h4>

          <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
          <?php endif; ?>
          <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('msg')) ?></div>
          <?php endif; ?>

          <form method="post" action="<?= base_url('login') ?>">
            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" id="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Senha</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </div>
          </form>

          <div class="text-center small">
            <a href="<?= base_url('cadastro') ?>" class="text-decoration-none">Cadastrar-se</a>
            <span class="mx-2">|</span>
            <a href="<?= base_url('recuperar-senha') ?>" class="text-decoration-none">Recuperar senha</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
