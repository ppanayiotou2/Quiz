<?php  
    $page = 'Create Question';
    require_once('header.php');
?>

<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Quiz</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="index.php">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Quiz</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="view-questions.php"><b>Create Question</b></a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ml-4">Creata a Question</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="add-question-form" class="col-md-12" method="post" action="../inc/forms_checker.php">
                                        <div class="form-group">
                                            <label for="q-name">Question Name:</label>
                                            <input required type="text" name="q-name" class="form-control" id="q-name" placeholder="Enter question name...">
                                        </div>
                                        <div class="form-group mt-3">
                                            <textarea required class="col-md-12 form-control" name="q-body" id="q-body" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <h2 class="pt-3 pb-1">Answers (leave empty if not applicable):</h2>
                                        </div>
                                        <div class="form-group">
                                            <label for="q-answer"> Answer (a):</label>
                                            <input required type="text" name="q-answer-one" class="form-control" placeholder="The answer of question (a)">
                                        </div>
                                        <div class="form-group">
                                            <label for="q-answer">Answer (b):</label>
                                            <input type="text" name="q-answer-two" class="form-control" placeholder="The answer of question (b)">
                                        </div>
                                        <div class="form-group">
                                            <label for="q-answer">Answer (c):</label>
                                            <input type="text" name="q-answer-three" class="form-control" placeholder="The answer of question (c)">
                                        </div>
                                        <div class="form-group">
                                            <label for="q-answer">Answer (d):</label>
                                            <input type="text" name="q-answer-four" class="form-control" placeholder="The answer of question (d)">
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="q-difficulty">Question Difficulty:</label>
                                            <select name="q-difficulty" class="form-control" id="q-difficulty">
                                                <option value="easy">Easy</option>
                                                <option value="hard">Hard</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="q-level">Question Level:</label>
                                            <select name="q-level" class="form-control" id="q-level" required>
                                                <option value="ps1">1st Class of Primary School</option>
                                                <option value="ps3">3rd Class of Primary School</option>
                                                <option value="ps6">6th Class of Primary School</option>
                                                <option value="ss2">2nd Class of Secondary School</option>
                                                <option value="l2">2nd Class of Lyceum</option>
                                                <option value="l3">3rd Class of Lyceum</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="q-category">Question Category:</label>
                                            <select name="q-category" class="form-control" id="q-category">
                                                <option value="arithmetic">Arithmetic</option>
                                            </select>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="q-tags">Question Tag(s):</label>
                                            <select name="tags[]" id="q-tags" class="form-control" multiple="multiple">
                                                <option value="Arithmetic">Arithmetic</option>
                                                <option value="Functions">Functions</option>
                                                <option value="Logic/Algorithms">Logic/Algorithms</option>
                                                <option value="Networks/Graphs">Networks/Graphs</option>
                                                <option value="Numbers">Numbers</option>
                                                <option value="Set Theory">Set Theory</option>
                                            </select>
                                        </div>
                                        <div class="form-group mt-1">
                                            <button class="btn btn-primary mt-3 sz2" id="submit-new-question" type="submit" name="submit-new-question">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require_once('footer.php'); ?>
