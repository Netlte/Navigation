<?php declare(strict_types = 1);

namespace Netlte\Navigation\Item;


/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class Icon implements IIcon {
	
	private string $icon;
	private ?string $color = null;

	public function __construct(string $icon) {
		$this->icon = $icon;
	}

	public function getIcon(): string {
		return $this->icon;
	}

	public function getColor(): ?string {
		return $this->color;
	}

	public function setIcon(string $icon): IIcon {
		$this->icon = $icon;

		return $this;
	}

	public function setColor(?string $color = null): IIcon {
		$this->color = $color;

		return $this;
	}

	public function __toString(): string {
		return $this->getIcon();
	}
}