<?php

namespace application\controllers;

use application\controllers\UserController;

class SecondUserController extends UserController {

	public function servicesAction() {
		$this->render($this->model->getContent($this->route,
			[
				$this->model::CONTENT,
				$this->model::USER_CHOICE,
			]
		));
	}

	public function busesAction() {
		$this->render($this->model->getContent($this->route,
			[
				$this->model::CONTENT,
				$this->model::USER_CHOICE,
			]
		));
	}

	public function minivansAction() {
		$this->render($this->model->getContent($this->route,
			[
				$this->model::CONTENT,
				$this->model::USER_CHOICE,
			]
		));	
	}

	public function excursionsAction() {
		$this->render($this->model->getContent($this->route,
			[
				$this->model::CONTENT,
				$this->model::USER_CHOICE,
			]
		));
	}

}