<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Jobs Page</title>
</head>
<body>
    <h1>Create a New Job</h1>
    <a href="main.php">Back to Main Page</a><br><br>
    <form action="createJobs.php" method="post">
        <label for="job_name">Job Name:</label><br>
        <input type="text" id="job_name" name="job_name" required><br><br>
        <label for="type">Job Type:</label><br>
            <select id="type" name="type" required>
                <option value="">Select a job type:</option>
                <option value="email_validation">Email Validation</option>
                <option value="data_import">Data Import</option>
                <option value="ad_event_ingest">Ad Event Ingest</option>
            </select><br><br>
            <label for="payload">Payload:</label><br> <!-- This is where the user will input the payload for the job. It is a required field and will be sent to the submitJob.php file when the form is submitted. -->
            <textarea id="payload" name="payload" rows="4" cols="50" required></textarea><br><br>    
            <input type="submit" value="Create Job"><br><br>
    </form>
</body>
</html>

<?php 
    function generateUUID() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant bits
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}   

    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $jobId = generateUUID();
        $job_name = $_POST["job_name"];
        $type = $_POST["type"];
        $payload = $_POST["payload"];
        $job_name_check = "SELECT job_name FROM jobs WHERE job_name = '$job_name'";
        $job_name_result = $conn->query($job_name_check);
        if($job_name_result->num_rows > 0){
            die("Job name already exists. Please choose a different name.");
        }
        else{
        
            $sql = "INSERT INTO jobs (job_name, job_id, type, payload) VALUES ( '$job_name', '$jobId', '$type', '$payload')";
            
            if ($conn->query($sql) === TRUE) {
                echo "New job created successfully with Job ID: " . $jobId;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    mysqli_close($conn);
?>