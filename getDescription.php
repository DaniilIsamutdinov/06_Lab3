<?php
require_once "connection.php";

try {
    $projectID = $_GET["projectID"];
    $date = $_GET["dateF"];

    $stmt = $connection->prepare("
        SELECT work.description, worker.ID_WORKER
        FROM work
        INNER JOIN worker ON work.FID_WORKER = worker.ID_WORKER
        WHERE work.FID_PROJECTS = :projectID AND work.date = :date
    ");
    $stmt->bindParam(":projectID", $projectID);
    $stmt->bindParam(":date", $date);
    $stmt->execute();
    $cursor = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header("Content-Type: text/plain");
    foreach ($cursor as $task) {
        echo "Task Description: " . $task["description"] . "<br>";
        echo "Worker ID: " . $task["ID_WORKER"];
    }
    if(empty($cursor)){
        echo "Nothing by this id and this date!";
    }
} catch(PDOException $ex) {
    echo "Connection failed: " . $ex->getMessage();
}
?>