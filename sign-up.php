<?php  
    $page = 'Sign Up';
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
                <form id="register-form-ajax" class="card form login-form">
                    <h2 class="form-title">Create an account</h2>

                    <span class="form-errors col-lg-9 mx-auto"></span>

                    <div class="form-group mb-1 col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="user"></i>
                        <input id="register-username" minlength="2" maxlength="15" required type="text" name="username" class="form-control" placeholder="Username" />
                    </div>

                    <div class="form-group mb-1 col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="mail"></i>
                        <input id="register-email" required type="email" name="email" class="form-control" placeholder="Email Address" />
                    </div>

                    <div class="form-group mb-1 col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="info"></i>
                        <input id="register-first-name" minlength="2" maxlength="30" required type="text" name="firstName" class="form-control" placeholder="First Name" />
                    </div>

                    <div class="form-group mb-1 col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="info"></i>
                        <input id="register-last-name" required type="text" minlength="2" maxlength="30" name="lastName" class="form-control" placeholder="Last Name" />
                    </div>

                    <div class="form-group mb-1 col-lg-9 mx-auto">
                        <span style="float: left;"><b>Gender:</b></span>
                        <select name="gender" class="col-lg-12 pt-2 pb-2" id="gender">
                            <option value="f">Female</option>
                            <option value="m">Male</option>
                            <option value="o">Other</option>
                        </select>
                    </div>

                    <div class="form-group mb-2 col-lg-9 mx-auto">
                        <i class="form-icons" data-feather="lock"></i>
                        <input minlength="2" maxlength="20" id="register-password" required type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-group col-lg-9 mx-auto">
                        <button class="mybtn col-lg-12 animated zoomIn" name="sign-up-submit">SIGN UP</button>
                    </div>

                    <span>Already a member? <a class="normal-link" href="sign-in.php">Login</a></span>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
