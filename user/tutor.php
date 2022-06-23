<?php
session_start();
if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
include 'dbconnect1.php';
$sqltutors = "SELECT * FROM `tbl_tutors`";
$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutors = $sqltutors . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
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
        <a href="mainpage.php" class="w3-bar-item w3-button w3-text-black w3-right">Back</a>
    </div>

    <div class="w3-container w3-padding-16 w3-center " style="font-size: 25px;">
        <h><b>Tutor Lists</b></h>
    </div>

    <div class="w3-container">
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $tutors) {
            $i++;
            $tutorid = $tutors['tutor_id'];
            $tutorname = truncate($tutors['tutor_name'],25);
            $tutoremail = $tutors['tutor_email'];
            $tutorphone = $tutors['tutor_phone'];
            $tutordescript = $tutors['tutor_description'];
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-yellow'><h5><b>$tutorname</b></h5></header>";
            echo "<img class='w3-image' src=../assets/tutors/$tutorid.jpg" .
                " onerror=this.onerror=null;this.src='../../user/refer/pictureerror.png'"
                . " style='width:100%;height:300px'></a><hr>";
            echo "<div class='w3-container'>
            <p><b>Email:</b> $tutoremail
            <br><b>Phone Number:</b> $tutorphone
            <br><b>Description:</b> $tutordescript
            </p></div>
            <br></div>";
            
        }
        ?>
    </div>
    </div>
    <br>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "index.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " [ " . $pageno . " ]";
    echo "</center>";
    echo "</div>";
    ?>
    <br>
    <br>
    <br>

    <div class=" w3-center w3-yellow w3-bottom" style="margin:0 auto;">
        <p> MyTutor&copy;</p>
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