<div class="container my-5">
    <div class="row g-4 justify-content-center">
        <div class="col-12 mb-5">
            <h1>Gerador de Prompt para Imagens</h1>
            <p class="text-muted">Descreva a imagem em uma frase de 150 palavras
            </p>
            <div class="col-12">
                <tt>
                    Prompt
                    <?php foreach ($prompt as $item): ?>
                        <div class="mb-4">
                            <h1><?= esc($item['gr_name']); ?> <?php echo $item['gr_class']; ?></h1>
                            <p>
                                Crie uma imagem na horizonta sobre "<?= esc($item['gr_name']); ?>".
                                Crie como um desenho.
                                Descreva a imagem para um cego.
                                Na imagem represente, um cego, cadeirante, idoso, altista, dificuldade de mobilidade, Deficiência Múltipla.
                                Não use texto na imagem.
                                Use uma proporça de 6x1.
                                A imagem é um banner.
                                Aumente o contraste das cores.
                                <br>Abordando os seguintes temas:
                                <?php foreach ($item['themas'] as $idk => $part): ?>
                                    <?= $part['gr_name']; ?>.
                                <?php endforeach; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </tt>
            </div>
        </div>
    </div>