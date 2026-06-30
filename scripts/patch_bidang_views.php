<?php
/**
 * Replace static blog posts in bidang views with dynamic partial.
 */
$views = ['sekretariat', 'ppi', 'mutasi', 'pengembangan', 'evaluasi', 'uppk'];
$partial = "                        <div class=\"blog-post\">\n                            <?php \$this->load->view('partials/bidang_berita_posts', array('berita_list' => \$berita_list ?? array())); ?>\n                        </div>\n";

foreach ($views as $view) {
    $path = __DIR__ . "/../application/views/{$view}.php";
    $content = file_get_contents($path);
    $pattern = '/<div class="blog-post">.*?<\/div>\s*<div class="row">\s*<div class="col-md-12">\s*<ul class="post-pagination/s';
    if (!preg_match($pattern, $content)) {
        echo "SKIP {$view}: pattern not found\n";
        continue;
    }
    $replacement = $partial . "\n                        <div class=\"row\">\n                            <div class=\"col-md-12\">\n                                <ul class=\"post-pagination";
    $new = preg_replace($pattern, $replacement, $content, 1);
    if ($new === null || $new === $content) {
        echo "FAIL {$view}\n";
        continue;
    }
    file_put_contents($path, $new);
    echo "OK {$view}\n";
}
