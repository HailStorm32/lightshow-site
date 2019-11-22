<?php
function canRun()
{
    $myfile = fopen("variables.txt","r");
    $fileValue = fread($myfile, filesize("variables.txt"));
    fclose($myfile);
    $targetTime = $fileValue;

    //reset the file if the time has passed
    if(idate("U") >= $targetTime)
    {
        $myfile = fopen("show_last_run.txt","w");
        fwrite($myfile,"z"); 
        fclose($myfile);
        //echo "1";
        return true;
    }
    else
    {
        return false;
    }

    /*$myfile = fopen("show_last_run.txt","r");
    $fileValue = fread($myfile, filesize("show_last_run.txt"));
    fclose($myfile);

    if($fileValue == "zHas_ran")
    {
        return false;
    }*/
}

function setShowTimer()
{
    $startTime = idate("U");
    $targetTime = $startTime + 60;

    $myfile = fopen("variables.txt","w");
    fwrite($myfile,$targetTime); 
    fclose($myfile);


    /*$myfile = fopen("show_last_run.txt","w");
    fwrite($myfile,"zHas_ran"); 
    fclose($myfile);*/
}


if(canRun())
{
    setShowTimer();
    echo "1";
}
else
{
    echo "0";
}
?>
