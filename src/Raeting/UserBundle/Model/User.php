<?php

namespace Raeting\UserBundle\Model;

use Raeting\CoreBundle\Model\BaseModel;

/**
 * User model
 */
class User extends BaseModel
{
    const USERGROUP_ADMIN    = 'admin';
    const USERGROUP_CUSTOMER = 'customer';

    public function getTableName()
    {
        return 'user';
    }

    /**
     * Return list of available fields.
     *
     * @return
     */
    public function getFields()
    {
        return array('email', 'usergroup', 'password', 'firstname', 'lastname');
    }

    public function getByEmail($email)
    {
        $query = 'SELECT * FROM user WHERE email = :email LIMIT 1';

        $statement = $this->conn->prepare($query);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function getByEmailAndGroup($email, $group)
    {
        $query = $this->getSelectSql() . ' WHERE u.email = :email AND u.usergroup = :group  LIMIT 1';

        $statement = $this->conn->prepare($query);
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->bindValue(':group', $group, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    /**
     * [getById]
     * @param  $id
     * @return array
     */
    public function getById($id)
    {
        $query = $this->getSelectSql() . ' WHERE u.id = :id LIMIT 1';

        $statement = $this->conn->prepare($query);
        $statement->bindValue(':id', $id, \PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(\PDO::FETCH_ASSOC);

        return $user;
    }

    public function getSelectSql()
    {
        return "SELECT 
                    u.*

                FROM user u
        ";
    }
}
