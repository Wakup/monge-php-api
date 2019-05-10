<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-14
 * Time: 11:45
 */

namespace Wakup;


class FinancialPromotion
{
    private $id, $name;

    /**
     * FinancialPromotion constructor.
     * @param $id string Financial promotion identifier
     * @param $name string Financial promotion internal name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    /**
     * @return int Financial promotion identifier
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id Financial promotion identifier
     */
    public function setIdPromocion(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string Financial promotion internal name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setPromocion($name): void
    {
        $this->name = $name;
    }


}