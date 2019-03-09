<?php namespace Intellex\Pixabay;

use Intellex\Pixabay\Exception\UnsupportedSearchParameterException;
use Intellex\Pixabay\Validation\ClassMemberValidator;
use Intellex\Pixabay\Validation\ValidationException;

/**
 * Class SearchParams defines the parameters for the search.
 *
 * @package Intellex\Pixabay
 */
class SearchParams implements \JsonSerializable {

	/** @var string An URL encoded search term. If omitted, all images are returned. This value may not exceed 100 characters. Example: "yellow+flower". */
	private $query = null;

	/** @var string Language code of the language to be searched in. @see Language. Default: "en". */
	private $lang = null;

	/** @var string Filter results by image type. @see ImageType. Default: "all". */
	private $imageType = null;

	/** @var string Filter results by video type. @see VideoType. Default: "all" */
	private $videoType = null;

	/** @var string Whether an image is wider than it is tall, or taller than it is wide. @see Orientation". Default: "all". */
	private $orientation = null;

	/** @var string Filter results by category. @see Category. */
	private $category = null;

	/** @var int Minimum image width. Default: "0". */
	private $minWidth = null;

	/** @var int Minimum image height. Default: "0". */
	private $minHeight = null;

	/** @var string|string[] Filter images by color properties.@see Color. */
	private $colors = null;

	/** @var bool Select images that have received an Editor's Choice award. Accepted values: true or false. Default: "false". */
	private $editorsChoice = null;

	/** @var bool A flag indicating that only images suitable for all ages should be returned. Accepted values: true or false. Default: "false". */
	private $safeSearch = null;

	/** @var string How the results should be ordered. @see Order. Default: "popular". */
	private $order = null;

	/** @var int Returned search results are paginated. Use this parameter to select the page number. Default: 1. */
	private $page = null;

	/** @var int Determine the number of results per page. Accepted values: 3 - 200. Default: 20. */
	private $perPage = null;

	/**
	 * Initialize the ImageSearchParams.
	 *
	 * @param array|null $params An optional list of parameters as array, @see
	 *                           https://pixabay.com/api/docs/.
	 *
	 * @throws UnsupportedSearchParameterException
	 * @throws ValidationException
	 */
	public function __construct($params = []) {
		foreach ((array) $params as $key => $value) {
			$key = str_replace('_', '', strtolower($key));
			switch ($key) {
				case 'q':
				case 'query':
					$this->setQuery($value);
					break;

				case 'category':
					$this->setCategory($value);
					break;

				case 'lang':
				case 'language':
					$this->setLang($value);
					break;

				case 'image':
				case 'imagetype':
					$this->setImageType($value);
					break;

				case 'video':
				case 'videotype':
					$this->setVideoType($value);
					break;

				case 'orientation':
					$this->setOrientation($value);
					break;

				case 'width':
				case 'minwidth':
					$this->setMinWidth($value);
					break;

				case 'height':
				case 'minheight':
					$this->setMinHeight($value);
					break;

				case 'color':
				case 'colors':
					$this->setColors($value);
					break;

				case 'editorschoice':
					$this->setEditorsChoice($value);
					break;

				case 'safesearch':
					$this->setSafeSearch($value);
					break;

				case 'order':
					$this->setOrder($value);
					break;

				case 'page':
					$this->setPage($value);
					break;

				case 'perpage':
					$this->setPerPage($value);
					break;

				default:
					throw new UnsupportedSearchParameterException($key);
			}
		}
	}

	/**
	 * @param string $query An URL encoded search term. If omitted, all images are returned. This
	 *                      value may not exceed 100 characters. Example: "yellow+flower".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setQuery($query) {
		$this->query = $query;
		ClassMemberValidator::assert('SearchParams::query', $this->query, 'string');
		return $this;
	}

	/**
	 * @param string $languageCode Language code of the language to be searched in. @see Language
	 *                             . Default: "en".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setLang($languageCode) {
		$this->lang = $languageCode;
		ClassMemberValidator::assert('SearchParams::lang', $this->lang, 'set:cs,da,de,en,es,fr,id,it,hu,nl,no,pl,pt,ro,sk,fi,sv,tr,vi,th,bg,ru,el,ja,ko,zh');
		return $this;
	}

	/**
	 * @param string $imageType Filter results by image type. @see ImageType. Default: "all".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setImageType($imageType) {
		$this->imageType = $imageType;
		ClassMemberValidator::assert('SearchParams::imageType', $this->imageType, 'set:all,photo,illustration');
		return $this;
	}

	/**
	 * @param string $videoType Filter results by video type. @see VideoType. Default: "all".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setVideoType($videoType) {
		$this->videoType = $videoType;
		ClassMemberValidator::assert('SearchParams::videoType', $this->videoType, 'set:all,film,animation');
		return $this;
	}

	/**
	 * @param string $orientation Whether an image is wider than it is tall, or taller than it is
	 *                            wide. @see Orientation. Default: "all".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setOrientation($orientation) {
		$this->orientation = $orientation;
		ClassMemberValidator::assert('SearchParams::orientation', $this->orientation, 'set:all,horizontal,vertical');
		return $this;
	}

	/**
	 * @param string $category Filter results by category. @see Category
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setCategory($category) {
		$this->category = $category;
		ClassMemberValidator::assert('SearchParams::category', $this->category, 'set:fashion,nature,backgrounds,science,education,people,feelings,religion,health,places,animals,industry,food,computer,sports,transportation,travel,buildings,business,music');
		return $this;
	}

	/**
	 * @param int $minWidth Minimum image width. Default: "0".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setMinWidth($minWidth) {
		$this->minWidth = $minWidth;
		ClassMemberValidator::assert('SearchParams::minWidth', $this->minWidth, 'positiveInteger');
		return $this;
	}

	/**
	 * @param int $minHeight Minimum image height. Default: "0".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setMinHeight($minHeight) {
		$this->minHeight = $minHeight;
		ClassMemberValidator::assert('SearchParams::minHeight', $this->minHeight, 'positiveInteger');
		return $this;
	}

	/**
	 * @param string|string[] $colors Filter images by color properties. A comma separated list of
	 *                                values may be used to select multiple properties. @see Color
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setColors($colors) {
		$this->colors = (array) $colors;
		ClassMemberValidator::assert('SearchParams::colors', $this->colors, 'set:grayscale,transparent,red,orange,yellow,green,turquoise,blue,lilac,pink,white,gray,black,brown');
		return $this;
	}

	/**
	 * @param bool $onlyEditorsChoice Select images that have received an Editor's Choice award.
	 *                                . Default: "false".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setEditorsChoice($onlyEditorsChoice) {
		$this->editorsChoice = $onlyEditorsChoice;
		ClassMemberValidator::assert('SearchParams::editorsChoice', $this->editorsChoice, 'boolean');
		return $this;
	}

	/**
	 * @param bool $useSafeSearch A flag indicating that only images suitable for all ages should
	 *                            be returned. Default: "false".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setSafeSearch($useSafeSearch) {
		$this->safeSearch = $useSafeSearch;
		ClassMemberValidator::assert('SearchParams::safeSearch', $this->safeSearch, 'boolean');
		return $this;
	}

	/**
	 * @param string $order How the results should be ordered. @see Order. Default: "popular".
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setOrder($order) {
		$this->order = $order;
		ClassMemberValidator::assert('SearchParams::order', $this->order, 'set:popular,latest');
		return $this;
	}

	/**
	 * @param int $page Returned search results are paginated. Use this parameter to select the
	 *                  page number. Default: 1.
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setPage($page) {
		$this->page = $page;
		ClassMemberValidator::assert('SearchParams::page', $this->page, 'positiveInteger');
		return $this;
	}

	/**
	 * @param int $itemsPerPage Determine the number of results per page. Accepted values: 3 - 200.
	 *                          Default: 20.
	 *
	 * @return SearchParams Itself, for chaining.
	 * @throws ValidationException
	 */
	public function setPerPage($itemsPerPage) {
		$this->perPage = $itemsPerPage;
		ClassMemberValidator::assert('SearchParams::perPage', $this->perPage, 'integer:3,200');
		return $this;
	}

	/** @return string An URL encoded search term. If omitted, all images are returned. This value may not exceed 100 characters. Example: "yellow+flower". */
	public function getQuery() {
		return $this->query;
	}

	/** @return string Language code of the language to be searched in. @see Language. Default: "en". */
	public function getLang() {
		return $this->lang;
	}

	/** @return string Filter results by image type. @see ImageType. Default: "all". */
	public function getImageType() {
		return $this->imageType;
	}

	/** @return string Whether an image is wider than it is tall, or taller than it is wide. @see Orientation. Default: "all". */
	public function getOrientation() {
		return $this->orientation;
	}

	/** @return string Filter results by category. @see Category. */
	public function getCategory() {
		return $this->category;
	}

	/** @return int Minimum image width. Default: "0". */
	public function getMinWidth() {
		return $this->minWidth;
	}

	/** @return int Minimum image height. Default: "0". */
	public function getMinHeight() {
		return $this->minHeight;
	}

	/** @return string Filter images by color properties. A comma separated list of values may be used to select multiple properties. @see Color. */
	public function getColors() {
		return $this->colors;
	}

	/** @return bool Select images that have received an Editor's Choice award. Default: "false". */
	public function getEditorsChoice() {
		return $this->editorsChoice;
	}

	/** @return bool A flag indicating that only images suitable for all ages should be returned. Default: "false". */
	public function getSafeSearch() {
		return $this->safeSearch;
	}

	/** @return string How the results should be ordered. @see Order. Default: "popular". */
	public function getOrder() {
		return $this->order;
	}

	/** @return int Returned search results are paginated. Use this parameter to select the page number. Default: 1. */
	public function getPage() {
		return $this->page;
	}

	/** @return int Determine the number of results per page. Accepted values: 3 - 200. Default: 20. */
	public function getPerPage() {
		return $this->perPage;
	}

	/** @inheritdoc */
	public function jsonSerialize() {

		// Build the JSON
		$json = [
			'q'              => $this->getQuery(),
			'lang'           => $this->getLang(),
			'imageType'      => $this->getImageType(),
			'orientation'    => $this->getOrientation(),
			'category'       => $this->getCategory(),
			'min_width'      => $this->getMinWidth(),
			'min_height'     => $this->getMinHeight(),
			'colors'         => $this->getColors(),
			'editors_choice' => (bool) $this->getEditorsChoice(),
			'safesearch'     => (bool) $this->getSafeSearch(),
			'order'          => $this->getOrder(),
			'page'           => $this->getPage(),
			'per_page'       => $this->getPerPage()
		];

		// Clear all unset values
		foreach ($json as $key => $value) {
			if ($value === null) {
				unset($json[$key]);
			}
		}

		return $json;
	}
}