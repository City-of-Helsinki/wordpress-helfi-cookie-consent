<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Cookie_List_Collection implements \Iterator, \Countable
{
	private array $lists;
	private $position = 0;

	public function __construct(
		Cookie_List ...$lists
	) {
		$this->lists = $lists;
		$this->position = 0;
	}

	public function count(): int
	{
		return count( $this->lists );
	}

	#[\ReturnTypeWillChange]
	public function current(): mixed
	{
		return $this->lists[$this->position];
	}

	#[\ReturnTypeWillChange]
	public function key(): mixed
	{
		return $this->position;
	}

	public function next(): void
	{
		++$this->position;
	}

	public function rewind(): void
	{
		$this->position = 0;
	}

	public function valid(): bool
	{
		return isset($this->lists[$this->position]);
	}

	public function all(): array
	{
		return $this->lists;
	}
}
