<?php 

class InstagramService {

	private $client;

	public function __construct() 
	{
		$this->client = new \GuzzleHttp\Client([
		    'verify' => false,
		    'headers' => [
		        'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_3_1 como Mac OS X) AppleWebKit/605.1.15 (KHTML, como Gecko) Mobile/15E148 Instagram 105.0.0.11.118 (iPhone11,8; iOS 12_3_1; en_US; en-US; escala =2,00; 828x1792; 165586599)',
		        'Accept'     => 'application/json',
		    ]
		]);
	}

	public function getLocationData(string $locationId) 
	{
		$response = $this->client->request('GET', 'https://www.instagram.com/api/v1/locations/web_info/?location_id='.$locationId);
		return json_decode($response->getBody(), true);
	}
}