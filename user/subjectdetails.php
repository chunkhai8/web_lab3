<?php

session_start();
if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

include 'dbconnect1.php';
if (isset($_GET['subjectid'])) {
    $subjectid = $_GET['subjectid'];
    $sqlsubject = "SELECT tbl_subjects.subject_id, tbl_subjects.subject_name, tbl_subjects.subject_description, tbl_subjects.subject_price, tbl_subjects.subject_sessions, tbl_subjects.subject_rating ,tbl_tutors.tutor_name FROM tbl_subjects INNER JOIN tbl_tutors ON tbl_subjects.tutor_id = tbl_tutors.tutor_id WHERE subject_id = '$subjectid'";
    $stmt = $conn->prepare($sqlsubject);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Subject not found.');</script>";
        echo "<script> window.location.replace('index.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('index.php')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../user/css/style.css">
    <title>document</title>
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

    <div class="w3-yellow">
        <div class="w3-container w3-center" >
            <h3 style="font-size: 30px;font-family: 'Times New Roman', Times, serif;"><b>Subject Details</b></h3>
        </div>
    </div>
    <div class="w3-bar w3-yellow">
        <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div >
    <?php
        foreach ($rows as $subject) {
            $subjectid = $subject['subject_id'];
            $subjectname = $subject['subject_name'];
            $subjectprice = number_format((float)$subject['subject_price'], 2, '.', ''); 
            $subjectrate = $subject['subject_rating'];
            $subjectsession = $subject['subject_sessions'];
            $subjectdescript = $subject['subject_description'];
            $subjecttutor = $subject['tutor_name'];
        }
        echo "<div class='w3-padding w3-center'><img class='w3-image resimg' src=../assets/courses/$subjectid.png" .
        " onerror=this.onerror=null;this.src='../../user/refer/pictureerror.png'"
        . " ></div><hr>";
        echo "<div class='w3-container w3-padding-medium w3-yellow'>
        <h4><b>Course Name: </b><b>$subjectname</b></h4>";
        echo " <div>
        <p ><b>Teach by:</b> $subjecttutor</p>
        <p><b>Rating:</b> $subjectrate</p>
        <p><b>Session:</b> $subjectsession hours</p>
        <p><b>Price:</b> RM $subjectprice</p>
        <p><b>Description:</b><br>$subjectdescript</p>
        <br><br>
        </div>
        </div>";
    ?>
    </div>
    <br><br>
    <div class=" w3-center w3-yellow w3-bottom" style="margin:0 auto;">
        <p> MyTutor&copy;</p>
    </div>
</body>

</html>