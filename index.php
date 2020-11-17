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
                <link rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>Dashboard(Cloud Computing)</title>
</head>

<body>

    <div class="model">

        <div class="main-container">    
            <div class="content">
            <button class="refresh" onClick="window.location.reload();">Refresh</button>        

                <h2 class="name">
                    VirtualBox Dashboard
                </h2>

                <p class="text">
                <form  class="form" method="post">
                        <div id="selectedVM" class="listOfVM"> SELECT VM:  </div>
                        <div><textarea placeholder="Command:" rows="6" cols="50" name="message" id="message"></textarea></div>
                        <button type="submit" name="getVMs" id="getVMs" ><i class="fa fa-play"></i> Execute Command</button><br/>
                        <button type="submit" name="startVM" id="startVM" ><i class="fa fa-arrow-right"></i> Start</button><br/>
                        <button type="submit" name="stopVM" id="stopVM"  ><i class="fa fa-power-off"></i> Power Off</button><br/>
                        <button type="submit" name="removeVM" id="removeVM" ><i class="fa fa-trash"></i> Remove</button><br/>
                        <button type="submit" name="cloneVM" id="cloneVM" ><i class="fa fa-copy"></i> Clone</button><br/>
                        <button type="submit" name="showInfo" id="showInfo" ><i class="fa fa-info"></i> Show Info</button><br/>
                        <div><input id="coreNum" type="text" name="coreNum" value="" size="45" maxlength="30" placeholder="Number of CPU cores:" />
                        <input type="submit" name="setCoreNum" id="setCoreNum" value="Submit" /></div><br/>
                        <div><input id="memSize" type="text" name="memSize" value="" size="45" maxlength="30" placeholder="Memory size:" />
                        <input type="submit" name="setMemSize" id="setMemSize" value="Submit" /></div><br/>

                        
                </form>
                    
                    
                </p>


                
            </div>


            <div class="content">

                <p class="text" id="res"><?php

                    
                    if(isset($_POST['getVMs'])){
                        echo '<h3> Result </h3>';
                        $command = $_POST['message'];
                        $vm = $_POST['selectedVM'];
                        $vmUser='vm1';
                        $ip="192.168.1.6";
                        $commandRes=shell_exec("ssh ".$vmUser."@".$ip." ".$command);
                        echo '<pre class="limited">'.$commandRes.'</pre>';
                    }

                    if(isset($_POST['startVM'])) { 
                        echo '<h3> Result </h3>';
                        $vm = $_POST['selectedVM'];
                        $startVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage startvm '. $vm);
                        echo '<pre class="limited">'.$startVM.'</pre>';
                        
                    }
                    if(isset($_POST['stopVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $stopVM=shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage controlvm '.$vm.' poweroff');
                    }
                    if(isset($_POST['cloneVM'])) { 
                        echo '<h3> Result </h3>';
                        $vm = $_POST['selectedVM'];
                        $cloneVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage clonevm '.$vm.' --name clone-'.rand(1,30).$vm.' --register' );
                        echo '<pre class="limited">'.$cloneVM.'</pre>';
                    }
                    if(isset($_POST['removeVM'])) { 
                        $vm = $_POST['selectedVM'];
                        $removeVM= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage unregistervm --delete '.$vm);
                    }
                    if(isset($_POST['setCoreNum'])){
                        $coreNum = (int)($_POST['coreNum']);
                        $vm = $_POST['selectedVM'];
                        $coreCommand=shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage modifyvm "'.$vm.'" --cpus '.$coreNum);

                    }
                    if(isset($_POST['setMemSize'])){
                        $memSize = (int)($_POST['memSize']);
                        $vm = $_POST['selectedVM'];
                        $memCommand=shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage modifyvm "'.$vm.'" --memory '.$memSize);

                    }

                    if(isset($_POST['showInfo'])){
                        echo '<h3> Result </h3>';
                        $vm = $_POST['selectedVM'];
                        $memCommand=shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage showvminfo '.$vm);
                        echo '<pre class="limited">'.$memCommand.'</pre>';
                    }


                    
                    
                    ?></p>
            </div>

            


        </div>


        


    <script type="text/javascript">
    
                

    var allVMs = <?php 
        $choicelist= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage list vms');
        preg_match_all("~\"(.*?)\"~",$choicelist,$listchoicevm);
        $listchoicevm = ($listchoicevm[1]);
        echo json_encode($listchoicevm);
    ?>;
    

    var runningVMs = <?php 
        $choicelistrun= shell_exec('/Applications/VirtualBox.app/Contents/MacOS/VBoxManage list runningvms');
        preg_match_all("~\"(.*?)\"~",$choicelistrun,$listchoicevmrun);
        $listchoicevmrun = ($listchoicevmrun[1]);
        echo json_encode($listchoicevmrun);
    ?>;

    var common = allVMs.filter(value => runningVMs.includes(value));
    var allVMs=allVMs.filter(val => !runningVMs.includes(val));
    var sel = document.getElementById('selectedVM');
    
    for(var i = 0; i < allVMs.length; i++) {
    var newDiv = document.createElement('div');
    newDiv.className += "eachVM";
    sel.appendChild(newDiv);
    var label = document.createElement('label');
    label.innerHTML = allVMs[i];
    var opt = document.createElement('input');
    opt.type="radio";
    opt.name="selectedVM";
    opt.value = allVMs[i];
    var redcircle = document.createElement('span');
    redcircle.className += "circle";
    redcircle.className += " red";
    newDiv.appendChild(opt);
    newDiv.appendChild(label);
    newDiv.appendChild(redcircle);
    }       

    for(var i = 0; i < common.length; i++) {
    var newDiv = document.createElement('div');
    newDiv.className += "eachVM";
    sel.appendChild(newDiv);
    var label = document.createElement('label');
    label.innerHTML = common[i];
    var opt = document.createElement('input');
    opt.type="radio";
    opt.name="selectedVM";
    opt.value = common[i];
    var greencircle = document.createElement('span');
    greencircle.className += "circle";
    greencircle.className += " green";
    newDiv.appendChild(opt);
    newDiv.appendChild(label);
    newDiv.appendChild(greencircle);
    }     

</script>
</body>




</html>