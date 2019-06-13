<?php
   
    $page = 'Quiz';
    require_once('header.php');

    if(!is_user_auth()) {
        header ('Location: index.php');
    }
    $currentQuestionId = $user->getCurrentQuestion();
    $user_current_question_num = $user->getCurrentQuestionNum();

    $showQNumb =  $user->getWantsQuestionNum();
    $showTime =  $user->getWantsTimer();
?>

<div class="container-fluid mt-5">
    <div class="container large">
        <div class="row">
            <div class="col-md-12 card quiz-card">
                <div class="card-body">
                    <div id="countdown" <?php if (!$showTime){ ?> class="op-0" <?php } ?>></div>

                    <input name="q_id" id="q_id" type="hidden" value="<?php echo $currentQuestionId; ?>">
                    <input name="q_user_num" id="q_user_num" type="hidden" value="<?php echo $user_current_question_num; ?>">
                    <input name="level" id="level" type="hidden">
                    <input name="difficulty" id="difficulty" type="hidden">
                    <span class="question-name mb-5 col-md-9">Question <?php if ($showQNumb){ ?><span id="question-numbering"><?php echo $user_current_question_num; ?> of 12</span> <?php } ?>: </span>
                    <div class="question-body"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>
