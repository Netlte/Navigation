<?php declare(strict_types = 1);

namespace Netlte\Navigation\Item;


/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class Label implements ILabel {

	public const DEFAULT_COLOR = 'blue';
	static public string $DEFAULT_COLOR = self::DEFAULT_COLOR;
	private string $caption;
	private string $color;

	public function __construct(string $caption) {
		$this->caption = $caption;
		$this->color = self::$DEFAULT_COLOR;
	}

	public function getCaption(): string {
		return $this->caption;
	}

	public function getColor(): string {
		return $this->color;
	}

	public function setCaption(string $caption): ILabel {
		$this->caption = $caption;

		return $this;
	}

	public function setColor(string $color): ILabel {
		$this->color = $color;

		return $this;
	}

	public function __toString(): string {
		return $this->getCaption();
	}
}