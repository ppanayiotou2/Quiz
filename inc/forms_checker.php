<?php

session_start();
require_once('classes.php');
require_once('dblogin.php');


if (isset($_POST['submit-new-question'])){
    $q_name = $_POST['q-name'];
    $q_body = $_POST['q-body'];
    $q_answer_one = $_POST['q-answer-one'];
    $q_answer_two = $_POST['q-answer-two'];
    $q_answer_three = $_POST['q-answer-three'];
    $q_answer_four = $_POST['q-answer-four'];
    $q_difficulty = $_POST['q-difficulty'];
    $q_level = $_POST['q-level'];
    $q_category = $_POST['q-category'];
   
    $question = new Question($q_name, $q_body, $q_answer_one, $q_answer_two, $q_answer_three, $q_answer_four, $q_difficulty, $q_level, $q_category);
    
    $conn = get_connection();
    
    $query = mysqli_query($conn, "SELECT id FROM questions WHERE name='$q_name'");
    $row = mysqli_fetch_array($query);
    //$q_id = $row['id'];
    
    /*$q_tags = $_POST['tags'];
	if ($q_tags){
        
        foreach ($q_tags as $tag){
          $query = "INSERT INTO questions_tags (question_id, tag) VALUES ('$q_id','$tag')";
            if (!mysqli_query($conn, $query)){
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
	}*/
    
    header('Location: ../dashboard/view-questions.php'); 

}
