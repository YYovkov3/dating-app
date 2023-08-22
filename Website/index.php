<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
    <style>
        body {
            background-image: url('sunrise-3562745_1280.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <?php 
            include("php/config.php");
            
            if(isset($_POST['submit'])){
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = $_POST['password'];

               
                if(empty($email) || empty($password)) {
                    echo "<div class='message'>
                              <p>Email and password are required.</p>
                           </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                    exit(); 
                }
                
             
                $stmt = $conn->prepare("SELECT * FROM users WHERE Email=?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if(is_array($row) && !empty($row)){
                    if(password_verify($password, $row['Password'])) {
                        $_SESSION['valid'] = $row['Email'];
                        $_SESSION['username'] = $row['Username'];
                        $_SESSION['age'] = $row['Age'];
                        $_SESSION['id'] = $row['Id'];
                        header("Location: home.php");
                    } else {
                        echo "<div class='message'>
                                  <p>Wrong Username or Password</p>
                               </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Go Back</button>";
                    }
                } else {
                    echo "<div class='message'>
                              <p>Wrong Username or Password</p>
                           </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Go Back</button>";
                }

             
                $stmt->close();
            } else {
            ?>
            <header class="title">Вход</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Парола</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Вход" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <button class="chatbot-toggler">
        <span class="material-symbols-outlinded"><i class="fa-regular fa-comment"></i></span>
        <span class="material-symbols-outlinded"><i class="fa-solid fa-xmark"></i></span>
    </button>
    <div class="chatbot">
        <header>
            <h2>Chatbot</h2>
            <span class="close-btn lmaterial-symbols-outlinded"><i class="fa-solid fa-xmark"></i></span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlinded"><i class="fa-solid fa-robot"></i></span>
                <p> Hi there <br> How can I help tou today?</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Enter a message..." required></textarea>
            <span id="send-btn" class="material-symbols-outlinde"><i class="fa-solid fa-share"></i></span>
        </div>
    </div>
    <script src="script.js"></script>
        <?php } ?>
    </div>
</body>
</html>
