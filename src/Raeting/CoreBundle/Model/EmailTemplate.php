<?php

namespace Raeting\CoreBundle\Model;

class EmailTemplate {

    protected $conn;
    /**
     * 
     * @param type $conn
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    /**
     * 
     * @param sting $slug
     * @param ing $languageId
     * 
     * @return array
     */
    public function getBySlug($slug)
    {

        $query = 'SELECT * FROM email_template WHERE slug = :slug LIMIT 0, 1';

        $statement = $this->conn->prepare($query);
        $statement->bindValue(':slug', $slug);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }
}