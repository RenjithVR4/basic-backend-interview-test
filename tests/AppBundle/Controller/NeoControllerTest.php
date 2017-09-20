<?php 

namespace test\AppBundle\Controller;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\NeoController;
use AppBundle\Entity\NeoData;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;

class NeoControllerTest extends KernelTestCase
{
	// I did not make new data for test. used the DB data for testing. Here there is no Insert Cases. If there are some insert cases, then I could insert some dummy data.
	public function testgetHazardousAsteroid()
	{

		self::bootKernel();
		$em = static::$kernel->getContainer()
            			     ->get('doctrine')
            			     ->getManager();

		$hazardous_asteroids = $em->getRepository(NeoData::class)
            				  ->getHazardousAsteroid();

		$expected_count =count($hazardous_asteroids);
		$this->assertEquals(29, $expected_count);
	}

	public function testgetFastestAsteroid()
	{

		self::bootKernel();
		$em = static::$kernel->getContainer()
            			     ->get('doctrine')
            			     ->getManager();
		$haz_value = 0;

		$fastest_asteroid = $em->getRepository(NeoData::class)
            			       ->getFastestAsteroid($haz_value);

		$this->assertEquals(109896.3078678745, $fastest_asteroid[0]['speed']);

		$haz_value = 1;

		$fastest_asteroid = $em->getRepository(NeoData::class)
            			       ->getFastestAsteroid($haz_value);

		$this->assertEquals(27105.0378727072, $fastest_asteroid[0]['speed']);
		
	}

	public function testgetbestYear()
	{
		//I don't think that I need to write some PHP code here for date. But I did. I hope this is not the right method!

		$expected = "";
		self::bootKernel();
		$em = static::$kernel->getContainer()
            			     ->get('doctrine')
            			     ->getManager();
		$haz_value = 0;

		$best_years = $em->getRepository(NeoData::class)
            			       ->getAsteroidYears($haz_value);

            	$years = array();
	   	foreach($best_years as $year)
	   	{
	   		array_push($years,$year['year']);
	   	}

	   	$year_count_values = array_count_values($years); 
	   	$best_asteroid_year = array_search(max($year_count_values), $year_count_values);		     

		$this->assertEquals(2017, $best_asteroid_year);

		$haz_value = 1;

		$fastest_asteroid = $em->getRepository(NeoData::class)
            			       ->getAsteroidYears($haz_value);

            	$years = array();
	   	foreach($best_years as $year)
	   	{
	   		array_push($years,$year['year']);
	   	}

	   	$year_count_values = array_count_values($years); 
	   	$best_asteroid_year = array_search(max($year_count_values), $year_count_values);		     

		$this->assertEquals(2017, $best_asteroid_year);

		
	}

	public function testgetbestMonth()
	{
		//I don't think that I need to write some PHP code here for date. But I did. I hope this is not the right method!
		$expected = "";
		self::bootKernel();
		$em = static::$kernel->getContainer()
            			     ->get('doctrine')
            			     ->getManager();
		$haz_value = 0;

		$best_months = $em->getRepository(NeoData::class)
            			       ->getAsteroidMonths($haz_value);

            	$months = array();
	   	foreach($best_months as $month)
	   	{
	   		array_push($months,$month['month']);
	   	}

	   	$month_count_values = array_count_values($months); 
	   	$max_asteroid_month = array_search(max($month_count_values), $month_count_values);		     
     		
	   	$this->assertEquals('09', $max_asteroid_month);

		$haz_value = 1;

		$best_months = $em->getRepository(NeoData::class)
            			       ->getAsteroidMonths($haz_value);

		$months = array();
	   	foreach($best_months as $month)
	   	{
	   		array_push($months,$month['month']);
	   	}

	   	$month_count_values = array_count_values($months); 
	   	$max_asteroid_month = array_search(max($month_count_values), $month_count_values);		     

		$this->assertEquals('09', $max_asteroid_month);

		
	}
}
