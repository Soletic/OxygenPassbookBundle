<?php
/**
 * Created by PhpStorm.
 * User: lolozere
 * Date: 23/09/2015
 * Time: 15:09
 */

namespace Oxygen\PassbookBundle\Model;

/**
 * Represent the type of products proposed in the event
 *
 * @package Oxygen\PassbookBundle\Model
 */
abstract class EventTypeModel
{

    protected $id;
    /**
     * @var string
     */
    protected $name;

    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}