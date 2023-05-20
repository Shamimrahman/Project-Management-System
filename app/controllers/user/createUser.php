<?php
ob_start();
date_default_timezone_set("Asia/Manila");
?>

<script>
$(document).ready(function() {
    $('#manage_user').submit(function(e) {
        e.preventDefault();
        $('input').removeClass("border-danger");
        start_load();
        $('#msg').html('');
        if ($('[name="Password"]').val() != '' && $('[name="cpass"]').val() != '') {
            if ($('#pass_match').attr('data-status') != 1) {
                if ($("[name='Password']").val() != '') {
                    $('[name="Password"],[name="cpass"]').addClass("border-danger");
                    end_load();
                    return false;
                }
            }
        }
        $.ajax({
            url: '../controllers/ajax.php?action=save_user',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast('Data successfully saved.', "success");
                    setTimeout(function() {
                        location.replace('index.php?page=users_list');
                    }, 70);
                } else if (resp == 2) {
                    $('#msg').html(
                        "<div class='alert alert-danger'>Email already exists.</div>");
                    $('[name="Email"]').addClass("border-danger");
                    end_load();
                }
            }
        });
    });
});
</script>