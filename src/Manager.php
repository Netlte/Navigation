<?php declare(strict_types = 1);

namespace Netlte\Navigation;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class Manager implements IManager {
	
	/** @var ISection[] */
	protected array $sections = [];

	/**
	 * @return ISection[]
	 */
	public function getSections(): array {
		return $this->sections;
	}

	public function getSection(string $name): ?ISection {
		return $this->sections[$name] ?? null;
	}

	public function createSection(string $name, ?string $caption = null, ?string $insertBefore = null): ISection {
		$section = new Section($caption);
		$this->addSection($name, $section, $insertBefore);

		return $section;
	}

	public function addSection(string $name, ISection $section, ?string $insertBefore = null): IManager {
		if ($insertBefore !== null && isset($this->sections[$insertBefore])){
			$arr = $this->getSections();

			$offset = (int) \array_search(\key([$insertBefore => null]), \array_keys($arr), true);
			$arr = \array_slice($arr, 0, $offset, true) + [$name => $section] + \array_slice($arr, $offset, \count($arr), true);
			$this->sections = $arr;
			return $this;
		}
		$this->sections[$name] = $section;
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
		return \count($this->sections);
	}
}