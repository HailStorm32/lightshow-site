<?php
require'../config.php';


function canRun()
{
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    //Check connection to database
    if(!$con)
    {
        die("connection to database failed!");
    }

    //Get show end time from database
    $result = $con->query("SELECT * FROM variables");

    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            if($row["variable"] === "showWaitTime")
            {
                $dbShowEndTime = $row["value"];
                break;
            }

        }
    }
    else
    {
        $con->close();
        die("Error: rows < 0");
    }

    //Check to see if we passed the set time which the show will have ended
    if(idate("U") >= $dbShowEndTime)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function setShowTimer()
{
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    //Check connection to database
    if(!$con)
    {
        die("connection to database failed!");
    }

    $startTime = idate("U");
    $showEndTime = $startTime + 159;

    
    if($stmt = $con->prepare('UPDATE variables SET value = ? WHERE variable = ?'))
    {
        $name = "showWaitTime";
        $stmt->bind_param('ss',$showEndTime,$name);
        $stmt->execute();
    }
    else
    {
        $con->close();
        die("Could not prepare statment!");
    }
    $stmt->close();
}
    

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

//Check connection to database
if(!$con)
{
    die("connection to database failed!");
}

if(canRun())
{
    if($stmt = $con->prepare('UPDATE variables SET value = ? WHERE variable = ?'))
    {
        $value = "start";
        $name = "showStartAck";
        $stmt->bind_param('ss',$value,$name);
        $stmt->execute();
    }
    else
    {
        $con->close();
        die("Could not prepare statment!");
    }
    $stmt->close();

    setShowTimer();


    $showStartAck = "0000";

    while($showStartAck != "read")
    {
        $result = $con->query("SELECT * FROM variables");

        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                if($row["variable"] === "showStartAck")
                {
                    $showStartAck = $row["value"];
                    break;
                }
            }
        }
        else
        {
            $con->close();
            die("Error: rows < 0");
        }
    }

    echo "1";

    if($stmt = $con->prepare('UPDATE variables SET value = ? WHERE variable = ?'))
    {
        $value = "0000";
        $name = "showStartAck";
        $stmt->bind_param('ss',$value,$name);
        $stmt->execute();
    }
    else
    {
        $con->close();
        die("Could not prepare statment!");
    }
    $stmt->close();
    $con->close();
}
else
{
    echo "0";
    $con->close();
}
?>
