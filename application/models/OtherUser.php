<?php

namespace application\models;

use application\core\Model;

class OtherUser extends User {


	public function getHeaders($route){
		$q = 'SELECT HTML_TITLE, HTML_DESCR, HTML_KEYWORDS FROM PAGES AS P INNER JOIN LIB_LOCATIONS AS LL ON LL.ID = P.ID_LOCATION WHERE (LL.CONTROLLER = :CONTROLLER) AND (LL.ACTION = :ACTION)';
		$params = [
			'CONTROLLER' => $route['controller'],
			'ACTION' => $route['action']
		];
		#debug([$this->db->row($q, $params), $q, $params]);
		$result = $this->db->row($q, $params);
		$result = (count($result) > 0) ? $result[0] : [];
		return $result;
	}

	public function getView($route){
		$q = 'SELECT V.NAME FROM LIB_VIEWS as V INNER JOIN (PAGES AS P INNER JOIN LIB_LOCATIONS AS L ON L.ID = P.ID_LOCATION) ON P.ID_VIEW = V.ID WHERE (L.CONTROLLER = :CONTROLLER) AND (L.ACTION = :ACTION)';
		$params = [
			'CONTROLLER' => $route['controller'],
			'ACTION' => $route['action'],
		];
		return $this->db->column($q, $params);
	}

	public function getNews($route){
		if($route['param'] == 0){
			$route['param'] = 1;
		}
		$countNews = 5;
		$limA = ($route['param'] - 1) * $countNews;
		$allcountNews = $this->db->column('SELECT COUNT(ID) FROM DATA_NEWS;');
		$allcountPage = intdiv($allcountNews, $countNews);
		if($allcountNews % $countNews > 0){
			$allcountPage++;
		}
		if($route['param'] > $allcountPage AND $allcountPage > 1){
			\application\core\View::errorCode(404);
		}
		$result['PAGINATION'] = $this->pagination($route['param'], $allcountPage);
		$result['PAGE'] = $route['param'];
		$result['NEWSLIST'] = $this->db->row('SELECT * FROM DATA_NEWS ORDER BY DATE_ADD DESC, TIME_ADD DESC LIMIT '.$limA.','.$countNews.';');
		$result['CONTENT'] = $this->content($route);
		#debug($result);
		return $result;
	}

	public function getBus($route){
		$params = ['URI' => $route['param']];

		$q = 'SELECT * FROM DATA_BUSES WHERE URI LIKE :URI';
		$bus = $this->db->row($q, $params);
		$q = 'SELECT * FROM DATA_MINIVANS WHERE URI LIKE :URI';
		$minivan = $this->db->row($q, $params);

		$is_bus = count($bus) > 0;
		$is_minivan = count($minivan) > 0;

		#debug([$bus, $minivan, $is_bus, $is_minivan]);

		if($is_bus && !$is_minivan){
			$return['CONTENT'] = $bus[0];
		}elseif(!$is_bus && $is_minivan){
			$return['CONTENT'] = $minivan[0];
		}else{
			return false;
		}

		$return['IS_BUS'] = $is_bus;
		$return['IS_MINIVAN'] = $is_minivan;
		return $return;
	}

}