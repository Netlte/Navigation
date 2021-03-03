<?php declare(strict_types = 1);

namespace Netlte\Navigation;


/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
interface IManager extends \Countable {

	public function createSection(string $name, ?string $caption = null, ?string $insertBefore = null): ISection;

	public function addSection(string $name, ISection $section, ?string $insertBefore = null): IManager;

	/**
	 * @return ISection[]
	 */
	public function getSections(): array;

	public function getSection(string $name): ?ISection;

}