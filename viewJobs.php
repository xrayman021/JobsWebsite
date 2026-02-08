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
                echo "Job Name: " . $row["job_name"]. " - Job ID: " . $row["job_id"]. " - Type: " . $row["type"]. " - Payload: " . $row["payload"]. "<br><br>";
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
