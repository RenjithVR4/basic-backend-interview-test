<?php  

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\NeoData;
use Datetime;

class NeoController extends Controller
{
     /**
     * @Route("/neo/hazardous/", name="hazardous")
     */
     public function getHazardousAsteroid(Request $request)
     { 				
     	$haz_value = trim($request->query->getBoolean('hazardous'));
     	$em = $this->getDoctrine()->getManager();

	$hazardous_asteroids = $em->getRepository('AppBundle:NeoData')->getHazardousAsteroid($haz_value);

   	if (count($hazardous_asteroids) == 0)
   	{
   		return new View("data not found", Response::HTTP_NOT_FOUND);
   	}

 	return $hazardous_asteroids;
     }

     /**
     * @Route("/neo/fastest/", name="fastest_hazardous")
     */
     public function getFastestAsteroid(Request $request)
     {

    	$haz_value = trim($request->query->getBoolean('hazardous'));

    	$em = $this->getDoctrine()->getManager();

	$fastest_asteroid = $em->getRepository('AppBundle:NeoData')->getFastestAsteroid($haz_value);
     	
     	if($fastest_asteroid === null)
   	{
   		return new View("data not found", Response::HTTP_NOT_FOUND);
   	}

   	return $fastest_asteroid;

     }

     /**
     * @Route("/neo/best-year/", name="best_year")
     */
     public function bestYear(Request $request)
     {
     	$haz_value = $request->query->getBoolean('hazardous');

     	$em = $this->getDoctrine()->getManager();

	$best_years = $em->getRepository('AppBundle:NeoData')->getAsteroidYears($haz_value);

     	if($best_years === null)
   	{
   		return new View("data not found", Response::HTTP_NOT_FOUND);
   	}

   	$years = array();
   	foreach($best_years as $year)
   	{
   		array_push($years,$year['year']);
   	}

   	$year_count_values = array_count_values($years); 
   	$best_asteroid_year = array_search(max($year_count_values), $year_count_values);

   	return $best_asteroid_year;
     	
     }


      /**
     * @Route("/neo/best-month/", name="best_month")
     */
     public function bestMonth(Request $request)
     {
     	$haz_value = $request->query->getBoolean('hazardous');

     	$em = $this->getDoctrine()->getManager();

	$best_months = $em->getRepository('AppBundle:NeoData')->getAsteroidMonths($haz_value);

     	if($best_months === null)
   	{
   		return new View("data not found", Response::HTTP_NOT_FOUND);
   	}

   	$months = array();
   	foreach($best_months as $month)
   	{
   		array_push($months,$month['month']);
   	}

   	$month_count_values = array_count_values($months); 
   	$max_asteroid_month = array_search(max($month_count_values), $month_count_values);

   	$bestmonth = DateTime::createFromFormat('!m', $max_asteroid_month);

   	return $bestmonth->format('F');
     	
     }




}