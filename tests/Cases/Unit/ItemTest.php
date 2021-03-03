<?php declare(strict_types = 1);

namespace Netlte\Navigation\Tests\Cases\Unit;

use Netlte\Navigation\Item;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../bootstrap.php';
require_once __DIR__ . '/../../Helpers/NavigationFactory.php';

class ItemTest extends TestCase {

	public function testItemRenderCondition(): void {

		$item = new Item('Test');

		// Rendering should be allowed in default
		Assert::true($item->isRenderingAllowed());

		// Rendering should be disabled if any condition return false
		$item->addRenderCondition(function () {
			return true;
		});

		Assert::true($item->isRenderingAllowed());

		$item->addRenderCondition(function () {
			return false;
		});

		Assert::false($item->isRenderingAllowed());

		$item->addRenderCondition(function () {
			return true;
		});

		Assert::false($item->isRenderingAllowed());

	}

	public function testItemActivation(): void {
		$item = new Item('Test');

		// Active state should be false in default
		Assert::false($item->isActive());

		// Active state should be true if any condition return true
		$item->addActiveCondition(function () {
			return true;
		});

		Assert::true($item->isActive());

		$item->addActiveCondition(function () {
			return false;
		});

		Assert::true($item->isActive());

		$item->addActiveCondition(function () {
			return false;
		});

		Assert::true($item->isActive());

		$item = new Item('Test2');

		$item->addActiveCondition(function () {
			return false;
		});

		Assert::false($item->isActive());

		$item->addActiveCondition(function () {
			return true;
		});

		Assert::true($item->isActive());

	}

}

(new NavigationTest())->run();