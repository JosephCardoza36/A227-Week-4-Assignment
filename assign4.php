<?php
    require_once('scripts/conn.php');

    $queryband = "SELECT bandid, bandname
                  FROM bandstbl;";
    $rsband = mysqli_query($con, $queryband);
    $countband = mysqli_num_rows($rsband);

    $queryinst = "SELECT instrumentid, instrument
                  FROM instrumentstbl;";
    $rsinst = mysqli_query($con, $queryinst);
    $countinst = mysqli_num_rows($rsinst);

    if (isset($_POST['submit'])) {

            $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
            $bandarray = count($_POST['band']);
            $instarray = count($_POST['inst']);
   
            for ($i=0; $i<$bandarray; $i++) {
                $query = "INSERT INTO musicianstbl (bandnamefk, firstname, lastname) 
                        VALUES ('" .$_POST['band'][$i]. "', '$firstname' , '$lastname');";
                $result = mysqli_query($con, $query);   
                if ($result) {
                }
                else {
                    echo "<p>INSERT error on band " .$_POST['band'][$i]. "</p>";
                }
            }   

            $musicianfk = "SELECT musicianid
                            FROM musicianstbl
                            WHERE firstname = '$firstname' AND lastname = '$lastname';";
            $musicianq = mysqli_query($con, $musicianfk);
            $musicianfkcount = mysqli_num_rows($musicianq);

              for($i=0; $i<$musicianfkcount; $i++) {
                    $row=mysqli_fetch_assoc($musicianq);
                    $musicianfk = $row['musicianid'];
            }

            for ($i=0;$i<$instarray; $i++) {
                $query = "INSERT INTO playstbl (musicianfk,instrumentfk)
                            VALUES ('$musicianfk', '" .$_POST['inst'][$i]. "');";
                $result = mysqli_query($con, $query);   
                if ($result) {
                }
                else {
                    echo "<p>INSERT error on instrument " .$_POST['inst'][$i]. "</p>";
                }
            }
            
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 4</title>
</head>
<body>
    <form method="post" action="" >

        <h2>Enter the Musician Name:</h2>
            <label><input type="firstname" name="firstname"placeholder="First Name" autofocus>
            <label><input type="lastname" name="lastname" placeholder="Last Name">

        <h2>What band do they play in?</h2>
            <?php for($i=0; $i<$countband; $i++) { $row=mysqli_fetch_assoc($rsband); ?> 
                <label><input type="checkbox" name="band[]" value="<?php echo $row['bandid']; ?>">
                <?php echo $row['bandname']; ?></label><br>
            <?php } ?>

        <h2>What instruments do they play?</h2>
        <?php for($i=0; $i<$countinst; $i++) { $row=mysqli_fetch_assoc($rsinst); ?> 
            <label><input type="checkbox" name="inst[]" value="<?php echo $row['instrumentid']; ?>">
            <?php echo $row['instrument']; ?></label><br>
        <?php } ?>

        <p><input type="submit" name="submit" value="Add Musician"></p>
    </form>
    
</body>
</html>