<?php
function canRun()
{
    $myfile = fopen("variables.txt","r");
    $fileValue = fread($myfile, filesize("variables.txt"));
    fclose($myfile);
    $targetTime = $fileValue;

    if(idate("U") >= $targetTime)
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
    $startTime = idate("U");
    $targetTime = $startTime + 60;

    $myfile = fopen("variables.txt","w");
    fwrite($myfile,$targetTime); 
    fclose($myfile);
}


if(canRun())
{
    $myfile = fopen("showStart.txt","w");
    fwrite($myfile, "start");
    fclose($myfile);
    setShowTimer();

/*    $myfile = fopen("showStart.txt","r");
    while($fileContents != "read")
    {
        $fileContents = fgets($myfile);
    }
    fclose($myfile);*/

    echo "1";

    $myfile = fopen("showStart.txt","w");
    fwrite($myfile, " ");
    fclose($myfile);
}
else
{
    echo "0";
}
?>
