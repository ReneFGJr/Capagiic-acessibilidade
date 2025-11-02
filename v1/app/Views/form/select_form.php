<div class="container my-5">
    <div class="row g-4 justify-content-center">
        <?php foreach ($forms as $index => $step): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card shadow-sm border-2 h-100 rounded-4 hover-card text-center">
                    <div class="">
                        <div class="mb-3">
                            <?= $step['image']; ?>
                        </div>
                        <h5 class="card-title text-primary fw-semibold mb-3">
                            <?= esc($step['gr_name']); ?>
                        </h5>
                        <div class="p-4">
                            <a href="<?=base_url('form/'.substr($step['gr_class'], 0, 2).'/01'); ?>" class="btn btn-outline-primary w-100 fw-semibold">
                                <i class="bi bi-clipboard-check"></i> Selecionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
</style>