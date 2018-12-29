<?php

namespace application\models;

use application\models\User;

class MainUser extends User {

	const CONTENT = 'CONTENT';
	const VACANCIESLIST = 'VACANCIESLIST';
	const PAGELIST = 'PAGELIST';
	const USER_CHOICE = 'USER_CHOICE';
	const NEWS = 'NEWS';
	const NEWS_ON_INDEX = 'NEWS_ON_INDEX';
	const LOCATION = 'LOCATION';


	public function getContent($route, $ADDITIONALS = ['CONTENT']){
		foreach($ADDITIONALS as $item){
			switch($item){
				case self::CONTENT:
					$result[self::CONTENT] = $this->content($route);
					break;
				case self::USER_CHOICE:
					$result[self::USER_CHOICE] = $this->choice_list();
					break;
				case self::VACANCIESLIST:
					$result[self::VACANCIESLIST] = $this->vacancieslist();
					break;
				case self::PAGELIST:
					$result[self::PAGELIST] = $this->pagelist($route);
					break;
				case self::NEWS:
					$result[self::NEWS] = $this->getNews();
					break;
				case self::NEWS_ON_INDEX:
					$result[self::NEWS_ON_INDEX] = $this->getNews(true);
					break;
				case self::LOCATION:
					$result[self::LOCATION] = $this->getLocationID($route);
					break;
			}
		}
		return $result;
	}


	private function pagelist($route){
		$q = '	SELECT NP.HTML_TITLE as TITLE, NP.URI as LINK, NP.IMAGE, NP.IMAGE_SIGN  
				FROM PAGES as NP
				WHERE NP.ID_PARENT = (
					SELECT P.ID 
					FROM PAGES as P
						INNER JOIN LIB_LOCATIONS as LL 
						ON LL.ID = P.ID_LOCATION
					WHERE (LL.CONTROLLER = :CONTROLLER)
					AND (LL.ACTION = :ACTION))';
		$params = [
			'CONTROLLER' => $route['controller'],
			'ACTION' => $route['action']
		];
		return $this->db->row($q, $params);
	}

	private function vacancieslist(){
		return $this->db->row('SELECT TITLE, IMAGE, DESCR FROM DATA_VACANCIES');
	}

	private function getLocationID($route){
		$q = 'SELECT ID FROM LIB_LOCATIONS
			WHERE (CONTROLLER = :CONTROLLER) AND (ACTION = :ACTION)';
		$params = [
			'CONTROLLER' => $route['controller'],
			'ACTION' => $route['action']
		];
		return $this->db->column($q, $params);
	}

	private function getNews($on_index = false){
		$q = 'SELECT * FROM DATA_NEWS';
		if($on_index){
			$q .= ' WHERE ON_INDEX = 1';
		}
		$q .= ' ORDER BY DATE_ADD DESC, TIME_ADD DESC';
		#debug([$q, $this->db->row($q)]);
		return $this->db->row($q);
	}

}