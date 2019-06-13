<?php  
    session_start();
    $page = 'View Questions';
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
                        <a href="view-questions.php"><b>View Questions</b></a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ml-3">All Quiz Questions</h4>
                        </div>
                        <div class="card-body fake">
                            <div class="loader center"></div>
                        </div>
                        <div class="card-body hidden">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <span class="ml-3">*Question categories can be found at the bottom of the question edit modal.</span>
                                    <div class="table-responsive mt-3">
                                        <table id="view-questions-table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>QUESTION NAME</th>
                                                    <th>DIFFICULTY</th>
                                                    <th>LEVEL</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody class="target">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- View Question Modal -->
    <div class="modal fade" id="view-question-modal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Question Preview</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container large">
                        <div class="row">
                            <div class="col-md-12 card quiz-card">
                                <div class="card-body">
                                    <div id="countdown"></div>
                                    <input name="level" id="level" type="hidden">
                                    <input name="difficulty" id="difficulty" type="hidden">
                                    <span class="question-name mb-5">Question 1: </span>
                                    <div class="question-body"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Question Modal -->
    <div class="modal fade col-lg-12" id="edit-question-modal" aria-hidden="true">
        <div class="modal-dialog col-md-6">
            <div class="modal-content">
                <!-- header -->
                <div class="modal-header">
                    <h2 class="modal-title">Edit Question</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <!-- body -->
                <div class="modal-body row justify-content-center">

                    <form method="POST" action="../inc/update_question.php" id="edit-question-form" class="col-md-12">
                        <input type="hidden" name="q-id-edit" id="q-id-edit">
                        <div class="form-group">
                            <label for="q-name">Question Name:</label>
                            <input required type="text" name="q-name-edit" class="form-control" id="q-name-edit" placeholder="Enter question name...">
                        </div>
                        <div class="form-group mt-3">
                            <textarea required class="col-md-12 form-control" name="q_body_edit" id="q_body_edit" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <h2 class="pt-3 pb-1">Answers (leave empty if not applicable):</h2>
                        </div>
                        <div class="form-group">
                            <label for="q-answer"> Answer (a):</label>
                            <input required type="text" name="q-answer-one-edit" id="q-answer-one-edit" class="form-control" placeholder="The answer of question (a)">
                        </div>
                        <div class="form-group">
                            <label for="q-answer">Answer (b):</label>
                            <input type="text" name="q-answer-two-edit" id="q-answer-two-edit" class="form-control" placeholder="The answer of question (b)">
                        </div>
                        <div class="form-group">
                            <label for="q-answer">Answer (c):</label>
                            <input type="text" name="q-answer-three-edit" id="q-answer-three-edit" class="form-control" placeholder="The answer of question (c)">
                        </div>
                        <div class="form-group">
                            <label for="q-answer">Answer (d):</label>
                            <input type="text" name="q-answer-four-edit" id="q-answer-four-edit" class="form-control" placeholder="The answer of question (d)">
                        </div>
                        <div class="form-group mt-3">
                            <label for="q-difficulty-edit">Question Difficulty:</label>
                            <select name="q-difficulty-edit" class="form-control" id="q-difficulty-edit">
                                <option value="easy">Easy</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="q-level">Question Level:</label>
                            <select name="q-level-edit" class="form-control" id="q-level-edit">
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
                            <select name="q-category-edit" class="form-control" id="q-category-edit">
                                <option value="arithmetic">Arithmetic</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="q-tags-edit">Question Tag(s):</label>
                            <select name="tags[]" id="q-tags-edit" class="form-control" multiple="multiple">
                                <option value="Arithmetic">Arithmetic</option>
                                <option value="Functions">Functions</option>
                                <option value="Logic/Algorithms">Logic/Algorithms</option>
                                <option value="Networks/Graphs">Networks/Graphs</option>
                                <option value="Numbers">Numbers</option>
                                <option value="Set Theory">Set Theory</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary mt-3 update-question" type="submit" name="update-question">UPDATE</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php require_once('footer.php'); ?>
