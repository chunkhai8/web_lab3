<?php
if (isset($_POST['submit'])) {
    include "dbconnect.php";
    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = sha1($_POST['password']);
    $phonenumber = $_POST["phoneno"];
    $homeaddress = $_POST["address"];
    $sqlinsertuser = "INSERT INTO `userregister` (`name`, `email`, `passwor`, `phoneno`, `address`)
    VALUES ('$username','$email','$password','$phonenumber','$homeaddress')";
     try {
        $conn-> exec($sqlinsertuser);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            $last_id = $conn->lastInsertId();
            uploadImage($last_id);
            echo "<script>alert('Register Success')</script>";
            echo "<script>window.location.replace('login.php')</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Register Failed');</script>";
        echo "<script>window.location.replace('register.php')</script>";
    }    
}

function uploadImage($filename)
{
    $target_dir = "../refer/userimage/";
    $target_file = $target_dir . $filename . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/scripts.js"></script>
    <script src="../js/password.js"></script>
    <title>Register</title>
</head>

<body>
    <div style="display:flex; justify-content: center;background-color:lightblue;">
        <div class="w3-container w3-card w3-padding w3-margin w3-yellow" style="width:600px;margin:auto;text-align:left;">
            <form name="registerForm" action="register.php" method="post"  enctype="multipart/form-data">
                <header class="w3-header w3-center w3-padding-8">
                    <h3><b>Create your account</b></h3>
                </header>
                <div class="w3-container w3-center">
                    <img class="w3-image w3-margin" src="../refer/uploadpicture.png" style="height:100%;width:60%"><br>
                    <input type="file" name="fileToUpload" onchange="previewFile()">
                </div>
                <p>
                    <label><b>Name</b></label>
                    <input class="w3-input w3-round w3-border" type="name" name="name" id="idname" placeholder="Your name" required>
                </p>
                <p>
                    <label><b>Email</b></label>
                    <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail" placeholder="Your email" required>
                </p>
                <p>
                    <label><b>Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="password" id="password" placeholder="Your password" required minlength="8">
                </p>
                <p>
                    <label><b>Re-enter Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="password1" id="confirm_password" placeholder="Your re-enter password" required minlength="8">
                </p>
                <p>
                    <label><b>Phone Number</b></label>
                    <input class="w3-input w3-round w3-border" type="phoneno" name="phoneno" id="idphoneno" placeholder="Your phone number" required>
                </p>
                <p>
                    <label><b>Home Address</b></label>
                    <textarea class="w3-input w3-round w3-border" rows="4" width="100%" type="address" name="address" id="idaddress" placeholder="Your home address" required></textarea>
                </p>
                <p class="w3-center">
                    <input class="w3-button w3-light-blue w3-round w3-border" type="submit" name="submit" value="Register">
                </p>
                <p class="w3-center">Already register? Back to login here<br>
                    <button class="w3-button w3-round w3-border w3-light-blue " name="back" id="idback"><a href="login.php">Back</a></button>
                </p>
            </form>
        </div>

</body>
</html>
