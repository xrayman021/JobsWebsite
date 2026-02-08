<?php
include("database.php");

// Get job_id from URL
$job_id = $_GET['job_id'] ?? '';

if (empty($job_id)) {
    die("No job ID provided. <a href='viewJobs.php'>Return to jobs list</a>");
}   

// Fetch job details
$stmt = $conn->prepare("SELECT job_name, job_id, type, payload, status, attempts, updated_at FROM jobs WHERE job_id = ?");
$stmt->bind_param("s", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Job not found. <a href='viewJobs.php'>Return to jobs list</a>");
}

$job = $result->fetch_assoc();
$stmt->close();

$payload = $job['payload'];
$job_type = $job['type'];
$attempts = $job['attempts'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Job Page; ?></title>
</head>
<body>
    <p><a href="viewJobs.php">Back to Jobs List</a></p>
    <p><a href="main.php">Back to Main Page</a></p> 
    <h2>Working on Job: <?php echo$job['job_name']; ?></h2>
    <p><strong>Job ID: </strong> <?php echo $job['job_id']; ?></p>
    <p><strong>Type: </strong> <?php echo $job['type']; ?></p>
    <p><strong>Payload: </strong><?php echo $job['payload']; ?></p>
    <p><strong>Status: </strong><?php echo $job['status']; ?></p>

    <h2>Actions: </h2>
    <form method="post">
        <button type="submit" name="action" value="attempt">Attempt</button><br><br>
        <button type="submit" name="action" value="cancel">Cancel</button><br><br>
    </form>

</body>
</html>

<?php
    function email_validation($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? "Valid Email" : "Invalid Email";
    }



    // Handle form submission for updating job
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
        $attempts += 1;
        $date_updated = date('Y-m-d H:i:s');
        if ($_POST['action'] == 'attempt') {
            // Update job status to IN_PROGRESS and increment attempts
            $update_stmt = $conn->prepare("UPDATE jobs SET status = 'IN_PROGRESS', attempts = attempts + 1 WHERE job_id = ?");
            $update_stmt->bind_param("s", $job_id);
            $update_stmt->execute();
            $update_stmt->close();
            if ($job_type == "email_validation") {
                $result = email_validation($payload);
                if($result == "Valid Email") {
                    $final_status = "COMPLETED";
                } else {
                    $final_status = "FAILED";
                }

                // Update job status based on validation result
                $update_status_stmt = $conn->prepare(query: "UPDATE jobs SET status = ?, updated_at = ? WHERE job_id = ?");
                $update_status_stmt->bind_param("sss", $final_status, $date_updated, $job_id);
                $update_status_stmt->execute();
                $update_status_stmt->close();
            }
            echo $final_status;
        }
        else if ($_POST['action'] == 'cancel') {
            // Update job status to CANCELLED
            $update_stmt = $conn->prepare("UPDATE jobs SET status = 'CANCELLED', updated_at = ? WHERE job_id = ?");
            $update_stmt->bind_param("ss", $date_updated, $job_id);
            $update_stmt->execute();
            $update_stmt->close();
            echo "Job Cancelled";
        }
}


    mysqli_close($conn);
?>
