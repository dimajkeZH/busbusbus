<?php

namespace application\controllers;

use application\controllers\AdminController;
use application\models\CronAdmin;

class AjaxAdminController extends AdminController {

	protected $SUPPORTED_METHODS = ['POST'];

	private $post;
	private $files;

	const MESSAGE__NO_VALUES = 'Нет параметров';
	const MESSAGE__BAD_VALUES = 'Не все параметры заполнены правильно';

	const MESSAGE__ADD_GOOD = 'Данные успешно добавлены';
	const MESSAGE__ADD_BAD = 'Добавление данных не произошло';

	const MESSAGE__CHANGE_GOOD = 'Данные успешно изменены';
	const MESSAGE__CHANGE_BAD = 'Изменение данных не произошло';

	const MESSAGE__DELETE_GOOD = 'Данные успешно удалены';
	const MESSAGE__DELETE_BAD = 'Удаление данных не произошло';

	public function saveConfigsAction(){
		$this->settings();
		if($this->post){
			if($this->model->verConfigs($this->post)){
				if($this->model->saveConfigs($this->post)){
					$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
				}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
			}$this->model->message(false, self::MESSAGE__BAD_VALUES);
		}else{
			$this->model->message(false, self::MESSAGE__NO_VALUES);
		}
	}

	public function saveContentAction(){
		$this->settings();
		if($this->post){
			if($this->model->verContent($this->post)){
				if($this->model->saveContent($this->post)){
					$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
				}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
			}$this->model->message(false, self::MESSAGE__BAD_VALUES);
		}else{
			$this->model->message(false, self::MESSAGE__NO_VALUES);
		}
	}

	public function saveSettingsAction(){
		$this->settings();
		if($this->post){
			if($this->model->verSettings($this->post)){
				if($this->model->saveSettings($this->post)){
					$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
				}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
			}$this->model->message(false, self::MESSAGE__BAD_VALUES);
		}else{
			$this->model->message(false, self::MESSAGE__NO_VALUES);
		}
	}




	public function savePagesAction(){
		$this->settings();
		if($this->model->savePages($this->route, $this->post, $this->files)){
			$this->model->updCron();
			$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
		}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
	}

	public function delPagesAction(){
		$this->settings();
		if($this->model->delPages($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD, ['redirect'=>'/admin']);
		}$this->model->message(false, self::MESSAGE__DELETE_BAD);
	}

	public function addPagesAction(){
		$this->settings();
		$ID = $this->model->addPages($this->post, $this->files);
		if($ID){
			$this->model->message(true, self::MESSAGE__ADD_GOOD, ['ID'=>$ID]);
		}$this->model->message(false, self::MESSAGE__ADD_BAD);
	}

	


	public function delBusesAction(){
		$this->settings();
		if($this->model->delBuses($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}$this->model->message(false, self::MESSAGE__DELETE_BAD);
	}

	public function delMinivansAction(){
		$this->settings();
		if($this->model->delMinivans($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}$this->model->message(false, self::MESSAGE__DELETE_BAD);
	}

	public function delNewsAction(){
		$this->settings();
		if($this->model->delNews($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}$this->model->message(false, self::MESSAGE__DELETE_BAD);
	}

	public function delVacanciesAction(){
		$this->settings();
		if($this->model->delVacancies($this->route)){
			$this->model->message(true, self::MESSAGE__DELETE_GOOD);
		}$this->model->message(false, self::MESSAGE__DELETE_BAD);
	}



	public function changeBusesAction(){
		$this->settings();
		if($this->model->changeBuses($this->post, $this->files)){
			$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
		}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
	}

	public function changeMinivansAction(){
		$this->settings();
		if($this->model->changeMinivans($this->post, $this->files)){
			$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
		}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
	}

	public function changeNewsAction(){
		$this->settings();
		if($this->model->changeNews($this->post, $this->files)){
			$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
		}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
	}

	public function changeVacanciesAction(){
		$this->settings();
		if($this->model->changeVacancies($this->post, $this->files)){
			$this->model->message(true, self::MESSAGE__CHANGE_GOOD);
		}$this->model->message(false, self::MESSAGE__CHANGE_BAD);
	}


	private function settings(){
		if(isset($_POST['DATA'])){
			$this->post = json_decode($_POST['DATA'], true);
		}
		$this->files = $_FILES;
		//file_get_contents('php://input')
	}
}