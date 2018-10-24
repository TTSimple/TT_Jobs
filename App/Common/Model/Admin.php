<?php
/**
 * Created by PhpStorm.
 * User: safer
 * Date: 2018/6/27
 * Time: 0:53:56
 */

namespace Common\Model;

use Core\AbstractInterface\AModel as Model;

/**
 * Class Admin
 * @package Common\Model
 */
class Admin extends Model
{
    protected $autoWriteTimestamp = true;

    const DELETED   = 1;
    const UN_DELETE = 0;

    /**
     * @var array
     */
    public $snapshotData = [];

    protected function initialize()
    {
        parent::initialize();
        $this->setSnapshotData();
        self::beforeInsert(function () {
            $this->_restPassword();
        });
        self::beforeUpdate(function () {
            try {
                if (
                    ($this->getData('password') != '')
                    and
                    ($this->getData('password') != $this->getSnapshotData('password'))
                ) {
                    $this->_restPassword();
                }
            } catch (\Exception $e) {

            }
        });
    }

    /**
     * @param array $snapshotData
     *
     * @return $this
     */
    function setSnapshotData($snapshotData = [])
    {
        if (empty($snapshotData)) {
            $snapshotData = $this->toArray();
        }
        $this->snapshotData = $snapshotData;
        return $this;
    }

    /**
     * @param null $field
     *
     * @return array|bool
     */
    function getSnapshotData($field = null)
    {
        if (empty($this->snapshotData)) {
            return false;
        }
        if (null === $field) {
            return $this->snapshotData;
        }
        if (false === isset($this->snapshotData[$field])) {
            return false;
        }
        return $this->snapshotData[$field];
    }

    private function _restPassword()
    {
        try {
            if ($this->getData('password')) {
                $this->setAttr('password', md5($this->getData('password')));
            }
        } catch (\Exception $e) {

        }
    }
}