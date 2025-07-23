
<?php
matchMentorAndMentee();
function matchMentorAndMentee() {
    $conne=mysqli_connect("localhost","root","","mentorlink");
    if (!$conne) {
        die("Connection failed: " . mysqli_connect_error());
    }   
    $match="SELECT * FROM (matches INNER JOIN (users)ON matches.mentee_id=users.id AND matches.mentor_id=users.id) ORDER BY matches.id DESC";
    if(mysqli_query($conne,$match)){
        $row=mysqli_fetch_assoc($match);
        $mentee_id = $row['mentee_id']; 
        $mentor_id = $row['mentor_id'];
        echo "<script>alert('Match successful!!!');</script>";
        mysqli_close($conne);
        header("Location: mentordashboard.php");
        exit;
    }
    else{
        echo "<script>alert('Error: " . mysqli_error($conne) . "');</script>";
    }
}
?>