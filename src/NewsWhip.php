<?php
/**
 * NewsWhip API Driver
 *
 * @author  Christopher M. Black <cblack@devonium.com>
 */
namespace NewsWhip;

use GuzzleHttp\Client as GuzzleClient;

class NewsWhip {

	/**
	 * @var string
	 */
	protected $_apiKey = '';

	/**
	 * @var bool
	 */
	protected $_debug = false;

	/**
	 * @var string
	 */
	protected $_baseUri = 'https://api.newswhip.com/v1/';

	/**
	 * @var GuzzleClient
	 */
	static protected $_client;

	/**
	 * NewsWhip constructor.
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array $config
	 */
	public function __construct($config = []) {

		if (empty($config['api_key'])) {
			throw new \RuntimeException('Api Key must be passed into the config!');
		}

		$this->setApiKey($config['api_key']);
		$this->setDebug(
			empty($config['debug'])
				? false
				: $config['debug']
		);

	}

	/**
	 * getClient
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return GuzzleClient
	 */
	public function getClient() {

		if (!self::$_client instanceof GuzzleClient) {
			self::$_client = new GuzzleClient(['base_url' => $this->_baseUri]);
		}

		return self::$_client;

	}

	/**
	 * setClient
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param GuzzleClient|array $client
	 *
	 * @return $this
	 */
	public function setClient($client = []) {

		if ($client instanceof GuzzleClient) {
			self::$_client = $client;
		} elseif (is_array($client)) {

			if (!array_key_exists('base_url', $client)) {
				$client['base_url'] = $this->_baseUri;
			}

			$client['defaults'] = [
				'headers' => ['Content-Type' => 'application/json'],
				'query' => ['key' => $this->getApiKey()]
			];

			self::$_client = new GuzzleClient($client);

		} else {
			throw new \UnexpectedValueException('Client must be an array of settings or an instance of GuzzleClient');
		}

		return $this;

	}

	/**
	 * _fetch
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $uri
	 * @param string $method
	 * @param array  $options
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	private function _fetch($uri, $method = 'post', $options = []) {

		$client = $this->getClient();

		switch (strtolower($method)) {
			case 'get':
				$response = $client->get($uri, $options);
				break;
			case 'post':
				$response = $client->post($uri, ['body' => json_encode($options)]);
				break;
			default:
				throw new \InvalidArgumentException("{$method} is not a supported method param!");
		}

		if ($response->getStatusCode() != 200) {
			throw new \ErrorException($response->getReasonPhrase(), $response->getStatusCode());
		}

		return json_decode(
			$response->getBody()
				->getContents(),
			true
		);

	}

	/**
	 * getApiKey
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return string
	 */
	public function getApiKey() {

		return $this->_apiKey;
	}

	/**
	 * setApiKey
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param $apiKey
	 *
	 * @return $this
	 */
	public function setApiKey($apiKey) {

		$this->_apiKey = $apiKey;

		return $this;

	}

	/**
	 * getDebug
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return boolean
	 */
	public function getDebug() {

		return $this->_debug;

	}

	/**
	 * setDebug
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param boolean $debug
	 *
	 * @return $this
	 */
	public function setDebug($debug) {

		$this->_debug = (boolean) $debug;

		return $this;

	}

	/**
	 * getByRegion
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $region
	 * @param string $category
	 * @param int    $timePeriod
	 * @param int    $size
	 * @param string $sortBy
	 * @param bool   $videoOnly
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getByRegion($region, $category, $timePeriod, $size = 100, $sortBy = 'default', $videoOnly = false) {

		return $this->_fetch(
			'region/' . urlencode($region) . '/' . urlencode($category) . '/' . $timePeriod,
			'get',
			['query' => ['size' => $size, 'sort_by' => $sortBy, 'video_only' => $videoOnly]]
		);

	}

	/**
	 * getByPublisher
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $publisher
	 * @param int    $timePeriod
	 * @param int    $size
	 * @param string $sortBy
	 * @param bool   $videoOnly
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getByPublisher($publisher, $timePeriod, $size = 100, $sortBy = 'default', $videoOnly = false) {

		return $this->_fetch(
			'publisher/' . urlencode($publisher) . '/' . $timePeriod,
			'get',
			['query' => ['size' => $size, 'sort_by' => $sortBy, 'video_only' => $videoOnly]]
		);

	}

	/**
	 * getByCity
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $city
	 * @param int    $timePeriod
	 * @param int    $size
	 * @param string $sortBy
	 * @param bool   $videoOnly
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getByCity($city, $timePeriod, $size = 100, $sortBy = 'default', $videoOnly = false) {

		return $this->_fetch(
			'local/' . urlencode($city) . '/' . $timePeriod,
			'get',
			['query' => ['size' => $size, 'sort_by' => $sortBy, 'video_only' => $videoOnly]]
		);

	}

	/**
	 * getBySearch
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param string $search
	 * @param int    $size
	 * @param string $sortBy
	 * @param bool   $videoOnly
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getBySearch($search, $size = 100, $sortBy = 'default', $videoOnly = false) {

		return $this->_fetch(
			'search',
			'get',
			['query' => ['size' => $size, 'sort_by' => $sortBy, 'video_only' => $videoOnly, 'q' => $search]]
		);

	}

	/**
	 * getRegionsAndCategories
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getRegionsAndCategories() {

		return $this->_fetch('region', 'get');

	}

	/**
	 * getCitiesAndLocalRegions
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getCitiesAndLocalRegions() {

		return $this->_fetch('local', 'get');

	}

	/**
	 * getSamplePublishers
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 * @throws \ErrorException
	 */
	public function getSamplePublishers() {

		return $this->_fetch('publisher', 'get');

	}

	/**
	 * getArticles
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array       $filters
	 * @param int|null    $from
	 * @param int|null    $to
	 * @param string      $language
	 * @param string      $sortBy
	 * @param bool        $videoOnly
	 * @param string|null $defaultField
	 * @param int|null    $size
	 * @param bool        $findRelated
	 *
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 */
	public function getArticles($filters = [],
		$from = null,
		$to = null,
		$language = 'en',
		$sortBy = 'default',
		$videoOnly = false,
		$defaultField = null,
		$size = null,
		$findRelated = true) {

		$filters = $this->_processFilters($filters);

		if (empty($filters)) {
			throw new \InvalidArgumentException('At least one filter must be passed');
		}

		$options = array_filter(
			[
				'filters' => $filters,
				'from' => $from,
				'to' => $to,
				'language' => $language,
				'sort_by' => $sortBy,
				'video_only' => $videoOnly,
				'default_field' => $defaultField,
				'size' => $size,
				'find_related' => $findRelated
			]
		);

		return $this->_fetch('articles', 'post', $options);

	}

	/**
	 * getArticleStats
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array       $filters
	 * @param string      $sortBy
	 * @param string      $aggregateBy
	 * @param int|null    $from
	 * @param int|null    $to
	 * @param string      $language
	 * @param bool        $videoOnly
	 * @param string|null $defaultField
	 * @param int|null    $size
	 *
	 * @return \GuzzleHttp\Stream\StreamInterface|null
	 */
	public function getArticleStats($filters,
		$sortBy,
		$aggregateBy,
		$from = null,
		$to = null,
		$language = 'en',
		$videoOnly = false,
		$defaultField = null,
		$size = null) {

		if (empty($filters)) {
			throw new \InvalidArgumentException('At least one filter must be passed');
		}

		$filters = $this->_processFilters($filters);

		$options = array_filter(
			[
				'filters' => $filters,
				'from' => $from,
				'to' => $to,
				'language' => $language,
				'sort_by' => $sortBy,
				'aggregate_by' => $aggregateBy,
				'video_only' => $videoOnly,
				'default_field' => $defaultField,
				'size' => $size
			]
		);

		return $this->_fetch('stats', 'post', $options);

	}

	/**
	 * _processFilters
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @param array|string $filters
	 * @param bool         $autoFormat
	 *
	 * @return string
	 * @throws \Exception
	 */
	protected function _processFilters($filters, $autoFormat = true) {

		if (empty($filters) || (!is_array($filters) && !is_string($filters))) {
			throw new \InvalidArgumentException('filters should be an associative array of strings or a string');
		}

		if (is_string($filters)) {

			if ($autoFormat && str_word_count($filters) > 1) {
				return '"' . $filters . '"';
			}

			return $filters;

		}

		$searchStrings = [];

		foreach ($filters as $filterField => $filter) {

			$prependStr = '';

			if (is_string($filterField)) {

				if (!array_key_exists($filterField, NewsWhipDefinitions::$postFilterFields)) {
					throw new \Exception("Invalid filter field passed ({$filterField}).");
				}

				$prependStr = "{$filterField}: ";

			}

			if ($autoFormat) {

				if (is_array($filter)) {
					$filter = '(' . implode(' OR ', $filter) . ')';
				} elseif (str_word_count($filter) > 1) {
					$filter = '"' . $filter . '"';
				}

			} else {

				if (is_array($filter)) {
					$filter = '(' . implode(' ', $filter) . ')';
				}

			}

			$searchStrings[] = $prependStr . $filter;

		}

		return implode(' AND ', $searchStrings);

	}

	/**
	 * getCategoryHierarchy
	 *
	 * @author  Christopher M. Black <cblack@devonium.com>
	 *
	 * @return array
	 */
	public static function getCategoryHierarchy() {

		$categories = [];

		foreach (NewsWhipDefinitions::$newsWhipCategoryHierarchy as $parentKey => $children) {
			$categoryChildren = [];
			if (!empty($children)) {
				foreach ($children as $child) {
					$categoryChildren[] = ['id' => $child, 'name' => NewsWhipDefinitions::$newsWhipCategories[$child]];
				}
			}
			$categories[] = [
				'id' => $parentKey,
				'name' => NewsWhipDefinitions::$newsWhipCategories[$parentKey],
				'children' => $categoryChildren
			];
		}

		return $categories;

	}

}
