<!DOCTYPE HTML>

<html>
<head>
<style>

body{
    background-color: #525252;
}

#submitBtn{
    position:relative;
    left:50px;
    top:500px;
    display:none;
}
#loadMusicBtn{
    position:relative;
    left:50px;
    top:400px;
}
</style>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
<script>
    var soundID = "carolBells";

    function loadSound() 
    {
        createjs.Sound.registerSound("carolOfTheBells.mp3", soundID);
    }

    function playSound() 
    {
        createjs.Sound.play(soundID);
    }

    function showStart() 
    {
        if(createjs.Sound.loadComplete(soundID))
        {
        $.post("_runShow.php", {nul: "nul"}, 
            function(test)
            {
                if(test == 1)
                {
                    //alert("Playing");

                    playSound();
                }
                else
                {
                    alert("Show already playing!");
                }
            } );  
        }
        else
        {
            alert("Music still loading, please try again in 12 seconds.");
        }
    }

    function showSubmit()
    {
        document.getElementById("submitBtn").style.display = "block";//Show btn
        document.getElementById("loadMusicBtn").style.display = "none";//Hide btn
    }
</script>
</head>
<body>


<p>Welcome</p>
        
<button id="loadMusicBtn" onclick="loadSound();">Load Music</button>

<button id="submitBtn">Start Show</button>

<script>
</script>
<script>
document.getElementById("submitBtn").addEventListener("click", showStart);
document.getElementById("loadMusicBtn").addEventListener("click", showSubmit);
</script>





<!--<audio id="music" src="carolOfTheBells.mp3" preload="auto" ></audio>--->











</body>
</html>
