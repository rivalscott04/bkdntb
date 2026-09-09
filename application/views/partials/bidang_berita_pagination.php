<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($pagination)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="blog-post">
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
