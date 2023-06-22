<?php
require_once "connection.php";

try {
    $projectID = $_GET["projectID"];
    
    $stmt = $connection->prepare("
        SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(work.time_end, work.time_start)))) AS total_work_time
        FROM work
        WHERE work.FID_PROJECTS = :projectID
    ");
    $stmt->bindParam(":projectID", $projectID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    header("Content-Type: text/xml");
    echo "<response>";
    echo "<time>" . $result["total_work_time"] . "</time>";
    echo "</response>";
} catch(PDOException $ex) {
    echo "Connection failed: " . $ex->getMessage();
}
?>