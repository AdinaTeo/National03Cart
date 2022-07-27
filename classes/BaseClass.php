<?php


abstract class BaseClass
{
    private $id;

    abstract public static function getTableName();

    public function fromArray($data)
    {
        foreach ($data as $key=>$value){
            $this->$key = $value;
        }
    }

    protected function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @param null $filterColumn
     * @param null $filterValue
     * @param null $orderColumn
     * @param string $orderDir
     * @param null $limit
     * @param int $offset
     * @return static[]
     */
    public static function findBy($filterColumn=null, $filterValue=null, $orderColumn=null, $orderDir='ASC', $limit=null, $offset=0)
    {
        global $conn;
        $tableName = static::getTableName();

        $className = static::class;

        $sql = "SELECT * FROM $tableName ";

        if (!is_null($filterColumn)){
            $sql = $sql." WHERE `$filterColumn`='".mysqli_real_escape_string($conn, $filterValue)."' ";
        }

        if (!is_null($orderColumn)){
            $sql = $sql." ORDER BY $orderColumn $orderDir ";
        }

        if (!is_null($limit)){
            $sql = $sql." LIMIT $offset,$limit;";
        }

        $data = runQuery($sql);

        $objectList = [];

        foreach ($data as $datum){
            $obj = new $className();
            //var_dump($obj);
            $obj->fromArray($datum);
            // var_dump($obj);die;
            $objectList[] = $obj;
        }

        return $objectList;
    }

     static function find($id){
        return self::findOneBy('id',$id);
    }

    static function findOneBy($filterColumn=null, $filterValue=null, $orderColumn=null, $orderDir='ASC', $offset=0)
    {
        $data = self::findBy($filterColumn, $filterValue, $orderColumn, $orderDir, 1, $offset);

        if (isset($data[0])){
            return $data[0];
        } else {
            return null;
        }
    }

    public static function findAll($orderColumn=null, $orderDir='ASC')
    {
        return self::findBy( null, null, $orderColumn, $orderDir);
    }

    public function save(){
        if (isset($this->id)){
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    protected function insert(){
        global $conn;
        $data = $this->toArray();
        $tableName = static::getTableName();
        $columnsString = '';
        $valuesString = '';
        foreach ($data as $column => $value){
            if($column != 'id'){
                $columnsString = $columnsString."`$column`, ";
                $valuesString = $valuesString."'".mysqli_real_escape_string($conn,$value)."', ";
            };
        }
        $columnsString = rtrim($columnsString, ", ");
        $valuesString = rtrim($valuesString, ", ");
        $sql = "INSERT INTO $tableName ($columnsString) VALUES ($valuesString);";

        $this->id = runQuery($sql);
    }

    protected function update(){
        global $conn;
        $data = $this->toArray();
        $tableName = static::getTableName();
        $id = $this->id;
        $setsString = '';
        foreach ($data as $column => $value){
            $setsString = $setsString."`$column`='".mysqli_real_escape_string($conn, $value)."', ";
        }
        $setsString = rtrim($setsString, ", ");

        $sql = "UPDATE `$tableName` SET $setsString WHERE  `id`=$id;";

        return runQuery($sql);

    }

    public function delete(){
        $tableName = static::getTableName();
        $id = $this->id;
        $sql = "DELETE FROM `$tableName` WHERE  `id`=$id;";

        return runQuery($sql);

    }
}