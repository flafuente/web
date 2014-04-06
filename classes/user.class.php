<?php
class User extends Model {

	public $id;
	public $statusId;
	public $roleId;
	public $nombre;
	public $apellidos;
	public $email;
	public $password;
	public $recoveryHash;
	public $dateInsert;
	public $dateUpdate;
	public $lastvisitDate;

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
	public static $reservedVarsChild = array("roles", "statuses", "statusesCss");

	public function init(){
		parent::$dbTable = "users";
		parent::$reservedVarsChild = self::$reservedVarsChild;
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
		if(!empty($data)){
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

	public function preInsert(){
		//Passwd encryption
		$this->password = User::encrypt($this->password);
		//Register Date
		$this->dateInsert = date("Y-m-d H:i:s");
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
		if(!empty($data)){
			//Password?
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

	public function preUpdate($data=array()){
		//Prevent blank password override
		if($data['password']){
			$this->password = User::encrypt($data['password']);
		}else{
			$this->password = null;
		}
		//Update Date
		$this->dateUpdate = date("Y-m-d H:i:s");
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
				$_SESSION['lang'] = $user->language;
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
			if($data['order'] && $data['orderDir']){
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

	public function sendRecovery(){
		$this->recoveryHash = bin2hex(openssl_random_pseudo_bytes(16));
		$this->update();
		$mailer = Registry::getMailer();
		$mailer->addAddress($this->email);
		$mailer->Subject = utf8_decode(Registry::translate("EMAILS_ACCOUNT_RECOVERY_SUBJECT"));
		$mailer->msgHTML(
			Template::renderEmail(
				"accountRecovery",
				array(
					"hash" => $this->recoveryHash
				), "bootstrap"
			)
		);
		$mailer->send();
	}
}
