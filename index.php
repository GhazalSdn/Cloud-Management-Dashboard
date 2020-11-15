<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
    <link rel="stylesheet" href="Normalize.css">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard(Cloud Computing)</title>
</head>

<body>

    <div class="model">
        <div class="main-container">            
            <div class="content">
                <h1>
                </h1>
                <p class="text">

                </p>
                <p class="text">
                <form  class="form" method="post">
                        <?php


                        // $list = array("vm1", "two", "three");
                        $list= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage list vms');
                        
                        preg_match_all("~\"(.*?)\"~",$list,$listvm);
                        $listvm = ($listvm[1]);
                        echo '<select name="selectedVM">';
                        foreach($listvm as $select => $row){
                        echo '<option value=' . $row . '>' . $row . '</option>';
                        }
                        echo '</select>';
                        ?>
                        <div><textarea placeholder="Command:" rows="6" cols="50" name="message" id="message"></textarea></div>
                        <input type="submit" name="getVMs" id="getVMs" value="Execute Command" /><br/>
                        <input type="submit" name="startVM" id="startVM" value="Start VM" /><br/>
                        <input type="submit" name="stopVM" id="stopVM" value="Stop VM" /><br/>
                        <input type="submit" name="cloneVM" id="cloneVM" value="Clone VM" /><br/>
                        <div><input type="text" name="txtSearch" value="" size="20" maxlength="64" /></div>
                </form>
                    
                    
                </p>


                
            </div>


            <div class="content">
                <h3>
                Result
                </h3>
                <p class="text" id="res"><?php
                        // require __DIR__ . '/vendor/autoload.php';
                        // use phpseclib\Net\SSH2;

                    function testfun()
                    {
                        $command = $_POST['message'];
                        $vm = $_POST['selectedVM'];
                        // $vm = $_POST['vm'];
                        if($vm == 'VM1'){
                            $vmUser='vm1';
                            // $pass='';
                        }
                        if($vm==''){
                            // $pass='';

                        }
                        
                        
                        // $ssh = new SSH2('192.168.1.6');
                        // if (!$ssh->login($vm , $pass)) {
                        //     exit('Login Failed');
                        // }
                        // $commandRes = $ssh->exec($command);
                        $commandRes=shell_exec("ssh ".$vmUser."@192.168.1.6 ".$command);


                        
                        echo '<pre>'.$commandRes.'</pre>';
                    }
                    
                    if(array_key_exists('getVMs',$_POST)){
                       testfun();

                    }
                    if(isset($_POST['startVM'])) { 
                        $vm = $_POST['selectedVM'];
                        exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage startvm '. $vm);
                        
                    }
                    if(isset($_POST['stopVM'])) { 
                        $vm = $_POST['selectedVM'];
                        shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage controlvm '.$vm.' poweroff');
                    }
                    if(isset($_POST['cloneVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $cloneVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage clonevm '.$vm.' --name clone'.$vm.' --register' );
                        echo '<pre>'.$cloneVM.'</pre>';
                    }
                    
                    
                    ?></p>
            </div>

            


        </div>

        


</body>





</html>