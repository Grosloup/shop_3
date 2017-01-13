<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 00:09
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function itCanReturnItsName()
    {
        $cd = new Command();

        $this->assertEquals("Command", $cd->getInternalName());
    }

    /** @test */
    public function itCanReturnItsHandlerName()
    {
        $cd = new Command();

        $this->assertEquals("CommandHandler", $cd->getHandlerName());
    }
}