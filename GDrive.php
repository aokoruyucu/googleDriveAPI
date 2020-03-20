<?php
require '../drive/vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class GDrive{
	public $client;
	public $service;
	public function __construct(){

    $this->client = new Google_Client();
      $this->client->setApplicationName('Sabancı Üniversitesi');
      $this->client->setScopes(Google_Service_Drive::DRIVE);
      $this->client->setAuthConfig('credentials.json');
      $this->client->setAccessType('offline');
      $this->client->setPrompt('select_account consent');
      $tokenPath = 'token.json';
      if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $this->client->setAccessToken($accessToken);
      }
      $this->service = new Google_Service_Drive($this->client);

	}

	public function createDrive($name){
		try{
			$teamDriveMetadata = new Google_Service_Drive_TeamDrive(array(
      		'name' => $name));
			$requestId = Rhumsaa\Uuid\Uuid::uuid4()->toString();
	 		$teamDrive = $this->service->teamdrives->create($requestId, $teamDriveMetadata, array(
	      'fields' => 'id'));
	 		$tdId =  $teamDrive->id;
	 		$arr = ['response'=>"success",'name'=>$name,"tdID"=>$tdId,'fonksiyon'=>'createdrive'];
	 		return $arr;
		}catch(Exception $e){
			 $arr = ['response'=>"error",'message'=>$e->getMessage(),'name'=>$name,'fonksiyon'=>'createdrive'];
            return $arr;
		}
		
	}

	public function addMember($teamDriveId,$email,$role="reader"){
		try{
			$userPermission = new Google_Service_Drive_Permission(array(
            	'type' => 'user',
            	'role' => $role,
            	'emailAddress' => $email
        	));
       
        	$req = $this->service->permissions->create($teamDriveId,$userPermission,[
        		'fields' => 'id',
        		'supportsTeamDrives' => true,
        		'sendNotificationEmail' => false
        	]);
        	$arr = ['response'=>"success","tdID"=>$teamDriveId,'email'=>$email,'rol'=>$role,'fonksiyon'=>'addMember'];
            return $arr;
		}
		catch(Exception $e){
			$arr = ['response'=>"error",'message'=>$e->getMessage(),"tdID"=>$teamDriveId,'email'=>$email,'rol'=>$role,'fonksiyon'=>'addMember'];
            return $arr;
		}
		
	}



}

   