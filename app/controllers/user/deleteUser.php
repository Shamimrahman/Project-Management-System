<?php
ob_start();
date_default_timezone_set("Asia/Manila");
?>
<script>
$(document).ready(function() {
    $('#list').dataTable()
    $('.view_user').click(function() {
        uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id=" + $(this).attr(
            'data-id'))
    })
    $('.delete_user').click(function() {
        _conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
    })
})

function delete_user($Id) {
    start_load()
    $.ajax({
        url: '../controllers/ajax.php?action=delete_user',
        method: 'POST',
        data: {
            Id: $Id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully deleted", 'success')
                setTimeout(function() {
                    location.reload()
                }, 15)

            }
        }
    })
}
</script>