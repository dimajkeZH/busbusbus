<?php

namespace application\models;

use application\models\Admin;

class AjaxAdmin extends Admin {

	public function updCron(){
		$c = new CronAdmin();
		$c->updMenu();
		$c->updSlicks();
	}

	const IMAGE_NAME_LEN = 64;
	const IMAGE_DIR = '/assets/img/';


	const IMAGE_CATALOG_SERVICES = 'services/';

	const IMAGE_CATALOG_BUSES = 'buses/mest/';
	const IMAGE_CATALOG_BUS = 'buses/bus_catalog/';

	const IMAGE_CATALOG_MINIVANS = 'minivans/mest/';
	const IMAGE_CATALOG_MINIVAN = 'minivans/minivan_catalog/';

	const IMAGE_CATALOG_EXCURSIONS = 'excursions/';

	const IMAGE_CATALOG_VACANCIES = 'vacancies/';

	const IMAGE_CATALOG_NEWS = 'news/';

	const IMAGE_TEMPLATE_HEADER_GROUP = 'templates/header_group/';
	const IMAGE_TEMPLATE_HEADER_PAGE = 'templates/header_page/';
	const IMAGE_TEMPLATE_BLOCK_IMAGES = 'templates/block_images/';

	const TEMPLATES_DIR = '/application/views/mainAdmin/templates/';

	const IMAGE_SLICK_BUSES = 'slick/';
	const IMAGE_SLICK_MINIVANS = 'slick/';

	public function verConfigs($post){
		return true;
	}
	public function saveConfigs($post){

	}


	public function verContent($post){
		return true;
	}
	public function saveContent($post){

	}


	public function verSettings($post){
		return true;
	}
	public function saveSettings($post){

	}

	/************************************************************* CATALOGS *************************************************************/

	public function delBuses($route){
		$q = 'DELETE FROM DATA_BUSES WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$old_files = $this->db->row('SELECT IMAGE_INNER, IMAGE_OUTER FROM DATA_BUSES WHERE ID = ' . $route['param']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];

		if($this->db->bool($q, $params)){
			$this->deleteImage(self::IMAGE_CATALOG_BUS, $old_files['IMAGE_INNER']);
			$this->deleteImage(self::IMAGE_CATALOG_BUS, $old_files['IMAGE_OUTER']);
			return true;
		}
		return false;
	}

	public function delMinivans($route){
		$q = 'DELETE FROM DATA_MINIVANS WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$old_files = $this->db->row('SELECT IMAGE_INNER, IMAGE_OUTER FROM DATA_MINIVANS WHERE ID = ' . $route['param']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];

		if($this->db->bool($q, $params)){
			$this->deleteImage(self::IMAGE_CATALOG_MINIVAN, $old_files['IMAGE_INNER']);
			$this->deleteImage(self::IMAGE_CATALOG_MINIVAN, $old_files['IMAGE_OUTER']);
			return true;
		}
		return false;
	}

	public function delNews($route){
		$q = 'DELETE FROM DATA_NEWS WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];
		$old_files = $this->db->row('SELECT IMAGE FROM DATA_NEWS WHERE ID = ' . $route['param']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];

		if($this->db->bool($q, $params)){
			$this->deleteImage(self::IMAGE_CATALOG_NEWS, $old_files['IMAGE']);
			return true;
		}
		return false;
	}

	public function delVacancies($route){
		$q = 'DELETE FROM DATA_VACANCIES WHERE ID = :ID';
		$params = [
			'ID' => $route['param'],
		];

		$old_files = $this->db->row('SELECT IMAGE FROM DATA_VACANCIES WHERE ID = ' . $route['param']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];

		if($this->db->bool($q, $params)){
			$this->deleteImage(self::IMAGE_CATALOG_VACANCIES, $old_files['IMAGE']);
			return true;
		}
		return false;
	}





	public function changeBuses($post, $files){
		if(!isset($post['ID'])){
			return false;
		};

		$params = [
			'TITLE' => $post['TITLE'],
			'ID_COUNTRY' => $post['ID_COUNTRY'],
			'URI' => $post['URI'],
			'TECH_TITLE' => $post['TECH_TITLE'],
			'TECH_DESCR' => $post['TECH_DESCR'],
			'SUBTITLE' => $post['SUBTITLE'],
			'TEXT' => $post['TEXT'],
		];

		if($post['SERIAL_NUMBER'] && $post['SERIAL_NUMBER'] != ''){
			$params['SERIAL_NUMBER'] = $post['SERIAL_NUMBER'];
			$old_serial_number = $this->db->column('SELECT SERIAL_NUMBER FROM DATA_BUSES WHERE ID = '.$post['ID']);
			if($old_serial_number != $post['SERIAL_NUMBER']){
				$this->db->bool('UPDATE DATA_BUSES SET SERIAL_NUMBER = SERIAL_NUMBER + 1 WHERE (SERIAL_NUMBER >= ' . $post['SERIAL_NUMBER'] . ') AND ID_COUNTRY = ' . $post['ID_COUNTRY']);
			}
		}else{
			$params['SERIAL_NUMBER'] = $this->db->column('SELECT MAX(`SERIAL_NUMBER`) + 1 FROM DATA_BUSES WHERE ID_COUNTRY = ' . $post['ID_COUNTRY']);
		}

		$old_files = $this->db->row('SELECT IMAGE_INNER, IMAGE_OUTER FROM DATA_BUSES WHERE ID = ' . $post['ID']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];
		$params['IMAGE_INNER'] = isset($old_files['IMAGE_INNER']) ? $old_files['IMAGE_INNER'] : '';
		$params['IMAGE_OUTER'] = isset($old_files['IMAGE_OUTER']) ? $old_files['IMAGE_OUTER'] : '';
		foreach($files as $name => $file){
			if($post['ID'] == 0){
				$params[$name] = $this->loadImage(self::IMAGE_CATALOG_BUS, $file);
			}else{
				if(isset($old_files[$name]) && $old_files[$name]!= ''){
					$params[$name] = $this->replaceImage(self::IMAGE_CATALOG_BUS, $old_files[$name], $file);
				}else{
					$params[$name] = $this->loadImage(self::IMAGE_CATALOG_BUS, $file);
				}
			}
		}

		if($post['ID'] == 0){
			$q = 'INSERT INTO DATA_BUSES (TITLE, ID_COUNTRY, URI, TECH_TITLE, TECH_DESCR, SUBTITLE, TEXT, SERIAL_NUMBER, IMAGE_INNER, IMAGE_OUTER) VALUES (:TITLE, :ID_COUNTRY, :URI, :TECH_TITLE, :TECH_DESCR, :SUBTITLE, :TEXT, :SERIAL_NUMBER, :IMAGE_INNER, :IMAGE_OUTER)';
		}else{
			$q = 'UPDATE DATA_BUSES SET TITLE = :TITLE, ID_COUNTRY = :ID_COUNTRY, URI = :URI, TECH_TITLE = :TECH_TITLE, TECH_DESCR = :TECH_DESCR, SUBTITLE = :SUBTITLE, TEXT = :TEXT, SERIAL_NUMBER = :SERIAL_NUMBER, IMAGE_INNER = :IMAGE_INNER, IMAGE_OUTER = :IMAGE_OUTER WHERE ID = :ID';
			$params['ID'] = $post['ID'];
		}
		#debug([$this->db->bool($q, $params),$q, $params]);
		return $this->db->bool($q, $params);
	}

	public function changeMinivans($post, $files){
		if(!isset($post['ID'])){
			return false;
		};

		$params = [
			'TITLE' => $post['TITLE'],
			'ID_COUNTRY' => $post['ID_COUNTRY'],
			'URI' => $post['URI'],
			'TECH_TITLE' => $post['TECH_TITLE'],
			'TECH_DESCR' => $post['TECH_DESCR'],
			'SUBTITLE' => $post['SUBTITLE'],
			'TEXT' => $post['TEXT'],
		];
		if($post['SERIAL_NUMBER'] && $post['SERIAL_NUMBER'] != ''){
			$params['SERIAL_NUMBER'] = $post['SERIAL_NUMBER'];
			$old_serial_number = $this->db->column('SELECT SERIAL_NUMBER FROM DATA_MINIVANS WHERE ID = '.$post['ID']);
			if($old_serial_number != $post['SERIAL_NUMBER']){
				$this->db->bool('UPDATE DATA_MINIVANS SET SERIAL_NUMBER = SERIAL_NUMBER + 1 WHERE (SERIAL_NUMBER >= ' . $post['SERIAL_NUMBER'] . ') AND ID_COUNTRY = ' . $post['ID_COUNTRY']);
			}
		}else{
			$params['SERIAL_NUMBER'] = $this->db->column('SELECT MAX(`SERIAL_NUMBER`) + 1 FROM DATA_MINIVANS WHERE ID_COUNTRY = ' . $post['ID_COUNTRY']);
			if($params['SERIAL_NUMBER'] == ''){
				$params['SERIAL_NUMBER'] = 1;
			}
		}

		$old_files = $this->db->row('SELECT IMAGE_INNER, IMAGE_OUTER FROM DATA_MINIVANS WHERE ID = ' . $post['ID']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];
		$params['IMAGE_INNER'] = isset($old_files['IMAGE_INNER']) ? $old_files['IMAGE_INNER'] : '';
		$params['IMAGE_OUTER'] = isset($old_files['IMAGE_OUTER']) ? $old_files['IMAGE_OUTER'] : '';
		foreach($files as $name => $file){
			if($post['ID'] == 0){
				$params[$name] = $this->loadImage(self::IMAGE_CATALOG_MINIVAN, $file);
			}else{
				if(isset($old_files[$name]) && $old_files[$name]!= ''){
					$params[$name] = $this->replaceImage(self::IMAGE_CATALOG_MINIVAN, $old_files[$name], $file);
				}else{
					$params[$name] = $this->loadImage(self::IMAGE_CATALOG_MINIVAN, $file);
				}
			}
		}

		if($post['ID'] == 0){
			$q = 'INSERT INTO DATA_MINIVANS (TITLE, ID_COUNTRY, URI, TECH_TITLE, TECH_DESCR, SUBTITLE, TEXT, SERIAL_NUMBER, IMAGE_INNER, IMAGE_OUTER) VALUES (:TITLE, :ID_COUNTRY, :URI, :TECH_TITLE, :TECH_DESCR, :SUBTITLE, :TEXT, :SERIAL_NUMBER, :IMAGE_INNER, :IMAGE_OUTER)';
		}else{
			$q = 'UPDATE DATA_MINIVANS SET TITLE = :TITLE, ID_COUNTRY = :ID_COUNTRY, URI = :URI, TECH_TITLE = :TECH_TITLE, TECH_DESCR = :TECH_DESCR, SUBTITLE = :SUBTITLE, TEXT = :TEXT, SERIAL_NUMBER = :SERIAL_NUMBER, IMAGE_INNER = :IMAGE_INNER, IMAGE_OUTER = :IMAGE_OUTER WHERE ID = :ID';
			$params['ID'] = $post['ID'];
		}
		#debug([$this->db->bool($q, $params),$q, $params]);
		return $this->db->bool($q, $params);
	}

	public function changeNews($post, $files){
				if(!isset($post['ID'])){
			return false;
		};

		$params = [
			'TITLE' => $post['TITLE'],
			'TEXT' => $post['TEXT'],
			'ON_INDEX' => 0, #$post['ON_INDEX'],
		];

		$old_files = $this->db->row('SELECT IMAGE FROM DATA_NEWS WHERE ID = ' . $post['ID']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];
		$params['IMAGE'] = isset($old_files['IMAGE']) ? $old_files['IMAGE'] : '';

		foreach($files as $name => $file){
			if($post['ID'] == 0){
				$params[$name] = $this->loadImage(self::IMAGE_CATALOG_NEWS, $file);
			}else{
				if(isset($old_files[$name]) && $old_files[$name]!= ''){
					$params[$name] = $this->replaceImage(self::IMAGE_CATALOG_NEWS, $old_files[$name], $file);
				}else{
					$params[$name] = $this->loadImage(self::IMAGE_CATALOG_NEWS, $file);
				}
			}
		}

		if($post['ID'] == 0){
			$q = 'INSERT INTO DATA_NEWS (TITLE, DATE_ADD, TIME_ADD, TEXT, ON_INDEX, IMAGE) VALUES (:TITLE, CURDATE(), CURTIME(), :TEXT, :ON_INDEX, :IMAGE)';
		}else{
			$q = 'UPDATE DATA_NEWS SET TITLE = :TITLE, TEXT = :TEXT, ON_INDEX = :ON_INDEX, IMAGE = :IMAGE WHERE ID = :ID';
			$params['ID'] = $post['ID'];
		}
		#debug([$this->db->bool($q, $params),$q, $params]);
		return $this->db->bool($q, $params);
	}

	public function changeVacancies($post, $files){
				if(!isset($post['ID'])){
			return false;
		};

		$params = [
			'TITLE' => $post['TITLE'],
			'DESCR' => $post['DESCR'],
		];

		$old_files = $this->db->row('SELECT IMAGE FROM DATA_VACANCIES WHERE ID = ' . $post['ID']);
		$old_files = count($old_files) == 1 ? $old_files[0] : [];
		$params['IMAGE'] = isset($old_files['IMAGE']) ? $old_files['IMAGE'] : '';

		foreach($files as $name => $file){
			if($post['ID'] == 0){
				$params[$name] = $this->loadImage(self::IMAGE_CATALOG_VACANCIES, $file);
			}else{
				if(isset($old_files[$name]) && $old_files[$name]!= ''){
					$params[$name] = $this->replaceImage(self::IMAGE_CATALOG_VACANCIES, $old_files[$name], $file);
				}else{
					$params[$name] = $this->loadImage(self::IMAGE_CATALOG_VACANCIES, $file);
				}
			}
		}

		if($post['ID'] == 0){
			$q = 'INSERT INTO DATA_VACANCIES (TITLE, IMAGE, DESCR) VALUES (:TITLE, :IMAGE, :DESCR)';
		}else{
			$q = 'UPDATE DATA_VACANCIES SET TITLE = :TITLE, IMAGE = :IMAGE, DESCR = :DESCR WHERE ID = :ID';
			$params['ID'] = $post['ID'];
		}
		#debug([$this->db->bool($q, $params),$q, $params]);
		return $this->db->bool($q, $params);
	}


	/************************************************************* CATALOGS END *************************************************************/



	/************************************************************* PAGES *************************************************************/
	
	public function savePages($route, $post, $files){
		$ID = $route['param'];
		$ID_PARENT = isset($post['ID_PARENT']) ? $post['ID_PARENT'] : 0;

		if($ID_PARENT > 0){
			$ID_LOCATION = $this->db->column('SELECT `ID_LOCATION` + 1 as `ID_LOCATION` FROM PAGES WHERE ID = :ID_PARENT', ['ID_PARENT' => $ID_PARENT]);
			#debug([1, $ID_LOCATION]);
		}else{
			$q = 'SELECT ID_LOCATION FROM PAGES WHERE ID = :ID';
			$params = [
				'ID' => $ID,
			];
			$ID_LOCATION = $this->db->column($q, $params);
			#debug([2, $ID_LOCATION, $q, $params]);
		}

		if(isset($post['LOC_NUMBER']) && $post['LOC_NUMBER'] != ''){
			$LOC_NUMBER = $post['LOC_NUMBER'];
			$OLD_LOC_NUMBER = $this->db->column('SELECT LOC_NUMBER FROM PAGES WHERE ID = :ID', ['ID' => $ID]);
			if($OLD_LOC_NUMBER != $LOC_NUMBER){
				$min = $OLD_LOC_NUMBER < $LOC_NUMBER;
				$this->db->bool('UPDATE PAGES SET LOC_NUMBER = LOC_NUMBER ' . ($min ? '-' : '+') . ' 1
					WHERE (ID_LOCATION = :ID_LOCATION)
					AND LOC_NUMBER >' . ($min ? '' : '=') . ' :MIN_LOC_NUMBER
					AND LOC_NUMBER <' . ($min ? '=' : '') . ' :MAX_LOC_NUMBER',
					[
						'ID_LOCATION' => $ID_LOCATION,
						'MIN_LOC_NUMBER' => $min ? $OLD_LOC_NUMBER : $LOC_NUMBER,
						'MAX_LOC_NUMBER' => $min ? $LOC_NUMBER : $OLD_LOC_NUMBER,
					]);
			}
		}else{
			$LOC_NUMBER = $this->db->column('SELECT MAX(LOC_NUMBER) + 1 as `NUMBER` FROM PAGES WHERE ID_LOCATION = :ID_LOCATION', ['ID_LOCATION' => $ID_LOCATION]);
		}

		$dir = '';
		switch($ID_LOCATION){
			case 3:
				$dir = self::IMAGE_CATALOG_SERVICES;
				break;
			case 5:
				$dir = self::IMAGE_SLICK_BUSES;
				break;
			case 7:
				$dir = self::IMAGE_SLICK_MINIVANS;
				break;
			case 9:
				$dir = '';
				break;
		}

		$old_file = $this->db->column('SELECT IMAGE FROM PAGES WHERE ID = :ID', ['ID' => $ID]);
		$IMAGE = '';

		if(isset($old_file) && $old_file != ''){
			if(isset($files['IMAGE'])){
				$IMAGE = $this->replaceImage($dir, $old_file, $files['IMAGE']);
			}else{
				$IMAGE = $old_file;
			}
		}else{
			if(isset($files['IMAGE'])){
				$IMAGE = $this->loadImage($dir,  $files['IMAGE']);
			}
		}

		#debug([$ID_LOCATION, $ID_PARENT, $dir, $image, $files]);

		$tran[] = [
			'sql' => 'UPDATE PAGES SET ID_LOCATION = :ID_LOCATION, ID_PARENT = :ID_PARENT, URI = :URI, LOC_NUMBER = :LOC_NUMBER, CHOICE_TITLE = :CHOICE_TITLE, HTML_TITLE = :HTML_TITLE, IMAGE = :IMAGE, IMAGE_SIGN = :IMAGE_SIGN, HTML_DESCR = :HTML_DESCR, HTML_KEYWORDS = :HTML_KEYWORDS WHERE ID = :ID',
			'params' => [
				'ID'					=> $ID,
				'HTML_TITLE'			=> isset($post['HTML_TITLE']) ? $post['HTML_TITLE'] : '',
				'HTML_DESCR'			=> isset($post['HTML_DESCR']) ? $post['HTML_DESCR'] : '',
				'HTML_KEYWORDS'			=> isset($post['HTML_KEYWORDS']) ? $post['HTML_KEYWORDS'] : '',
				'URI'					=> isset($post['URI']) ? $post['URI'] : '',
				'ID_PARENT'				=> $ID_PARENT,
				'ID_LOCATION'			=> $ID_LOCATION,
				'LOC_NUMBER'			=> $LOC_NUMBER,
				'CHOICE_TITLE'			=> isset($post['CHOICE_TITLE']) ? $post['CHOICE_TITLE'] : '',
				'IMAGE'					=> $IMAGE,
				'IMAGE_SIGN'			=> isset($post['IMAGE_SIGN']) ? $post['IMAGE_SIGN'] : '',
			],
		];

		$old_converted_data = [];
		$old_data = $this->db->row('SELECT PC.VAL, LVF.VAR FROM PAGE_CONTENT as PC INNER JOIN LIB_VIEW_FIELDS as LVF ON LVF.ID = PC.ID_FIELD WHERE PC.ID_PAGE = :ID_PAGE', ['ID_PAGE' => $ID]);
		foreach($old_data as $key => $val){
			$old_converted_data[$val['VAR']] = $val['VAL'];
		}
		$old_data = $old_converted_data;
		unset($old_converted_data);

		$id_view = $this->db->column('SELECT ID_VIEW FROM PAGES WHERE ID = :ID', ['ID' => $ID]);
		$fields = $this->db->row('SELECT FIELDS.ID, FIELDS.VAR, TYPES.NAME as TYPE FROM LIB_VIEW_FIELDS as FIELDS LEFT JOIN LIB_FIELD_TYPES as TYPES ON TYPES.ID = FIELDS.CMS_TYPE WHERE FIELDS.ID_VIEW = :ID_VIEW', ['ID_VIEW' => $id_view]);

		#debug($fields);
		foreach($fields as $field){
			if($field['TYPE'] == 'TABLE'){
				if(isset($post['TABLE'])){
					$isset_table = isset($old_data['TABLE_ID']) && $old_data['TABLE_ID'] > 0;

					if($isset_table){
						$tran[] = [
							'sql' => 'DELETE FROM DATA_TABLE WHERE ID_TABLE = :ID_TABLE',
							'params' => [
								'ID_TABLE' => $old_data['TABLE_ID'],
							],
						];
						$max_id = $old_data['TABLE_ID'];
					}else{
						$max_id = $this->db->column('SELECT MAX(ID_TABLE) + 1 FROM DATA_TABLE');
						if($max_id == '') $max_id = 1;

						$tran[] = [
							'sql' => 'INSERT INTO PAGE_CONTENT (ID_PAGE, ID_FIELD, VAL) VALUES (:ID_PAGE, :ID_FIELD, :VAL)',
							'params' => [
								'ID_PAGE' => $ID,
								'ID_FIELD' => $field['ID'],
								'VAL' => $max_id,
							],
						];
					}

					$cells = $this->DataTableToSimpleArray(json_decode($post['TABLE']['DATA']));
					foreach($cells as $cell){
						$tran[] = [
							'sql' => 'INSERT INTO DATA_TABLE (ID_TABLE, ROW, COL, VAL) VALUES (:ID_TABLE, :ROW, :COL, :VAL)',
							'params' => [
								'ID_TABLE' => $max_id,
								'ROW' => $cell['ROW'],
								'COL' => $cell['COL'],
								'VAL' => $cell['VAL'],
							],
						];
					}				
				}
			}elseif($field['TYPE'] == 'MULTITABLE'){
				if(isset($post['MULTITABLE'])){
					$multitable = $post['MULTITABLE'];

					$isset_table = isset($old_data['MULTITABLE_ID']) && $old_data['MULTITABLE_ID'] > 0;

					if($isset_table){
						$tran[] = [
							'sql' => 'DELETE FROM DATA_MULTITABLE_CONTENT WHERE ID_DATA_MULTITABLE IN (SELECT ID FROM DATA_MULTITABLE WHERE ID_MULTITABLE = :ID_MULTITABLE)',
							'params' => [
								'ID_MULTITABLE' => $old_data['MULTITABLE_ID'],
							],
						];
						$tran[] = [
							'sql' => 'DELETE FROM DATA_MULTITABLE WHERE ID_MULTITABLE = :ID_MULTITABLE',
							'params' => [
								'ID_MULTITABLE' => $old_data['MULTITABLE_ID'],
							],
						];
						$max_id = $old_data['MULTITABLE_ID'];
					}else{
						$max_id = $this->db->column('SELECT MAX(ID_MULTITABLE) + 1 FROM DATA_MULTITABLE');
						if($max_id == '') $max_id = 1;

						$tran[] = [
							'sql' => 'INSERT INTO PAGE_CONTENT (ID_PAGE, ID_FIELD, VAL) VALUES (:ID_PAGE, :ID_FIELD, :VAL)',
							'params' => [
								'ID_PAGE' => $ID,
								'ID_FIELD' => $field['ID'],
								'VAL' => $max_id,
							],
						];
					}

					foreach($multitable['TABLES'] as $table_key => $table_val){
						$tran[] = [
							'sql' => 'INSERT INTO DATA_MULTITABLE (`ID_MULTITABLE`, `SUBTITLE`, `SERIAL_NUMBER`) VALUES (:ID_MULTITABLE, :SUBTITLE, :SERIAL_NUMBER)',
							'params' => [
								'ID_MULTITABLE' => $max_id,
								'SUBTITLE' => $post['TITLE_TABLE' . $table_key] ?? '',
								'SERIAL_NUMBER' => $table_key,
							],
						];

						$cells = $this->DataTableToSimpleArray(json_decode($table_val['DATA']));
						foreach($cells as $cell){
							$tran[] = [
								'sql' => 'INSERT INTO DATA_MULTITABLE_CONTENT (`ID_DATA_MULTITABLE`, `ROW`, `COL`, `VAL`) VALUES ((SELECT MAX(ID) FROM DATA_MULTITABLE), :ROW, :COL, :VAL)',
								'params' => [
									'ROW' => $cell['ROW'],
									'COL' => $cell['COL'],
									'VAL' => $cell['VAL'],
								],
							];
						}
					}
				}
				#debug($tran);

			}elseif($field['TYPE'] == 'IMAGES'){
				$images = [];
				$old_images = $this->db->row('SELECT IMAGES_IMAGE_LINK FROM DATA_IMAGES WHERE  ID_IMAGES = :ID_IMAGES', ['ID_IMAGES' => $old_data['IMAGES_ID'] ?? 0]);

				foreach($post as $key => $val){
					if(preg_match('#^IMAGES_IMAGE_LINK[0-9]{1,}$#', $key)){
						$index = explode('IMAGES_IMAGE_LINK', $key)[1];
						$images[$index]['LINK'] = $val;
					}elseif(preg_match('#^IMAGES_IMAGE_SIGN[0-9]{1,}$#', $key)){
						$index = explode('IMAGES_IMAGE_SIGN', $key)[1];
						$images[$index]['SIGN'] = $val;
					}elseif(preg_match('#^IMAGES_IMAGE_SUBTITLE[0-9]{1,}$#', $key)){
						$index = explode('IMAGES_IMAGE_SUBTITLE', $key)[1];
						$images[$index]['SUBTITLE'] = $val;
					}
				}

				foreach($images as $key => $image){
					$index = 'IMAGES_IMAGE_LINK'.$key;

					if(isset($files[$index])){
						if(isset($old_images[$key]['IMAGES_IMAGE_LINK'])){
							$filename = $this->replaceImage(self::IMAGE_TEMPLATE_BLOCK_IMAGES, $old_images[$key]['IMAGES_IMAGE_LINK'], $files[$index]);
						}else{
							$filename = $this->loadImage(self::IMAGE_TEMPLATE_BLOCK_IMAGES, $files[$index]);
						}
					}else{
						if(isset($old_images[$key]['IMAGES_IMAGE_LINK'])){
							$filename = $old_images[$key]['IMAGES_IMAGE_LINK'];
						}else{
							$filename = '';
						}
					}

					$images[$key]['LINK'] = $filename ?? '';
				}

				$old_images = [];
				$isset_images = isset($old_data['IMAGES_ID']) && $old_data['IMAGES_ID'] > 0;

				if($isset_images){

					/*foreach($old_images as $key => $old_image){
						$this->deleteImage(self::IMAGE_TEMPLATE_BLOCK_IMAGES, $old_image['IMAGES_IMAGE_LINK']); 
					}*/

					$tran[] = [
						'sql' => 'DELETE FROM DATA_IMAGES WHERE ID_IMAGES = :ID_IMAGES',
						'params' => [
							'ID_IMAGES' => $old_data['IMAGES_ID'],
						],
					];
					$max_id = $old_data['IMAGES_ID'];
				}else{
					$max_id = $this->db->column('SELECT MAX(ID_IMAGES) + 1 FROM DATA_IMAGES');
					if($max_id == '') $max_id = 1;

					$tran[] = [
						'sql' => 'INSERT INTO PAGE_CONTENT (ID_PAGE, ID_FIELD, VAL) VALUES (:ID_PAGE, :ID_FIELD, :VAL)',
						'params' => [
							'ID_PAGE' => $ID,
							'ID_FIELD' => $field['ID'],
							'VAL' => $max_id,
						],
					];
				}

				foreach($images as $key => $image){
					$tran[] = [
						'sql' => 'INSERT INTO DATA_IMAGES (ID_IMAGES, IMAGES_IMAGE_LINK, IMAGES_IMAGE_SUBTITLE, IMAGES_IMAGE_SIGN, SERIAL_NUMBER) VALUES (:ID_IMAGES, :IMAGES_IMAGE_LINK, :IMAGES_IMAGE_SUBTITLE, :IMAGES_IMAGE_SIGN, :SERIAL_NUMBER)',
						'params' => [
							'ID_IMAGES' => $max_id,
							'IMAGES_IMAGE_LINK' => $image['LINK'],
							'IMAGES_IMAGE_SUBTITLE' => $image['SUBTITLE'],
							'IMAGES_IMAGE_SIGN' => $image['SIGN'],
							'SERIAL_NUMBER' => $key
						],
					];
				}
			}else{
				if(isset($post[$field['VAR']]) || isset($files[$field['VAR']])){
					#debug($field);
					if(isset($old_data[$field['VAR']])){
						$q = 'UPDATE PAGE_CONTENT SET VAL = :VAL WHERE (ID_PAGE = :ID_PAGE) AND (ID_FIELD = :ID_FIELD)';
					}else{
						$q = 'INSERT INTO PAGE_CONTENT (ID_PAGE, ID_FIELD, VAL) VALUES (:ID_PAGE, :ID_FIELD, :VAL)';
					}
					$params = [
						'ID_PAGE' => $ID,
						'ID_FIELD' => $field['ID'],
					];

					if($field['TYPE'] == 'FILE'){

						#debug([$field, $files[$field['VAR']]]);

						$dir = '';
						switch($field['VAR']){
							case 'HEADER_LEFT_IMAGE':
							case 'HEADER_MIDDLE_IMAGE':
							case 'HEADER_RIGHT_IMAGE':
								$dir = self::IMAGE_TEMPLATE_HEADER_PAGE;
								break;
							case 'PRICE_IMAGE1':
							case 'PRICE_IMAGE2':
							case 'PRICE_IMAGE3':
								$dir = self::IMAGE_CATALOG_EXCURSIONS;
								break;
							default:
								debug($field);
						}

						if(isset($old_data[$field['VAR']])){
							$params['VAL'] = $this->replaceImage($dir, $old_data[$field['VAR']], $files[$field['VAR']]);
						}else{
							$params['VAL'] = $this->loadImage($dir, $files[$field['VAR']]);
						}
					}else{
						$params['VAL'] = $post[$field['VAR']];
					}
					$tran[] = [
						'sql' => $q,
						'params' => $params,
					];
				}
			}
		}

		#debug($tran);

		return $this->db->transaction($tran);
	}

	public function delPages($route){
		$ID = $route['param'];
		$tran = [];
		$params = [
			'ID' => $ID,
		];

		$q = 'SELECT ID, ID_FIELD, VAL FROM PAGE_CONTENT WHERE ID_PAGE = :ID';
		foreach($this->db->row($q, $params) as $row){
			$field_type = $this->db->column('SELECT NAME FROM LIB_FIELD_TYPES WHERE ID = (SELECT CMS_TYPE FROM LIB_VIEW_FIELDS WHERE ID = :ID)', ['ID' => $row['ID_FIELD']]);

			$tran[] = [
				'sql' => 'DELETE FROM PAGE_CONTENT WHERE ID = :ID',
				'params' => [
					'ID' => $row['ID'],
				],
			];

			if($field_type == 'FILE'){
				//delete file!
			}
		}

		$tran[] = [
			'sql' => 'DELETE FROM PAGES WHERE ID = :ID',
			'params' => $params,
		];

		return $this->db->transaction($tran);
	}
	
	public function addPages($post, $files){
		$ID_LOCATION = $this->db->column('SELECT `ID_LOCATION` + 1 as `ID_LOCATION` FROM PAGES WHERE ID = :ID_PARENT', ['ID_PARENT' => $post['ID_PARENT']]);
		if(isset($post['LOC_NUMBER']) && $post['LOC_NUMBER'] != ''){
			$LOC_NUMBER = $post['LOC_NUMBER'];
			$this->db->bool('UPDATE PAGES SET LOC_NUMBER = LOC_NUMBER + 1 WHERE ID_LOCATION = :ID_LOCATION', ['ID_LOCATION' => $ID_LOCATION]);
		}else{
			$LOC_NUMBER = $this->db->column('SELECT MAX(LOC_NUMBER) + 1 as `NUMBER` FROM PAGES WHERE ID_LOCATION = :ID_LOCATION', ['ID_LOCATION' => $ID_LOCATION]);
		}

		$dir = '';
		switch($post['ID_PARENT']){
			case 3:
				$dir = self::IMAGE_CATALOG_SERVICES;
				break;
			case 5:
				$dir = self::IMAGE_SLICK_BUSES;
				break;
			case 7:
				$dir = self::IMAGE_SLICK_MINIVANS;
				break;
			case 9:
				$dir = '';
				break;
		}

		$q = 'INSERT INTO PAGES (ID_LOCATION, ID_VIEW, ID_PARENT, CAN_BE_SUPPLEMENTED, MAY_HAVE_THE_PARENT, URI, LOC_NUMBER, CHOICE_TITLE, HTML_TITLE, DESCR, IMAGE, IMAGE_SIGN, HTML_DESCR, HTML_KEYWORDS) VALUES (:ID_LOCATION, :ID_VIEW, :ID_PARENT, :CAN_BE_SUPPLEMENTED, :MAY_HAVE_THE_PARENT, :URI, :LOC_NUMBER, :CHOICE_TITLE, :HTML_TITLE, :DESCR, :IMAGE, :IMAGE_SIGN, :HTML_DESCR, :HTML_KEYWORDS)';
		$params = [
			'HTML_TITLE'			=> isset($post['HTML_TITLE']) ? $post['HTML_TITLE'] : '',
			'HTML_DESCR'			=> isset($post['HTML_DESCR']) ? $post['HTML_DESCR'] : '',
			'HTML_KEYWORDS'			=> isset($post['HTML_KEYWORDS']) ? $post['HTML_KEYWORDS'] : '',
			'ID_VIEW'				=> isset($post['ID_VIEW']) ? $post['ID_VIEW'] : '',
			'URI'					=> isset($post['URI']) ? $post['URI'] : '',
			'ID_PARENT'				=> isset($post['ID_PARENT']) ? $post['ID_PARENT'] : '',
			'DESCR'					=> isset($post['DESCR']) ? $post['DESCR'] : '',
			'ID_LOCATION'			=> $ID_LOCATION,
			'CAN_BE_SUPPLEMENTED'	=> 0,
			'MAY_HAVE_THE_PARENT'	=> 1,
			'LOC_NUMBER'			=> $LOC_NUMBER,
			'CHOICE_TITLE'			=> isset($post['CHOICE_TITLE']) ? $post['CHOICE_TITLE'] : '',
			'IMAGE'					=> isset($post['IMAGE']) && $dir != '' ? $this->loadImage($dir, $files['IMAGE']) : '',
			'IMAGE_SIGN'			=> isset($post['IMAGE_SIGN']) ? $post['IMAGE_SIGN'] : '',
		];

		return $this->db->return($q, $params);
	}
	
	/************************************************************* PAGES END *************************************************************/












	private function DataTableToSimpleArray($arr){
		$data = [];
		foreach($arr as $key => $value){
			list($cell_index, $cell_row, $cell_col) = explode('_', explode('CELL_TABLE', $key)[1]);
			$data[] = [
				'VAL' => $value,
				'ROW' => $cell_row,
				'COL' => $cell_col,
			];
		}
		return $data;
	}


	private function switchUPDTemplate($val, $files, $SN, $ID_PAGE){
		$NAME_TMPL = $val['TYPE'];
		$TYPE = $this->getTMPLtype($ID_PAGE);
		$ID_TEMPLATE = $this->getTMPLid($NAME_TMPL);

		$index = 0;

		switch($NAME_TMPL){
			case 'EXC1':
				$return[$index]['sql'] = 'INSERT INTO PAGE_FULL (`ID_PAGE`, `ID_TEMPLATE`) VALUES (:IP, :IT);';
				$return[$index++]['params'] = [
					'IP' => $ID_PAGE,
					'IT' => $ID_TEMPLATE
				];
				break;
			default:
				$return[$index]['sql'] = 'INSERT INTO PAGE_TEMPLATES (`ID_PAGE`, `ID_TEMPLATE`, `SERIAL_NUMBER`) VALUES (:IP, :IT, :SN);';
				$return[$index++]['params'] = [
					'IP' => $ID_PAGE,
					'IT' => $ID_TEMPLATE,
					'SN' => $SN
				];
				break;
		}
		
		$NUMERIC_PART_IMAGE = $SN;

		switch($NAME_TMPL){
			case 'H1': //order
				$oldImages = $this->db->row('SELECT LEFT_IMAGE, RIGHT_IMAGE FROM BLOCK_HEADER_ORDER WHERE ID = :ID', ['ID'=>$val['ID']])[0];
				$oldL = isset($oldImages['LEFT_IMAGE']) ? $oldImages['LEFT_IMAGE'] : '';
				$oldR = isset($oldImages['RIGHT_IMAGE']) ? $oldImages['RIGHT_IMAGE'] : '';
				$LEFT_IMAGE = '';
				$RIGHT_IMAGE = '';
				//load left image
				if(isset($files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE]) && $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE] != '' && $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE]['size'] > 0){
					$img = $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE];
					if($oldL != ''){
						$LEFT_IMAGE = $this->replaceImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $oldL, $img);
					}else{
						$LEFT_IMAGE = $this->loadImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $img);
					}
				}else{
					if($oldL != ''){
						$LEFT_IMAGE = $oldL;
					}
				}

				//load right image
				if(isset($files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE]) && $files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE] != '' && $files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE]['size'] > 0){
					$img = $files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE];
					if($oldR != ''){
						$RIGHT_IMAGE = $this->replaceImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $oldR, $img);
					}else{
						$RIGHT_IMAGE = $this->loadImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $img);
					}
				}else{
					if($oldR != ''){
						$RIGHT_IMAGE = $oldR;
					}
				}

				//set sql string
				$return[$index++]['sql'] = 'INSERT INTO BLOCK_HEADER_ORDER (`ID_PAGE_TEMPLATE`, `TITLE`, `LEFT_IMAGE`, `LEFT_IMAGE_SIGN`, `RIGHT_IMAGE`, `RIGHT_IMAGE_SIGN`) VALUES ('
					.'(SELECT MAX(ID) FROM PAGE_TEMPLATES), '
					.'"'.$val['TITLE'].'", '
					.'"'.$LEFT_IMAGE.'", '
					.'"'.$val['LEFT_IMAGE_SIGN'].'", '
					.'"'.$RIGHT_IMAGE.'", '
					.'"'.$val['RIGHT_IMAGE_SIGN'].'");';
				break;
			case 'H2': //images
				//debug([$files, isset($files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE]) && $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE] != '' && $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE]['size'] > 0]);
				$oldImages = $this->db->row('SELECT LEFT_IMAGE, MIDDLE_IMAGE, RIGHT_IMAGE FROM BLOCK_HEADER_IMAGES WHERE ID = :ID', ['ID'=>$val['ID']])[0];

				$oldL = isset($oldImages['LEFT_IMAGE']) ? $oldImages['LEFT_IMAGE'] : '';
				$oldM = isset($oldImages['MIDDLE_IMAGE']) ? $oldImages['MIDDLE_IMAGE'] : '';
				$oldR = isset($oldImages['RIGHT_IMAGE']) ? $oldImages['RIGHT_IMAGE'] : '';

				$LEFT_IMAGE = '';
				$MIDDLE_IMAGE = '';
				$RIGHT_IMAGE = '';
				//load left image
				if(isset($files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE]) && $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE] != '' && $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE]['size'] > 0){
					$img = $files['LEFT_IMAGE_'.$NUMERIC_PART_IMAGE];
					if($oldL != ''){
						$LEFT_IMAGE = $this->replaceImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $oldL, $img);
					}else{
						$LEFT_IMAGE = $this->loadImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $img);
					}
				}else{
					if($oldL != ''){
						$LEFT_IMAGE = $oldL;
					}
				}
				//load middle image
				if(isset($files['MIDDLE_IMAGE_'.$NUMERIC_PART_IMAGE]) && $files['MIDDLE_IMAGE_'.$NUMERIC_PART_IMAGE] != '' && $files['MIDDLE_IMAGE_'.$NUMERIC_PART_IMAGE]['size'] > 0){
					$img = $files['MIDDLE_IMAGE_'.$NUMERIC_PART_IMAGE];
					if($oldM != ''){
						$MIDDLE_IMAGE = $this->replaceImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $oldM, $img);
					}else{
						$MIDDLE_IMAGE = $this->loadImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $img);
					}
				}else{
					if($oldM != ''){
						$MIDDLE_IMAGE = $oldM;
					}
				}
				//load right image
				if(isset($files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE]) && $files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE] != '' && $files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE]['size'] > 0){
					$img = $files['RIGHT_IMAGE_'.$NUMERIC_PART_IMAGE];
					if($oldR != ''){
						$RIGHT_IMAGE = $this->replaceImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $oldR, $img);
					}else{
						$RIGHT_IMAGE = $this->loadImage(self::IMAGE_TEMPLATE_HEADER_PAGE, $img);
					}
				}else{
					if($oldR != ''){
						$RIGHT_IMAGE = $oldR;
					}
				}
				
				//set sql string
				$return[$index++]['sql'] = 'INSERT INTO BLOCK_HEADER_IMAGES (`ID_PAGE_TEMPLATE`, `TITLE`, `LEFT_IMAGE`, `LEFT_IMAGE_SIGN`, `RIGHT_IMAGE`, `RIGHT_IMAGE_SIGN`, `MIDDLE_IMAGE`, `MIDDLE_IMAGE_SIGN`) VALUES ('
					.'(SELECT MAX(ID) FROM PAGE_TEMPLATES), '
					.'"'.$val['TITLE'].'", '
					.'"'.$LEFT_IMAGE.'", '
					.'"'.$val['LEFT_IMAGE_SIGN'].'", '
					.'"'.$RIGHT_IMAGE.'", '
					.'"'.$val['RIGHT_IMAGE_SIGN'].'", ' 
					.'"'.$MIDDLE_IMAGE.'", '
					.'"'.$val['MIDDLE_IMAGE_SIGN'].'");';
				//debug([$return, $val['ID'], $oldImages, $oldL, $oldM, $oldR, $LEFT_IMAGE, $MIDDLE_IMAGE, $RIGHT_IMAGE]);
				break;
			case 'B1': //table
				$return[$index]['sql'] = 'INSERT INTO BLOCK_TABLE (ID_PAGE_TEMPLATE, TITLE, SUBTITLE, DESCR) VALUES ((SELECT MAX(ID) FROM PAGE_TEMPLATES), :TITLE, :SUBTITLE, :DESCR)';
				$return[$index++]['params'] = [
					'TITLE' => $val['TITLE'],
					'SUBTITLE' => $val['SUBTITLE'],
					'DESCR' => $val['DESCR']
				];
				
				$TABLE_DATA = [];
				foreach($val as $key => $value){
					if(preg_match('#^CELL_TABLE[0-9]{0,}_[0-9]{1,}_[0-9]{1,}$#', $key)){
						$c = explode('CELL_TABLE', $key)[1];
						list($cell_index, $cell_row, $cell_col) = explode('_', $c);
						$CELL['VAL'] = $value;
						$CELL['ROW'] = $cell_row;
						$CELL['COL'] = $cell_col;
						if(isset($TABLE_DATA)){
							array_push($TABLE_DATA, $CELL);
						}else{
							$TABLE_DATA[0] = $CELL;
						}
					}
				}

				foreach($TABLE_DATA as $subkey => $subval){
					$return[$index]['sql'] = 'INSERT INTO DATA_TABLE (ID_TABLE, ROW, COL, VAL) VALUES ((SELECT MAX(ID) FROM BLOCK_TABLE), :ROW, :COL, :VAL);';
					$return[$index++]['params'] = [
						'ROW' => $subval['ROW'],
						'COL' => $subval['COL'],
						'VAL' => $subval['VAL']
					];
				}
				break;
			case 'B2': //multitable
				$return[$index]['sql'] = 'INSERT INTO BLOCK_MULTITABLE (ID_PAGE_TEMPLATE, TITLE, SUBTITLE, DESCR) VALUES ((SELECT MAX(ID) FROM PAGE_TEMPLATES), :TITLE, :SUBTITLE, :DESCR);';
				$return[$index++]['params'] = [
					'TITLE' => $val['TITLE'],
					'SUBTITLE' => $val['SUBTITLE'],
					'DESCR' => $val['DESCR']
				];
				$TABLE_DATA = [];
				foreach($val as $key => $value){
					if(preg_match('#^ID_TABLE[0-9]{0,}$#', $key)){
						$TABLE_DATA[explode('ID_TABLE', $key)[1]]['ID'] = $value;
					}elseif(preg_match('#^TITLE_TABLE[0-9]{0,}$#', $key)){
						$TABLE_DATA[explode('TITLE_TABLE', $key)[1]]['TITLE'] = $value;
					}elseif(preg_match('#^CELL_TABLE[0-9]{0,}_[0-9]{1,}_[0-9]{1,}$#', $key)){
						$c = explode('CELL_TABLE', $key)[1];
						list($cell_index, $cell_row, $cell_col) = explode('_', $c);
						$CELL['VAL'] = $value;
						$CELL['ROW'] = $cell_row;
						$CELL['COL'] = $cell_col;
						if(isset($TABLE_DATA[$cell_index]['CELLS'])){
							array_push($TABLE_DATA[$cell_index]['CELLS'], $CELL);
						}else{
							$TABLE_DATA[$cell_index]['CELLS'][0] = $CELL;
						}
					}
				}

				foreach($TABLE_DATA as $subkey => $subval){
					$return[$index]['sql'] = 'INSERT INTO BLOCK_MULTITABLE_CONTENT (ID_MULTITABLE, SUBTITLE, SERIAL_NUMBER) VALUES ((SELECT MAX(ID) FROM BLOCK_MULTITABLE), :ST, :SN);';
					$return[$index++]['params'] = [
						'ST' => $subval['TITLE'],
						'SN' => strval($subkey)
					];
					foreach($subval['CELLS'] as $cellkey => $cellval){
						$return[$index]['sql'] = 'INSERT INTO DATA_MULTITABLE (ID_MULTITABLE_CONTENT, ROW, COL, VAL) VALUES ((SELECT MAX(ID) FROM BLOCK_MULTITABLE_CONTENT), :ROW, :COL, :VAL);';
						$return[$index++]['params'] = [
							'ROW' => $cellval['ROW'],
							'COL' => $cellval['COL'],
							'VAL' => $cellval['VAL']
						];
					}
				}
				break;
			case 'B3': //text
				$return[$index]['sql'] = 'INSERT INTO BLOCK_TEXT (`ID_PAGE_TEMPLATE`, `TITLE`, `TEXT`) VALUES ((SELECT MAX(ID) FROM PAGE_TEMPLATES), :TITLE, :TEXT);';
				$return[$index++]['params'] = [
					'TITLE' => $val['TITLE'],
					'TEXT' => $val['TEXT']
				];
				break;
			case 'B4': //image list
				/* LOAD IMAGES */
				$return[$index]['sql'] = 'INSERT INTO BLOCK_IMAGES (ID_PAGE_TEMPLATE, TITLE, DESCR) VALUES ((SELECT MAX(ID) FROM PAGE_TEMPLATES), :TITLE, :DESCR);';
				$return[$index++]['params'] = [
					'TITLE' => $val['TITLE'],
					'DESCR' => $val['DESCR']
				];

				$NUMERIC_PART_IMAGE = $SN;
				$IMAGE_DATA = [];
				foreach($val as $key => $value){
					if(preg_match('#^ID_IMAGE_CONTENT[0-9]{1,}$#', $key)){
						$IMAGE_DATA[explode('ID_IMAGE_CONTENT', $key)[1]]['ID'] = $value;
					}elseif(preg_match('#^SUBTITLE[0-9]{1,}$#', $key)){
						$IMAGE_DATA[explode('SUBTITLE', $key)[1]]['SUBTITLE'] = $value;
					}elseif(preg_match('#^IMAGE_SIGN[0-9]{1,}$#', $key)){
						$IMAGE_DATA[explode('IMAGE_SIGN', $key)[1]]['IMAGE_SIGN'] = $value;
					}elseif(preg_match('#^SERIAL_NUMBER[0-9]{1,}$#', $key)){
						$IMAGE_DATA[explode('SERIAL_NUMBER', $key)[1]]['SERIAL_NUMBER'] = $value;
					}
				}
				for($i = 0; $i < count($IMAGE_DATA); $i++){

					$local_index = 'IMAGE_LINK'.$i.'_'.$NUMERIC_PART_IMAGE;

					$ID_IMAGE_CONTENT = $IMAGE_DATA[$i]['ID'];
					
					$q = 'SELECT IMAGE_LINK FROM BLOCK_IMAGE_CONTENT WHERE ID = :ID';
					$params = [
						'ID' => $ID_IMAGE_CONTENT
					];
					$old = $this->db->column($q, $params);

					if(isset($files[$local_index]) && $files[$local_index] != '' && $files[$local_index]['size'] > 0){
						$img = $files[$local_index];
						if($old != '' && $old != null){
							$new_img = $this->replaceImage(self::IMAGE_TEMPLATE_BLOCK_IMAGES, $old, $img);
						}else{
							$new_img = $this->loadImage(self::IMAGE_TEMPLATE_BLOCK_IMAGES, $img);
						}
					}else{
						$new_img = $old;
					}
					$IMAGE_DATA[$i]['IMAGE'] = $new_img;
				}
				foreach($IMAGE_DATA as $key => $val){
					$return[$index]['sql'] = 'INSERT INTO BLOCK_IMAGE_CONTENT (ID_IMAGE, IMAGE_LINK, SUBTITLE, IMAGE_SIGN, SERIAL_NUMBER) VALUES ((SELECT MAX(ID) FROM BLOCK_IMAGES), :IMAGE, :SUBTITLE, :SIGN, :SN);';
					$return[$index++]['params'] = [
						'IMAGE' => $val['IMAGE'],
						'SUBTITLE' => $val['SUBTITLE'],
						'SIGN' => $val['IMAGE_SIGN'],
						'SN' => $val['SERIAL_NUMBER']
					];
				}
				break;
			case 'B5': //links
			#debug($val);
				$return[$index]['sql'] = 'INSERT INTO BLOCK_LINKS (ID_PAGE_TEMPLATE, TITLE, IS_BUSES, IS_MINIVANS) VALUES ((SELECT MAX(ID) FROM PAGE_TEMPLATES), :TITLE, :IS_BUSES, :IS_MINIVANS);';
				$return[$index++]['params'] = [
					'TITLE' => $val['TITLE'],
					'IS_BUSES' => $val['IS_BUSES'],
					'IS_MINIVANS' => $val['IS_MINIVANS']
				];
				break;
			case 'EXC1': //excursion 1
				/*
				
				LOAD IMAGES

				 */
				foreach($val as $subkey => $subval){

					$return[$index]['sql'] = 'INSERT INTO PAGE_FULL_CONTENT (ID_FULL_PAGE, VAL, VAR) VALUES ((SELECT MAX(ID) FROM PAGE_FULL), :VAL, :VAR);';
					$return[$index++]['params'] = [
						'VAR' => $subkey,
						'VAL' => $subval
					];
				}
				break;
		}
		return $return;
	}














	private function casePathCatalog($ID, $ID_GROUP = 0){
		if($ID_GROUP == 0){
			$q = 'SELECT ID_GROUP FROM PAGES WHERE ID = :ID';
			$params = [
				'ID' => $ID
			];
			$ID_GROUP = $this->db->column($q, $params);
		}	
		switch($ID_GROUP){
			case 2:
				return self::IMAGE_CATALOG_SERVICES;
			case 3:
				return self::IMAGE_CATALOG_BUSES;
			case 4:
				return self::IMAGE_CATALOG_MINIVANS;
			case 5:
				return self::IMAGE_CATALOG_EXCURSIONS;
		}
		return '';
	}



	private function loadImage($dir, $file){
		if($file['size'] > 0){
			$path = $_SERVER['DOCUMENT_ROOT'].self::IMAGE_DIR.$dir;
			if(file_exists($path)){
				do{
					$name = $this->generateStr(self::IMAGE_NAME_LEN);
					$full_name = $name.'.'.self::IMAGE_FILE_FORMAT;
					$newfile = $path.$full_name;
				}while(file_exists($newfile));
				$this->imgOptimize($file['tmp_name']);
				if(copy($file['tmp_name'], $newfile)){
		            return $name;
		        }
			}
	   	}
	   	return '';
	}

	private function replaceImage($dir, $oldFile, $newfile){
		#debug([$dir, $oldFile, $newfile]);
		if($newfile['size'] > 0){
			$oldName = $oldFile;
			$oldFile = $_SERVER['DOCUMENT_ROOT'].self::IMAGE_DIR.$dir.$oldFile.'.'.self::IMAGE_FILE_FORMAT;
			$this->imgOptimize($newfile['tmp_name']);
			if(copy($newfile['tmp_name'], $oldFile)){
	            return $oldName;
	        }
	   	}
	   	return '';
	}

	private function deleteImage($dir, $file){
		$path = $_SERVER['DOCUMENT_ROOT'].self::IMAGE_DIR.$dir.$file.'.'.self::IMAGE_FILE_FORMAT;
		if(file_exists($path)){
			return unlink($path);
		}
		return true;
	}


	private function imgOptimize($image){
		return;
	}

	public function toPost($json){
		$post = [];
		$prepost = (array)json_decode($json);
		foreach($prepost as $key => $val){
			$val = (array)$val;
			foreach($val as $subkey => $subval){
				if(gettype($subval) == 'object'){
					debug($subval);
				}
				$val[$subkey] = $this->clear($subval);
			}
			$post[$key] = $val;
		}
		return array_change_key_case($post, CASE_UPPER);
	}

}