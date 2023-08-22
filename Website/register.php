<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
        <?php 
include("php/config.php");

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    if(empty($username) || empty($email) || empty($age) || empty($password)) {
        echo "<div class='message'>
                  <p>All fields are required.</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
        exit(); 
    }

   
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='message'>
                  <p>Invalid email format.</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
        exit(); 
    }

   
    $verify_query = mysqli_query($conn, "SELECT Email FROM users WHERE Email='$email'");
    if(mysqli_num_rows($verify_query) != 0) {
        echo "<div class='message'>
                  <p>This email is used, Try another one.</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
        exit(); 
    } else {
     
        $stmt = $conn->prepare("INSERT INTO users (Username, Email, Age, Password) VALUES (?, ?, ?, ?)");
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      
        $stmt->bind_param("ssis", $username, $email, $age, $hashed_password);

    
        if($stmt->execute()) {
            echo "<div class='message'>
                      <p>Registration successful!</p>
                  </div> <br>";
            echo "<a href='index.php'><button class='btn'>Login Now</button>";
        } else {
            echo "<div class='message'>
                      <p>Error occurred during registration.</p>
                  </div> <br>";
            echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
        }

      
        $stmt->close();
    }
} else {
?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="index.php">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php } ?>

