<?php


namespace LazyAnts\Bundle\ApiBundle\Util;

/**
 * Contains some helpful functions
 *
 * Class Helper
 * @package LazyAnts\Bundle\ApiBundle\Util
 */
class Helper
{
    /**
     * Validating date by format. Should looks like: Y-m-d
     *
     * @param $date
     * @return bool
     */
    static function validateDateByFormat($date)
    {
        $dt = \DateTime::createFromFormat("Y-m-d", $date);
        return $dt !== false && !array_sum($dt->getLastErrors());
    }

}