<?php

if (isset($_POST['q-id-edit'])){
    
    require_once('dblogin.php');

    $q_id=$_POST['q-id-edit'];
    $q_name=$_POST['q-name-edit'];
    $q_body=$_POST['q_body_edit'];
    $q_answer_one=$_POST['q-answer-one-edit'];
    $q_answer_two=$_POST['q-answer-two-edit'];
    $q_answer_three=$_POST['q-answer-three-edit'];
    $q_answer_four=$_POST['q-answer-four-edit'];
    $q_difficulty=$_POST['q-difficulty-edit'];
    $q_level=$_POST['q-level-edit'];
    $q_category=$_POST['q-category-edit'];

    $data = array(
        'qName' => $q_name,
        'qBody' => $q_body,
        'qAnswerOne' => $q_answer_one,
        'qAnswerTwo' => $q_answer_two,
        'qAnswerThree' => $q_answer_three,
        'qAnswerFour' => $q_answer_four,
        'qDifficulty' => $q_difficulty,
        'qLevel' => $q_level,
        'qCategory' => $q_category
        );
        
        # Create a connection
        $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$q_id.'';
        $ch = curl_init($url);
        # Form data string
        $postString = http_build_query($data, '', '&');
        # Setting options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        # Get the response
        $response = curl_exec($ch);
        curl_close($ch);
    
        $conn = get_connection();
        
        $tags = $_POST['tags'];
        
        mysqli_query($conn, "DELETE FROM questions_tags WHERE question_id='$q_id'");
    
        foreach ($tags as $tag) {
            mysqli_query($conn,"INSERT INTO questions_tags (question_id, tag)
            VALUES ('$q_id','$tag')") 
            or die(mysqli_error($conn));
        }
        
        mysqli_close($conn);
    
        header("Location: ../dashboard/view-questions.php");
        exit;
        
}
