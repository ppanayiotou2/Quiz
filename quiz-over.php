<?php
   
    $page = 'Quiz Result';
    require_once('header.php');
    require_once('inc/dblogin.php');

    if(!is_user_auth()) {
        header ('Location: index.php');
    }

    $user_id = $user->getId();
    
    $sqla = "SELECT question_id
    FROM answered_questions
    WHERE correct =0 AND user_id='$user_id'
    ORDER BY question_id ASC";

    $sql = "SELECT question_id
    FROM answered_questions
    WHERE correct =1 AND user_id='$user_id'";

    $conn = get_connection();

    $allQuestions = $conn->query($sqla);
    $correctQuestions = $conn->query($sql);
    
    $correctQuestionsCounter = mysqli_num_rows($correctQuestions);
    

    $arithmCounter = 0;
    $funcCounter = 0;
    $logicCounter = 0;
    $setCounter = 0;
    $numbCounter = 0;
    $networksCounter = 0;
    $incorrectQuestions = 12 - $correctQuestionsCounter;
    $highest_number;
    $score = $user->getScore();
    $maxScore = 115;
    $msgToUser;
    $scorePercentage = $score/$maxScore * 100;   
    
    if ($scorePercentage < 40){
        $msgToUser = "Nice try. Following the British undergraduate degree classification, you have achieved a
        lowest class honours(lower than 40%), sometimes known as 'pass'. You will do better next time!";
    }
    elseif($scorePercentage >= 40 && $scorePercentage < 50 ){
        $msgToUser = "Good job! Following the British undergraduate degree classification, you have achieved a
        Third-class honours(40 - 49%). Keep studying!";
    } elseif($scorePercentage >= 50 && $scorePercentage < 60 ){
        $msgToUser = "Great job! Following the British undergraduate degree classification, you have achieved a
        Second-class honours, lower division(50 - 59%). Congratulations and keep studying!";
    }
    elseif($scorePercentage >= 60 && $scorePercentage < 70 ){
        $msgToUser = "Excellent job! Following the British undergraduate degree classification, you have achieved a
        Second-class honours, upper division(60 - 69%). Congratulations and keep studying!";
    }
    else{
        $msgToUser = "Outstanding job! Following the British undergraduate degree classification, you have achieved a
        First-class honours(70% or higher). Congratulations! Keep studying!";
    }

?>

<div class="container-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 card">
                <div class="card-body p-5">
                    <h1 class="pb-2">Score:<span style="font-size:2em; margin-left: 15px; color:orange;" ><?php echo sprintf('%.2f', $scorePercentage); ?>% !</span></h1>
                    <h2 class="pb-1">You have answered correctly <b><?php echo $correctQuestionsCounter; ?></b> out of 12 questions! </h2>
                    <div class="row">
                    <div class="col-lg-8 mb-3">
                    <h4 style="line-height:150%;" class="mt-4 text-justify"><?php echo $msgToUser; ?></h4></div></div>
                    <hr>
                    <h2 class="mb-4">Below you can find some more information about your Quiz result.</h2>
                    <h5>*A question might have more than one mathematical categories.</h5>
                    
                    
                    <?php while($row = $allQuestions->fetch_assoc()) {
                        $q_id = $row['question_id'];
                        $q_name = $row['name'];
                        
                        $sqlo = "SELECT  tag from questions_tags
                        WHERE question_id='$q_id'";
    
                        $res = $conn->query($sqlo);

                        while($row = $res->fetch_assoc()) {
                            $tag = $row['tag'];
                            
                            if ($tag == "Set Theory"){
                                $setCounter++;
                            }
                            elseif ($tag =="Arithmetic"){
                                $arithmCounter++;
                            }
                            elseif ($tag =="Logic/Algorithms"){
                                $logicCounter++;
                            }
                            elseif ($tag =="Networks/Graphs"){
                                $networksCounter++;
                            }
                            elseif ($tag =="Numbers"){
                                $numbCounter++;
                            }
                            else{
                                $funcCounter++;
                            }
                        }
                    
                    } 
                    ?>
                    
                    <h2>Your <?php echo $incorrectQuestions; ?> incorrect questions are categorized as: </h2>
                    <h3>- Set Theory: <?php echo $setCounter; ?></h3>
                    <h3>- Arithmetic: <?php echo $arithmCounter; ?></h3>
                    <h3>- Logic/Algorithms: <?php echo $logicCounter; ?></h3>
                    <h3>- Networks/Graphs: <?php echo $networksCounter; ?></h3>
                    <h3>- Numbers: <?php echo $numbCounter; ?></h3>
                    <h3>- Functions: <?php echo $funcCounter; ?></h3>
                    
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Incorrect Questions Categories</div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="pieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Incorrect Questions Categories Distribution</div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="barChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="col-lg-6">
                        <h4 class="text-justify">Discrete Mathematics is a branch of mathematics involving discrete elements that uses algebra and arithmetic. It is increasingly being applied in the practical fields of mathematics and computer science. It is a very good tool for improving reasoning and problem-solving capabilities. </h4>
                        <h4>You can find more about Discrete Mathematics in these online sources: </h4>
                        <a target="_blank" href="https://www.wisdomjobs.com/e-university/discrete-mathematics-tutorial-471.html">Source 1</a><br>
                        <a target="_blank" href="http://www.cs.yale.edu/homes/aspnes/classes/202/notes.pdf">Source 2</a><br>
                        <a target="_blank" href="https://math.tutorvista.com/discrete-math.html">Source 3</a>
                    </div>
                    
                    <input id="sets-counter" type="hidden" value="<?php echo $setCounter; ?>">
                    <input id="arithm-counter" type="hidden" value="<?php echo $arithmCounter; ?>">
                    <input id="logic-counter" type="hidden" value="<?php echo $logicCounter; ?>">
                    <input id="net-counter" type="hidden" value="<?php echo $networksCounter; ?>">
                    <input id="num-counter" type="hidden" value="<?php echo $numbCounter; ?>">
                    <input id="func-counter" type="hidden" value="<?php echo $funcCounter; ?>">
                    <input id="wrong-questions-counter" type="hidden" value="<?php echo $incorrectQuestions; ?>">

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
