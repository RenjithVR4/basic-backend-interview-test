<?php 

namespace AppBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\NeoData;


/**
* main class
*/
class FetchNasaAsteroidData extends ContainerAwareCommand
{
	
	protected function configure()
	{
		$this->setName('manipulateData:nasa')
            	    ->setDescription('Fetching Nasa asteroid data and insert into the database');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
    	{
        	$em = $this->getContainer()->get('doctrine')->getEntityManager();

        	// date_default_timezone_set("Europe/Berlin");

	        $api_key = "N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD";
	        $three_days_prev = date("Y-m-d", strtotime("-3 days"));
	        $yesterday = date("Y-m-d", strtotime("-1 days"));

	        $service_url = "https://api.nasa.gov/neo/rest/v1/feed?start_date=".$three_days_prev."&end_date=".$yesterday."&detailed=true&api_key=".$api_key;  

	        $curl = curl_init($service_url);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	        $curl_response   = curl_exec($curl);
	        curl_close($curl);

	        $return_result = json_decode($curl_response, true);

	        if(isset($return_result['near_earth_objects']))
        	{
			$near_earth_objects =  $return_result['near_earth_objects'];

			$near_earth_objects_count =  count($near_earth_objects);

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

					$em->persist($neo);

					$i++;
				}
			}

			$em->flush();
			$output->writeln('near_earth_objects_count :'. $near_earth_objects_count);
		}
		else
		{
			$output->writeln('near_earth_objects_count :'. '0');
			$output->writeln('No data fetched and inserted');
		}
	}
		
}