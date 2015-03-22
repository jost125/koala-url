<?php

namespace Koala\Url;

use Koala\Collection\Immutable\Map;

class Url {

	private $scheme;
	private $host;
	private $path;
	private $queryParameters;

	public function __construct(
		$scheme,
		$host,
		$path,
		Map $queryParameters
	) {
		$this->scheme = $scheme;
		$this->host = $host;
		$this->path = $path;
		$this->queryParameters = $queryParameters;
	}

	public function getScheme() {
		return $this->scheme;
	}

	public function getHost() {
		return $this->host;
	}

	public function getPath() {
		return $this->path;
	}

	public function getQueryParameters() {
		return $this->queryParameters;
	}

	public function toString() {
		return "{$this->getScheme()}://{$this->getHost()}/{$this->getPath()}{$this->buildQuery()}";
	}

	private function buildQuery() {
		$queryPairs = $this->getQueryParameters()->map(function ($value, $key) {
			return $value ? $key . "=" . rawurlencode($value) : $key;
		});

		return $this->getQueryParameters()->isEmpty() ? "" : "?" . implode("&", $queryPairs->toArray());
	}
}
