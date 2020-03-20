<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require_once('gDrive.php');
    //1SaELlKqEF8fI9QSJWA2O-2JhXwO55qwc
    try{
      echo "<pre>";
      $client = getClient();
      $service = new Google_Service_Drive($client);
$TeamDriveList = new Google_Service_Drive_TeamDriveList($client);

$date = date("d.m.Y H:i:s");

$teamDriveMetadata = new Google_Service_Drive_TeamDrive(array(
      'name' => "IT Course Test Drive 101"));
	$requestId = Rhumsaa\Uuid\Uuid::uuid4()->toString();
   
 $teamDrive = $service->teamdrives->create($requestId, $teamDriveMetadata, array(
      'fields' => 'id'));
 $tdId =  $teamDrive->id;
 echo "<a href='https://drive.google.com/drive/folders/".$tdId."'>Tıkla</a>";
 echo $tdId;
/*
  $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => 'oguz123'.$date,
                'mimeType' => 'application/vnd.google-apps.folder',
                'driveId' => $tdId,
                'parents' => array($tdId)
              
            ));
            $file = $service->files->create($fileMetadata, array(
                'fields' => 'id',
                'supportsTeamDrives' => true));*/
           
   /*        
  $request = $service->files->create(new Google_Service_Drive_DriveFile(array(
            "name" => "DERS 1",
             'mimeType' => 'application/vnd.google-apps.folder',
            "teamDriveId" => $tdId,
            , array(
      'fields' => 'id'));
  $fileidd=$request->id;
  echo $fileidd;*/

    $userPermission = new Google_Service_Drive_Permission(array(
            'type' => 'group',
            'role' => 'reader',
            'emailAddress' => 'vildan.yalciner@sabanciuniv.edu'
        ));
       
 
        $req = $service->permissions->create($tdId,$userPermission,[
        	'fields' => 'id',
        	'supportsTeamDrives' => true,
        	'sendNotificationEmail' => false
        ]);

         $userPermission2 = new Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => 'organizer',
            'emailAddress' => 'osman.demirhan@sabanciuniv.edu'
        ));
       
 
        $req2 = $service->permissions->create($tdId,$userPermission2,[
        	'fields' => 'id',
        	'supportsTeamDrives' => true,
        	'sendNotificationEmail' => false
        ]);

        $userPermission3 = new Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => 'serkan.keskin@sabanciuniv.edu'
        ));
       
 
        $req3 = $service->permissions->create($tdId,$userPermission3,[
        	'fields' => 'id',
        	'supportsTeamDrives' => true,
        	'sendNotificationEmail' => false
        ]);

         $userPermission4 = new Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => 'reader',
            'emailAddress' => 'murat.eksioglu@sabanciuniv.edu'
        ));
       
 
        $req4 = $service->permissions->create($tdId,$userPermission4,[
        	'fields' => 'id',
        	'supportsTeamDrives' => true,
        	'sendNotificationEmail' => false
        ]);


        print_r($req2);
      echo "</pre>";
    }catch (Exception $e){
      echo $e->getMessage();
    }

?>
