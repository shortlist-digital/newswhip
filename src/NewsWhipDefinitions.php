<?php
/**
 * NewsWhip API Definitions
 *
 * @author  Christopher M. Black <cblack@devonium.com>
 */
namespace NewsWhip;

class NewsWhipDefinitions {

	/**
	 * @var array $postFilterFields fields that can be used for filtering post requests
	 */
	static public $postFilterFields = [
		'headline' => ['label' => 'Headline'],
		'summary' => ['label' => 'Summary'],
		'authors' => ['label' => 'Authors'],
		'country_code' => ['label' => 'Country Code'],
		'region_code' => ['label' => 'Region Code'],
		'language' => ['label' => 'Language'],
		'categories' => ['label' => 'Categories'],
		'publisher' => ['label' => 'Publisher'],
		'domain' => ['label' => 'Domain'],
		'href' => ['label' => 'Link']
	];

	/**
	 * @var array $postArticlesParams array of valid article parameters
	 *      Options:
	 *      - (*) filters (array[string]):
	 *                  List of Lucene QueryString filters to be applied to the articles. See available fields for filtering below.
	 *      - from (int - Unix timestamp in milliseconds) (default: -1 week):
	 *                  Filters articles published after {from}.
	 *      - to (int - Unix timestamp in milliseconds) (default: Now):
	 *                  Filters articles published before {to}.
	 *      - language (string - Two letter ISO 639-1 language code) (default: Any)
	 *      - sort_by (string) (default: default):
	 *                  One of the following: default, fb_likes, fb_shares, fb_comments, fb_total, twitter, linkedin,
	 *                  fb_tw_and_li, nw_score, nw_max_score, created_at.
	 *      - video_only (boolean) (default: false)
	 *      - default_field (string) (default: Relevant fields):
	 *                  Field to be used when filtering by keywords and no fields are used in the query string.
	 *      - size (int):
	 *                  Max number of articles to be returned (includes related stories.)
	 *      - find_related (boolean) (default: true)
	 *                  Related stories will be collapsed when set.
	 */
	static public $postArticlesParams = [
		'filters' => [
			'type' => [
				'string',
				'array'
			],
			'required' => true
		],
		'from' => [
			'type' => 'timestamp'
		],
		'to' => [
			'type' => 'timestamp'
		],
		'language' => [
			'type' => 'string'
		],
		'sort_by' => [
			'type' => 'string',
			'options' => [
				'default' => ['label' => 'Default'],
				'fb_likes' => ['label' => 'Facebook Likes'],
				'fb_shares' => ['label' => 'Facebook Shares'],
				'fb_comments' => ['label' => 'Facebook Comments'],
				'fb_total' => ['label' => 'Facebook Overall'],
				'twitter' => ['label' => 'Twitter'],
				'linkedin' => ['label' => 'LinkedIn'],
				'fb_tw_and_li' => ['label' => 'Facebook, Twitter and LinkedIn'],
				'nw_score' => ['label' => 'Score'],
				'nw_max_score' => ['label' => 'Max Score'],
				'created_at' => ['label' => 'Created']
			]
		],
		'video_only' => [
			'type' => 'boolean'
		],
		'default_field' => [
			'type' => 'string'
		],
		'size' => [
			'type' => 'int'
		],
		'find_related' => [
			'type' => 'boolean'
		]
	];

	/**
	 * @var array $postStatsParams array of valid stat parameters
	 *      Options:
	 *      - (*) filters (array[string]):
	 *                  List of Lucene QueryString filters to be applied to the articles. See available fields for filtering below.
	 *      - (*) sort_by (string - {aggregation_name}.{stat_value}):
	 *                  {aggregation_name} is one of fb_likes, fb_shares, fb_comments, fb_total, twitter, linkedin, pinterest and
	 *                  {stat_value} is one of count, min, max, avg, sum, sum_of_squares, variance, std_dev.
	 *      - (*) aggregate_by (string):
	 *                  Groups all matched stories by any of the following: publisher, domains, domain, language, authors,
	 *                  country, categories
	 *      - from (int - Unix timestamp in milliseconds) (default: -1 week):
	 *                  Filters articles published after {from}.
	 *      - to (int - Unix timestamp in milliseconds) (default: Now):
	 *                  Filters articles published before {to}.
	 *      - language (string - Two letter ISO 639-1 language code) (default: Any)
	 *      - video_only (boolean) (default: false)
	 *      - default_field (string) (default: Relevant fields):
	 *                  Field to be used when filtering by keywords and no fields are used in the query string.
	 *      - size (int):
	 *                  Max number of aggregations to be returned.
	 *
	 *      (*) denotes required
	 */
	static public $postStatsParams = [
		'filters' => [
			'type' => [
				'string',
				'array'
			],
			'required' => true
		],
		'from' => [
			'type' => 'timestamp'
		],
		'to' => [
			'type' => 'timestamp'
		],
		'language' => [
			'type' => 'string'
		],
		'sort_by' => [
			'type' => 'string',
			'required' => true,
			'options' => [],
			'aggregate_name_options' => [
				'fb_likes' => ['label' => 'Facebook Likes'],
				'fb_shares' => ['label' => 'Facebook Shares'],
				'fb_comments' => ['label' => 'Facebook Comments'],
				'fb_total' => ['label' => 'Facebook Overall'],
				'twitter' => ['label' => 'Twitter'],
				'linkedin' => ['label' => 'LinkedIn'],
				'pinterest' => ['label' => 'Pinterest']
			],
			'stat_value_options' => [
				'count' => ['label' => 'Count'],
				'min' => ['label' => 'Min'],
				'max' => ['label' => 'Max'],
				'avg' => ['label' => 'Avg'],
				'sum' => ['label' => 'Sum'],
				'sum_of_squares' => ['label' => 'Sum of Squares'],
				'variance' => ['label' => 'Variance'],
				'std_dev' => ['label' => 'Standard Deviation']
			]
		],
		'aggregate_by' => [
			'type' => 'string',
			'required' => true,
			'options' => [
				'publisher' => ['label' => ''],
				'domains' => ['label' => ''],
				'domain' => ['label' => ''],
				'language' => ['label' => ''],
				'authors' => ['label' => ''],
				'country' => ['label' => ''],
				'categories' => ['label' => 'Categories']
			]
		],
		'video_only' => [
			'type' => 'boolean'
		],
		'default_field' => [
			'type' => 'string'
		],
		'size' => [
			'type' => 'int'
		]
	];

	/**
	 * @var array $newsWhipCategories
	 *
	 * ids are required for certain types of requests and are not provided through the API
	 *
	 * @link http://www.newswhip.com/api#topics-covered
	 */
	static public $newsWhipCategories = [
		280 => 'All',
		285 => 'Pre-Viral',
		2 => 'News',
		20 => 'Politics',
		3 => 'Entertainment',
		652 => 'Teens',
		4 => 'Culture',
		5 => 'Fashion',
		6 => 'Arts',
		7 => 'Design',
		8 => 'Movies',
		9 => 'Music',
		10 => 'Gaming',
		11 => 'Ideas',
		12 => 'Life',
		13 => 'Health',
		15 => 'Food and Drink',
		16 => 'For Him',
		17 => 'For Her',
		18 => 'Fun',
		19 => 'Opinion',
		21 => 'Economics',
		22 => 'Mayhem',
		23 => 'Left',
		24 => 'Right',
		25 => 'Tech',
		537 => 'Cloud Computing',
		26 => 'Science',
		27 => 'Environment',
		14 => 'Psychology',
		28 => 'Business',
		29 => 'The Wire',
		30 => 'Startups',
		31 => 'Strategy',
		429 => 'Media',
		32 => 'Sports',
		33 => 'Soccer',
		34 => 'Rugby',
		35 => 'Golf',
		36 => 'Motorsports',
		37 => 'Cycling',
		38 => 'Tennis',
		39 => 'American Football',
		40 => 'Basketball',
		41 => 'Cricket',
		42 => 'Track',
		43 => 'Baseball',
		44 => 'Aus Football',
		430 => 'Ice Hockey',
		286 => 'YouTube',
		432 => 'Mining',
		433 => 'Energy',
		434 => 'Parenting',
		435 => 'Fathers',
		436 => 'Mothers',
		437 => 'Homemaking',
		438 => 'Reddit',
		441 => 'Careers',
		442 => 'Commodities',
		443 => 'Travel',
		444 => 'Influencers',
		476 => 'Storyful',
		446 => 'Personal Finance',
		447 => 'Marketing',
		448 => 'Retirement',
		449 => 'Markets',
		450 => 'Currencies',
		451 => 'Stocks',
		452 => 'Financial Products',
		453 => 'Funds',
		454 => 'Rates and Bonds',
		455 => 'Agricultural Goods',
		456 => 'Indexes',
		457 => 'Private Equity',
		458 => 'Emerging Markets',
		459 => 'Industries',
		473 => 'Autos',
		538 => 'Biotech',
		472 => 'Defence',
		463 => 'Finance',
		461 => 'Health Care',
		464 => 'Transport',
		475 => 'Education',
		540 => 'Beauty',
		621 => 'Partners',
		469 => 'Accounting',
		470 => 'Electronics',
		462 => 'Insurance',
		467 => 'Legal',
		466 => 'Luxury',
		460 => 'Oil and Gas',
		474 => 'Real Estate',
		539 => 'Renewable Energy',
		465 => 'Retail',
		471 => 'Tech Industry',
		468 => 'Telecom',
		622 => 'Wochit',
		623 => 'Gadgets',
		624 => 'Wireless and Mobile',
		625 => 'Cyber Security',
		626 => 'Data Storage',
		627 => 'Networking',
		628 => 'Software',
		629 => 'Hardware',
		633 => 'Latino',
		636 => 'Aging',
		638 => 'World Cup 2014',
		651 => 'Quiz',
		652 => 'Teens',
		653 => 'Action Sports',
		655 => 'TV',
		661 => 'Weather',
		663 => 'Anime',
		664 => 'Horse Racing',
		665 => 'Boat Racing',
		667 => 'Brands',
		668 => 'Events',
		669 => 'K-POP',
		670 => 'Pets',
		671 => 'Martial Arts',
		685 => 'IInternational',
		686 => 'Society',
		687 => 'People',
		689 => 'Curation',
		690 => 'Viral',
		691 => 'Social',
		692 => 'App',
		693 => 'MANGA',
		694 => 'DIY',
		696 => 'Development',
		697 => 'Fitness',
		699 => 'Celebrity',
		750 => 'Great Outdoors',
		751 => 'U.S. Election 2016',
		752 => 'Combat Sports',
		753 => 'Gaelic Games',
		755 => 'Canadian Election',
		756 => 'Religion'
	];

	static public $newsWhipCategoryHierarchy = [
		280 => [],
		285 => [
			689,
			691,
			690,
			438
		],
		286 => [],
		751 => [],
		755 => [],
		2 => [
			687,
			686,
			668,
			20,
			661
		],
		3 => [
			669,
			699,
			652,
			655,
			663
		],
		4 => [
			6,
			7,
			5,
			10,
			11,
			693,
			8,
			9,
			756
		],
		12 => [
			636,
			540,
			694,
			475,
			435,
			697,
			15,
			17,
			16,
			13,
			437,
			633,
			436,
			434,
			670,
			443
		],
		18 => [],
		19 => [
			21,
			23,
			24,
			22
		],
		25 => [
			692,
			537,
			625,
			626,
			623,
			629,
			627,
			628,
			624,
			696,
		],
		26 => [
			27,
			14
		],
		28 => [
			441,
			447,
			446,
			448,
			30,
			31,
			29
		],
		459 => [
			469,
			473,
			538,
			472,
			470,
			433,
			463,
			461,
			462,
			467,
			466,
			429,
			460,
			474,
			539,
			465,
			471,
			468,
			464
		],
		449 => [
			455,
			442,
			450,
			458,
			452,
			453,
			456,
			432,
			457,
			454,
			451
		],
		32 => [
			653,
			39,
			44,
			43,
			40,
			665,
			752,
			41,
			37,
			753,
			35,
			750,
			664,
			430,
			671,
			36,
			34,
			33,
			38,
			42,
			638
		],
		667 => []
	];

	/**
	 * @var array $newsWhipCities
	 *
	 * ids are required for certain types of requests and are not provided through the API
	 *
	 * @link http://www.newswhip.com/api#cities-covered
	 */
	static public $newsWhipCities = [
		'U.S.' => [
			163 => 'Atlanta, GA',
			140 => 'Austin, TX',
			164 => 'Baltimore, MD',
			165 => 'Boston, MA',
			141 => 'North Carolina',
			166 => 'Chicago, IL',
			142 => 'Cincinnati, OH',
			143 => 'Cleveland, OH',
			144 => 'Columbus, OH',
			167 => 'Connecticut, CT',
			145 => 'Dallas, TX',
			168 => 'Denver, CO',
			146 => 'Detroit, MI',
			147 => 'Houston, TX',
			169 => 'Indianapolis, IN',
			170 => 'Jacksonville, FL',
			148 => 'Kansas City, MO',
			171 => 'L.A., CA',
			149 => 'Las Vegas, NV',
			150 => 'Long Island, NY',
			151 => 'Memphis, TN',
			172 => 'Miami, FL',
			152 => 'Minneapolis, MN',
			153 => 'Nashville, TN',
			173 => 'New Orleans, LA',
			174 => 'New York, NY',
			154 => 'Oklahoma City, OK',
			175 => 'Orlando, FL',
			155 => 'Philadelphia, PA',
			176 => 'Phoenix, AZ',
			156 => 'Pittsburgh, PA',
			157 => 'Portland, OR',
			630 => 'Richmond, VA',
			177 => 'Sacramento, CA',
			158 => 'Salt Lake City, UT',
			159 => 'San Antonio, TX',
			178 => 'San Diego, CA',
			179 => 'San Francisco, CA',
			180 => 'San Jose, CA',
			160 => 'Seattle, WA',
			161 => 'St. Louis, MO',
			181 => 'Tampa, FL',
			162 => 'Washington, DC',
			657 => 'Omaha, NE',
			658 => 'Des Moines, IA',
			659 => 'Little Rock, AR',
			660 => 'Milwaukee, WI',
		],
		'U.K.' => [
			417 => 'London',
			418 => 'Birmingham',
			419 => 'Manchester',
			420 => 'Liverpool',
			421 => 'Scotland',
			422 => 'Wales',
			424 => 'Midlands',
			425 => 'North England',
			426 => 'Yorkshire and Humber',
			427 => 'South East England',
			428 => 'East England',
			431 => 'South West England'
		],
		'Canada' => [
			186 => 'Calgary',
			187 => 'Edmonton',
			183 => 'Montreal',
			185 => 'Ottawa',
			182 => 'Toronto',
			184 => 'Vancouver'
		],
		'Deutschland' => [
			263 => 'Baden-Württemberg',
			264 => 'Bayern',
			265 => 'Berlin-Brandenburg',
			266 => 'Hamburg-Schleswig-Holstein',
			267 => 'Hessen',
			440 => 'Lower Saxony',
			268 => 'Mecklenburg-Vorpommern',
			269 => 'Niedersachsen-Bremen',
			270 => 'Nordrhein-Westfalen',
			272 => 'Rheinland-Pfalz',
			273 => 'Saarland',
			274 => 'Sachsen',
			275 => 'Sachsen-Anhalt',
			276 => 'Thüringen'
		]
	];

	/**
	 * @var array $newsWhipRegions
	 *
	 * ids are required for certain types of requests and are not provided through the API
	 *
	 * @link http://www.newswhip.com/api#regions-covered
	 */
	static public $newsWhipRegions = [
		279 => 'World',
		45 => 'U.S.',
		46 => 'U.K.',
		49 => 'Australia',
		47 => 'Canada',
		48 => 'Ireland',
		50 => 'New Zealand',
		51 => 'India',
		52 => 'Europe',
		54 => 'China',
		57 => 'Africa',
		56 => 'South Africa',
		99 => 'Brasil',
		634 => 'México',
		100 => 'Portugal',
		139 => 'España',
		277 => 'France',
		278 => 'Deutschland',
		318 => 'België',
		370 => 'Belgique',
		371 => 'Nederland',
		367 => 'Eesti',
		416 => 'Suomi',
		536 => 'Sverige',
		580 => 'Italia',
		631 => 'South East Asia',
		632 => 'Middle East',
		650 => 'Argentina',
		656 => 'Norge',
		666 => 'U.S. Hispanic'
	];

}
