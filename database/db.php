<?php

function db_connect()
{
    return new PDO('mysql:host=127.0.0.1;dbname=todos', 'root', '');
}

function db_fetch_all($pdo, string $table)
{
    $query = "SELECT * FROM $table";

    $statement = $pdo->prepare($query);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function db_insert($pdo, string $table, array $fields)
{
    $fieldNames = implode(', ', array_keys($fields));
    $values = array_values($fields);
    
    $query = "INSERT INTO $table ($fieldNames) VALUES (?, ?, ?)";

    $statement = $pdo->prepare($query);

    return $statement->execute($values);
}

function db_update($pdo, string $table, array $fields, array $conditions)
{
    $query = "UPDATE $table SET ";
    
    foreach ($fields as $key => $value) {
        $fieldArray[] = "$key = ?";
    }
    
    $query .= implode(', ', $fieldArray);
    
    foreach ($conditions as $key => $value) {
        $conditionArray[] = "$key = ?";
    }
    
    $query .= " WHERE " . implode('AND ', $conditionArray);

    $statement = $pdo->prepare($query);

    $values = array_values($fields);
    $conditionValues = array_values($conditions);
    
    return $statement->execute(array_merge($values, $conditionValues));
}

// NEW FUNCTION: db_delete to delete records based on conditions
function db_delete($pdo, string $table, array $conditions)
{
    $query = "DELETE FROM $table WHERE ";
    
    $conditionArray = [];
    foreach ($conditions as $key => $value) {
        $conditionArray[] = "$key = ?";
    }
    
    $query .= implode(' AND ', $conditionArray);

    $statement = $pdo->prepare($query);

    $values = array_values($conditions);
    
    return $statement->execute($values);
}

function db_fetch_one($pdo, string $table, array $conditions)
{
    $query = "SELECT * FROM $table WHERE ";

    $conditionArray = [];
    foreach ($conditions as $key => $value) {
        $conditionArray[] = "$key = ?";
    }

    $query .= implode(' AND ', $conditionArray) . " LIMIT 1";

    $statement = $pdo->prepare($query);

    $values = array_values($conditions);
    
    $statement->execute($values);

    return $statement->fetch(PDO::FETCH_ASSOC);
}
