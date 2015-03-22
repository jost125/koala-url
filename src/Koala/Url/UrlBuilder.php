<?php

namespace Koala\Url;

use InvalidArgumentException;
use Koala\Collection\IMap;
use Koala\Collection\Immutable\ArrayList;
use Koala\Collection\Immutable\Map;

class UrlBuilder {

	private $scheme;
	private $host;
	private $path;
	private $queryParameters;

	public function __construct() {
		$this->queryParameters = new Map([]);
	}

	public function setScheme($scheme) {
		$this->scheme = $scheme;
	}

	public function setHost($host) {
		$this->host = $host;
	}

	public function setPath($path) {
		$this->path = $path;
	}

	public function setQueryParameter($name, $value = null) {
		$this->queryParameters = $this->queryParameters->put($name, $value);
	}

	public function setQueryParameters(IMap $parameters) {
		$this->queryParameters = $this->queryParameters->merge($parameters);
	}

	public function buildUrl() {
		return new Url(
			$this->scheme,
			$this->host,
			$this->path,
			$this->queryParameters
		);
	}

	public static function fromString($urlString) {
		$parsedUrl = parse_url($urlString);

		if ($parsedUrl === false || !array_key_exists('scheme', $parsedUrl)) {
			throw new InvalidArgumentException("Url {$urlString} cannot be parsed");
		}

		$scheme = $parsedUrl['scheme'];
		$host = $parsedUrl['host'];
		$path = array_key_exists('path', $parsedUrl) ? ltrim($parsedUrl['path'], "/") : null;
		$queryParameters = array_key_exists('query', $parsedUrl) ? self::parseQuery($parsedUrl['query']) : new Map([]);

		$urlBuilder = new self();
		$urlBuilder->setScheme($scheme);
		$urlBuilder->setHost($host);
		$urlBuilder->setPath($path);
		$urlBuilder->setQueryParameters($queryParameters);

		return $urlBuilder;
	}

	private static function parseQuery($query) {
		$queryPairs = new ArrayList(explode('&', $query));
		return new Map($queryPairs->map(function ($queryPair) {
			list($encodedParameterName, $encodedParameterValue) = explode('=', $queryPair);

			return [
				$encodedParameterName,
				$encodedParameterValue ? urldecode($encodedParameterValue) : null
			];
		})->toArray());
	}
}
