<?php
session_start();
if (!isset($_SESSION['sessionid'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

include 'dbconnect1.php';
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];

    if ($operation == 'search') {
        $search = $_GET['search'];
            $sqlsubject = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
    }
} else {
    $sqlsubject = "SELECT * FROM `tbl_subjects`";
}

$stmt = $conn->prepare($sqlsubject);
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

$stmt = $conn->prepare($sqlsubject);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlsubject = $sqlsubject . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlsubject);
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
        <a href="login.php" class="w3-bar-item w3-button w3-text-black w3-right">Logout</a>
    </div>


    <div class="w3-container w3-padding-16 w3-center " style="font-size: 25px;">
        <h><b>Subject Lists</b></h>
    </div>

    <div class="w3-card w3-container w3-padding w3-margin w3-round w3-yellow">
        <h3>Subject Search</h3>
        <form>
            <div class="w3-row">
                <div style="padding-right:4px">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter subject name." /></p>
                </div>
            </div>
            <button class="w3-button w3-round w3-light-blue w3-right" type="submit" name="submit" value="search">search</button>
        </form>

    </div>

    <div class="w3-container">
    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $subject) {
            $i++;
            $subjectid = $subject['subject_id'];
            $subjectname = truncate($subject['subject_name'],20);
            $subjectprice = number_format((float)$subject['subject_price'], 2, '.', ''); 
            $subjectrate = $subject['subject_rating'];
            $subjectsession = $subject['subject_sessions'];
            $subjectdescript = truncate($subject['subject_description'],50);
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-yellow'>
                <h5><b>$subjectname</b></h5>
            </header>";
            echo "<a href='subjectdetails.php?subjectid=$subjectid' style='text-decoration: none;'> <img class='w3-image' src=../assets/courses/$subjectid.png" .
                " onerror=this.onerror=null;this.src='../../user/refer/pictureerror.png'"
                . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container'>
            <p><b>Rating:</b> $subjectrate
            <br><b>Price: RM</b> $subjectprice
            <br><b>Subject session:</b> $subjectsession
            <br><b>Description:</b> $subjectdescript
            <br>
            </p></div>
            </div>";
            
        }
        ?>
    </div>
    </div>
    <br>

    <div class="w3-container ">
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
    </div>

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