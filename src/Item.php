<?php declare(strict_types = 1);

namespace Netlte\Navigation;

use Netlte\Navigation\Item\Icon;
use Netlte\Navigation\Item\IIcon;
use Netlte\Navigation\Item\ILabel;
use Netlte\Navigation\Item\Label;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class Item implements IItem {

	private string $caption = '';
	private ?Label $label = null;
	private ?string $link = null;
	private ?Icon $icon = null;
	private bool $url = false;

	/** @var IItem[] */
	private array $items = [];

	/** @var \Closure[]|callable[]|array */
	private array $activeConditions = [];

	/** @var \Closure[]|callable[]|array */
	private array $renderConditions = [];

	public function __construct(
		string $caption = '',
		?string $label = null,
		?string $link = null,
		bool $url = false
	) {
		$this->caption = $caption;
		$this->label = $label !== null ? new Label($label) : null;
		$this->link = $link;
		$this->url = $url;
	}

	public function getCaption(): string {
		return $this->caption;
	}

	public function getLabel(): ?ILabel {
		return $this->label;
	}

	public function getIcon(): ?IIcon {
		return $this->icon;
	}

	public function getLink(): ?string {
		return $this->link;
	}

	public function isUrl(): bool {
		return $this->url;
	}

	public function isTreeView(): bool {
		return $this->count() > 0;
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

	public function setCaption(string $caption): IItem {
		$this->caption = $caption;

		return $this;
	}

	public function setLabel(?string $label = null, ?string $color = null): IItem {
		$this->label = $label !== null ? new Label($label) : null;

		if ($this->label !== null && $color !== null) {
			$this->label->setColor($color);
		}

		return $this;
	}

	public function setLink(?string $link = null): IItem {
		$this->link = $link;

		return $this;
	}

	public function setIcon(?string $icon = null, ?string $color = null): IItem {
		$this->icon = $icon !== null ? new Icon($icon) : null;

		if ($this->icon !== null && $color !== null) {
			$this->icon->setColor($color);
		}

		return $this;
	}

	public function setUrl(bool $url = true): IItem {
		$this->url = $url;

		return $this;
	}

	public function createItem(string $name, string $caption, ?string $insertBefore = null): IItem {
		$item = new Item($caption);
		$this->addItem($name, $item, $insertBefore);

		return $item;
	}

	public function addItem(string $name, IItem $item, ?string $insertBefore = null): IItem {
		if ($insertBefore !== null && isset($this->items[$insertBefore])) {
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
	 * @inheritDoc
	 */
	public function addActiveCondition(callable $callable): IItem {
		$this->activeConditions[] = $callable;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function addRenderCondition(callable $callable): IItem {
		$this->renderConditions[] = $callable;

		return $this;
	}

	public function isActive(): bool {
		$result = false;
		foreach ($this->activeConditions as $handler) {
			$return = $handler($this);
			$result = $return !== null ? (bool)$return : $result;
		}

		return $result;
	}

	public function isRenderingAllowed(): bool {
		$result = true;
		foreach ($this->renderConditions as $handler) {
			$return = $handler($this);
			$result = $return !== null ? (bool)$return : $result;
		}

		return $result;
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
