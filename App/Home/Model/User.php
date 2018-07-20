<?php
/**
 * Created by PhpStorm.
 * User: yangcai
 * Date: 2018/5/16
 * Time: 17:26
 */

namespace Home\Model;

use Core\AbstractInterface\AModel as Model;


/**
 * Class User
 * @package Home\Model
 */
class User extends Model
{
    protected $autoWriteTimestamp = true;

    protected $id;
    protected $name;
    protected $sex;
    protected $phone;

    public static function init()
    {
        self::event('before_insert', function ($table) {
            $table->sex = \mt_rand(0, 1);
        });
    }
}
