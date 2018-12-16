<?php

namespace application\controllers;

use application\controllers\AdminController;

class ApiAdminController extends AdminController {

	protected $SUPPORTED_METHODS = ['POST'];

	const URI_CHECK_GOOD = 'Ссылка свободна для использования';
	const URI_CHECK_BAD = 'Ссылка уже используется';


	public function SiteTreeAction(){
		if($this->model->isAuth()){
			$content = $this->model->getSiteTree();
			$this->model->message(true, '', $content);
		}else{
			$this->model->message(false, self::NOT_AUTH);
		}
	}

	public function CheckURIAction(){
		if($this->model->isAuth()){
			$this->init();
			if($this->model->checkURI($this->post)){
				$this->model->message(true, self::URI_CHECK_GOOD);
			}else{
				$this->model->message(false, self::URI_CHECK_BAD);
			}
		}else{
			$this->model->message(false, self::NOT_AUTH);
		}
	}



	public function ShowBusesAction(){
		if($this->model->isAuth()){
			$content = $this->model->getBuses($this->route);
			$this->model->message(true, '', $content);
		}else{
			$this->model->message(false, self::NOT_AUTH);
		}
	}
	public function ShowMinivansAction(){
		if($this->model->isAuth()){
			$content = $this->model->getMinivans($this->route);
			$this->model->message(true, '', $content);
		}else{
			$this->model->message(false, self::NOT_AUTH);
		}
	}
	public function ShowNewsAction(){
		if($this->model->isAuth()){
			$content = $this->model->getNews($this->route);
			$this->model->message(true, '', $content);
		}else{
			$this->model->message(false, self::NOT_AUTH);
		}
	}
	public function ShowVacanciesAction(){
		if($this->model->isAuth()){
			$content = $this->model->getVacancies($this->route);
			$this->model->message(true, '', $content);
		}else{
			$this->model->message(false, self::NOT_AUTH);
		}
	}
}