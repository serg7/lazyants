<?php

namespace LazyAnts\Bundle\ApiBundle\Tests\Util;

use LazyAnts\Bundle\ApiBundle\Util\Helper;



class HelperTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateDateByFormat()
    {
        $is_correct = Helper::validateDateByFormat('2012-11-11');

        $this->assertTrue($is_correct);
    }


}