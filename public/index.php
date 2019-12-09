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
}
</style>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
<script>
    var soundID = "carolBells";

    function loadSound () {
        createjs.Sound.registerSound("carolOfTheBells.mp3", soundID);
    }

    function playSound () {
        createjs.Sound.play(soundID);
    }

    function showStart() 
    {
        $.post("_runShow.php", {bed: "essr"}, 
            function(test)
            {
                //alert(test);
                if(test == 1)
                {
                    // alert("Playing");

                    //var audio = document.getElementById("music");
                    //audio.play();
                    playSound();
                }
                else
                {
                    alert("Show already playing!");
                }
            } );  
    }
</script>
</head>
<body onload="loadSound();">

<p>Welcome</p>
        


<button id="submitBtn">Start Show</button>

<script>
document.getElementById("submitBtn").addEventListener("click", showStart);
</script>





<!--<audio id="music" src="carolOfTheBells.mp3" preload="auto" ></audio>--->

<script>
/*function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}*/



/*var musicLoaded = false;


document.getElementById("music").onplaying =  mLoaded()
    {
        musicLoaded = true; 
        alert("loaded");
    };
 document.getElementById("music").addEventListener("onloadstart", 
    mLoading(){alert("loading");});*/

</script>










</body>
</html>
