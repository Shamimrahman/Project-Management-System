<script>
//Password matching
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

//delete user
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

//Login 
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