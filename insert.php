<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['gender'])
    && isset($_POST['email']) && isset($_POST['password']) &&
       isset($_POST['phone'])) {
        
        $username = $_POST['username'];   
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "happy";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);


        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM programmer WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO programmer (username, gender, email, password, phoneNumber) values(?, ?, ?, ?, ?)"; // This is database name
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssi",$username, $gender, $email, $password, $phone);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>