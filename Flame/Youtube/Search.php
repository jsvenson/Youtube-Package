<?php
/**
 * Search.php
 *
 * @author  Jiří Šifalda <sifalda.jiri@gmail.com>
 * @package Flame
 *
 * @date    01.01.13
 */

namespace Flame\Youtube;

use Kdyby\Curl\CurlException;
use Nette\Http\Url;

class Search extends UrlService
{

	const URL = 'https://gdata.youtube.com/feeds/api/videos';

	/** @var array */
	private $default = array(
		'orderby' => 'relevance',
		'start-index' => '1',
		'max-results' => '10',
		'v' => '2',
		'strict' => false,
		'alt' => 'json'
	);

	/**
	 * @param $key
	 * @return $this
	 */
	public function setSearchKey($key)
	{
		$this->default['q'] = (string) $key;
		return $this;
	}

	/**
	 * @param $limit
	 * @return $this
	 */
	public function setMaxResults($limit)
	{
		$this->default['max-results'] = (string) $limit;
		return $this;
	}

	/**
	 * @param $key
	 * @return $this
	 */
	public function setOrderBy($key)
	{
		$this->default['orderby'] = (string) $key;
		return $this;
	}

	/**
	 * @param $index
	 * @return $this
	 */
	public function setStartIndex($index)
	{
		$this->default['start-index']  = ((int) $index) ? (int) $index : 1;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return (string) $this->createUrl(self::URL)->setQuery($this->default);
	}

	/**
	 * @return string
	 */
	public function getResponse()
	{
		try {
			$curl = $this->createCurl($this->getUrl());
			return $curl->get()->getResponse();
		}catch (CurlException $ex) {}
	}

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		if($response = $this->getResponse()) {
			return json_decode($response);
		}
	}

}
