<?php

namespace Raeting\CoreBundle\Model;

abstract class BaseModel
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $conn;

    public function __construct(\Doctrine\DBAL\Connection $conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $query = 'SELECT * FROM `' . $this->getTableName() . '`';
        $statement = $this->conn->executeQuery($query);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Return row from model table by it's id.
     * 
     * @param int $id 
     *
     * @return array
     */
    public function getById($id)
    {
        $query = 'SELECT * FROM `' . $this->getTableName() . '` WHERE id = :id LIMIT 1';
        $statement = $this->conn->executeQuery($query, array('id' => $id));
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return row from model table by it's slug.
     * 
     * @param string $slug
     *
     * @return array
     */
    public function getBySlug($slug)
    {
        $query = 'SELECT * FROM `' . $this->getTableName() . '` WHERE slug = :slug LIMIT 1';
        $statement = $this->conn->executeQuery($query, array('slug' => $slug));
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Return row from model table by attributes specified
     * 
     * @param array $attributes 
     *
     * @return array
     */
    public function getByAttributes(array $attributes)
    {
        $wheres = array();
        $bindings = array();
        foreach ($attributes AS $attr => $value) {
            $wheres[] = '`' . $attr . '` = :' . $attr;
            $bindings[$attr] = $value;
        }

        $query = 'SELECT * FROM `' . $this->getTableName() . '` WHERE ';
        $query .= implode(' AND ', $wheres);
        $query .= ' LIMIT 1';
        $statement = $this->conn->executeQuery($query, $bindings);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Insert data into model table.
     * 
     * @param array $data 
     *
     * @return int Record id in database.
     */
    public function insert(array $data)
    {
        $this->conn->insert('`' . $this->getTableName() . '`', $data);
        return $this->conn->lastInsertId();
    }

    /**
     * Update model data.
     * 
     * @param array $data 
     * @param array $identifier 
     *
     * @return int Number of affected rows.
     */
    public function update(array $data, array $identifier)
    {
        return $this->conn->update('`' . $this->getTableName() . '`', $data, $identifier);
    }

    /**
     * Delete record from db.
     * 
     * @param array $identifier 
     */
    public function delete(array $identifier)
    {
        return $this->conn->delete('`' . $this->getTableName() . '`', $identifier);
    }

    /**
     * Database table name which is used by model for basic methods,
     * such as getAll(), getById(), etc...
     * @return string
     */  
    abstract public function getTableName();
}
