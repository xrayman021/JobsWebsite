<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Jobs Page</title>
</head>
<body>
    <h1>Create a New Job</h1>
    <form action="submitJob.php" method="post">
        <label for="jobTitle">Job Title:</label><br>
        <input type="text" id="jobTitle" name="jobTitle" required><br><br>
        
        <label for="jobDescription">Job Description:</label><br>
        <textarea id="jobDescription" name="jobDescription" rows="4" cols="50" required></textarea><br><br>
        
        <label for="jobLocation">Job Location:</label><br>
        <input type="text" id="jobLocation" name="jobLocation" required><br><br>
        
        <input type="submit" value="Create Job">
    </form>
</body>
</html>