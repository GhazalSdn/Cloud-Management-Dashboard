<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard(cloud computing)</title>
</head>

<body>


    <div class="model">
        <div class="main-container">            
            <div class="content">
                <h1>
                </h1>
                <p class="text">
                <form  class="form" method="post">
                        <div><input placeholder="VM name:" type="text" name="vm" id="vm"></input></div>
                        <div><textarea placeholder="command" rows="6" cols="50" name="message" id="message"></textarea></div>
                        <input type="submit" name="getVMs" id="getVMs" value="getVMs" /><br/>
                </form>
                    
                    
                </p>
                
            </div>


            <div class="content">
                <h3>
                Result
                </h3>
                <p class="text" id="res"><?php
                        require __DIR__ . '/vendor/autoload.php';
                        use phpseclib\Net\SSH2;

                    function testfun()
                    {
                        $command = $_POST['message'];
                        $vm = $_POST['vm'];
                        if($vm == 'vm1'){
                            $pass='12345';
                        }
                        
                        
                        $ssh = new SSH2('192.168.1.6');
                        if (!$ssh->login($vm , $pass)) {
                            exit('Login Failed');
                        }
                        
                        echo $ssh->exec($command);
                    }
                    
                    if(array_key_exists('getVMs',$_POST)){
                       testfun();

                    }
                    
                    ?></p>
            </div>

            


        </div>

        


</body>





</html>