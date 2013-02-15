<?php

class bootstrap {


	private $setApplicationName;
	private $setDeveloperKey;
	private $keywords;
	private $service;
	private $categories_array;
	private $magpie;
	private $categories;

	function __construct($keywords,$setApplicationName,$setDeveloperKey,$categories_array) {
		
		require_once 'lib/google/apiClient.php';
		require_once 'lib/google/contrib/apiShoppingService.php';
		require_once 'lib/magpie/rss_fetch.inc';

		$this->setApplicationName = $setApplicationName;
		$this->setDeveloperKey = $setDeveloperKey;
		$this->keywords = $keywords;
		$this->categories_array = $categories_array;
	}

	function getCategories(){

		$this->categories = array();
		foreach ($this->categories_array as $key => $value){

			// Get Category Nam
			array_push($this->categories, $key);
		}	

		return $this->categories;

	}

	function displayFeeds(){
		$mobile_app_data = array();
		foreach ($this->categories_array as $key => $value){

			// Get Category Nam
			$category_name = $key;
			$feed_data = array();


			// Loop through Data and dump in
			foreach($value as $feed){
				$num_items = 4;
				$rss = fetch_rss( $feed );
				$items = array_slice($rss->items, 0, $num_items);

				foreach($items as $item){

			
					$formated_data = array();
					$formated_data['title'] = $item['title'];
					$formated_data['link'] = $item['link'];
					$formated_data['author'] = $item['author_name'];
					$formated_data['link'] = $item['link'];
					$formated_data['published'] = date("M j, Y", strtotime($item['published']));


		
					if (isset($item['content']['encoded'])){

						$content = $item['content']['encoded'];


					} elseif(isset($item['atom_content'])){

						$content = $item['atom_content'];

					} else{

						$content = $item['description'];
					}


					preg_match_all('/<img[^>]+>/i',$content, $result);
					$formated_data['description'] = substr(utf8_encode($content),0,2000);
					$formated_data['thumbnail'] = ($result[0][0]);

					$doc = new DOMDocument();
					$doc->loadHTML($formated_data['thumbnail'] );
					$xpath = new DOMXPath($doc);
					$formated_data['thumbnail_image'] = $src = $xpath->evaluate("string(//img/@src)");


					$pos = strpos(strtolower($formated_data['thumbnail']) , ".jpg");
					$pos2 = strpos(strtolower($formated_data['thumbnail']) , ".png");
					if ($pos || $pos2){
						array_push($feed_data,$formated_data);

					}

				}

			}

			$data_object = array(
				'category' => $category_name,
				'feeds' => $feed_data
			);


			$feed_data = array();

			array_push($mobile_app_data,$data_object);
			
		}


		//var_dump($mobile_app_data);
		return ($mobile_app_data);
	}

	function displayProducts(){

		$client = new apiClient();
		$client->setApplicationName($this->setApplicationName);
		$client->setDeveloperKey($this->setDeveloperKey);
		$service = new apiShoppingService($client);
		$source = "public";
		$rand = rand(1, count($this->keywords));
		$query = "mens " . $this->keywords[$rand];
		$ranking = "relevancy";

		$results = $service->products->listProducts($source, array(
				"country" => "US",
				"q" => $query,
				"rankBy" => $ranking,
			));

		$count = (count($results) > 20 ? 20 : count($results) );
		$results_array = array();

		for ($i = 0; $i < $count; $i++){
			$results_obj = array(
				'title' => $results['items'][$i]['product']['title'],
				'description' => $results['items'][$i]['product']['description'],
				'link' => $results['items'][$i]['product']['link'],
				'brand' => $results['items'][$i]['product']['brand'],
				'condition' => $results['items'][$i]['product']['condition'],
				'price' => $results['items'][$i]['product']['inventories'][0]['price'],
				'shipping' => $results['items'][$i]['product']['inventories'][0]['shipping'],
				'availability' => $results['items'][$i]['product']['inventories'][0]['availability'],
				'image' => $results['items'][$i]['product']['images'][0]['link']
			);

			array_push($results_array,$results_obj);
		}

		
		$products = ($results_array);
		return $products;
	}

}
?>