<script>
var CSRF_TOKEN_NAME = <?php echo json_encode($this->security->get_csrf_token_name()); ?>;
var CSRF_TOKEN_HASH = <?php echo json_encode($this->security->get_csrf_hash()); ?>;

function updateCsrfToken(name, hash) {
    if (!name || !hash) {
        return;
    }
    CSRF_TOKEN_NAME = name;
    CSRF_TOKEN_HASH = hash;
    $('input[name="' + name + '"]').val(hash);
}
</script>
