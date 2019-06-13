<?php

// If the user submitted the form(answer) continue
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  
    session_start();
    include_once('classes.php');
    include_once('user.php');

    $user = unserialize($_SESSION['user']);
    
    // The id, score of the user
    $user_id = $user->getId();
    $user_score = $user->getScore();
    
    // The answers given by the user
    $user_answer_one = strtolower($_POST['a']);
    $user_answer_two = strtolower($_POST['b']);
    $user_answer_three = strtolower($_POST['c']);
    $user_answer_four = strtolower($_POST['d']);
    
    // Variables to hold the corrects answers retrieved from the database
    $correct_answer_one;
    $correct_answer_two;
    $correct_answer_three;
    $correct_answer_four;
    $isCorrect = false;
    // DB connection
    $conn = get_connection();
    
    // Information about the currently answered question
    $q_id = $_POST['question_id'];
    $q_difficulty = $_POST['question_difficulty'];
    $q_level = $_POST['question_level'];
    
    $easyQuestionReward = 5;  // Points
    $hardQuestionReward = 10; // Points
    $wrongQuestionPenalty = 2;
    
    // Get all the answers for the given question
    $sql="SELECT answer_one,answer_two,answer_three,answer_four FROM questions WHERE id=".$q_id;
        
    $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
    while ($row = mysqli_fetch_array($result)){
        $correct_answer_one = $row["answer_one"];
        $correct_answer_two = $row["answer_two"];
        $correct_answer_three = $row["answer_three"];
        $correct_answer_four = $row["answer_four"]; 
    }
    
    // Only answer a is set
    if ($correct_answer_two == "not applicable"){
        if ($user_answer_one == $correct_answer_one){
            $isCorrect = true;
        }
    }
    // Only answers a and b are set
    elseif ($correct_answer_three == "not applicable"){
        if ($user_answer_one == $correct_answer_one &&
            $user_answer_two == $correct_answer_two){
            $isCorrect = true;
        }
    }
    // Only answers a, b and c are set 
    elseif ($correct_answer_four == "not applicable"){
        if ($user_answer_one == $correct_answer_one &&
            $user_answer_two == $correct_answer_two &&
            $user_answer_three == $correct_answer_three){
            $isCorrect = true;
        }
    }
    // All answers are set
    else{
        if ($user_answer_one == $correct_answer_one && 
            $user_answer_two== $correct_answer_two &&
            $user_answer_three == $correct_answer_three &&
            $user_answer_four == $correct_answer_four){
            $isCorrect = true;
        }
    }
        
    
    // Always update the answered questions table with the id
    // of the user and the currently answered question
    $query = "INSERT INTO answered_questions (question_id, user_id, correct) 
    VALUES ('$q_id','$user_id','$isCorrect')";
    
    if (!mysqli_query($conn, $query)){
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    
    if(isset($_POST['submit-answer'])){
    
    // If the user answered correctly proceed
    // The next question will be hard
    if ($isCorrect){
       // $user->setCurrentQuestion($q_id+1);
                
        // If the question was easy increase the user score by the easy question reward
        if ($q_difficulty == "easy"){
            $user_score += $easyQuestionReward;
        }
        // If the question was hard increase the user score by the hard question reward
        else{
            $user_score += $hardQuestionReward;
        }
        
        // Update the score of the user in the database
        $user->setScore($user_score);
        
        // Increase the current question at level counter
        $user->setCurrentQuestionAtLevel($user->getCurrentQuestionAtLevel()+1);
        
        // Increase the current question at level counter
        $user->setCurrentQuestionNum($user->getCurrentQuestionNum()+1);
                
        // Check if the current question at level counter > 2(max questions per level) go to the next level 
        // (means that the user completed the 2 questions of this level)
        if ($user->getCurrentQuestionAtLevel() > 2 ){
            
            $nextLevel;
            
             if ($q_level == "ps1"){
                $nextLevel = "ps3";
            }
            elseif($q_level == "ps3"){
                $nextLevel = "ps6";
            }
            elseif($q_level == "ps6"){
                $nextLevel = "ss2";
            }
            elseif($q_level == "ss2"){
                $nextLevel = "l2";
            }
            else{
                $nextLevel = "l3";
            }
            
            // Create a connection
            $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$nextLevel.'/hard/';
            $ch = curl_init($url);
        
            // Setting options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response, true);
            
            // Array to hold all the id's of the questions of a particular level and difficulty
            $ids = array();
            $idsToNotUse = array();
            $idsTotUse = array();
            
            
            // Copy all the ids to the ids array for easy access
            for ($i = 0; $i <= count($response); $i++) {    
             $ids[$i] = $response[$i][id];
            }
            
           //for ($x = 0; $x <= count($ids); $x++) { 
               //echo $ids[$x].' ';
           //}
           
            // Get all the id's of the answered questions(to not use again)
            $sql="SELECT question_id FROM answered_questions WHERE user_id=".$user_id;
            
            $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0){
                $y = 0;
                while ($row = mysqli_fetch_array($result)){  
                    $idsToNotUse[$y] = $row["question_id"];
                    $y++;
                }
            }
            
            //for ($z = 0; $z <= count($idsToNotUse); $z++) { 
               //echo $idsToNotUse[$z].' ';
            //}
            
            // Set the idsToUse array to the difference of all the ids and the one's the user currently answered
            // to avoid an answered question from coming again to the same user
            $idsTotUse = array_values(array_diff($ids, $idsToNotUse));
            $idsTotUse = array_filter($idsTotUse);
            
            //for ($z = 0; $z <= count($idsTotUse); $z++) { 
                //echo '<h1>'.$idsTotUse[$z].'</h1>';
            //}
            
            // Randomly select a question from the available question of this level and difficulty
            $randomQuestionId = $idsTotUse[array_rand($idsTotUse)];
            
            // Set the id of the next question to the randomly selected on
            $user->setCurrentQuestionId($randomQuestionId);
            //echo $nextQuestionId;
            
            
            
            $user->setCurrentQuestionAtLevel(1);
        }
        // The user has one more question of this level
        else{
            // Call the API to get all the questios(id) of the given level(difficulty is always hard in this condition)
            
            // Create a connection
            $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$q_level.'/hard/';
            $ch = curl_init($url);
        
            // Setting options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response, true);
            
            // Array to hold all the id's of the questions of a particular level and difficulty
            $ids = array();
            $idsToNotUse = array();
            $idsTotUse = array();
            
            
            // Copy all the ids to the ids array for easy access
            for ($i = 0; $i <= count($response); $i++) {    
             $ids[$i] = $response[$i][id];
            }
            
           //for ($x = 0; $x <= count($ids); $x++) { 
               //echo $ids[$x].' ';
           //}
           
            // Get all the id's of the answered questions(to not use again)
            $sql="SELECT question_id FROM answered_questions WHERE user_id=".$user_id;
            
            $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0){
                $y = 0;
                while ($row = mysqli_fetch_array($result)){  
                    $idsToNotUse[$y] = $row["question_id"];
                    $y++;
                }
            }
            
            //for ($z = 0; $z <= count($idsToNotUse); $z++) { 
               //echo $idsToNotUse[$z].' ';
            //}
            
            // Set the idsToUse array to the difference of all the ids and the one's the user currently answered
            // to avoid an answered question from coming again to the same user
            $idsTotUse = array_values(array_diff($ids, $idsToNotUse));
            $idsTotUse = array_filter($idsTotUse);
            
            //for ($z = 0; $z <= count($idsTotUse); $z++) { 
                //echo '<h1>'.$idsTotUse[$z].'</h1>';
            //}
            
            // Randomly select a question from the available question of this level and difficulty
            $randomQuestionId = $idsTotUse[array_rand($idsTotUse)];
            
            // Set the id of the next question to the randomly selected on
            $user->setCurrentQuestionId($randomQuestionId);
            //echo $nextQuestionId;
            
        }
        
          
    }
    // If wrong then points -penalty and next question is always easy
    else{ 
        // Decrease user score by the penalty value only if the current score is greater than 0 (to avoid negative scores)
        $user_score -= $wrongQuestionPenalty;
        if ($user_score < 0){
            $user_score = 0;
        }
         
        // Update the score of the user in the database
        $user->setScore($user_score);
        
        // Increase the current question at level counter
        $user->setCurrentQuestionAtLevel($user->getCurrentQuestionAtLevel()+1);
        
        // Increase the current question at level counter
        $user->setCurrentQuestionNum($user->getCurrentQuestionNum()+1);
        
        // Check if the current question at level counter > 2(max questions per level) go to the next level 
        // (means that the user completed the 2 questions of this level)
        if ($user->getCurrentQuestionAtLevel() > 2 ){
            $nextLevel;
            
            if ($q_level == "ps1"){
                $nextLevel = "ps3";
            }
            elseif($q_level == "ps3"){
                $nextLevel = "ps6";
            }
            elseif($q_level == "ps6"){
                $nextLevel = "ss2";
            }
            elseif($q_level == "ss2"){
                $nextLevel = "l2";
            }
            else{
                $nextLevel = "l3";
            }
           
            // Create a connection
            $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$nextLevel.'/easy/';
            $ch = curl_init($url);
        
            // Setting options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response, true);
            
            // Array to hold all the id's of the questions of a particular level and difficulty
            $ids = array();
            $idsToNotUse = array();
            $idsTotUse = array();
            
            
            // Copy all the ids to the ids array for easy access
            for ($i = 0; $i <= count($response); $i++) {    
             $ids[$i] = $response[$i][id];
            }
            
           //for ($x = 0; $x <= count($ids); $x++) { 
               //echo $ids[$x].' ';
           //}
           
            // Get all the id's of the answered questions(to not use again)
            $sql="SELECT question_id FROM answered_questions WHERE user_id=".$user_id;
            
            $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0){
                $y = 0;
                while ($row = mysqli_fetch_array($result)){  
                    $idsToNotUse[$y] = $row["question_id"];
                    $y++;
                }
            }
            
            //for ($z = 0; $z <= count($idsToNotUse); $z++) { 
               //echo $idsToNotUse[$z].' ';
            //}
            
            // Set the idsToUse array to the difference of all the ids and the one's the user currently answered
            // to avoid an answered question from coming again to the same user
            $idsTotUse = array_values(array_diff($ids, $idsToNotUse));
            $idsTotUse = array_filter($idsTotUse);
            
            //for ($z = 0; $z <= count($idsTotUse); $z++) { 
                //echo '<h1>'.$idsTotUse[$z].'</h1>';
            //}
            
            // Randomly select a question from the available question of this level and difficulty
            $randomQuestionId = $idsTotUse[array_rand($idsTotUse)];
            
            // Set the id of the next question to the randomly selected on
            $user->setCurrentQuestionId($randomQuestionId);
            //echo $nextQuestionId;
            
            
            
            $user->setCurrentQuestionAtLevel(1);
        }
        // The user has one more question of this level
        else{
            // Call the API to get all the questios(id) of the given level(difficulty is always hard in this condition)
            
            // Create a connection
            $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$q_level.'/easy/';
            $ch = curl_init($url);
        
            // Setting options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response, true);
            
            // Array to hold all the id's of the questions of a particular level and difficulty
            $ids = array();
            $idsToNotUse = array();
            $idsTotUse = array();
            
            
            // Copy all the ids to the ids array for easy access
            for ($i = 0; $i <= count($response); $i++) {    
             $ids[$i] = $response[$i][id];
            }
            
           //for ($x = 0; $x <= count($ids); $x++) { 
               //echo $ids[$x].' ';
           //}
           
            // Get all the id's of the answered questions(to not use again)
            $sql="SELECT question_id FROM answered_questions WHERE user_id=".$user_id;
            
            $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0){
                $y = 0;
                while ($row = mysqli_fetch_array($result)){  
                    $idsToNotUse[$y] = $row["question_id"];
                    $y++;
                }
            }
            
            //for ($z = 0; $z <= count($idsToNotUse); $z++) { 
               //echo $idsToNotUse[$z].' ';
            //}
            
            // Set the idsToUse array to the difference of all the ids and the one's the user currently answered
            // to avoid an answered question from coming again to the same user
            $idsTotUse = array_values(array_diff($ids, $idsToNotUse));
            $idsTotUse = array_filter($idsTotUse);
            
            //for ($z = 0; $z <= count($idsTotUse); $z++) { 
                //echo '<h1>'.$idsTotUse[$z].'</h1>';
            //}
            
            // Randomly select a question from the available question of this level and difficulty
            $randomQuestionId = $idsTotUse[array_rand($idsTotUse)];
            
            // Set the id of the next question to the randomly selected on
            $user->setCurrentQuestionId($randomQuestionId);
            //echo $nextQuestionId;    
        }
        
    }
    
        if ($user->getCurrentQuestionNum() <= 12){
            header('Location: ../quiz.php'); 
        }
        else{
            header('Location: ../quiz-over.php'); 
        }
    
    // Close of the submit if statement
}
     elseif(isset($_POST['skip-answer'])){
        // User score doesn't change when question is skipped
         
        // Increase the current question at level counter
        $user->setCurrentQuestionAtLevel($user->getCurrentQuestionAtLevel()+1);
        
        // Increase the current question at level counter
        $user->setCurrentQuestionNum($user->getCurrentQuestionNum()+1);
        
        // Check if the current question at level counter > 2(max questions per level) go to the next level 
        // (means that the user completed the 2 questions of this level)
        if ($user->getCurrentQuestionAtLevel() > 2 ){
            $nextLevel;
            
            if ($q_level == "ps1"){
                $nextLevel = "ps3";
            }
            elseif($q_level == "ps3"){
                $nextLevel = "ps6";
            }
            elseif($q_level == "ps6"){
                $nextLevel = "ss2";
            }
            elseif($q_level == "ss2"){
                $nextLevel = "l2";
            }
            else{
                $nextLevel = "l3";
            }
           
            // Create a connection
            $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$nextLevel.'/easy/';
            $ch = curl_init($url);
        
            // Setting options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response, true);
            
            // Array to hold all the id's of the questions of a particular level and difficulty
            $ids = array();
            $idsToNotUse = array();
            $idsTotUse = array();
            
            
            // Copy all the ids to the ids array for easy access
            for ($i = 0; $i <= count($response); $i++) {    
             $ids[$i] = $response[$i][id];
            }
            
           //for ($x = 0; $x <= count($ids); $x++) { 
               //echo $ids[$x].' ';
           //}
           
            // Get all the id's of the answered questions(to not use again)
            $sql="SELECT question_id FROM answered_questions WHERE user_id=".$user_id;
            
            $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0){
                $y = 0;
                while ($row = mysqli_fetch_array($result)){  
                    $idsToNotUse[$y] = $row["question_id"];
                    $y++;
                }
            }
            
            //for ($z = 0; $z <= count($idsToNotUse); $z++) { 
               //echo $idsToNotUse[$z].' ';
            //}
            
            // Set the idsToUse array to the difference of all the ids and the one's the user currently answered
            // to avoid an answered question from coming again to the same user
            $idsTotUse = array_values(array_diff($ids, $idsToNotUse));
            $idsTotUse = array_filter($idsTotUse);
            
            //for ($z = 0; $z <= count($idsTotUse); $z++) { 
                //echo '<h1>'.$idsTotUse[$z].'</h1>';
            //}
            
            // Randomly select a question from the available question of this level and difficulty
            $randomQuestionId = $idsTotUse[array_rand($idsTotUse)];
            
            // Set the id of the next question to the randomly selected on
            $user->setCurrentQuestionId($randomQuestionId);
            //echo $nextQuestionId;
            
            
            
            $user->setCurrentQuestionAtLevel(1);
        }
        // The user has one more question of this level
        else{
            // Call the API to get all the questios(id) of the given level(difficulty is always hard in this condition)
            
            // Create a connection
            $url = 'https://ppanayiotou2.com/quizapi/public/api/questions/'.$q_level.'/easy/';
            $ch = curl_init($url);
        
            // Setting options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            
            $response = json_decode($response, true);
            
            // Array to hold all the id's of the questions of a particular level and difficulty
            $ids = array();
            $idsToNotUse = array();
            $idsTotUse = array();
            
            
            // Copy all the ids to the ids array for easy access
            for ($i = 0; $i <= count($response); $i++) {    
             $ids[$i] = $response[$i][id];
            }
            
           //for ($x = 0; $x <= count($ids); $x++) { 
               //echo $ids[$x].' ';
           //}
           
            // Get all the id's of the answered questions(to not use again)
            $sql="SELECT question_id FROM answered_questions WHERE user_id=".$user_id;
            
            $result = mysqli_query($conn, $sql) or die (mysqli_error($conn));
        
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0){
                $y = 0;
                while ($row = mysqli_fetch_array($result)){  
                    $idsToNotUse[$y] = $row["question_id"];
                    $y++;
                }
            }
            
            //for ($z = 0; $z <= count($idsToNotUse); $z++) { 
               //echo $idsToNotUse[$z].' ';
            //}
            
            // Set the idsToUse array to the difference of all the ids and the one's the user currently answered
            // to avoid an answered question from coming again to the same user
            $idsTotUse = array_values(array_diff($ids, $idsToNotUse));
            $idsTotUse = array_filter($idsTotUse);
            
            //for ($z = 0; $z <= count($idsTotUse); $z++) { 
                //echo '<h1>'.$idsTotUse[$z].'</h1>';
            //}
            
            // Randomly select a question from the available question of this level and difficulty
            $randomQuestionId = $idsTotUse[array_rand($idsTotUse)];
            
            // Set the id of the next question to the randomly selected on
            $user->setCurrentQuestionId($randomQuestionId);
            //echo $nextQuestionId;    
        }
         if ($user->getCurrentQuestionNum() <= 12){
            header('Location: ../quiz.php'); 
        }
        else{
            header('Location: ../quiz-over.php'); 
        }  
     }
}
else{
    echo 'Nothing to see...';
}
