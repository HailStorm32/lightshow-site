<?php
session_start();

if(!isset($_SESSION['loggedin']))
{
    header('Location: index.php');
    exit();
}
?>

<html>
<head>
    <title>Light Controls</title>
    <script>
        function submitForm()
        {
            //alert("test");
            document.getElementById("chSwitch").submit();
        }
        
    </script>
</head>
<body>
    <p>Wellcome!</p>

    <form id="chSwitch" method="POST">
        <p>Channel 1 control:</p>
        <input id="ch1_on" type="radio" name="ch1" value="on">On</input>
        <input id="ch1_off" type="radio" name="ch1" value="off">Off</input>

        <p>Channel 2 control:</p>
        <input id="ch2_on" type="radio" name="ch2" value="on">On</input>
        <input id="ch2_off" type="radio" name="ch2" value="off">Off</input>

        <p>Channel 3 control:</p>
        <input id="ch3_on" type="radio" name="ch3" value="on">On</input>
        <input id="ch3_off" type="radio" name="ch3" value="off">Off</input>

        <p>Channel 4 control:</p>
        <input id="ch4_on" type="radio" name="ch4" value="on">On</input>
        <input id="ch4_off" type="radio" name="ch4" value="off">Off</input>

        <p>Channel 5 control:</p>
        <input id="ch5_on" type="radio" name="ch5" value="on">On</input>
        <input id="ch5_off" type="radio" name="ch5" value="off">Off</input>

        <p>Channel 6 control:</p>
        <input id="ch6_on" type="radio" name="ch6" value="on">On</input>
        <input id="ch6_off" type="radio" name="ch6" value="off">Off</input>

        <p>Channel 7 control:</p>
        <input id="ch7_on" type="radio" name="ch7" value="on">On</input>
        <input id="ch7_off" type="radio" name="ch7" value="off">Off</input>

        <p>Channel 8 control:</p>
        <input id="ch8_on" type="radio" name="ch8" value="on">On</input>
        <input id="ch8_off" type="radio" name="ch8" value="off">Off</input>
    </form>

<script>
    var chRadioBtns = [];

    chRadioBtns[0] = document.getElementsByName("ch1");
    chRadioBtns[1] = document.getElementsByName("ch2");
    chRadioBtns[2] = document.getElementsByName("ch3");
    chRadioBtns[3] = document.getElementsByName("ch4");
    chRadioBtns[4] = document.getElementsByName("ch5");
    chRadioBtns[5] = document.getElementsByName("ch6");
    chRadioBtns[6] = document.getElementsByName("ch7");
    chRadioBtns[7] = document.getElementsByName("ch8");
    
    for(var chNum = 0; chNum < 8; chNum++)
    {
        for(var i = 0; i < 2; i++)
        {
            chRadioBtns[chNum][i].addEventListener("click", submitForm);
        }
    }
</script>
</body>
</html>


<?php
require'../config.php';


$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//Check connection to the database
if(!$con)
{
    die("connection to database failed:");
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($stmt = $con->prepare('UPDATE channels SET state = ? WHERE channel = ?'))
    {
        for($i = 1; $i < 9; $i++)//start count on 1 b/c channels start at 1
        {
            $channel = "ch".$i;
            $stmt->bind_param('ss',$_POST["ch".$i],$channel);   
            $stmt->execute(); 
        }
    }
    else
    {
        die("Could not prepare statement!");
    }
    $stmt->close();

    updateBtns(); 
}
else
{
    updateBtns();
}

function updateBtns()
{
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    //Check connection to the database
    if(!$con)
    {
        die("connection to database failed:".mysqli_connect_error());
    }


    $result = $con->query("SELECT * FROM channels");

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            if($row["state"] === "off")
            {
                //set the 'off' radio btn
                $id = "".$row["channel"]."_".$row["state"]."";
                
                echo("<script>document.getElementById('".$id."')
                    .setAttributeNode(
                        document.createAttribute('checked'));</script>");

                //unset the 'on' radio btn
                $id = "".$row["channel"]."_on";

                echo("<script>document.getElementById('".$id."')
                    .removeAttribute('checked');</script>");
            }
            else if($row["state"] === "on")
            {
                //set the 'on' radio btn
                $id = "".$row["channel"]."_".$row["state"]."";
                
                echo("<script>document.getElementById('".$id."')
                    .setAttributeNode(
                        document.createAttribute('checked'));</script>");

                //unset the 'off' radio btn
                $id = "".$row["channel"]."_off";

                echo("<script>document.getElementById('".$id."')
                    .removeAttribute('checked');</script>");
            }
        }
    }
    else
    {
        die("Error: rows < 0");
    }

    $con->close();
}

?>
