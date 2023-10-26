<!DOCTYPE html>
<html>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <body>
    <div class="navbar">
      <img class="logo" src="header.png" alt="logo">
    </div>
    <title>KSU Students Grade Record</title>
    <br>
    <h1>Students' ID Number and Grade List</h1>
    <br><br>
<?php
$idnumber = $_POST["idnumber"];
$grade = filter_input(INPUT_POST, "grade", FILTER_VALIDATE_FLOAT);
if (!$grade){
    $grade=0;
}
//var_dump($idnumber,$grade);
$host = "database-2.c9vyvdgfb7uk.us-east-1.rds.amazonaws.com";
$dbname = "SWEassg_2";
$username = "admin";
$password = "SWEassignment_2";
$conn = mysqli_connect (hostname: $host, username: $username, password: $password, database: $dbname);
if(mysqli_connect_errno()){
    die ("Connect error: ". mysqli_connect_error());
}
//echo "Connection Succesful";
$sql = "INSERT INTO records (idnumber, grade) VALUES (?, ?)";
$stmt=mysqli_stmt_init($conn);
if (! mysqli_stmt_prepare($stmt,$sql)){
    die(mysqli_error($conn));
};
mysqli_stmt_bind_param($stmt, "sd", $idnumber, $grade);
mysqli_stmt_execute($stmt);
//echo "recrod saved";
?>
<br>
<fieldset>
<table>
<tbody>
    <?php
$sql = "SELECT CAST(avg(grade) AS DECIMAL(10,2)) FROM records"; 
$result = $conn->query($sql); 
//display data on web page 
$row = mysqli_fetch_array($result);
$average = $row['CAST(avg(grade) AS DECIMAL(10,2))']; 
    echo "<p style='color:gold;'> Average Grade : $average</p>";
    echo "<br>"; 
    $Letter;
if ($average>=90.00){
    $Letter="A";
}
else if ($average<90.00&&$average>=80.00){
    $Letter="B";
}
else if ($average<80.00&&$average>=70.00){
    $Letter="C";
}
else if ($average<70.00&&$average>=65.00){
    $Letter="D";
}
else {
    $Letter="F";
}
    echo "<p style='color:gold;'> Corresponding Letter Grade: $Letter</p>";
    ?>
</tbody>
    </table>
    <a href="Grades.html"><input type="submit" class="bth" name="Back" id="Back" value="Back"></a>
    </fieldset>
<br>
<br>
<table style="float: left; margin-top:10px; margin: left 300px;">
    <thread>
        <tr>
            <th>ID Number</th>
            <th>Grade</th>
        </tr>
</thread>
<tbody>
    <?php
    $query = "SELECT * FROM `records`;"; 
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()){
        echo "<tr>
        <td> ".$row["idnumber"]." </td>
        <td> ".$row["grade"]."</td>
    </tr>";
    }
    ?>
</tbody>
    </table>
</body>
</html>