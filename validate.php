<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 1 Fields
    $firstName = cleanInput($_POST["firstName"]);
    $lastName = cleanInput($_POST["lastName"]);
    $age = cleanInput($_POST["age"]);
    $gender = cleanInput($_POST["gender"]);
    $country = cleanInput($_POST["country"]);

    // Step 2 Fields
    $email = cleanInput($_POST["email"]);
    $phone = cleanInput($_POST["phone"]);
    $address = cleanInput($_POST["address"]);
    $city = cleanInput($_POST["city"]);
    $zipcode = cleanInput($_POST["zipcode"]);

    // Step 3 Fields
    $message = cleanInput($_POST["message"]);
    $institution = cleanInput($_POST["institution"]);
    $subscribe = isset($_POST["subscribe"]) ? "Yes" : "No";
    $degree = cleanInput($_POST["degree"]);
    $cgpa = cleanInput($_POST["cgpa"]);
    $selectedSkill = cleanInput($_POST["skills"]);
    $reason=cleanInput($_POST["reason"]);

    // Validate data (perform additional validation as needed)
    $errors = [];

    // Step 1 Validation
    if (!preg_match("/^[A-Za-z]+$/", $firstName)) {
        $errors["firstName"] = "First name should contain only letters.";
    }

    if (!preg_match("/^[A-Za-z]+$/", $lastName)) {
        $errors["lastName"] = "Last name should contain only letters.";
    }

    if (!is_numeric($age) || $age <= 0) {
        $errors["age"] = "Age should be a positive number.";
    }

    if ($gender !== "male" && $gender !== "female") {
        $errors["gender"] = "Invalid gender selection.";
    }

    if (!preg_match("/^[A-Za-z]+$/", $country)) {
        $errors["country"] = "Country should contain only letters.";
    }

    // Step 2 Validation
    $emailRegex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    if (!preg_match($emailRegex, $email)) {
        $errors["email"] = "Invalid email format.";
    }
    if (!preg_match("/^[0-9]{11}$/", $phone)) {
        $errors["phone"] = "Phone should be a 11-digit number.";
    }

    if (empty($address)) {
        $errors["address"] = "Address is required.";
    }

    if (!preg_match("/^[A-Za-z]+$/", $city)) {
        $errors["city"] = "City should contain only letters.";
    }

    if (!preg_match("/^[0-9]{4}$/", $zipcode)) {
        $errors["zipcode"] = "Zip code should be a 4-digit number.";
    }

    // Step 3 Validation
    if (empty($message)) {
        $errors["message"] = "Message is required.";
    }

    if (empty($institution)) {
        $errors["interests"] = "Interests is required.";
    }

   
    if (empty($errors)) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "form";


        $conn = new mysqli($servername, $username, $password, $dbname);


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $skillSql = "SELECT id FROM skills WHERE Skill='$selectedSkill'";
        $result = $conn->query($skillSql);

        if ($result && $result->num_rows > 0) {
        // Fetch the id from the result set
        $row = $result->fetch_assoc();
        $id = $row['id'];
    }

        $sql = "INSERT INTO user_info (firstName, lastName, age, gender, country, email, phone, address, city, zipcode, institution, degree, message, subscribe,cgpa,reason,skill_id)
                VALUES ('$firstName', '$lastName', $age, '$gender', '$country', '$email', '$phone', '$address', '$city', $zipcode, '$institution', '$degree', '$message', '$subscribe', '$cgpa','$reason','$id')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        header("Location: main.php?errors=" . urlencode(json_encode($errors)));
        exit;
    }
}



function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
