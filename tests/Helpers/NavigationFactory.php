<?php declare(strict_types = 1);

namespace Netlte\Navigation\Tests\Helpers;

use Netlte\Navigation\Navigation;
use Nette\Application\PresenterFactory;
use Nette\ComponentModel\IComponent;
use Nette\Http\Request;
use Nette\Http\Response;
use Nette\Http\Session;
use Nette\Http\UrlScript;

/**
 * @author       Tomáš Holan <tomas@holan.dev>
 * @package      netlte/navigation
 * @copyright    Copyright © 2021, Tomáš Holan [www.holan.dev]
 */
class NavigationFactory {

	/**
	 * @return Navigation
	 */
	public function create(string $presenterName = 'Testing'): ?IComponent {
		$presenterFactory = new PresenterFactory();
		$presenterFactory->setMapping(['*' => 'Netlte\Navigation\Tests\Helpers\*Presenter']);

		/** @var TestingPresenter $presenter */
		$presenter = $presenterFactory->createPresenter($presenterName);

		$url = new UrlScript('http://localhost');
		$request = new Request($url);
		$response = new Response;
		$session = new Session($request, $response);

		$presenter->injectPrimary(null, null, null, $request, $response, $session);
		return $presenter->getComponent('navigation');
	}
}