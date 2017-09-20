<?php 

namespace test\AppBundle\Controller;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\DefaultController;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NeoControllerTest extends KernelTestCase
{
	public function testrootMessage()
	{
		$default_controller = new DefaultController();
		$result = $default_controller->indexAction();
		$expected = array("hello" => "world");
		$this->assertEquals($expected, $result);
	}
}
