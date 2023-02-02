<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AccordionSection extends Component
{
	public int $formId;
	public string $icon;
	public string $title;
	public bool $isShow;

	/**
	 * Create a new component instance.
	 *
	 * @param $title
	 * @param $icon
	 * @param $isShow
	 *
	 * @throws \Exception
	 */
	public function __construct($title, $icon = '', $isShow = 'false')
	{
		$this->formId = random_int(1000, 9000);
		$this->icon   = $icon;
		$this->title  = $title;
		$this->isShow = $isShow;
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\View\View|string
	 */
	public function render()
	{
		return view('components.accordion-section');
	}
}
