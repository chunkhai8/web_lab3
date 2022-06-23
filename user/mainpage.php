<?php
session_start();
if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
} else {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
include 'dbconnect.php';
$sqluser = "SELECT * FROM `userregister`";
$stmt = $conn->prepare($sqluser);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../user/css/style.css">
    <title>Document</title>
</head>
<body style="background-color:lightblue;">
    <div class="w3-bar w3-yellow" style="font-size: 20px;font-family: 'Times New Roman', Times, serif;">
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-text-black w3-right">Profile</a>
        <a href="#" class="w3-bar-item w3-button w3-hide-small w3-text-black w3-right">Subscription</a>
        <a href="tutor.php" class="w3-bar-item w3-button w3-hide-small w3-text-black w3-right">Tutors</a>
        <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-text-black w3-right">Courses</a>
        <a href="javascript:void(0)" onclick="sideMude();" class="w3-bar-item w3-button w3-hide-large w3-hide-medium w3-text-black w3-right">&#9776</a>
    </div>

    <div id="idsidebar" class="w3-bar-block w3-yellow w3-hide w3-hide-large " style="font-size: 20px;font-family: 'Times New Roman', Times, serif;">
        <a href="#" class="w3-bar-item w3-button w3-text-black w3-left">Profile</a>
        <a href="#" class="w3-bar-item w3-button w3-text-black w3-left">Subscription</a>
        <a href="tutor.php" class="w3-bar-item w3-button w3-text-black w3-left">Tutors</a>
        <a href="index.php" class="w3-bar-item w3-button w3-text-black w3-left">Courses</a>
    </div>

    <div class="w3-bar w3-yellow" style="font-size: 20px;font-family: 'Times New Roman', Times, serif;">
        <a href="login.php" class="w3-bar-item w3-button w3-text-black w3-right">Logout</a>
    </div>

    <div class="w3-bar w3-yellow" style="font-size: 20px;font-family: 'Times New Roman', Times, serif;">
        <p class="w3-right w3-padding-4"><?php echo $user_email ?></p>     
    </div>

    <div class="w3-center">
        <img class='w3-image w3-margin' src="../refer/welcome.png" style="width:80%">
        <br>
    </div>
    
    <div class=" w3-center w3-yellow w3-bottom" style="margin:0 auto;">
        <p>MyTutor&copy;</p>
    </div>

</body>
<script>
    function sideMude(){
        var x = document.getElementById("idsidebar");
        if(x.className.indexOf("w3-show") == -1){
            x.className += " w3-show";
        } else {
            x.className = x.className.replace("w3-show","");
        }
    }
</script>
</html>