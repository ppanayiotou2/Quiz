<?php  
    $page = 'Sign In';
    require_once('header.php');

    if(is_user_auth()) {
        header ('Location: index.php');
    }
?>

<div class="container-fluid pt-5">
    <div class="container">
        <div class="row">
            <div class="bg-image"></div>
            <div class="col-lg-7 mx-auto">
                <form id="login-form-ajax" class="card form login-form">

                    <h2 class="form-title">Login to your account</h2>

                    <span class="form-errors col-lg-9 mx-auto"></span>
                    <span class="form-success col-lg-9 mx-auto">
                        Account successfully created, you can now login
                    </span>

                    <div class="form-group mb-1 col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="user"></i>
                        <input id="login-username" required type="text" name="username" class="form-control" placeholder="Username" />
                    </div>

                    <div class="form-group col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="lock"></i>
                        <input id="login-password" required type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-group col-lg-9 mx-auto">
                        <label class="remember-me">
                            <input class="input-checkbox" name="remember-me-checkbox" type="checkbox">
                            Remember me
                        </label>
                    </div>

                    <div class="form-group col-lg-9 mx-auto">
                        <button class="mybtn col-lg-12 animated zoomIn" name="sign-in-submit">SIGN IN</button>
                    </div>

                    <span>Not a member? <a class="normal-link" href="sign-up.php">Register</a></span>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
