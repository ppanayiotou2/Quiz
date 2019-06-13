<?php 
if(isset($_POST['pref-submit'])){
    session_start();
    include_once('user.php');
    require_once('dblogin.php');

    $wants_timer = ($_POST['timer']);
    $wants_qnum = ($_POST['qnum']);
    $wants_nav = ($_POST['nav']);
    
    if ($wants_timer != 1){
        $wants_timer = 0;
    }
    if ($wants_qnum != 1){
        $wants_qnum = 0;
    }
    if ($wants_nav != 1){
        $wants_nav = 0;
    }

    $user = unserialize($_SESSION['user']);
    
    
    $user->setWantsTimer($wants_timer);
    $user->setWantsQuestionNum($wants_qnum);
    $user->setWantsQuizNav($wants_nav);
    
     header('Location: ../quiz.php'); 
}
else{
    echo 'Nothing to see...';
}
?>
