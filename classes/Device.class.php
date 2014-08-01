<?php

/**
 * Device Class
 */
class Device extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;

    /**
     * TypeId
     * @var int
     */
    public $typeId;

    /**
     * UserId
     * @var int
     */
    public $userId;

    /**
     * Push Token
     * @var string
     */
    public $pushToken;

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
    public $lastVisitDate;

    /**
     * Types
     * @var array
     */
    public $types = array(
        1 => "Android",
        2 => "iOS"
    );

    /**
     * Reserved vars (not at database table)
     * @var array
     */
    public static $reservedVarsChild = array("types");

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "devices";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Pre-Insert actions
     *
     * @return void
     */
    public function preInsert()
    {
        //Creation Date
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    /**
     * Pre-Update actions
     *
     * @return void
     */
    public function preUpdate()
    {
        //Update Date
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    /**
     * Device login.
     *
     * If device exist
     * @param  string $pushToken
     * @param  int    $userId
     * @param  int    $typeId
     * @return bool
     */
    public static function login($pushToken, $userId, $typeId) {
        //Device exists?
        $device = @current(Device::getBy("pushToken", $pushToken));
        if ($device) {
            $device->userId = $userId;
            $device->lastVisitDate = date("Y-m-d H:i:s");
            return $device->update();
        } else {
            $device = new Device();
            $device->userId = $userId;
            $device->typeId = $typeId;
            $device->pushToken = $pushToken;
            $device->lastVisitDate = date("Y-m-d H:i:s");
            return $device->insert();
        }
    }
}
