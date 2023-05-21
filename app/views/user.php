<?php
 include '../controllers/user/create_user.php';
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_user">
                <input type="hidden" name="Id" value="<?php echo isset($Id) ? $Id : '' ?>">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group">
                            <label for="" class="control-label">Name</label>
                            <input type="text" name="Name" class="form-control form-control-sm" required
                                value="<?php echo isset($Name) ? $Name : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label">User Role</label>
                            <select name="type" id="type" class="custom-select custom-select-sm">
                                <option value="2" <?php echo isset($type) && $type == 2 ? 'selected' : '' ?>>Developer
                                </option>
                                <option value="1" <?php echo isset($type) && $type == 1 ? 'selected' : '' ?>>Project
                                    Manager
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="" class="control-label">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="img"
                                    onchange="displayImg(this,$(this))">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-center align-items-center">
                            <img src="<?php echo isset($Avatar) ? 'assets/uploads/'.$Avatar :'' ?>" alt="Avatar"
                                id="cimg" class="img-fluid img-thumbnail ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="Email" required
                                value="<?php echo isset($Email) ? $Email : '' ?>">
                            <small id="#msg"></small>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Address</label>
                            <input type="text" name="Address" class="form-control form-control-sm" required
                                value="<?php echo isset($Address) ? $Address : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Status</label>
                            <input type="text" name="Status" class="form-control form-control-sm" required
                                value="<?php echo isset($Status) ? $Status : '' ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control form-control-sm" name="Password"
                                <?php echo !isset($Id) ? "required":'' ?>>
                            <small><i><?php echo isset($Id) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
                        </div>
                        <div class="form-group">
                            <label class="label control-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" name="cpass"
                                <?php echo !isset($Id) ? 'required' : '' ?>>
                            <small id="pass_match" data-status=''></small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-lg-12 text-right justify-content-center d-flex">
                    <button class="btn btn-primary mr-2">Save</button>
                    <button class="btn btn-secondary" type="button"
                        onclick="location.href = 'index.php?page=user_list'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
img#cimg {
    height: 15vh;
    width: 15vh;
    object-fit: cover;
    border-radius: 100% 100%;
}
</style>

<script>
//Password Matching
$('[name="Password"],[name="cpass"]').keyup(function() {
    var pass = $('[name="Password"]').val()
    var cpass = $('[name="cpass"]').val()
    if (cpass == '' || pass == '') {
        $('#pass_match').attr('data-status', '')
    } else {
        if (cpass == pass) {
            $('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>')
        } else {
            $('#pass_match').attr('data-status', '2').html(
                '<i class="text-danger">Password does not match.</i>')
        }
    }
})

function displayImg(input, _this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#cimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>