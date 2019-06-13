<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get all questions (validated)
$app->get('/api/questions', function (Request $request, Response $response) {
    $sql = "SELECT * FROM questions ORDER BY id ASC";
    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $questions = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($questions);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'no questions']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Get single question by id (validated)
$app->get('/api/questions/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT id,level,difficulty,name,body FROM questions WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $question = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($question);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'question invalid id']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Get all questions of a given level and difficulty
$app->get('/api/questions/{level}/{difficulty}/', function (Request $request, Response $response) {
    $level = $request->getAttribute('level');
    $difficulty = $request->getAttribute('difficulty');

    $sql = "SELECT id FROM questions WHERE level = :level AND difficulty = :difficulty";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':difficulty', $difficulty);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($questions);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'no questions or invalid parameters']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }

});

// Get single question with answers by id (validated)
$app->get('/api/questions/full/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM questions WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $question = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($question);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'question invalid id']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Get single question tag(s)
$app->get('/api/questions/tags/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM questions_tags WHERE question_id = $id";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $question = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($question);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'question invalid id or no tags']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Get single question tag(s)
$app->get('/api/questions/tags/', function (Request $request, Response $response) {

    $sql = "SELECT * FROM questions_tags";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $question = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($question);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'no tags']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Delete single question by id (validated)
$app->delete('/api/questions/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM questions WHERE id = $id";
    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson(['status' => 'success', 'description' => 'question successfully deleted']);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'question invalid id']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Create question (maybe if / ifelse/ else in catch)
$app->post('/api/questions', function (Request $request, Response $response) {
    $qName = $request->getParam('qName');
    $qBody = $request->getParam('qBody');
    $qAnswerOne = $request->getParam('qAnswerOne');
    $qAnswerTwo = $request->getParam('qAnswerTwo');
    $qAnswerThree = $request->getParam('qAnswerThree');
    $qAnswerFour = $request->getParam('qAnswerFour');
    $qDifficulty = $request->getParam('qDifficulty');
    $qLevel = $request->getParam('qLevel');
    $qCategory = $request->getParam('qCategory');

    $sql = "INSERT INTO questions (name, body, answer_one, answer_two, answer_three, answer_four, difficulty, level, category)
    VALUES (:qName, :qBody, :qAnswerOne, :qAnswerTwo, :qAnswerThree, :qAnswerFour, :qDifficulty, :qLevel, :qCategory)";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':qName', $qName);
        $stmt->bindParam(':qBody', $qBody);
        $stmt->bindParam(':qAnswerOne', $qAnswerOne);
        $stmt->bindParam(':qAnswerTwo', $qAnswerTwo);
        $stmt->bindParam(':qAnswerThree', $qAnswerThree);
        $stmt->bindParam(':qAnswerFour', $qAnswerFour);
        $stmt->bindParam(':qDifficulty', $qDifficulty);
        $stmt->bindParam(':qLevel', $qLevel);
        $stmt->bindParam(':qCategory', $qCategory);
        $stmt->execute();
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson(['status' => 'success', 'description' => 'question successfully created']);
        }
    } catch (PDOException $e) {
        return $response->withStatus(409)->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Update a single question by id (maybe if / ifelse/ else in catch)
$app->put('/api/questions/{id}', function (Request $request, Response $response) {
    $qId = $id = $request->getAttribute('id');
    $qName = $request->getParam('qName');
    $qBody = $request->getParam('qBody');
    $qAnswerOne = $request->getParam('qAnswerOne');
    $qAnswerTwo = $request->getParam('qAnswerTwo');
    $qAnswerThree = $request->getParam('qAnswerThree');
    $qAnswerFour = $request->getParam('qAnswerFour');
    $qDifficulty = $request->getParam('qDifficulty');
    $qLevel = $request->getParam('qLevel');
    $qCategory = $request->getParam('qCategory');

    $sql = "UPDATE questions SET
                name         = :qName,
                body         = :qBody,
                answer_one   = :qAnswerOne,
                answer_two   = :qAnswerTwo,
                answer_three = :qAnswerThree,
                answer_four  = :qAnswerFour,
                difficulty   = :qDifficulty,
                level        = :qLevel,
                category     = :qCategory
            WHERE id= $qId";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':qName', $qName);
        $stmt->bindParam(':qBody', $qBody);
        $stmt->bindParam(':qAnswerOne', $qAnswerOne);
        $stmt->bindParam(':qAnswerTwo', $qAnswerTwo);
        $stmt->bindParam(':qAnswerThree', $qAnswerThree);
        $stmt->bindParam(':qAnswerFour', $qAnswerFour);
        $stmt->bindParam(':qDifficulty', $qDifficulty);
        $stmt->bindParam(':qLevel', $qLevel);
        $stmt->bindParam(':qCategory', $qCategory);

        $stmt->execute();
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson(['status' => 'success', 'description' => 'question successfully updated']);
        }

        return $response;
    } catch (PDOException $e) {
        return $response->withStatus(409)->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});
