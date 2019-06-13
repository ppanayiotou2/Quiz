<?php
    $page = 'Quiz Options';
    require_once('header.php');
    
    if(!is_user_auth()) {
        header ('Location: index.php');
    }

    if (!$user->getHasSeenIntro()){
        $user->setHasSeenIntro(true);
    }
?>

<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="inc/user_pref.php" class="card form">
                    <div class="card-body">
                        <h1 class="col-lg-12 opt-ti"> <i style="margin-right:15px; opacity:.7;" data-feather="sliders"></i>
                            Personalize <b>your</b> Quiz</h1>
                        <div class="form-group col-lg-12 mt-5">
                            <label class="wrapped-label">
                                <h4>
                                    <i style="margin-right:15px; opacity:.7;" data-feather="clock"></i>
                                    Display question timer during test(timer will be activated even if it's hidden)
                                    <input style="margin-left:15px;" class="input-checkbox" name="timer" value="1" checked type="checkbox">
                                </h4>
                            </label>
                        </div>
                        <div class="form-group col-lg-12 mt-3">
                            <label class="wrapped-label">
                                <h4>
                                    <i style="margin-right:15px; opacity:.7;" data-feather="edit-3"></i>
                                    Display question number(e.g. Question <b>1</b> of <b>12</b>)
                                    <input style="margin-left:15px;" class="input-checkbox" name="qnum" value="1" checked type="checkbox"></h4>
                            </label>
                        </div>
                        <div class="form-group col-lg-12 mt-3">
                            <label class="wrapped-label">
                                <h4>
                                    <i style="margin-right:15px; opacity:.7;" data-feather="eye"></i>
                                    Display Quiz navigation with options(if removed, you won't be able to use the speech to answer services).
                                    <input style="margin-left:15px;" class="input-checkbox" checked name="nav" value="1" type="checkbox"></h4>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4  mt-4 mb-5 ml-4">
                        <input class="mybtn" type="submit" name="pref-submit" value="START THE QUIZ"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>

