<?php

namespace application\models;

use application\models\User;

class SecondUser extends User {

	public function getContent($route) {
		#debug($route);
		$return['CONTENT'] = [];
		
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
				$return['CONTENT']['TABLE'] = $this->getTable($val);
			}elseif($var == 'MULTITABLE_ID'){
				$return['CONTENT']['MULTITABLE'] = $this->getMultitable($val);
			}elseif($var == 'IMAGES_ID'){
				$return['CONTENT']['IMAGES'] = $this->getImages($val);
			}elseif($var == 'LINKS_IS_BUSES' && $val == 1){
				$return['CONTENT']['LIST_BUSES'] = $this->getBuses();
			}elseif($var == 'LINKS_IS_MINIVANS' && $val == 1){
				$return['CONTENT']['LIST_MINIVANS'] = $this->getMinivans();
			}else{
				$return['CONTENT'][$var] = $val;
			}
		}
		#debug($return);

		return $return;
	}

	private function getTable($ID){
		return [];
	}

	private function getMultitable($ID){
		return [];
	}

	private function getImages($ID){
		return [];
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