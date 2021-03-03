<?php declare(strict_types = 1);

namespace Netlte\Navigation\Tests\Cases\Unit;

use Netlte\Navigation\Exceptions\InvalidStateException;
use Netlte\Navigation\IManager;
use Netlte\Navigation\Manager;
use Netlte\Navigation\Navigation;
use Netlte\Navigation\Tests\Helpers\NavigationFactory;
use Netlte\Navigation\Tests\Helpers\TestingTemplateFactory;
use Nette\ComponentModel\IComponent;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../Helpers/NavigationFactory.php';

class NavigationTest extends TestCase {

	private IManager $manager;

	/** @var Navigation|IComponent|null */
	private $navigation;

	public function setUp(): void {
		$factory = new NavigationFactory();
		$this->navigation = $factory->create();
		$this->manager = new Manager();
	}

	public function testRender(): void {
		/** @var Navigation $navigation */
		$navigation = $this->navigation;

		$callback = function() use ($navigation): void {
			$navigation->render();
		};

		Assert::exception($callback, InvalidStateException::class, 'You have to set manager first.');

		$navigation->setTemplateFactory(new TestingTemplateFactory());

		$hash = \spl_object_hash($this->manager);
		$navigation->setManager($this->manager);
		\ob_start();
		$navigation->render();
		$result = \ob_get_clean();

		Assert::equal('TestingTemplate', $result);
		Assert::equal($hash, \spl_object_hash($navigation->getManager()));
	}

}

(new NavigationTest())->run();