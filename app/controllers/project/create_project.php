<script>
$('#manage-project').submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: '../controllers/ajax.php?action=save_project',
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
                    location.href = 'index.php?page=project_list'
                }, 2000)
            }
        }
    })
})
</script>