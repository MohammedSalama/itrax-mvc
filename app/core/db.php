<?php

namespace itrax\core;

//PDO CLASS
use PDO;
use PDOException;

class db 
{
    private $connection;
    private $statement;  // Statement Object - last query [Result]
    private $table;

    //METHODS
    public function __construct()
    {
        $this->connectionToDataBase();
        $this->get_class_name();
    }
    
    // Get Class Name.
    private function get_class_name()
    {
        $table = explode("\\",static::class);
        $table = end($table);
        $this->table = substr($table,0,-5);
        // echo '<pre>';
        // print_r($table);
        // echo '</pre>';
    }

    // connection To DataBase.
    private function connectionToDataBase()
    {
        try{

            $this->connection = new PDO( DSN,DB_USER,DB_PASS);

            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $exception)
        {
            print "Connection failed: " . $exception->getMessage();
            die();
        }

    }

    // Prepares a statement for execution and returns a statement object.
    private function Prepare($query)
    {
      $this->statement = $this->connection->prepare($query);
    }

    /**
     * Executes a prepared statement.
     * @param $data
     * @return bool
     */
    private function Execute($data)
    {
        if($this->statement->execute($data))

        return true;
           return false;
    }

    /**
     * handle PDO errors Method.
     * @param $query
     * @param $error_message
     */
    private function handle_sql_errors($query, $error_message)
    {
        echo '<pre>';
        echo  '<strong style="color: red;">SQL Query: </strong>'.$query;
        echo '</pre>';
        echo '<strong style="color: red;">Error Message: </strong>'.$error_message;
        die;
    }

    /**
     * check value of query string Or intger.
     * @param $array
     * @return mixed
     */
    private function check_array_value($array)
    {

        foreach ($array as $k => $v)
        {
            if(!is_numeric($v) && !intval($v) == $v)
            {
                $v = "'$v'";
            }
        }
        return $array;
    }

    /**
     * Return the number of affected rows via that method [ Like That mysqli_affected_rows ].
     * @return mixed
     */
    private function row_count()
    {
        return $this->statement->rowCount();
    }

    /**
     * Return the number of rows in a result set. [ Like That mysqli_num_rows ].
     * @return mixed
     */
    private function NumRows()
    {
        return $this->statement->fetchColumn();
    }
    
    /**
     * Insert Data To Database Table.
     *
     * @param $data
     * @return bool
     */
    protected function Insert($data)
    {

        // setup some variables for fields columns [database_table] and values.

        $fields = '';

        $values = '';

        foreach ($data as $key => $value)
        {
            $fields .= "`$key`,";

            $values .= ":$key,";

        }

            // remove last Comma , in This Variable.
            $fields = substr($fields, 0, -1);
            // remove last Comma , in This Variable.
            $values = substr($values, 0, -1);

            $query = "INSERT INTO `$this->table` ($fields) VALUES ($values)";

          //  echo $query ;die();
          //  print_r($data);die();


        try
        {
           $this->Prepare($query);

             if($this->Execute($data))

            return true;

                return false;
        }

        catch (PDOException $exception)
        {
            $this->handle_sql_errors($query,$exception->getMessage());
        }

    }

    // Delete Record From Database Table.
    protected function delete($id)
    {
        try
        {

            $query = "DELETE FROM `$this->table` WHERE `$this->table`.`id` = :id";

            $data  = ['id' => $id];

            $this->Prepare($query);

            $result = $this->Execute($data);

            if($result && $this->row_count()>0)

                return true;

            return false;
        }

        catch (PDOException $exception)
        {
            $this->handle_sql_errors($query,$exception->getMessage());
        }


    }

    //  update Data From Database Table.
    protected function update($data,$id)
    {
        $query = '';

        foreach ($data as $key => $value)
        {
            // update query syntax:
            // UPDATE `table_name` SET `column_1` = ':value_1', `column_1` = ':value_2' WHERE some_column=some_value
            $query .= "`$key` = :$key,";
        }

        // remove last Comma , in This Variable.

        $query = substr($query,0,-1);


        // update query syntax:
        // UPDATE `table_name` SET `column_1` = ':value_1', `column_1` = ':value_2' WHERE some_column=some_value
        $queryString = "UPDATE `$this->table` SET $query WHERE `$this->table`.`id` = :id";

        try
        {
            $data["id"] = $id;

            // prepare statement
            $this->Prepare($queryString);

            if($this->Execute($data))

                return true;
            return false;
        }
        catch (PDOException $exception)
        {
            $this->handle_sql_errors($queryString,$exception->getMessage());
        }
    }

    // Select Data From Database Table.
    protected function All($query)
    {

        try
        {

        $statement   = $this->connection->query($query);
        $result      = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(count($result)>0)

            return $result;

        return null;

        }

        catch (PDOException $exception)
        {
           $this->handle_sql_errors($query,$exception->getMessage());
        }


    }

    // Return the number of Records In table.
    protected function select_count($extra='')
    {
        return $this->connection->query("SELECT COUNT(*) FROM `$this->table` $extra")->fetchColumn();
    }

    // close Database connection
    public function __destruct()
    {
        $this->connection = null;
    }
}