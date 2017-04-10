<?php
/**
 * @author Liao Gengling <liaogling@gmail.com>
 */
use Planfox\Component\Config\Repository;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testData()
    {
        $repository = new Repository();
        $repository->setDirectory(__DIR__ . '/config');

        $this->assertEquals('This is app name.', $repository->get('app.app_name'));

        $this->assertEquals('127.0.0.1', $repository->get('database.connections.mysql.host'));

    }
}