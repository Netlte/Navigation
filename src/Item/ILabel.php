<?php declare(strict_types = 1);

namespace Netlte\Navigation\Item;


/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
interface ILabel {

	public function getCaption(): string;

	public function getColor(): string;

	public function setCaption(string $caption): self;

	public function setColor(string $color): self;

	public function __toString(): string;

}