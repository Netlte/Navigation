<?php declare(strict_types = 1);

namespace Netlte\Navigation;

use Netlte\Navigation\Item\IBadge;
use Netlte\Navigation\Item\IIcon;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
interface IItem extends \Countable {

	public function getCaption(): string;

	public function getBadge(): ?IBadge;

	public function getIcon(): ?IIcon;

	public function getLink(): ?string;

	public function isUrl(): bool;

	public function isTreeView(): bool;

	/**
	 * @return IItem[]
	 */
	public function getItems(): array;

	public function getItem(string $name): ?IItem;

	public function setCaption(string $caption): self;

	public function setBadge(?string $caption = null, ?string $color = null): self;

	public function setLink(string $link): self;

	public function setIcon(?string $icon = null, ?string $color = null): self;

	public function setUrl(bool $url = true): self;

	public function createItem(string $name, string $caption, ?string $insertBefore = null): self;

	public function addItem(string $name, IItem $item, ?string $insertBefore = null): self;

	/**
	 * @param callable $callable (IItem $item, $result)
	 * @return IItem
	 */
	public function addActiveCondition(callable $callable): self;

	/**
	 * @param callable $callable (IItem $item, $result)
	 * @return IItem
	 */
	public function addRenderCondition(callable $callable): self;

	public function isActive(): bool;

	public function isRenderingAllowed(): bool;


}