<?php declare(strict_types = 1);

namespace Netlte\Navigation\Tests\Helpers;


use Nette\Application\UI\Template;
use Nette\Localization\Translator;

class TestingTemplate extends \stdClass implements Template {

	private ?string $file = null;
	private ?Translator $translator = null;

	function render(): void {
		echo 'TestingTemplate';
	}

	function setTranslator(?Translator $translator = null): Template {
		$this->translator = $translator;
		return $this;
	}

	function getTranslator(): ?Translator {
		return $this->translator;
	}

	function setFile(string $file): Template {
		$this->file = $file;
		return $this;
	}

	function getFile(): ?string {
		return $this->file;
	}
}