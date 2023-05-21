<script>
function delete_task($Id) {
    start_load()
    $.ajax({
        url: '../controllers/ajax.php?action=delete_task',
        method: 'POST',
        data: {
            Id: $Id
        },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully deleted", 'success')
                setTimeout(function() {
                    location.reload()
                }, 1500)

            }
        }
    })
}
</script>