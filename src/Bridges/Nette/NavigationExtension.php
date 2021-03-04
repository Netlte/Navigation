<?php declare(strict_types = 1);

namespace Netlte\Navigation\Bridges\Nette;

use Netlte\Navigation\Manager;
use \Nette\DI\CompilerExtension;

class NavigationExtension extends CompilerExtension {

	public function loadConfiguration(): void {
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('manager'))
			->setFactory(Manager::class);

	}


}