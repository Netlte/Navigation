<?php declare(strict_types = 1);

namespace Netlte\Navigation;

use Netlte\Navigation\Exceptions\InvalidStateException;
use Netlte\UI\AbstractControl;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 *
 * @method getTemplate() \Nette\Bridges\ApplicationLatte\Template|\Nette\Application\UI\Template
 */
class Navigation extends AbstractControl {

	public const DEFAULT_TEMPLATE = __DIR__ . \DIRECTORY_SEPARATOR . 'templates' . \DIRECTORY_SEPARATOR . 'default.latte';

	public static string $DEFAULT_TEMPLATE = self::DEFAULT_TEMPLATE;

	private ?IManager $manager = null;

	public function __construct() {
		$this->setTemplateFile(self::$DEFAULT_TEMPLATE);
	}

	public function setManager(IManager $manage): Navigation {
		$this->manager = $manage;
		return $this;
	}

	public function getManager(): ?IManager {
		return $this->manager;
	}

	public function render(): void {
		if ($this->manager === null) {
			throw new InvalidStateException('You have to set manager first.');
		}

		$this->getTemplate()->manager = $this->getManager();
		$this->getTemplate()->setFile($this->getTemplateFile() ?? self::$DEFAULT_TEMPLATE);
		$this->getTemplate()->setTranslator($this->getTranslator());
		$this->getTemplate()->render();
	}
}
