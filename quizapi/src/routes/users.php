<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// Get all users (validated)
$app->get('/api/users', function (Request $request, Response $response) {
    $sql = "SELECT * FROM users ORDER BY created_at ASC";
    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($users);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'no users']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Create user (maybe if / ifelse/ else in catch)
$app->post('/api/users', function (Request $request, Response $response) {
    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $request->getParam('email');
    $firstName = $request->getParam('firstName');
    $lastName = $request->getParam('lastName');
    $gender = $request->getParam('gender');
    $sql = "INSERT INTO users (username, password, email, first_name, last_name, gender)
    VALUES (:username, :password, :email, :firstName, :lastName, :gender)";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':gender', $gender);
        $stmt->execute();
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson(['status' => 'success', 'description' => 'user successfully created']);
        }
    } catch (PDOException $e) {
        if (preg_match('/\busername\b/i', $e->getMessage())) {
            return $response->withStatus(409)->withJson(['status' => 'error', 'description' => 'Username already exists, please choose a new one']);
        } else {
            return $response->withStatus(409)->withJson(['status' => 'error', 'description' => 'Email already exists, please choose a new one']);
        }
    }
});

// Delete all users (validated) ***CAREFUL***
$app->delete('/api/users', function (Request $request, Response $response) {
    $sql = "DELETE FROM users";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson(['status' => 'success', 'description' => 'users successfully deleted']);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'No users']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Get user by id (validated)
$app->get('/api/users/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM users WHERE id = $id";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson($user);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'user invalid id']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

// Delete user by id (validated)
$app->delete('/api/users/{id}', function (Request $request, Response $response) {
    $id = $request->getAttribute('id');
    $sql = "DELETE FROM users WHERE id = $id";
    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            return $response->withStatus(200)->withJson(['status' => 'success', 'description' => 'user successfully deleted']);
        } else {
            return $response->withJson(['status' => 'error', 'description' => 'user invalid id']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});

    // Login user (maybe if / ifelse/ else in catch)
    $app->post('/api/users/login', function (Request $request, Response $response) {
    $username = $request->getParam('username');
    $password = $request->getParam('password');
    $sql = "SELECT * FROM users WHERE username = :username";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $db = null;
        $count = $stmt->rowCount();

        if ($count > 0) {
            $user = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dbPassword = $user[0]->password;
            
            if (password_verify($password, $dbPassword)){
                return $response->withStatus(200)->withJson($user);
            }
            else{
                return $response->withStatus(422)->withJson(['status' => 'error', 'description' => 'Incorrect Password']);
            }
            
        } else {
            return $response->withStatus(422)->withJson(['status' => 'error', 'description' => 'Incorrect Username or Password']);
        }
    } catch (PDOException $e) {
        return $response->withJson(['status' => 'error', 'description' => $e->getMessage()]);
    }
});
