
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="registration.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/af8ea0c35a.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container" style="margin: 30px 500px">
        <form action="Registration.php" method="post">
            <i class="fa fa-user" aria-hidden="true"></i>
            <label class="values">Name: </label><br>
            <input class="values" type="text" name="Name" placeholder="Name" id="Name" required><br>

            <i class="fa fa-id-card" aria-hidden="true"></i>
            <label class="values">IDno: </label><br>
            <input type="text" class="values" name="IDno" placeholder="ID"  id="IDno" required><br>

            <i class="fa fa-mobile" aria-hidden="true"></i>
            <label class="values">Phone No: </label><br>
            <input type="text" class="values" name="PhoneNo" placeholder="Tel No"  id="PhoneNo" required><br>

            <i class="fa fa-envelope" aria-hidden="true"></i>
            <label class="values">Email: </label><br>
            <input type="Email" class="values" name="Email" placeholder="Email"  id="Email" required><br>

            <i class="fa fa-tasks" aria-hidden="true"></i>
            <label class="values">Program: </label><br>
            <input type="text" class="values" name="Program" placeholder="Program"  id="Program" required><br>

            <label class="values">Role: </label><br>
            <select class="values" name="Role" id="Role" style="width:45%; padding: 5px; border-radius: 10px;" required>
                <option value="Mentor">Mentor</option>
                <option value="Mentee">Mentee</option>
                <option value="Admin">Admin</option>
            </select><br>

<!--
            <i class="fa fa-spinner" aria-hidden="true"></i>
            <label class="values">Role: </label><br>
            <input type="text" class="values" name="Role" placeholder="Role"  id="Role"><br>
-->

            <i class="fa fa-user-plus" aria-hidden="true"></i>
            <label class="values">UserName: </label><br>
            <input type="text" class="values" name="UserName" placeholder="UserName"  id="UserName" required><br>

            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            <label class="values">Password: </label><br>
            <input type="password" class="values" name="Password" placeholder="Password"  id="Password" required><br>
            
            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
            <label class="values">Repeat-Password: </label><br>
            <input type="password" class="values" name="Repeat-Password" placeholder="Repeat-Password"  id="Repeat-Password" required><br>
            
            <input type="submit" name="Submit" value="Submit" id="Submit" style="margin-top: 5px">
        </form>
    </div>


    

    <?php
   // include ['match.php'];
    $Hostname = "localhost";
    $Username = "root";
    $Password = "";
    $dbName = "mentorlink";

    if(isset($_POST['Submit'])) {
        $name = $_POST["Name"];
        $idno = $_POST["IDno"];
        $phoneNo = $_POST["PhoneNo"];
        $email = $_POST["Email"];
        $program = $_POST["Program"];
        $role = $_POST["Role"];
        $userName = $_POST["UserName"];
        $password = $_POST["Password"];
        $repeatPassword = $_POST["Repeat-Password"];

        if ($password !== $repeatPassword) {
            echo "<script>alert('Passwords do not match');</script>";
            exit;
        }
        if (empty($name) || empty($idno) || empty($phoneNo) || empty($email) || empty($program) || empty($role) || empty($userName) || empty($password)) {
            echo "<script>alert('All fields are required');</script>";
            exit;
        }

         

        $conn = mysqli_connect($Hostname, $Username, $Password, $dbName);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO users (name, email, IDno, PhoneNo, Program, UserName, password, role) 
                VALUES ('$name', '$email', '$idno', '$phoneNo', '$program', '$userName', '$password', '$role')";
         $match5="INSERT INTO matches (mentor_id, mentee_id) 
                VALUES ((SELECT users.Userid FROM users WHERE users.role='Mentor' AND users.Program='$program'), 
                        (SELECT users.Userid FROM users WHERE users.role='Mentee' AND users.UserName='$userName'));";       
        
        $mentorid="SELECT users.Userid FROM users WHERE users.role='Mentor' AND users.Program='$program';";
        $mentorResult = mysqli_query($conn, $mentorid);
        if ($mentorResult && mysqli_num_rows($mentorResult) > 0) {
            echo "<script>alert('Mentor already exists for this program');</script>";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Registration successful');</script>";
                if (mysqli_query($conn, $match5)) {
                    echo "<script>alert('Match created successfully');</script>";
                } else {
                    echo "<script>alert('Error creating match: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
    }
        mysqli_close($conn);
}
    ?>
    <?php
    /*if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["Name"];
        $idno = $_POST["IDno"];
        $phoneNo = $_POST["PhoneNo"];
        $email = $_POST["Email"];
        $program = $_POST["Program"];
        $role = $_POST["Role"];
        $userName = $_POST["UserName"];
        $password = $_POST["Password"];
        $repeatPassword = $_POST["Repeat-Password"];
        print_r($_POST);

        if ($password !== $repeatPassword) {
            echo "<script>alert('Passwords do not match');</script>";
            exit;
        }

        $conn = mysqli_connect($Hostname, $Username, $Password, $dbName);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO users (name, email, IDno, PhoneNo, Program, UserName, password, role) 
        VALUES ('$name', '$email','$idno', '$phoneNo', , '$program',  '$userName', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration successful');</script>";
            header("Location: login.php");
            exit;
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }

        mysqli_close($conn);
    }*/

    ?>
           
    </body>
    </html>