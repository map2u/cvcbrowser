<?php

namespace Yorku\JuturnaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dictionaries
 *
 * @ORM\Table(name="dictionaries")
 * @ORM\Entity
 */
class Dictionaries
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="dictionaries_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="table_name", type="string", length=20, nullable=true)
     */
    private $tableName;

    /**
     * @var string
     *
     * @ORM\Column(name="column_name", type="string", length=30, nullable=true)
     */
    private $columnName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="data_type", type="string", length=40, nullable=true)
     */
    private $dataType;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tableName
     *
     * @param string $tableName
     * @return Dictionaries
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    
        return $this;
    }

    /**
     * Get tableName
     *
     * @return string 
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * Set columnName
     *
     * @param string $columnName
     * @return Dictionaries
     */
    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;
    
        return $this;
    }

    /**
     * Get columnName
     *
     * @return string 
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Dictionaries
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dataType
     *
     * @param string $dataType
     * @return Dictionaries
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    
        return $this;
    }

    /**
     * Get dataType
     *
     * @return string 
     */
    public function getDataType()
    {
        return $this->dataType;
    }
}