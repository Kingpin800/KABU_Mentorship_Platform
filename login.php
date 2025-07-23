<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentorship</title>
    <link href="login.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/af8ea0c35a.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="register">
        <a href="Registration.php"><button id="regButton">REGISTER</button></a>
    </div>
    <div class="container" >
        <form action="login.php" method="post">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label>USERNAME: </label><br>
            <input type="text" class="inputs" placeholder="Username" id="Username" name="Username"><br><br>
            <i class="fa fa-key" aria-hidden="true"></i> 
            <label>PASSWORD: </label><br>
            <input type="password" class="inputs" placeholder="Password" id="Password" name="Password"><br><br>
            <input type="submit" name="Submit" value="LOGIN" id="sub"><br>
            <p><a href="">forgot your password?</a></p>
        </form>
    </div> -->
    <?php
    $Hostname="localhost";
$Username="root";
$Password="";
$dbName="mentorlink";
    if(isset($_POST['Submit'])){
    $user=$_POST["Username"];
    $pass=$_POST["Password"];
    $conn=mysqli_connect($Hostname,$Username,$Password,$dbName);;
    $sql="SELECT Userid FROM users WHERE UserName='$user' AND password='$pass';";
    $checker="SELECT Role FROM users WHERE UserName='$user' AND Password='$pass';";
    $result=mysqli_query($conn, $sql);
    $role="";

    if(mysqli_num_rows($result) > 0){
        session_start();
        $_SESSION['Username'] = $user;
        $_SESSION['Userid'] = mysqli_fetch_assoc($result)['Userid'];
        $roleResult = mysqli_query($conn, $checker);
        if ($roleResult && mysqli_num_rows($roleResult) > 0) {
            $row = mysqli_fetch_assoc($roleResult);
            $role = $row['Role'];
            if($role == "mentor") {
                header("Location: mentordashboard.php");
                exit();
            } elseif($role == "mentee") {
                header("Location: mentee.php");
                exit();
            } elseif($role == "admin") {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<script>alert('Unknown role');</script>";
            }
        }
      //header("Location: mentordashboard.php");
    } 
    else {
        echo "<script> alert('Invalid username or password'); </script>";
    }
    mysqli_close($conn);

}



function connection(){
$Hostname="localhost";
$Username="root";
$Password="";
$dbName="mentorlink";
$con= mysqli_connect($Hostname,$Username,$Password,$dbName);
if($con){
    echo "You are connected";
}
else{
    die("Connection failed: " . mysqli_connect_error());
}
};
    ?>
<!--</body>
</html> -->
