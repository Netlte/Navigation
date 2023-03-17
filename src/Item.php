<?php declare(strict_types = 1);

namespace Netlte\Navigation;

use Netlte\Navigation\Item\Badge;
use Netlte\Navigation\Item\IBadge;
use Netlte\Navigation\Item\Icon;
use Netlte\Navigation\Item\IIcon;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class Item implements IItem {

	private string $caption = '';
	private ?Badge $badge = null;
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
		?string $badge = null,
		?string $link = null,
		bool $url = false
	) {
		$this->caption = $caption;
		$this->badge = $badge !== null ? new Badge($badge) : null;
		$this->link = $link;
		$this->url = $url;
	}

	public function getCaption(): string {
		return $this->caption;
	}

    /**
     * @deprecated use getBadge()
     */
    public function getLabel(): ?IBadge {
        return $this->getBadge();
    }

	public function getBadge(): ?IBadge {
		return $this->badge;
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

    /**
     * @deprecated use setBadge()
     */
    public function setLabel(?string $label = null, ?string $color = null): IItem {
        return $this->setBadge($label,$color);
    }

	public function setBadge(?string $caption = null, ?string $color = null): IItem {
		$this->badge = $caption !== null ? new Badge($caption) : null;

		if ($this->badge !== null && $color !== null) {
			$this->badge->setColor($color);
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
