<?php
namespace Pandora3\Widgets\FieldHidden;

use Pandora3\Widgets\FormField\FormField;

/**
 * Class FieldHidden
 * @package Pandora3\Widgets\FieldHidden
 */
class FieldHidden extends FormField {

	/** @var bool $isArray */
	protected $isArray;

	/** @var string $delimiter */
	protected $delimiter;

	/**
	 * @param string $name
	 * @param mixed $value
	 * @param array $context
	 */
	public function __construct(string $name, $value, array $context = []) {
		$this->isArray = $context['array'] ?? false;
		$this->delimiter = $context['delimiter'] ?? ',';
		parent::__construct($name, $value, $context);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getView(): string {
		return __DIR__.'/Views/Widget';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setValue($value): void {
		if ($this->isArray && is_string($value)) {
			$value = explode($this->delimiter, $value);
		}
		parent::setValue($value);
	}

	/**
	 * @return string
	 */
	public function getTextValue(): string {
		$value = $this->getValue();
		if ($this->isArray && is_array($value)) {
			return implode($this->delimiter, $value);
		}
		return $value ?? '';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getContext(): array {
		return array_replace( parent::getContext(), [
			'textValue' => $this->getTextValue()
		]);
	}

}