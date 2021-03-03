<?php declare(strict_types = 1);

namespace Netlte\Navigation;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
interface ISection extends \Countable {

	public function getCaption(): ?string;

	public function setCaption(?string $caption = null): self;

	/**
	 * @return IItem[]
	 */
	public function getItems(): array;

	public function getItem(string $name): ?IItem;

	public function createItem(string $name, string $caption, ?string $insertBefore = null): IItem;

	public function addItem(string $name, IItem $item, ?string $insertBefore = null): self;

}