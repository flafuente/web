<?php
class User extends Model {

	public $id;
	public $statusId;
	public $verified;
	public $roleId;
	public $permisos;
	public $username;
	public $nombre;
	public $apellidos;
	public $email;
	public $password;
	public $recoveryHash;
	public $verificationHash;
	public $foto;
	public $sexo;
	public $fechaNacimiento;
	public $ubicacion;
	public $biografia;
	public $intereses;
	public $trabajo;
	public $estudios;
	public $dateInsert;
	public $dateUpdate;
	public $lastvisitDate;

	public $fotosPath = "/files/images/";

	public $secciones = array(
		"todo"		=> "Todo",
		"noticias" 	=> "Notícias",
		"cortos" 	=> "Cortos",
		"musica" 	=> "Música",
		"juegos" 	=> "Juegos",
		"usuarios" 	=> "Usuarios",
		"logs" 		=> "Logs",
	);

	public $statusesCss = array(
		0 => "danger",
		1 => "success",
	);
	public $statuses = array(
		0 => "Bloqueado",
		1 => "Activo",
	);
	public $roles = array(
		1 => "Usuario",
		2 => "Administrador"
	);

	public static $reservedVarsChild = array("fotosPath", "secciones", "roles", "statuses", "statusesCss");

	public function init(){
		parent::$dbTable = "users";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

    public function getFotoUrl(){
        $config = Registry::getConfig();
        if($this->foto){
            return Url::site($this->fotosPath.$this->foto);
        }else{
            return Url::template("img/tu_haces/en_corto/user_icon.png");
        }
    }

	public function checkPermisos($seccion=""){
		//Es una acción?
		if(!@in_array($seccion, $this->secciones)){
			switch($seccion){
				//Cortos
				case 'users':
				case 'usersEdit':
				case 'usersSave':
				case 'usersDelete':
					$seccion = "usuarios";
				break;
				//Usuarios
				case 'videos':
				case 'videosEdit':
				case 'videosSave':
				case 'videosDelete':
					$seccion = "cortos";
				break;
			}
		}
		if(@in_array($seccion, json_decode($this->permisos)) || @in_array("todo", json_decode($this->permisos))){
			return true;
		}
	}

	public function getStatusString(){
		return $this->statuses[$this->statusId];
	}

	public function getStatusCssString(){
		return $this->statusesCss[$this->statusId];
	}

	public function getRoleString($roleId=0){
		if(!$roleId){
			$roleId = $this->roleId;
		}
		if($roleId){
			return $this->roles[$roleId];
		}else{
			return "-";
		}
	}

	public function validateInsert($data=array()){
		//Check nombre
		if(!$this->nombre){
			Registry::addMessage("Debes introcurir tu nombre", "error", "nombre");
		}
		//Check apellidos
		if(!$this->apellidos){
			Registry::addMessage("Debes introducir tus apellidos", "error", "apellidos");
		}
		//Check email
		if(!$this->email){
			Registry::addMessage("Debes introducir tu email", "error", "email");
		}elseif($this->getUserByEmail($this->email)){
			Registry::addMessage("Este email ya esta registrado", "error", "email");
		}
		//Password?
		if(!empty($data) && !$this->dateInsert){
			if(!$this->password){
				Registry::addMessage("Debes introcir una contraseña", "error", "password");
			}elseif(strlen($this->password)<6){
				Registry::addMessage("La contraseña debe tenter al menos 6 caracteres", "error", "password");
			}elseif($this->password!=$data["password2"]){
				Registry::addMessage("Las contraseñas no coinciden", "error", "password");
			}
		}
		return Registry::getMessages(true);
	}

	public function preInsert($data=array()){
		//Passwd encryption
		$this->password = User::encrypt($this->password);
		//Register Date
		$this->dateInsert = date("Y-m-d H:i:s");
		//Permisos
		if(isset($data["permisos"])){
			$this->permisos = json_encode($data["permisos"]);
		}
		//Foto
        $this->uploadFoto($_FILES["foto"]);
	}

	public function postInsert(){
		$this->sendVerification();
	}

	public function validateUpdate($data=array()){
		//Check nombre
		if(!$this->nombre){
			Registry::addMessage("Debes introcuri tu nombre", "error", "nombre");
		}
		//Check apellidos
		if(!$this->apellidos){
			Registry::addMessage("Debes introducir tus apellidos", "error", "apellidos");
		}
		//Check email
		if(!$this->email){
			Registry::addMessage("Debes introducir tu email", "error", "email");
		}elseif($this->getUserByEmail($this->email, $this->id)){
			Registry::addMessage("Este email ya esta registrado", "error", "email");
		}
		return Registry::getMessages(true);
	}

	public function preUpdate($data=array()){
		//Prevent blank password override
		if($data['password']){
			$this->password = User::encrypt($data['password']);
		}else{
			$this->password = null;
		}
		//Update Date
		$this->dateUpdate = date("Y-m-d H:i:s");
		//Permisos
		if(isset($data["permisos"])){
			$this->permisos = json_encode($data["permisos"]);
		}
		//Foto
        $this->uploadFoto($_FILES["foto"]);
	}

	public function uploadFoto($resource){
		if($resource["size"]){
			$config = Registry::getConfig();
	        $uploadDir = $config->get("path").$this->fotosPath;
	        $uploadTempDir = $config->get("path")."/files/tmp/";
	        //Tmp Upload
	        $temp = explode(".", $resource["name"]);
	        $extension = end($temp);
	        $newName = md5(uniqid());
	        $tmpName = $newName.".".$extension;
	        if(move_uploaded_file($resource["tmp_name"], $uploadTempDir.$tmpName)){
	            //New name
	            $newName = $newName.".png";
	            //Resize
	            $resizeObj = new resize($uploadTempDir.$tmpName);
	            $resizeObj->resizeImage(512, 512);
	            $resizeObj->saveImage($uploadDir.$newName, 0);
	            @unlink($uploadTempDir.$tmpName);
	            $this->foto = $newName;
	        }
		}else{
			$this->foto = null;
		}
	}

	public function login($login, $password){
		$db = Registry::getDb();
		$query = "SELECT * FROM `users` WHERE
		`email`='".htmlspecialchars(mysql_real_escape_string(trim($login)))."' AND
		`password`='".User::encrypt($password)."' AND `statusId`=1 LIMIT 1;";
		if($db->query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				$user = new User($row);
				//Set Session
				session_start();
				$_SESSION['userId'] = $user->id;
				//Update lastVisitDate
				$user->lastvisitDate = date("Y-m-d H:i:s");
				$user->update();
                return true;
			}
		}
	}

	public function logout(){
		session_start();
		$_SESSION = array();
		session_unset();
		session_destroy();
		return true;
	}

	public function encrypt($password=""){
		return md5(sha1(trim($password)));
	}

	public function select($data=array(), $limit=0, $limitStart=0, &$total=null){
		$db = Registry::getDb();
        //Query
		$query = "SELECT * FROM `users` WHERE 1=1 ";
		//Total
		if($db->Query($query)){
			$total = $db->getNumRows();
			//Order
			if(isset($data['order']) && isset($data['orderDir'])){
				//Secure Field
				$orders = array("ASC", "DESC");
				if(@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)){
					$query .= " ORDER BY `".mysql_real_escape_string($data['order'])."` ".mysql_real_escape_string($data['orderDir']);
				}
			}
			//Limit
			if($limit){
				$query .= " LIMIT ".(int)$limitStart.", ".(int)$limit;
			}
			if($total){
				if($db->Query($query)){
					if($db->getNumRows()){
						$rows = $db->loadArrayList();
						foreach($rows as $row){
							$results[] = new User($row);
						}
						return $results;
					}
				}
			}
		}
	}

	public function getUserByEmail($email, $ignoreId=0){
		$db = Registry::getDb();
		$query = "SELECT * FROM `users` WHERE `email`='".htmlentities(mysql_real_escape_string($email))."'";
		if($ignoreId){
			$query .= " AND `id` !=".(int)$ignoreId;
		}
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new User($row);
			}
		}
	}

	public function getUserByRecoveryHash($hash){
		$db = Registry::getDb();
		$query = "SELECT * FROM `users` WHERE `recoveryHash`='".htmlentities(mysql_real_escape_string($hash))."'";
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new User($row);
			}
		}
	}

	public function getUserByVerificationHash($hash){
		$db = Registry::getDb();
		$query = "SELECT * FROM `users` WHERE `verificationHash`='".htmlentities(mysql_real_escape_string($hash))."'";
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new User($row);
			}
		}
	}

	public function sendRecovery(){
		$config = Registry::getConfig();
		$this->recoveryHash = bin2hex(openssl_random_pseudo_bytes(16));
		$this->update();
		$mailer = Registry::getMailer();
		$mailer->addAddress($this->email);
		$mailer->Subject = utf8_decode("Recuperación de la cuenta");
		$mailer->msgHTML(
			Template::renderEmail(
				"accountRecovery",
				array(
					"hash" => $this->recoveryHash
				), $config->get("template")
			)
		);
		$mailer->send();
	}

	public function sendVerification(){
		$config = Registry::getConfig();
		$this->verificationHash = bin2hex(openssl_random_pseudo_bytes(16));
		$this->update();
		$mailer = Registry::getMailer();
		$mailer->addAddress($this->email);
		$mailer->Subject = utf8_decode("Activación de la cuenta");
		$mailer->msgHTML(
			Template::renderEmail(
				"accountVerification",
				array(
					"hash" => $this->verificationHash
				), $config->get("template")
			)
		);
		$mailer->send();
	}
}
