<?php

use \Entity\User;

function step(string $name)
{
    echo PHP_EOL . $name . ':' . PHP_EOL;
}

/**
 * Setup connection
 */

$dsn = "mysql:host=database;port=3306;dbname=users_database";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
];

$pdo = new PDO($dsn, 'app', 'pass', $options);

/**
 * PDO::FETCH_BOTH
 */

step('FETCH_BOTH');
$stmt = $pdo->query('SELECT * FROM users');
$results = $stmt->fetch(PDO::FETCH_BOTH);
var_dump($results);

/**
 * PDO::FETCH_ASSOC
 */

step('FETCH_ASSOC');
$stmt = $pdo->query('SELECT * FROM users');
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
var_dump($results);

/**
 * PDO::FETCH_NUM
 */

step('FETCH_NUM');
$stmt = $pdo->query('SELECT * FROM users');
$results = $stmt->fetchAll(PDO::FETCH_NUM);
var_dump($results);

/**
 * PDO::FETCH_COLUMN
 */

step('FETCH_COLUMN');
$stmt = $pdo->query('SELECT surname FROM users');
$results = $stmt->fetchAll(PDO::FETCH_COLUMN);
var_dump($results);

/**
 * PDO::FETCH_KEY_PAIR
 */

step('FETCH_KEY_PAIR');
$stmt = $pdo->query('SELECT id, surname FROM users');
$results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
var_dump($results);

/**
 * PDO::FETCH_OBJ
 */

step('FETCH_OBJ');
$stmt = $pdo->query('SELECT * FROM users');
$results = $stmt->fetchAll(PDO::FETCH_OBJ);
var_dump($results);

/**
 * PDO::FETCH_CLASS
 */

step('FETCH_CLASS');
$stmt = $pdo->query('SELECT * FROM users');
$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
$results = $stmt->fetchAll();
var_dump($results);

/**
 * WHILE + FETCH
 */

step('WHILE + FETCH');
$stmt = $pdo->query('SELECT * FROM users');
$stmt->setFetchMode(PDO::FETCH_CLASS, User::class);

while ($user = $stmt->fetch()) {
    echo $user;
}

/**
 * Prepared statements [positional placeholders]
 */

step('Prepared statements [positional placeholders]');
$stmt = $pdo->prepare('INSERT INTO users (name, surname) VALUES (?, ?)');
$result = $stmt->execute(['Name', 'Surname']);
var_dump($result);

/**
 * Prepared statements [named placeholders]
 */

step('Prepared statements [named placeholders]');
$stmt = $pdo->prepare('INSERT INTO users (name, surname) VALUES (:name, :surname)');
$result = $stmt->execute(['name' => 'Name1', 'surname' => 'Surname1']);
var_dump($result);

/**
 * Prepared statements [named placeholders] [bindValue]
 */

step('Prepared statements [named placeholders] [bindValue]');
$name = 'Name2';
$surname = 'Surname2';
$stmt = $pdo->prepare('INSERT INTO users (name, surname) VALUES (:name, :surname)');
$stmt->bindValue('name', $name, PDO::PARAM_STR);
$stmt->bindValue('surname', $surname, PDO::PARAM_STR);
$result = $stmt->execute();
var_dump($result);

/**
 * Transactions
 */

step('Transaction');

$pdo->beginTransaction();

try {
    $stmtInsert = $pdo->prepare('INSERT INTO users (name, surname) VALUES (?, ?)');
    $stmtInsert->execute(['1', '2']);

    throw new PDOException('Some error during processing!');

    $pdo->commit();
} catch (PDOException $exception) {
    echo '>>> rollback' . PHP_EOL;

    $pdo->rollBack();
} finally {
    echo '>>> Users data from database:' . PHP_EOL;

    $stmt = $pdo->query('SELECT * FROM users');
    $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
    $users = $stmt->fetchAll();

    var_dump($users);
}
