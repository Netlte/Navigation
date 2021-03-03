<?php declare(strict_types = 1);

namespace Netlte\Navigation\Item;


/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
interface IIcon {

	public function getIcon(): string;

	public function getColor(): ?string;

	public function setIcon(string $icon): IIcon;

	public function setColor(?string $color = null): IIcon;

	public function __toString(): string;

}