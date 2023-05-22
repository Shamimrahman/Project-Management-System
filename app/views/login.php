<!DOCTYPE html>
<html lang="en">
<?php 
if(!isset($_SESSION['login_Id']))
include '../../config/db_connect.php';
include '../partials/header.php';
?>
<?php 
if(isset($_SESSION['login_Id']))
header("location:index.php?page=home");

?>
<?php include '../partials/header.php' ?>

<body class="hold-transition login-page bg-black">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" class="text-white"><b> Project Manager</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <form action="" id="login-form">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="Email" required placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="Password" required placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <?php include '../controllers/UserController.php';
          include '../partials/footer.php';
            
        ?>

</body>

</html>