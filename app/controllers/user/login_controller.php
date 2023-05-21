<?php
ob_start();
date_default_timezone_set("Asia/Manila");
?>
<script>
$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        start_load();

        if ($(this).find('.alert-danger').length > 0) {
            $(this).find('.alert-danger').remove();
        }

        $.ajax({
            url: '../controllers/ajax.php?action=login',
            method: 'POST',
            data: $(this).serialize(),
            error: function(xhr, status, error) {
                console.log(error);
                end_load();
            },
            success: function(resp) {
                if (resp === '1') {
                    location.href = 'index.php?page=home';
                } else {
                    $('#login-form').prepend(
                        '<div class="alert alert-danger">Username or password is incorrect.</div>'
                    );
                    end_load();
                }
            }
        });
    });
});
</script>