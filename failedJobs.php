<?php 
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Jobs Page</title>
    <a href="viewJobs.php">Back to Active Jobs</a><br><br>
</head>
<body>
    <h2>Failed Jobs:</h2>
    <?php
        $sql = "SELECT job_name, job_id, type, attempts, payload FROM jobs WHERE status = 'FAILED'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                $attempts = $row["attempts"];
                echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";

                if($attempts < 3){ //Check if attempts are less than 3 to allow retry
                    echo "<a href='workJob.php?job_id=" . urlencode($row["job_id"]) . "' style='font-size: 18px; font-weight: bold;'>" . htmlspecialchars($row["job_name"]) . "</a><br>";
                }
                else{ // If attempts are 3 or more, show job name in red without link
                    echo "<span style='font-size: 18px; font-weight: bold; color: red;'>" . htmlspecialchars($row["job_name"]) . " (Max Attempts Reached)</span><br>";
                }
                echo "Job ID: " . htmlspecialchars($row["job_id"]) . "<br>";
                echo "Type: " . htmlspecialchars($row["type"]) . "<br>";
                echo "Payload: " . htmlspecialchars($row["payload"]) . "<br>";
                echo "Attempts: " . htmlspecialchars($row["attempts"]) . "<br>";
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
