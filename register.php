<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmpassword = htmlspecialchars($_POST['confirmpassword']);
    $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : '';

    // Check if passwords match
    if ($password != $confirmpassword) {
        echo "Passwords do not match";
        exit;
    }

    $conn = new mysqli('localhost', 'root', '', 'test2');
    if ($conn->connect_error) {
        die('Connection Failed : ' . $conn->connect_error);
    } else {
        $sql = "CREATE TABLE IF NOT EXISTS registration (
            id INT AUTO_INCREMENT,firstname VARCHAR(50),lastname VARCHAR(50),email VARCHAR(100),password VARCHAR(255),gender VARCHAR(10),PRIMARY KEY (id)
        )";
        $conn->query($sql);

        $stmt = $conn->prepare("Insert into registration(firstname, lastname, email, password, gender) values(?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $password, $gender);
            $stmt->execute();
            echo "Registration Successful... <a href='display_data.php'>View all registrations</a>";
            $stmt->close();
        } else {
            echo "Failed to prepare statement: " . $conn->error;
        }
        $conn->close();
    }
}
?>

<!-- Registration Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h1 class="heading">Registration Form</h1>
    <input placeholder="First Name" type="text" id="firstname" name="firstname"><br>
    <input placeholder="Last Name" type="text" id="lastname" name="lastname"><br>
    <input placeholder="Email" type="email" id="email" name="email"><br>
    <input placeholder="Password" type="password" id="password" name="password"><br>
    <input placeholder="Confirm Password" type="password" id="confirmpassword" name="confirmpassword"><br>
    <div class="gender-select">
        <label for="gender">Gender:</label>
        <div class="gender-sty">
            <input class="form-check-input" id="male" type="radio" name="gender" value="male">
            <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="gender-sty">
            <input class="form-check-input" type="radio" name="gender" id="female" value="femail">
            <label class="form-check-label" for="female">Female</label>
        </div>
    </div>
    <input type="submit" value="Register">
</form>


<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    form {
        width: 30%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .heading {
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%;
        height: 40px;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    input[type="radio"] {
        margin: 10px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #3e8e41;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
    }

    .gender-select {
        display: flex;
        margin-bottom: 10px;
        align-items: baseline;
    }

    .gender-sty {
        display: flex;
    justify-content: center;
    align-items: center;
    }

    .form-check-label {
        margin-bottom: 0;
    }
</style>