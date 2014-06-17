<?php

/**
 * User Class
 *
 * @package LightFramework\Core
 */
class User extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;

    /**
     * Status Id
     * @var int
     */
    public $statusId;

    /**
     * Role Id
     * @var int
     */
    public $roleId;

    /**
     * Email
     * @var string
     */
    public $email;

    /**
     * Username
     * @var string
     */
    public $username;

    /**
     * Password
     * @var string
     */
    public $password;

    /**
     * Recovery Hash
     * @var string
     */
    public $recoveryHash;

    public $verified;
    public $nombre;
    public $apellidos;
    public $foto;
    public $sexo;
    public $fechaNacimiento;
    public $ubicacion;
    public $biografia;
    public $intereses;
    public $trabajo;
    public $estudios;
    public $permisos;
    /**
     * Categorías que puede gestionar como validador (JSON)
     * @var string
     */
    public $categorias;
    /**
     * Insert date
     * @var string
     */
    public $dateInsert;

    /**
     * Update date
     * @var string
     */
    public $dateUpdate;

    /**
     * Last visit date
     * @var string
     */
    public $lastvisitDate;

    /**
     * Ruta de subida de las imágenes
     * @var string
     */
    public $fotosPath = "/files/images/";

    /**
     * Secciones
     * @var array
     */
    public $secciones = array(
        "todo"          => "Todo",
        "usuarios"      => "Usuarios",
        "contenidos"    => "Contenidos",
        "videos"        => "Vídeos",
        "pariilla"      => "Parrilla",
        "programas"     => "Programas",
        "capitulos"     => "Capítulos",
    );

    /**
     * Status CSS classes
     * @var array
     */
    public $statusesCss = array(
        0 => "danger",
        1 => "success",
    );

    /**
     * Status types
     * @var array
     */
    public $statuses = array(
        0 => "Bloqueado",
        1 => "Activo",
    );

    /**
     * Roles
     * @var array
     */
    public $roles = array(
        1 => "Regular",
        2 => "Tribber",
        3 => "Validador",
        4 => "Administrador"
    );

    /**
     * Reserved vars (not at database table)
     * @var array
     */
    public static $reservedVarsChild = array("fotosPath", "secciones", "roles", "statuses", "statusesCss");

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "users";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getCategoriasIds()
    {
        return json_decode($this->categorias);
    }

    public function getPermisos()
    {
        return json_decode($this->permisos);
    }

    /**
     * Devuelve el nombre y los apellidos
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->nombre." ".$this->apellidos;
    }

    /**
     * Get the user status
     *
     * @return string User status
     */
    public function getStatusString()
    {
        return $this->statuses[$this->statusId];
    }

    /**
     * Get the CSS class for user status
     *
     * @return string CSS Class
     */
    public function getStatusCssString()
    {
        return $this->statusesCss[$this->statusId];
    }

    /**
     * Get the role of the user
     *
     * @param integer $roleId Role (optional)
     *
     * @return string Role
     */
    public function getRoleString($roleId=0)
    {
        if (!$roleId) {
            $roleId = $this->roleId;
        }
        if ($roleId) {
            return $this->roles[$roleId];
        } else {
            return "-";
        }
    }

    public function getFotoUrl()
    {
        if ($this->foto) {
            return Url::site($this->fotosPath.$this->foto);
        } else {
            return Url::template("img/tu_haces/en_corto/user_icon.png");
        }
    }

    public function checkPermisos($app="")
    {
        $permisos = $this->getPermisos();
        if (@in_array($app, $permisos) || @in_array("todo", $permisos)) {
            return true;
        }
    }

    /**
     * Insert validation
     *
     * @return array Object Messages
     */
    public function validateInsert($data=array())
    {
        //Check nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introcurir tu nombre", "error", "nombre");
        }
        //Check apellidos
        if (!$this->apellidos) {
            Registry::addMessage("Debes introducir tus apellidos", "error", "apellidos");
        }
        //Check email
        if (!$this->email) {
            Registry::addMessage("Debes introducir tu email", "error", "email");
        } elseif ($this->getUserByEmail($this->email)) {
            Registry::addMessage("Este email ya esta registrado", "error", "email");
        }
        //Password?
        if (!empty($data) && !$this->dateInsert) {
            if (!$this->password) {
                Registry::addMessage("Debes introcir una contraseña", "error", "password");
            } elseif (strlen($this->password)<6) {
                Registry::addMessage("La contraseña debe tenter al menos 6 caracteres", "error", "password");
            } elseif ($this->password!=$data["password2"]) {
                Registry::addMessage("Las contraseñas no coinciden", "error", "password");
            }
        }

        return Registry::getMessages(true);
    }

    /**
     * Pre-Insert actions
     *
     * @return void
     */
    public function preInsert($data=array())
    {
        //Passwd encryption
        $this->password = User::encrypt($this->password);
        //Register Date
        $this->dateInsert = date("Y-m-d H:i:s");
        //Permisos
        if (isset($data["permisos"])) {
            $this->permisos = json_encode($data["permisos"]);
        }
        //Categorias
        if (isset($data["categorias"])) {
            $this->categorias = json_encode($data["categorias"]);
        }
        //Foto
        $this->uploadFoto($_FILES["foto"]);
    }

    public function postInsert()
    {
        $this->sendVerification();
    }

    /**
     * Update validation
     *
     * @return array Object Messages
     */
    public function validateUpdate()
    {
        //Check nombre
        if (!$this->nombre) {
            Registry::addMessage("Debes introcuri tu nombre", "error", "nombre");
        }
        //Check apellidos
        if (!$this->apellidos) {
            Registry::addMessage("Debes introducir tus apellidos", "error", "apellidos");
        }
        //Check email
        if (!$this->email) {
            Registry::addMessage("Debes introducir tu email", "error", "email");
        } elseif ($this->getUserByEmail($this->email, $this->id)) {
            Registry::addMessage("Este email ya esta registrado", "error", "email");
        }

        return Registry::getMessages(true);
    }

    /**
     * Pre-Update actions
     *
     * @return void
     */
    public function preUpdate($data=array())
    {
        //Prevent blank password override
        if ($data['password']) {
            $this->password = User::encrypt($data['password']);
        } else {
            $this->password = null;
        }
        //Update Date
        $this->dateUpdate = date("Y-m-d H:i:s");
        //Permisos
        if (isset($data["permisos"])) {
            $this->permisos = json_encode($data["permisos"]);
        }
        //Categorias
        if (isset($data["categorias"])) {
            $this->categorias = json_encode($data["categorias"]);
        }
        //Foto
        $this->uploadFoto($_FILES["foto"]);
    }

    public function uploadFoto($resource)
    {
        if ($resource["size"]) {
            $config = Registry::getConfig();
            $uploadDir = $config->get("path").$this->fotosPath;
            $uploadTempDir = $config->get("path")."/files/tmp/";
            //Tmp Upload
            $temp = explode(".", $resource["name"]);
            $extension = end($temp);
            $newName = md5(uniqid());
            $tmpName = $newName.".".$extension;
            if (move_uploaded_file($resource["tmp_name"], $uploadTempDir.$tmpName)) {
                //New name
                $newName = $newName.".png";
                //Resize
                $resizeObj = new resize($uploadTempDir.$tmpName);
                $resizeObj->resizeImage(512, 512);
                $resizeObj->saveImage($uploadDir.$newName, 0);
                @unlink($uploadTempDir.$tmpName);
                $this->foto = $newName;
            }
        } else {
            $this->foto = null;
        }
    }

    /**
     * Login
     *
     * @param string $login    Username or email
     * @param string $password Plain password
     *
     * @return bool
     */
    public static function login($login, $password)
    {
        $db = Registry::getDb();
        $rows = $db->query("SELECT * FROM `users` WHERE (username=:username OR email=:email) AND password=:password AND statusId=1",
            array(
                ":email" => $login,
                ":username" => $login,
                ":password" => User::encrypt($password)
            )
        );
        if ($rows) {
            $user = new User($rows[0]);
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

    /**
     * Logout
     *
     * @return bool
     */
    public static function logout()
    {
        //Destroy PHP Session
        session_start();
        $_SESSION = array();
        session_unset();
        session_destroy();

        return true;
    }

    /**
     * Password encryption
     *
     * @param string $password Plain password
     *
     * @return string Encrypted password
     */
    public static function encrypt($password="")
    {
        return md5(sha1(trim($password)));
    }

    /**
     * Object selection
     *
     * @param array   $data       Conditionals and Order values
     * @param integer $limit      Limit
     * @param integer $limitStart Limit start
     * @param int     $total      Total rows found
     *
     * @return array Objects found
     */
    public static function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `users` WHERE 1=1 ";
        //Total
        $total = count($db->Query($query));
        if ($total) {
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                if (@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".$data['order']."` ".$data['orderDir'];
                }
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query);
            if (count($rows)) {
                foreach ($rows as $row) {
                    $results[] = new User($row);
                }

                return $results;
            }
        }
    }

    /**
     * Get an User by email
     *
     * @param string  $email    Email to search
     * @param integer $ignoreId User id to be ignored (optional)
     *
     * @return bool|object User
     */
    public static function getUserByEmail($email, $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `users` WHERE email = :email";
        $params[":email"] = $email;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new User($rows[0]);
        }
    }

    /**
     * Get an User by username
     *
     * @param string  $username Username to search
     * @param integer $ignoreId User id to be ignored (optional)
     *
     * @return bool|object User
     */
    public static function getUserByUsername($username, $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `users` WHERE username = :username";
        $params[":username"] = $username;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if (count($rows)) {
            return new User($rows[0]);
        }
    }

    /**
     * Get an User by Recovery hash
     *
     * @param string $hash Hash to search
     *
     * @return bool|object User
     */
    public static function getUserByRecoveryHash($recoveryHash)
    {
        $db = Registry::getDb();
        $rows = $db->query("SELECT * FROM `users` WHERE recoveryHash = :recoveryHash",
            array(
                ":recoveryHash" => $recoveryHash
            )
        );
        if (count($rows)) {
            return new User($rows[0]);
        }
    }

    /**
     * Sends a recovery email to current User
     *
     * @return bool
     */
    public function sendRecovery()
    {
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
        if ($mailer->send()) {
            return true;
        } else {
            Registry::addMessage(Registry::translate("MODL_USER_RECOVERY_EMAIL_ERROR"), "error");
        }
    }
}
