<!--<div class="container-fluid footer">
    <div class="container">
        <div class="row">

        </div>
    </div>
</div>-->

<!-- JAVASCRIPT -->
<script src="assets/js/core/jquery.3.2.1.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<script src="assets/js/custom/shared.js"></script>
<?php if($page == 'Quiz'){ ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/2.9.3/intro.js"></script>
<script src="assets/js/custom/cd360.js"></script>
<script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="assets/js/custom/quiz.js"></script>
<?php if (!$user->getHasSeenIntro()){ ?>
<script src="assets/js/custom/quiz-intro.js"></script>
<?php } ?>
<?php } ?>
<?php if($page == 'Sign In'){ ?>
<script src="assets/js/custom/sign-in.js"></script>
<?php } ?>
<?php if($page == 'Sign Up'){ ?>
<script src="assets/js/custom/sign-up.js"></script>
<?php } ?>
<?php if($page == 'Quiz Result'){ ?>
<script src="assets/js/plugin/chart.js/chart.min.js"></script>
<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>
<script src="assets/js/custom/quiz-result.js"></script>
<?php } ?>


</body>

</html>
