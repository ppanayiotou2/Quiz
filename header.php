<?php 
    session_start();
    //require_once("inc/dblogin.php");
    require_once('inc/user.php');
    require_once('inc/watcher.php');

    $user = unserialize($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'Quiz | '.$page; ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/css/dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <?php if($page == 'Quiz'){ ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/introjs.css">

    <script type="text/x-mathjax-config">
        MathJax.Hub.Config({
        "fast-preview": {disabled:true},
        CommonHTML: {
    scale: 130
  },
        tex2jax: {
            preview: ["[...]"],
            inlineMath: [["$","$"],["\\(","\\)"]]
        }
    });
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <link rel="stylesheet" href="assets/css/fonts.min.css">
    <?php } ?>
</head>

<body>

    <div class="top-nav">
        <ul class="container">
            <li><img id="logo" src="assets/img/logo.png" alt=""></li>
            <li><a <?php if($page == 'Home'){ echo ' class="active"';}?> href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact Us</a></li>
            <?php  if(!is_user_auth()) { ?>
            <ul class="right">
                <li><a <?php if($page == 'Sign In'){ echo 'class="active"';}?> href="sign-in.php">Sign In</a></li>
                <span>/</span>
                <li><a <?php if($page == 'Sign Up'){ echo 'class="active"';}?> href="sign-up.php">Sign Up</a></li>
            </ul>
            <?php } else { ?>
            <?php if($page != 'Quiz Result') { ?>
            <ul class="right">
                <li><a id="quiz-btn" href="quiz.php">Quiz</a></li>
            </ul>
            <?php } ?>
            <li class="user-profile d-flex center">
                <span class="user-name"><?php echo $user->getUsername(); ?><i id="arrow" data-feather="chevron-down"></i></span>
                <ul id="user-profile-dropdown" class="dropdown">
                    <li><a href="log-out.php">Logout</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>



    <div class="mobile-nav">
        <div class="d-flex justify-between">
            <img id="logo" src="assets/img/logo.png" alt="">
            <div class="mobile-menu-container">
                <span class="mobile-menu-icon"></span>
            </div>
        </div>
        <ul>
            <li><a <?php if($page == 'Home'){ echo ' class="active"';}?> href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact Us</a></li>
            <?php  if(!is_user_auth()) { ?>
            <li><a <?php if($page == 'Sign In'){ echo 'class="active"';}?> href="sign-in.php">Sign In</a></li>
            <li><a <?php if($page == 'Sign Up'){ echo 'class="active"';}?> href="sign-up.php">Sign Up</a></li>
            <?php } else { ?>
            <li><a href="log-out.php">Logout</a></li>
            <li><a id="quiz-btn" href="quiz.php">Quiz</a></li>
            <?php } ?>
        </ul>
    </div>

    <div class="quiz-menu">
        <div class="container">
            <ul class="center">
                <li id="font-btns">
                    <button id="dec-font" type="button" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Decrease text size" data-trigger="hover">
                        <i data-feather="minus"></i>
                    </button>
                    <button id="inc-font" type="button" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Increase text size" data-trigger="hover">
                        <i data-feather="plus"></i>
                    </button>
                </li>
                <div id="help">
                    <button type="button" class="btn btn-primary" data-html="true" data-container="body" data-toggle="popover" data-placement="top" data-content="<b>Remember to allow Quiz to access you microphone!</b><br>Voice input available commands:<br>
                - <b>Submit:</b> Submit your current answer.<br>
                - <b>Skip:</b> Skip the current question.<br>
                *<i>You can click on any input and talk.</i>
                " data-trigger="hover">
                    </button>
                </div>
                <div id="microphone">
                    <i class="mic-icon" data-feather="mic"></i>
                </div>

            </ul>
        </div>
    </div>
