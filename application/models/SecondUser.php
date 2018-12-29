<?php

namespace application\models;

use application\models\User;

class SecondUser extends User {


	const CONTENT = 'CONTENT';
	const VACANCIESLIST = 'VACANCIESLIST';
	const PAGELIST = 'PAGELIST';
	const USER_CHOICE = 'USER_CHOICE';
	const NEWS = 'NEWS';
	const NEWS_ON_INDEX = 'NEWS_ON_INDEX';
	const LOCATION = 'LOCATION';


	public function getContent($route, $ADDITIONALS = ['CONTENT']){
		$result = [];
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


	public function content($route) {
		#debug($route);
		$return = [];
		
		$q = 'SELECT P.ID, P.URI, LL.CONTROLLER, LL.ACTION FROM PAGES as P INNER JOIN LIB_LOCATIONS as LL ON P.ID_LOCATION = LL.ID WHERE LL.CONTROLLER = :CONTROLLER AND LL.ACTION = :ACTION AND P.URI = :URI';
		$params = [
			'CONTROLLER' => $route['controller'],
			'ACTION' => $route['action'],
			'URI' => $route['param'],
		];
		$ID_PAGE = $this->db->column($q, $params);
		#debug($ID_PAGE);

		$q = 'SELECT FIELDS.VAR, CONTENT.VAL FROM PAGE_CONTENT as CONTENT LEFT JOIN LIB_VIEW_FIELDS as FIELDS ON FIELDS.ID = CONTENT.ID_FIELD WHERE ID_PAGE = :ID_PAGE';
		$params = [
			'ID_PAGE' => $ID_PAGE,
		];
		$CONTENT = $this->db->row($q, $params);
		#debug($CONTENT);

		foreach($CONTENT as $item){
			$var = $item['VAR'];
			$val = $item['VAL'];

			if($var == 'TABLE_ID'){
				$return['TABLE'] = $this->getTable($val);
			}elseif($var == 'MULTITABLE_ID'){
				$return['MULTITABLE'] = $this->getMultitable($val);
			}elseif($var == 'IMAGES_ID'){
				$return['IMAGES'] = $this->getImages($val);
			}elseif($var == 'LINKS_IS_BUSES' && $val == 1){
				$return['LIST_BUSES'] = $this->getBuses();
			}elseif($var == 'LINKS_IS_MINIVANS' && $val == 1){
				$return['LIST_MINIVANS'] = $this->getMinivans();
			}else{
				$return[$var] = $val;
			}
		}
		#debug($return);

		return $return;
	}

	private function getTable($ID){
		$result = [];

		$result = $this->db->row('SELECT ROW, COL, VAL FROM DATA_TABLE WHERE ID_TABLE = :ID_TABLE', ['ID_TABLE' => $ID]);
		foreach($result as $val){
			$return[$val['ROW']][$val['COL']] = $val['VAL'];
		}

		return $return;
	}

	private function getMultitable($ID){
		$return = [];

		$main_result = $this->db->row('SELECT ID, SUBTITLE FROM DATA_MULTITABLE WHERE ID_MULTITABLE = :ID_MULTITABLE ORDER BY SERIAL_NUMBER ASC', ['ID_MULTITABLE' => $ID]);
		foreach($main_result as $table_key => $table){
			$return[$table_key]['SUBTITLE'] = $table['SUBTITLE'];

			$q = 'SELECT ROW, COL, VAL FROM DATA_MULTITABLE_CONTENT WHERE ID_DATA_MULTITABLE = :ID_DATA_MULTITABLE';
			$params = [
				'ID_DATA_MULTITABLE' => $table['ID']
			];
			
			$inner_result = $this->db->row($q, $params);
			foreach($inner_result as $table_data){
				$return[$table_key]['DATA'][$table_data['ROW']][$table_data['COL']] = $table_data['VAL'];
			}
		}
		#debug($return);
		return $return;
	}

	private function getImages($ID){
		return $this->db->row('SELECT `IMAGES_IMAGE_LINK` as `LINK`, `IMAGES_IMAGE_SUBTITLE` as `SUBTITLE`, `IMAGES_IMAGE_SIGN` as `SIGN` FROM DATA_IMAGES WHERE ID_IMAGES = :ID_IMAGES ORDER BY SERIAL_NUMBER ASC', ['ID_IMAGES' => $ID]);
	}


	private function getBuses(){
		return $this->getTransportList('DATA_BUSES');
	}

	private function getMinivans(){
		return $this->getTransportList('DATA_MINIVANS');
	}

	private function getTransportList($TABLE){
		$return = [];
		$countries = $this->getCountries();
		foreach($countries as $key => $country){
			$id_country = $country['ID'];
			$q = 'SELECT * FROM ' . $TABLE . ' WHERE ID_COUNTRY = :ID_COUNTRY ORDER BY SERIAL_NUMBER ASC';
			$params = [
				'ID_COUNTRY' => $id_country,
			];

			$data_country = [];
			$raw_data_country = $this->db->row($q, $params);
			
			if(count($raw_data_country) == 0){
				continue;
			}

			foreach($raw_data_country as $data_key => $data_val){
				$data_country[$data_key]['TITLE'] = $data_val['TITLE'];
				
				$images_isset = $data_val['IMAGE_INNER'] != ''
								&& $data_val['IMAGE_OUTER'] != '';
				$text_isset = $data_val['TITLE'] != ''
								&& $data_val['TECH_TITLE'] != ''
								&& $data_val['TECH_DESCR'] != '';
				if($images_isset && $text_isset){
					$data_country[$data_key]['URI'] = $data_val['URI'];
				}
			}

			$country_title = $country['TITLE'];
			$country_image = $country['IMAGE'];

			$return[$key] = [
				'TITLE' => $country_title,
				'IMAGE' => $country_image,
				'LIST' => $data_country,
			];
		}
		#debug($return);
		return $return;
	}

	private function getCountries(){
		return $this->db->row('SELECT ID, TITLE, IMAGE FROM DATA_COUNTRIES ORDER BY SERIAL_NUMBER ASC');
	}
}