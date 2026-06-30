<?php if (!empty($use_editor)): ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-id-ID.min.js"></script>
<script>
var SUMMERNOTE_UPLOAD_URL = <?php echo json_encode(site_url('admin/berita/upload_gambar')); ?>;
var BERITA_ASSET_BASE = <?php echo json_encode(rtrim(base_url(), '/')); ?>;

function beritaAssetUrl(path) {
    if (!path) {
        return '';
    }
    if (/^https?:\/\//i.test(path) || path.charAt(0) === '/') {
        return path;
    }
    return BERITA_ASSET_BASE + '/' + path.replace(/^\//, '');
}

function uploadSummernoteImage(file, editor) {
    var data = new FormData();
    data.append('file', file);
    data.append(CSRF_TOKEN_NAME, CSRF_TOKEN_HASH);
    $.ajax({
        url: SUMMERNOTE_UPLOAD_URL,
        method: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(res) {
            if (res && res.csrf_name && res.csrf_token) {
                updateCsrfToken(res.csrf_name, res.csrf_token);
            }
            var src = res && res.path ? beritaAssetUrl(res.path) : (res && res.url ? res.url : '');
            if (src) {
                editor.summernote('insertImage', src);
            }
        },
        error: function(xhr) {
            var msg = 'Upload gambar gagal.';
            try {
                var res = JSON.parse(xhr.responseText);
                if (res.error) {
                    msg = res.error;
                }
            } catch (e) {}
            alert(msg);
        }
    });
}

$(function() {
    $('.summernote').summernote({
        height: 350,
        lang: 'id-ID',
        placeholder: 'Tulis narasi berita di sini...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'table', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        styleTags: ['p', 'blockquote', 'h3', 'h4'],
        callbacks: {
            onImageUpload: function(files) {
                var editor = $(this);
                for (var i = 0; i < files.length; i++) {
                    uploadSummernoteImage(files[i], editor);
                }
            }
        }
    });

    $('form').on('submit', function(e) {
        var $form = $(this);
        var $editor = $form.find('.summernote');
        if ($editor.length) {
            var content = $editor.summernote('code');
            $editor.val(content);
            var plain = $('<div>').html(content).text().replace(/\u00a0/g, ' ').trim();
            if (!plain) {
                e.preventDefault();
                alert('Narasi / isi berita wajib diisi.');
                return false;
            }
        }
        $form.find('button[type="submit"]').prop('disabled', true);
    });
});
</script>
<?php endif; ?>
