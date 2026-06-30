<?php
/**
 * Replace static blog section in home.php with dynamic partial.
 */
$path = __DIR__ . '/../application/views/home.php';
$content = file_get_contents($path);

$replacement = <<<'HTML'
        <!--Start blog area-->
        <section id="blog-area" class="blog-default-area">
            <div class="container">
                <div class="row">
                    <?php if (empty($berita_list)): ?>
                        <div class="col-12 text-center py-4"><p>Belum ada berita terbaru.</p></div>
                    <?php else: $i = 0; foreach ($berita_list as $item): ?>
                        <?php $this->load->view('partials/berita_card_grid', array('item' => $item, 'delay' => ($i % 3) * 100)); $i++; ?>
                    <?php endforeach; endif; ?>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-3">
                        <a class="btn-one" href="<?php echo site_url('berita'); ?>">Lihat Semua Berita<span class="flaticon-next"></span></a>
                    </div>
                </div>
            </div>
        </section>
        <!--End blog area-->
HTML;

$pattern = '/<!--Start blog area-->.*?<!--End blog area-->/s';
$new = preg_replace($pattern, $replacement, $content, 1);
if ($new && $new !== $content) {
    file_put_contents($path, $new);
    echo "OK home.php patched\n";
} else {
    echo "FAIL home.php patch\n";
    exit(1);
}
