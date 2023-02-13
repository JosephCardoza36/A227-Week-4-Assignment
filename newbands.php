<?php
    require_once('scripts/conn.php');

    $genrequery = "SELECT genreid, genre
                    FROM genrestbl;";
    $genrem = mysqli_query($con, $genrequery);
    $genrecount = mysqli_num_rows($genrem);

    if (isset($_POST['submit'])) {
        $bandname = mysqli_real_escape_string($con, $_POST['bandname']);
        $genrecount = count($_POST['genre']);

        $query = "INSERT INTO bandstbl (bandname)
                    VALUES ('$bandname'); ";
        mysqli_query($con, $query);  

        $bandquery = "SELECT bandid
                    FROM bandstbl
                    WHERE bandname = '$bandname';";

        $band = mysqli_query($con, $bandquery);  
        $bandidcount = mysqli_num_rows($band);
        for($i=0; $i<$bandidcount; $i++) {
            $row=mysqli_fetch_assoc($band);
            $bandfk = $row['bandid'];
        }
        // echo "<p>" .$bandfk. "</p>";

    

        for ($i=0; $i<$genrecount; $i++) {

              $query = "INSERT INTO mixestbl (mixbandfk, genrefk)
                        VALUES ( '$bandfk', '".$_POST['genre'][$i]."')";

            mysqli_query($con, $query);  

        }
           

        
    }
   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new bands</title>
</head>
<body>
    <form method="post" action="" >

        <h2>Enter the Band Name:</h2>
                    <label><input type="name" name="bandname"placeholder="Band Name" autofocus>


        <h2>What genre does the new band play?</h2>
                <?php for($i=0; $i<$genrecount; $i++) { $row=mysqli_fetch_assoc($genrem); ?> 
                    <label><input type="checkbox" name="genre[]" value="<?php echo $row['genreid']; ?>">
                    <?php echo $row['genre']; ?></label><br>
                <?php } ?>

        <p><input type="submit" name="submit" value="Add Band"></p>

    </form>
        
</body>
</html>