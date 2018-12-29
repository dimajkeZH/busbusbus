<?php

namespace application\models;

use application\models\Admin;

class ApiAdmin extends Admin {


	public function getSiteTree(){
		$parents = $this->db->row('SELECT ID, HTML_TITLE, CAN_BE_SUPPLEMENTED FROM PAGES WHERE ID_PARENT = 0 ORDER BY LOC_NUMBER ASC');
		if(!$parents){
			return;
		}
		$obj = [];

		#debug($parents);
		foreach($parents as $parent){
			$parent_obj = [
				'ID' => $parent['ID'],
				'TITLE' => $parent['HTML_TITLE'],
				'CAN_BE_SUPPLEMENTED' => $parent['CAN_BE_SUPPLEMENTED'],
			];

			if(!$parent['CAN_BE_SUPPLEMENTED']){
				array_push($obj, $parent_obj);
				continue;
			}

			$parent_obj['CHILDRENS'] = $this->getChildrens($parent['ID']);

			array_push($obj, $parent_obj);
		}

		#debug($obj);
		return $obj;
	}

	private function getChildrens($ID_PARENT){
		$q = 'SELECT ID, HTML_TITLE, CAN_BE_SUPPLEMENTED FROM PAGES WHERE ID_PARENT = :ID_PARENT ORDER BY LOC_NUMBER ASC';
		$params = [
			'ID_PARENT'=> $ID_PARENT,
		];
		$childrens = $this->db->row($q, $params);
		$children_obj =[];

		foreach($childrens as $children){
			$subchildren_obj = [
				'ID' => $children['ID'],
				'TITLE' => $children['HTML_TITLE'],
				'CAN_BE_SUPPLEMENTED' => $children['CAN_BE_SUPPLEMENTED'],
			];

			if(!$children['CAN_BE_SUPPLEMENTED']){
				array_push($children_obj, $subchildren_obj);
				continue;
			}

			array_push($children_obj['CHILDRENS'], $this->getChildrens($children['ID']));

			array_push($children_obj, $subchildren_obj);
		}

		return $children_obj;
	}

	public function checkURI($post){
		$URI = $post['URI'];
		$ID = isset($post['ID']) ? $post['ID'] : 0;
		$CHECK_ID = $post['CHECK_ID'];

		$q = 'SELECT count(*) as `COUNT` FROM PAGES WHERE ' . ($CHECK_ID ? '(ID NOT IN (:ID)) AND ' : '') . '(URI LIKE :URI)';
		$params['URI'] = $URI;
		if($CHECK_ID){
			$params['ID'] = $ID;
		}
		$count = $this->db->column($q, $params);
		if($count == 0){
			return true;
		}
		return false;
	}




	public function getBuses($route){
		if(!$route['param']){
			return [];
		}
		$q = 'SELECT * FROM DATA_BUSES WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$return['FIELDS'] = $this->db->row($q, $params)[0];
		return $return;
	}

	public function getMinivans($route){
		if(!$route['param']){
			return [];
		}
		$q = 'SELECT * FROM DATA_MINIVANS WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$return['FIELDS'] = $this->db->row($q, $params)[0];
		return $return;
	}

	public function getNews($route){
		if(!$route['param']){
			return [];
		}
		$q = 'SELECT * FROM DATA_NEWS WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$return['FIELDS'] = $this->db->row($q, $params)[0];
		return $return;
	}

	public function getVacancies($route){
		if(!$route['param']){
			return [];
		}
		$q = 'SELECT * FROM DATA_VACANCIES WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$return['FIELDS'] = $this->db->row($q, $params)[0];
		return $return;
	}

}