<?php 
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Jobs Page</title>
    <a href="main.php">Back to Main Page</a><br><br>
</head>
<body>
    <h2>Available Jobs:</h2>
    <?php
        $sql = "SELECT job_name, job_id, type, payload FROM jobs";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
                echo "<a href='workJob.php?job_id=" . urlencode($row["job_id"]) . "' style='font-size: 18px; font-weight: bold;'>" . htmlspecialchars($row["job_name"]) . "</a><br>";
                echo "Job ID: " . htmlspecialchars($row["job_id"]) . "<br>";
                echo "Type: " . htmlspecialchars($row["type"]) . "<br>";
                echo "Payload: " . htmlspecialchars($row["payload"]) . "<br>";
                echo "</div>";
            }
        } else {
            echo "No jobs found.";
        }
    ?>
</body>
</html>
<?php  
    mysqli_close($conn);
?>
