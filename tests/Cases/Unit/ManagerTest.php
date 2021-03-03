<?php declare(strict_types = 1);

namespace Netlte\Navigation\Tests\Cases\Unit;

use Netlte\Navigation\IManager;
use Netlte\Navigation\ISection;
use Netlte\Navigation\Manager;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../Helpers/NavigationFactory.php';

class ManagerTest extends TestCase {

	private IManager $manager;

	public function setUp(): void {
		$this->manager = new Manager();
		$this->manager->createSection('test', 'Testing');
	}

	public function testSection(): void {
		Assert::type(ISection::class, $this->manager->getSection('test'));
		Assert::equal('Testing', $this->manager->getSection('test')->getCaption());
		Assert::equal(1, $this->manager->count());

		$this->manager->createSection('test2', 'Testing2', 'test');
		Assert::equal(2, $this->manager->count());

		$sections = $this->manager->getSections();
		$section = \reset($sections);
		Assert::equal('Testing2', $section->getCaption());
	}

	public function testTree(): void {
		$section = $this->manager->getSection('test');

		$section->createItem('item', 'Item1');
		Assert::equal('Item1', $section->getItem('item')->getCaption());
		Assert::equal(1, $section->count());

		$section->createItem('item2', 'Item2', 'item');
		Assert::equal('Item2', $section->getItem('item2')->getCaption());
		Assert::equal(2, $section->count());

		$sections = $this->manager->getSections();
		$section = \reset($sections);
		Assert::equal('Item2', $section->getCaption());

		$item = $section->getItem('item');

		$item->createItem('subitem', 'Sub-Item1');
		Assert::equal('Item1', $item->getItem('item')->getCaption());
		Assert::equal(1, $item->count());

		$item->createItem('subitem2', 'Sub-Item2', 'subitem');
		Assert::equal('Sub-Item2', $item->getItem('subitem2')->getCaption());
		Assert::equal(2, $item->count());

		Assert::equal(2, $section->count());
		Assert::true($item->isTreeView());
		Assert::equal(1, $this->manager->count());

	}

}

(new NavigationTest())->run();