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
    public function getData()
    {
        date_default_timezone_set("Europe/Berlin");

        $api_key = "N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD";
        $three_days_prev = date("Y-m-d", strtotime("-3 days"));
        $yesterday = date("Y-m-d", strtotime("-1 days"));

        $service_url = "https://api.nasa.gov/neo/rest/v1/feed?start_date=".$three_days_prev."&end_date=".$yesterday."&detailed=true&api_key=".$api_key;  

        $curl            = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response   = curl_exec($curl);
        curl_close($curl);

        $return_result = json_decode($curl_response, true);

        return $return_result;
    }

    /**
    * @Route("/getdata", name="getdata") Just used to get and insert data!
    */
    public function manipulateData(Request $request)
    {
        $data = self::getData();
        $return_result = array();       

        if($data)
        {
		$near_earth_objects =  $data['near_earth_objects'];

		$return_result['near_earth_objects_count'] =  count($near_earth_objects);

		$i = 0;

		foreach($near_earth_objects as $keys => $objects)
		{
			$date = $keys;
			foreach($objects as $key => $value)
			{
				$neo = new NeoData;
				$neo->setReference($value['neo_reference_id']); 
				$neo->setName(trim($value['name']));
				$neo->setIsHazardous($value['is_potentially_hazardous_asteroid']); //it's boolean
				$neo->setDate(new \DateTime($date));
				foreach($value['close_approach_data'] as $val)
				{
					$neo->setSpeed($val['relative_velocity']['kilometers_per_hour']);
				}
		
				$em = $this->getDoctrine()->getManager();
				$em->persist($neo);

				$i++;
			}
		}

		$em->flush();
        }

        return $return_result; 
    }

     /**
     * @Route("/neo/hazardous/", name="hazardous")
     */
     public function getHazardousAsteroid(Request $request)
     { 				

     	$em = $this->getDoctrine()->getManager();

	$hazardous_asteroids = $em->getRepository('AppBundle:NeoData')->getHazardousAsteroid();

   	if ($hazardous_asteroids === null)
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