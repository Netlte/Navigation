<?php declare(strict_types = 1);

namespace Netlte\Navigation;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class Section implements ISection {

	/** @var IItem[] */
	private array $items = [];

	public function __construct(private ?string $caption = null) {
	}

	public function getCaption(): ?string {
		return $this->caption;
	}

	public function setCaption(?string $caption = null): ISection {
		$this->caption = $caption;
		return $this;
	}

	/**
	 * @return IItem[]
	 */
	public function getItems(): array {
		return $this->items;
	}

	public function getItem(string $name): ?IItem {
		return $this->items[$name] ?? null;
	}

	public function createItem(string $name, string $caption, ?string $insertBefore = null): IItem {
		$item = new Item($caption);
		$this->addItem($name, $item, $insertBefore);
		return $item;
	}

	public function addItem(string $name, IItem $item, ?string $insertBefore = null): ISection {
		if ($insertBefore !== null && isset($this->items[$insertBefore])){
			$arr = $this->getItems();

			$offset = (int) \array_search(\key([$insertBefore => null]), \array_keys($arr), true);
			$arr = \array_slice($arr, 0, $offset, true) + [$name => $item] + \array_slice($arr, $offset, \count($arr), true);
			$this->items = $arr;
			return $this;
		}
		$this->items[$name] = $item;
		return $this;
	}

	/**
	 *
	 *
	 * 			\Countable
	 *
	 *
	 */

	public function count(): int {
		return \count($this->items);
	}
	
}