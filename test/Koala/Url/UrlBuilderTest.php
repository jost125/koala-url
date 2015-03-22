<?php

namespace Koala\Url;

use InvalidArgumentException;

class UrlBuilderTest extends \PHPUnit_Framework_TestCase {

	public function testUrlBuilder() {
		$urlBuilder = new UrlBuilder();
		$urlBuilder->setScheme("http");
		$urlBuilder->setHost("koala.org");
		$urlBuilder->setPath("path");
		$urlBuilder->setQueryParameter("query", "value");
		$urlBuilder->setQueryParameter("query2", "value2");
		$urlBuilder->setQueryParameter("query", "newvalue");

		$this->assertEquals("http://koala.org/path?query=newvalue&query2=value2", $urlBuilder->buildUrl()->toString());
	}

	/**
	 * @dataProvider getStringUrlData
	 * @param $urlString
	 */
	public function testUrlBuilderFromString($urlString, $expectedBuildUrl) {
		$this->assertEquals($expectedBuildUrl, UrlBuilder::fromString($urlString)->buildUrl()->toString());
	}

	public function getStringUrlData() {
		return [
			["http://koala.org/path?query=value&query2=value2&query=newvalue&query3=", "http://koala.org/path?query=newvalue&query2=value2&query3"],
			["http://koala.org/path?", "http://koala.org/path"],
			["http://koala.org", "http://koala.org/"],
		];
	}

	public function testUrlBuilderFromStringInvalid() {
		try {
			UrlBuilder::fromString("invalidurl");
			$this->fail("Exception expected");
		} catch (InvalidArgumentException $ex) {
			$this->assertEquals("Url invalidurl cannot be parsed", $ex->getMessage());
		}
	}

}
