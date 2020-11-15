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
                        <input type="submit" name="removeVM" id="removeVM" value="Remove VM" /><br/>
                </form>
                    
                    
                </p>


                
            </div>


            <div class="content">
                <h3>
                Result
                </h3>
                <p class="text" id="res"><?php

                    
                    if(isset($_POST['getVMs'])){
                        $command = $_POST['message'];
                        $vm = $_POST['selectedVM'];

                        if($vm == 'VM1'){
                            $vmUser='vm1';
                            $ip="192.168.1.6";
                        }
                        if($vm==''){
                        }
                        $commandRes=shell_exec("ssh ".$vmUser."@".$ip." ".$command);
                        echo '<pre>'.$commandRes.'</pre>';

                    }

                    if(isset($_POST['startVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $startVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage startvm '. $vm);
                        echo '<pre>'.$startVM.'</pre>';
                        
                    }
                    if(isset($_POST['stopVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $stopVM=shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage controlvm '.$vm.' poweroff');
                        echo '<pre>'.$stopVM.'</pre>';
                    }
                    if(isset($_POST['cloneVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $cloneVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage clonevm '.$vm.' --name clone'.$vm.' --register' );
                        echo '<pre>'.$cloneVM.'</pre>';
                    }
                    if(isset($_POST['removeVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $removeVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage unregistervm --delete '.$vm);
                        echo '<pre>'.$removeVM.'</pre>';
                    }
                    
                    
                    ?></p>
            </div>

            


        </div>

        


</body>





</html>