<?php

if (isset($_POST['jsonData'])) {
    session_start();
    require_once('classes.php');
    require_once('user.php');
    require_once('dblogin.php');
    
    $data = $_POST['jsonData'];
    
    $id = $data['id'];
    $role = $data['role'];
    $score = $data['score'];
    $username = $data['username'];
    $has_seen_intro = $data['has_seen_intro'];
    $current_question = $data['current_question_id'];
    $current_question_num = $data['current_question_num'];
    $current_question_at_level = $data['current_question_at_level'];
    $gender = $data['gender'];
    $show_timer = $data['show_timer'];
    $show_question_num = $data['show_question_num'];
    $show_quiz_nav = $data['show_quiz_nav'];
    
    $user = new User($id, $role, $score, $username, $has_seen_intro, $current_question, $current_question_num, $current_question_at_level, $gender, $show_timer, $show_question_num, $show_quiz_nav);
    
    $_SESSION['user'] = serialize($user);
}
