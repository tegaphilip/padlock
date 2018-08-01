<?php

namespace App\Models;

use App\Library\Utils;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Di;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\MetaData\Memory;

/**
 * Class BaseModel
 * @property string created_at
 * @property string updated_at
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @author Tega Oghenekohwo <tega@cottacush.com>
 */
class BaseModel extends Model
{
    use Utils;

    private static $lastErrorMessage;

    /**
     * Set created_at before validation
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     */
    public function beforeValidationOnCreate()
    {
        $this->created_at = $this->getCurrentDateTime();
        $this->updated_at = $this->getCurrentDateTime();
    }

    /**
     * Set created_at before validation
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     */
    public function beforeValidationOnUpdate()
    {
        $this->updated_at = $this->getCurrentDateTime();
    }

    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        $called_class = get_called_class();
        /** @var Model $model */
        $model = new $called_class();
        self::fill($data, $model);
        return ($model->save()) ? $model : false;
    }

    /**
     * @author Tega Oghenekohwo <tega@cottacush.com>
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        self::fill($data, $this);
        return ($this->update()) ? $this : false;
    }

    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param array $data
     * @param Model $model
     */
    public static function fill($data, $model)
    {
        $modelAttributes = (new Memory())->getAttributes($model);
        foreach ($data as $key => $value) {
            if (in_array($key, $modelAttributes)) {
                $model->{$key} = $value;
            }
        }
    }

    /**
     * @return Mysql
     */
    public static function getDb()
    {
        /** @var Mysql $db */
        $db = Di::getDefault()->get('db');
        return $db;
    }

    /**
     * Get the primary key of a model
     *
     * @param Model $model
     * @return string
     */
    public static function getPrimaryKeyField(Model $model)
    {
        $metaData = new Memory();
        $keys = $metaData->getPrimaryKeyAttributes($model);
        return !empty($keys) ? $keys[0] : '';
    }
}
