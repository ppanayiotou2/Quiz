<?php

require_once('dblogin.php');
session_start();

class Database
{
    public function createQuestion($question)
    {
        $q_name = $question->getName();
        $q_body = $question->getBody();
        $q_answer_one = $question->getAnswer("one");
        $q_answer_two = $question->getAnswer("two");
        $q_answer_three = $question->getAnswer("three");
        $q_answer_four = $question->getAnswer("four");
        $q_difficulty = $question->getDifficulty();
        $q_level = $question->getLevel();
        $q_category = $question->getCategory();
     
        if (empty($q_answer_two)){
            $q_answer_two="not applicable";
        }
        
        if (empty($q_answer_three)){
            $q_answer_three="not applicable";
        }
        
        if (empty($q_answer_four)){
            $q_answer_four="not applicable";
        }

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
        $url = 'http://ppanayiotou2.com/quizapi/public/api/questions';
        $ch = curl_init($url);
        # Form data string
        $postString = http_build_query($data, '', '&');
        # Setting options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Get the response
        $response = curl_exec($ch);
        curl_close($ch);
        $jsonData = json_decode($response,true);
        $conn = get_connection();
        $result = mysqli_query($conn, "SELECT id FROM questions ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_array($result);
        $last_id = $row['id'];
        
        $tags = $_POST['tags'];
        
        foreach ($tags as $tag) {
            mysqli_query($conn,"INSERT INTO questions_tags (question_id, tag)
            VALUES ('$last_id','$tag')") 
            or die(mysqli_error($conn));
        }
        
        
        mysqli_close($conn);
        
    } 
    
        
}

class Question
{
    /***private Properties***/
    private $name;
    private $body;
    private $answerOne;
    private $answerTwo;
    private $answerThree;
    private $answerFour;
    private $difficulty;
    private $level;
    private $category;
    private $db;
    
    /***Public Methods***/
    public function __construct($name, $body, $answerOne, $answerTwo, $answerThree, $answerFour, $difficulty, $level, $category)
    {
        $this->name = $name;
        $this->body = $body;
        $this->answerOne = $answerOne;
        $this->answerTwo = $answerTwo;
        $this->answerThree = $answerThree;
        $this->answerFour = $answerFour;
        $this->difficulty = $difficulty;
        $this->level = $level;
        $this->category = $category;
        $this->db = new Database;
        $this->save();    
    }
    
    /***getters and Setters***/
    public function getName()
    {
        return $this->name;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function getAnswer($answerNumber)
    {
        if ($answerNumber == "one")
        {
            return $this->answerOne;
        }
        elseif($answerNumber == "two")
        {
            return $this->answerTwo;
        }
        elseif($answerNumber == "three")
        {
            return $this->answerThree;
        }
        else
        {
            return $this->answerFour;
        }
    }
    
    public function getDifficulty()
    {
        return $this->difficulty;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function save()
    {
        $this->db->createQuestion($this);
    }
}



/*
class SignedInUser
{
    private $name;
    private $password;
   
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }
}
*/
