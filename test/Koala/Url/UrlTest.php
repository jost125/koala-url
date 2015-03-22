<?php

namespace Koala\Url;

use Koala\Collection\Immutable\Map;
use PHPUnit_Framework_TestCase;

class UrlTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider urlDataProvider
	 * @param Url $url
	 * @param $expectedUrl
	 */
	public function testUrlToString(Url $url, $expectedUrl) {
		$this->assertEquals($expectedUrl, $url->toString());
	}

	public function urlDataProvider() {
		return [
			[new Url("http", "koala.org", "", new Map([])), "http://koala.org/"],
			[new Url("http", "koala.org", "path", new Map([])), "http://koala.org/path"],
			[new Url("http", "koala.org", "path", new Map([["query", null]])), "http://koala.org/path?query"],
			[new Url("http", "koala.org", "path", new Map([["query", "value"]])), "http://koala.org/path?query=value"],
			[new Url("http", "koala.org", "path", new Map([["query", "value"], ["query2", "value2"]])), "http://koala.org/path?query=value&query2=value2"],
		];
	}

}
