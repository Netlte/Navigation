<?php declare(strict_types = 1);

namespace Netlte\Navigation\Bridges\Nette;

use Netlte\Navigation\Manager;
use \Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class NavigationExtension extends CompilerExtension {

	public function getConfigSchema(): Schema {
		$items = [
			'caption' => Expect::string()->required(),
			'link'    => Expect::string()->nullable()->required(false),
			'url'     => Expect::bool()->required(false),
			'label'   => Expect::structure(
				[
					'caption' => Expect::string()->required(),
					'color'   => Expect::string()->nullable()->required(false),
				]
			)->required(false),
			'icon'    => Expect::structure(
				[
					'icon'  => Expect::string()->required(),
					'color' => Expect::string()->nullable()->required(false),
				]
			)->required(false),
		];

		$items['items'] = Expect::arrayOf(Expect::structure($items));

		$sections = Expect::structure(
			[
				'caption' => Expect::string()->nullable()->required(false),
				'items'   => Expect::arrayOf(Expect::structure($items))->required(false)
			]
		);

		return Expect::arrayOf($sections)->required(false);
	}

	public function loadConfiguration() {
		$config = $this->config;
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('manager'))
			->setFactory(Manager::class);

	}


}