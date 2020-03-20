<?php
    require_once('list_sl.php');
    require_once('GDrive.php');
    $gDrive = new GDrive();
/*
    $time = date("Ymd-His");
    if(!isset($_GET['offset']) || empty($_GET['limit'])){
        die("Offset ve limit alanları boş geçilemez!");
    } 
    $offset = $_GET['offset'];
    $limit = $_GET['limit'];
 
    

    $arr = array_slice($list,$offset,$limit);*/
    $file = fopen("log/${time}_${offset}_${limit}.txt",'w');
    $file2 = fopen('log/sites.txt',"a");
    $arr = [
      'ENG0004-4D2-201902'=>array(),
      'GR503M-201902'=>array()
    ];
 
    $i = 0;
    foreach ($arr as $key => $value) {
        $driveName = $key;
        echo $i." - DRIVE OLUŞTUR -> ".$driveName."<br/>";
        
        $resCreate = $gDrive->createDrive($driveName);
      
        fwrite($file,json_encode($resCreate).",\n");
        $teamDriveID = $resCreate['tdID'];
        fwrite($file2,$driveName.",".$teamDriveID."\n");

        $resUCreate = $gDrive->addMember($teamDriveID,'onlinecourses@sabanciuniv.edu',"organizer");

        $instName = $driveName."_inst@sabanciuniv.edu";
        echo $driveName." ÜZERİNDE FILEORGANIZER YETKİSİ VER -> ".$instName."<br/>";
        $resUCreate = $gDrive->addMember($teamDriveID,$instName,"fileOrganizer");
        fwrite($file,json_encode($resUCreate).",\n");


        $stuName = $driveName."_stu@sabanciuniv.edu";
        echo $driveName." ÜZERİNDE READER YETKİSİ VER -> ".$stuName."<br/>";
        $resSCreate = $gDrive->addMember($teamDriveID,$stuName,"reader");
        fwrite($file,json_encode($resSCreate).",\n");

/*
        
        
        $instructors = $value['instructor'];
        foreach ($instructors as $email) {
             echo $driveName." ÜZERİNDE ORGANIZER YETKİSİ VER -> ".$email."<br/>";
             $resUCreate = $gDrive->addMember($teamDriveID,$email,"organizer");
            fwrite($file,json_encode($resUCreate).",\n");
        }

        $students = $value['students'];
        foreach ($students as $email) {
            echo $driveName." ÜZERİNDE READER YETKİSİ VER -> ".$email."<br/>";
            $resSCreate = $gDrive->addMember($teamDriveID,$email,"reader");
            fwrite($file,json_encode($resSCreate).",\n");
        }
*/

        $i++;
    }

    fclose($file);
    fclose($file2);


?>