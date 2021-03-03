<?php declare(strict_types = 1);

namespace Netlte\Navigation\Tests\Helpers;

use Netlte\Navigation\Navigation;
use Nette\Application\UI\Presenter;

final class TestingPresenter extends Presenter {

	protected function createComponentNavigation(): Navigation {
		return new Navigation();
	}
}