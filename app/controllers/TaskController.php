<script>
//create task
$('#manage-task').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: '../controllers/ajax.php?action=save_task',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            if (resp == 1) {
                alert_toast('Data successfully saved', "success");
                setTimeout(function() {
                    location.reload()
                }, 1500)
            }
        }
    })
})

//delete task
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