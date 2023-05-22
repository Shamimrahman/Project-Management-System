<script>
//Create Project
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
                    location.href = 'index.php?page=projects_list'
                }, 2000)
            }
        }
    })
})

//delete Project
$(document).ready(function() {
    $('#list').dataTable()

    $('.delete_project').click(function() {
        _conf("Are you sure to delete this project?", "delete_project", [$(this).attr('data-id')])
    })
})

function delete_project($Id) {
    start_load()
    $.ajax({
        url: '../controllers/ajax.php?action=delete_project',
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