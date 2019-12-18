<html>
<head>
    <title>Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit()
        {
            document.getElementById("loginForm").submit();
        }
    </script>
</head>
<body>
    <form id="loginForm" action="" method="POST">
        <input type="text" placeholder="Enter Username" name="username" required>
        <input type="password" placeholder="Enter Password" name="password" required>
        <button 
            class="g-recaptcha" 
            data-sitekey="6LeyFMgUAAAAAEH9VeR5_kwWyrR72eS_GguRaQkk" 
            data-callback='onSubmit'>Login</button>
    </form>
</body>
</html>


<?php
require'../config.php';

$loginFail = FALSE;

if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
{
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_SECRET_KEY.'&response='.$_POST['g-recaptcha-response']);

    $responseData = json_decode($verifyResponse);

    if(!$responseData->success)
    {
        echo("<script>alert('CAPATCHA Verification Failed!');</script>");
    }
    else
    {
        session_start();

        $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        //Check connection to the database
        if(!$con)
        {
            die("connection to database failed:".mysqli_connect_error());
        }
        
        //make sure fields were filled out
        if($_POST['username'] == NULL && $_POST['password'] == NULL)
        {
            echo("<script>alert('Please fill both the username and password field!');</script>");
            die();
        }
        else if($_POST['username'] == NULL)
        {
            echo("<script>alert('Missing username field!');</script>");
            die();
        }
        else if($_POST['password'] == NULL)
        {
            echo("<script>alert('Missing password field!');</script>");
            die();
        }

        //Sanitize inputs
        $cleanUname = filter_var($_POST['username'],FILTER_SANITIZE_ENCODED);
        $cleanPswd = filter_var($_POST['password'], FILTER_SANITIZE_ENCODED);

        //check database and get data if there
        if($stmt = $con->prepare('SELECT id, password FROM accounts WHERE 
            username = ?'))
        {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->store_result();   
        }
        else
        {
            die("An error occurred while preparing database search");
        }

        //varify fields
        if($stmt->num_rows > 0)
        {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            if(password_verify($cleanPswd, $password))
            {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $cleanUname;
                $_SESSION['id'] = $id;
                
                header('Location: settings.php');
            }
            else
            {
                $loginFail = TRUE;
            }
        }
        else
        {
            $loginFail = TRUE;
        }

        if($loginFail)
        {
            echo("<script>alert('Incorrect username or password!');</script>");
            die();
        }
    }
    
    $stmt->close();
}
?>
