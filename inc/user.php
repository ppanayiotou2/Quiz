<?php
session_start();
include_once('classes.php');
include_once('dblogin.php');

class User
{
    // Private variables
    private $id;
    private $role;
    private $score;
    private $username;
    private $hasSeenIntro;
    private $currentQuestionId;
    private $currentQuestionNum;
    private $currentQuestionAtLevel;
    private $gender;
    private $showTimer;
    private $showQuestionNum;
    private $showQuizNav;
    
    // Constructor
    public function __construct($id, $role, $score, $username, $hasSeenIntro, $currentQuestion, $currentQuestionNum, $currentQuestionAtLevel, $gender, $showTimer, $showQuestionNum, $showQuizNav){
        $this->id = $id;
        $this->role = $role;
        $this->score = $score;
        $this->username = $username;
        $this->hasSeenIntro = $hasSeenIntro;
        $this->currentQuestionId = $currentQuestion;
        $this->currentQuestionNum = $currentQuestionNum;
        $this->currentQuestionAtLevel = $currentQuestionAtLevel;
        $this->gender = $gender;
        $this->showTimer = $showTimer;
        $this->showQuestionNum = $showQuestionNum;
        $this->showQuizNav = $showQuizNav;
    }
    
    // Public getters
    public function getId(){
        return $this->id;
    }
    
    public function getRole(){
        return $this->role;
    }
    
    public function getScore(){
        return $this->score;
    }
    
    public function getUsername(){
        return $this->username;
    }
    
    public function getHasSeenIntro(){
        return $this->hasSeenIntro;
    }
    
    public function getCurrentQuestion(){
        return $this->currentQuestionId;
    }
    
    public function getCurrentQuestionNum(){
        return $this->currentQuestionNum;
    }
    
    public function getCurrentQuestionAtLevel(){
        return $this->currentQuestionAtLevel;
    }
    
    public function getGender(){
        return $this->gender;
    }
    
    public function getWantsTimer(){
        return $this->showTimer;
    }
    
    public function getWantsQuestionNum(){
        return $this->showQuestionNum;
    }
    
    public function getWantsQuizNav(){
        return $this->showQuizNav;
    }
    
    // Public setters
    //public function setId(){
        //return $this->id;
    //}
    
    public function setRole($role){
        $this->role = $role;
        $this->updateUser();
    }
    
    public function setScore($score){
        $this->score = $score;
        $this->updateUser();
    }
    
    public function setUsername($username){
        $this->username = $username;
        $this->updateUser();
    }
    
    public function setHasSeenIntro($hasSeen){
        $this->hasSeenIntro = $hasSeen;
        $this->updateUser();
    }
    
    public function setCurrentQuestionId($questionId){
        $this->currentQuestionId = $questionId;
        $this->updateUser();
    }
    
    public function setCurrentQuestionNum($questionNum){
        $this->currentQuestionNum = $questionNum;
        $this->updateUser();
    }
    
    public function setCurrentQuestionAtLevel($questionAtLevel){
        $this->currentQuestionAtLevel = $questionAtLevel;
        $this->updateUser();
    }
    
    public function setGender($gender){
        $this->gender = $gender;
        $this->updateUser();
    }
    
    public function setWantsTimer($wantOrNot){
        $this->showTimer = $wantOrNot;
        $this->updateUser();
    }
    
    public function setWantsQuestionNum($wantOrNot){
        $this->showQuestionNum = $wantOrNot;
        $this->updateUser();
    }
    
    public function setWantsQuizNav($wantOrNot){
        $this->showQuizNav = $wantOrNot;
        $this->updateUser();
    }
    
    private function updateUser(){
        // DB connection
        $conn = get_connection();
                
        $sql="UPDATE users 
        SET role='$this->role',
        score='$this->score',
        username='$this->username',
        has_seen_intro='$this->hasSeenIntro',
        current_question_id='$this->currentQuestionId',
        current_question_num='$this->currentQuestionNum',
        current_question_at_level='$this->currentQuestionAtLevel',
        gender='$this->gender',
        show_timer='$this->showTimer',
        show_question_num='$this->showQuestionNum',
        show_quiz_nav='$this->showQuizNav'
        WHERE id='$this->id'";
        
        if (!mysqli_query($conn, $sql)) {
            echo("Error description(from user correct answer score increase): " . mysqli_error($conn));
        }
        
        $_SESSION['user'] = serialize($this);
    }
    
    
  
    
   
}
