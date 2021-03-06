/******************************* class for communication with server  *******************************/
class api{

	constructor(type){
		this.type = type;
	}

	send(uri, data = {}, success = function(){}, error = function(){}){
		switch(this.type){
			case 'load':
				//this.getContent(uri, data, returnVar);
				break;
			case 'api':
				this.sendApi(uri, data, success, error);
				break;
		}
	}

	/*
	loadContent(uri, data, Class){
		$.ajax({
			url: uri,
			type: 'POST',
			data: data,
			success: function(data){
				try{
					data = JSON.parse(data.trim());
					$(Class).html(data.message);
				}catch(e){
					console.log('Error of get script. Refresh page!');
				}finally{
					
				}
			},
			error: function(){
				console.log('something was wrong. Refresh page!');
			}
		});
	}
	*/

	sendApi(uri, data, success_callback, error_callback){
		$.ajax({
			url: uri,
			type: 'POST',
			data: data,
			dataType: 'JSON',
	        contentType: false,
	        processData: false,
	        cache: false,
			success: function(data){
				success_callback(data);
			},
			error: function(e){
				error_callback(e.responseText);
			}
		});
	}
}





/******************************* class for show the message  *******************************/
class Message{

	constructor(){
		this.typeGood = 1;
		this.typeBad = 2;
		this.typeCommon = 3;

		this.classMessage = 'message';

		this.classMessageBox = '.popup__message';

		this.classMessageGood = 'good';
		this.classMessageBad = 'bad';
		this.classMessageCommon = 'common';

		this.messageGoodTimeout = 2800;
		this.messageBadTimeout = 3500;
		this.messageCommonTimeout = 3100;

		this.messageHide = 600;

		this.curClassMessage = '';
		this.curTimeout = 0;
	}

	show(msg = '', status = null){
		if(status){
			this.curClassMessage = this.classMessageGood;
			this.curTimeout = this.messageGoodTimeout;
		}else if(!status){
			this.curClassMessage = this.classMessageBad;
			this.curTimeout = this.messageBadTimeout;
		}else if(status == null){
			this.curClassMessage = this.classMessageCommon;
			this.curTimeout = this.messageCommonTimeout;
		}
		this.create(msg);
	}

	create(msg){
		let MessageBox = document.createElement("div");
		MessageBox.classList.add(this.classMessage);
		MessageBox.classList.add(this.curClassMessage);
		MessageBox.innerHTML = '<span>'+msg+'</span>';
		$(this.classMessageBox).prepend(MessageBox);
		this.destroy(MessageBox);
	}

	destroy(msgBox){
		let messages = this.classMessageBox+'>div',
			timehide = this.messageHide,
			timeout = this.curTimeout;
		setTimeout(function(){
			$(messages)
				.filter(function(){ return $(this).css("opacity") == 1; })
				.last()
				.hide(timehide, function(){ msgBox.remove(); });
		}, timeout);
	}
}





/******************************* class for show the loader on page  *******************************/
class Loader{

	constructor(id){
		this.idLoaderPag = id;
		this.loaderPageHide = 10;
		this.loaderHideWeight = 0.02;
		this.loader = document.getElementById(this.idLoaderPag);

		this.opacityFirstBreakPoint = 0.85;
		this.opacitySecondBreakPoint = 0.65;
	}

	show(){
		this.loader.removeAttribute('style');
		this.loader.classList.remove('hide');
	}

	hide(){
		this.loader.style.opacity = 1;
		let THIS = this;
		setTimeout(function(){
			Loader.tickHideLoader(THIS, THIS.loaderHideWeight, false, false);
		}, this.loaderPageHide);
	}

	static tickHideLoader(THIS, weight, bpFirstIsset, bpSecondIsset){
		if(THIS.loader.style.opacity <= 0){
			THIS.loader.classList.add('hide');
			THIS.loader.removeAttribute('style');
			return;
		}
		THIS.loader.style.opacity -= weight;
		if(THIS.loader.style.opacity <= THIS.opacityFirstBreakPoint && !bpFirstIsset){
			weight = weight * 2;
			bpFirstIsset = true;
		}else if(THIS.loader.style.opacity <= THIS.opacitySecondBreakPoint && !bpSecondIsset){
			weight = weight * 4;
			bpSecondIsset = true;
		}
		setTimeout(function(){
			Loader.tickHideLoader(THIS, weight, bpFirstIsset, bpSecondIsset);
		}, THIS.loaderPageHide);
	}
}





/******************************* class for redirect (static and global)  *******************************/
class Redirect{

	constructor(Class){
		this.anchors = document.getElementsByClassName(Class);
		for(let i = 0; i < this.anchors.length; i++ ) {
			this.anchors[i].onclick = Redirect.handler;
		}
		window.onpopstate = function(e) {
			if(history.state != null){
				Redirect.go(history.state.url);
			}
		}
	}

	static go(uri){ cms.redirect(uri); }

	static handler(url = null, title = null){
		let curTitle, curUrl;
		if(typeof this === 'object'){
			curTitle = this.innerText || this.textContent;
			curUrl = this.getAttribute( "href", 2 );
		}else if(typeof this === 'function'){
			curTitle = title;
			curUrl = url;
		}
		let state = {
			title: curTitle,
			url: curUrl
		}
		history.pushState(state, state.title, state.url);
		Redirect.go(state.url);
		return false;
	}

}













/******************************* core class for CMS  *******************************/
class CMS_CORE{

	constructor(){
		this.is_logging = true;

		this.content_box_id = 'content_box';
		this.content_form_id = 'data';

		this.modal_wnd_id = 'modal_wnd';
		this.modal_form_id = 'modal_form';

		this.site_tree_box_id = 'tree_box';
		this.header_box_id = 'tabs';

		this.loader_box_id = 'loader';

		this.LINK_SITE_PAGE = '/admin/site/pages/';
	}



	static getJSON(url, component_name = '', callback = function(){}){
		if(!url && url === ''){
			console.log('error load json: no url');
			return false;
		}
		new api('api').send(
			url, 
			[], 
			function success(data){
				//console.log(data);
				if(data.status){
					callback(data.data);
				}else{
					EASY_CMS.load_filed(component_name, data.message);
				}
			},
			function error(e){
				console.log(e);
				EASY_CMS.load_filed(component_name, 'Failed to send api script');
			}
		);
	}

	ajaxSend(url, btn = null, is_parent_remove = false){
		if(btn && btn.classList.contains('remove')){
			if(!confirm('Вы уверены, что хотите удалить это ?')){
				return false;
			}
		}

		console.log('ajax send: ' + url);
		this.content_loader.show();
		let THIS = this;
		new api('api').send(
			url, 
			[], 
			function success(data){
				THIS.show_message(data.message, data.status);
				if(btn && is_parent_remove){
					let parent_for_remove = btn.parentNode.parentNode;
					parent_for_remove.remove();
				}
				if(data.data.redirect){
					setTimeout(function(){
						window.location = data.data.redirect;
					}, 600);
				}else{
					THIS.content_loader.hide();
				}
			},
			function error(e){
				console.log(e);
				THIS.show_message('Failed send api script', false);
				setTimeout(function(){
					THIS.content_loader.hide();
				}, 500)
			}
		);
		return false;
	}

	dataSend(url){
		console.log('data send: ' + url);
		this.content_loader.show();
		let ajax_data = EASY_CMS.getData(this.content_form_id);
		let THIS = this;
		new api('api').send(
			url, 
			ajax_data, 
			function success(data){
				THIS.show_message(data.message, data.status);
				if(data.data.ID){
					let cur_location = window.location.pathname + '/' + data.data.ID + window.location.search;
					setTimeout(function(){
						window.location = cur_location;
					}, 600);
				}else{
					THIS.refresh_tree();
					THIS.content_loader.hide();
				}
			},
			function error(e){
				console.log(e);
				THIS.show_message('Failed send api script', false);
				setTimeout(function(){
					THIS.content_loader.hide();
				}, 500)
			}
		);
		return false;
	}

	modalSend(url){
		console.log('modal send: ' + url);
		let modal_data = EASY_CMS.getData(this.modal_form_id);
		let THIS = this;
		new api('api').send(
			url, 
			modal_data, 
			function success(data){
				THIS.show_message(data.message, data.status);
				if(data.status){
					modalClose();
				}
				THIS._refresh_content(window.location.pathname + window.location.search, false);
				//loader hide
			},
			function error(e){
				console.log(e);
				THIS.show_message('Failed send api script', false);
				setTimeout(function(){
					//loader hide
				}, 500)
			}
		);
		return false;
	}


	static getData(form_id){
		let forms = document.querySelectorAll('#'+form_id),
			data = new FormData(),
			fields = {};

		let field, type, name, value;
		let multitable_id, sub_multitable_id, tabel_id, images_id;

		forms.forEach(function(form, index){
			
			let ID = form.querySelector('input[name=ID]');
			if(ID){
				fields['ID'] = ID.value;
			}
			//console.log('ID', fields['ID']);

			form.querySelectorAll('.forma_group_item').forEach(function(item){
				if(item.hasAttribute('data-table-id')){
					tabel_id = item.getAttribute('data-table-id');
					fields['TABLE'] = {
						'ID': tabel_id,
						'DATA': EASY_CMS._get_cells_data(item),
					};
					console.log(fields['TABLE']);
				}else if(item.hasAttribute('data-multitable-id')){
					multitable_id = item.getAttribute('data-multitable-id');
					sub_multitable_id = item.getAttribute('data-multitable-component-id');
					fields['MULTITABLE'] = EASY_CMS._add_multitable(fields['MULTITABLE'], multitable_id, sub_multitable_id, item);
					console.log(fields['MULTITABLE']);
				}else if(item.hasAttribute('data-images-id')){
					images_id = item.getAttribute('data-images-id');
					fields['IMAGES'] = [];
					console.log(fields['IMAGES']);
				}else{
					field = item.querySelector('input, select, textarea');

					if(field.disabled) return;

					type = field.type;
					name = field.name;
					if(type == 'file'){
						value = field.files[0];
						if(value) data.append(name, value);
					}else if(type == 'checkbox'){
						value = field.checked ? 1 : 0;
						fields[name] = value;
					}else{
						value = field.value;
						fields[name] = value;
					}
				}
			});
		});

		data.append('DATA', JSON.stringify(fields));
		return data;
	}

	static _add_multitable(arr, id, table_id, item){
		let cells_data = EASY_CMS._get_cells_data(item);
		if(arr){
			arr['TABLES'][arr['TABLES'].length] = {
				'ID': table_id,
				'DATA': cells_data,
			}
		}else{
			arr = {
				'ID': id,
				'TABLES': [{
					'ID': table_id,
					'DATA': cells_data,
				}],
			};
		}
		return arr;
	}

	static _get_cells_data(item){
		let data = {};
		item.querySelectorAll('input').forEach(function(input, index){
			data[input.name] = input.value;
		});
		return JSON.stringify(data);
	}


	static load_filed(component_name, message = ''){
		console.groupCollapsed('Failed to load ' + component_name);
		console.log('message: [' + message + ']');
		console.groupEnd();
	}

	static load_success(){}

	show_message(msg = '', status = null){
		if(msg == ''){
			return;
		}
		this.message.show(msg, status);
		if(this.is_logging && !status){
			this.log_message(msg)
		}
	}

	log_message(msg = '', status = null){
		console.log(msg);
	}
}





/******************************* class for CMS  *******************************/
class EASY_CMS extends CMS_CORE{

	constructor(_parent, _onload_func = function(){}, _onrefresh_func = function(){}){
		super();
		this.parent_box_id = _parent;
		this.onload_func = _onload_func;
		this.onrefresh_func = _onrefresh_func;

		this.cms_load = false;
	}

	run(){
		this.init();
		this.loading_environment();
		this.loading_content();
		this.load();
	}

	init(){
		this.get_static_data();
		this.get_dynamic_data();
	}

	get_static_data(){
		let data = {
			'title': 'EASY_CMS',
			'ver': '0.6',
			'username': Cookie.get('username'),
			'menu': [
				{
					'title': 'Главная',
					'uri': '',
					'childrens': [
						{
							'title':'Редактировать общий контент',
							'uri': '/admin/site/content'
						},
						{
							'title':'Добавить страницу',
							'uri': '/admin/site/pages'
						},
					],
				},
				{
					'title': 'Каталоги',
					'uri': '',
					'childrens': [
						{
							'title':'Автобусы',
							'uri': '/admin/catalog/buses'
						},
						{
							'title':'Микроавтобусы',
							'uri': '/admin/catalog/minivans'
						},
						{
							'title':'Новости',
							'uri': '/admin/catalog/news'
						},
						{
							'title':'Вакансии',
							'uri': '/admin/catalog/vacancies'
						},
					],
				},
				{
					'title': 'Настройки',
					'uri': '/admin/site/settings',
				},
				{
					'title': 'Отчёты',
					'uri': '',
					'childrens': [
						{
							'title':'Аккаунты',
							'uri': '/admin/report/accounts'
						},
						{
							'title':'Сессии',
							'uri': '/admin/report/sessions'
						},
						{
							'title':'Действия в сессиях',
							'uri': '/admin/report/actions'
						},
					],
				},
			],
		};

		this.session_username = data['username'] ? data['username'] : 'No Username';
		this.cms_title = data['title'] ? data['title'] : 'No cms name';
		this.cms_version = data['ver'] ? data['ver'] : 'No version';
		this.cms_menu = data['menu'] ? data['menu'] : [];
		this.tab_index = this._get_tab_index(this.cms_menu);
	}

	_get_tab_index(menu){
		let cur_uri = window.location.pathname;
		for(let i = 0; i < menu.length; i++){
			let item = menu[i];
			if(item.uri === cur_uri){
				//console.log(i);
				return i;
			}
			let childrens = item.childrens || [];
			for(let j = 0; j < childrens.length; j++){
				if(childrens[j].uri === cur_uri){
					return i;
				}
			};
		}
		return 0;
	}

	get_dynamic_data(){}

	loading_environment(){
		let empty_header_content = Components.header(this.cms_title, this.cms_version, this.session_username, this.cms_menu, this.header_box_id),
			empty_wrapper_content = Components.wrapper(this.site_tree_box_id, this.content_box_id, this.loader_box_id, this.modal_wnd_id, this.modal_loader_box_id),
			empty_footer_content = Components.footer();

		let content = empty_header_content + empty_wrapper_content + empty_footer_content;

		try{
			document.getElementById(this.parent_box_id).innerHTML = content;
		}
		catch(e){
			console.log('no box (#'+this.parent_box_id+') for load cms');
			return;
		}

		document.title = this.cms_title;
		this._init_tabs();

		this.message = new Message();
		this.content_loader = new Loader(this.loader_box_id);

		this.environment_loaded = true;
	}

	_init_tabs(){
		let tabs = document.getElementById(this.header_box_id);
		let nav = tabs.querySelectorAll('.' + Components.header_nav_parent__class_name()),
			navLis = tabs.querySelectorAll('.' + Components.header_nav_menu__item__class_name()),
			content = tabs.querySelectorAll('.' + Components.header_content_parent__class_name()),
			contentLis = tabs.querySelectorAll('.' + Components.header_content_menu__item__class_name());
		$(navLis[this.tab_index]).addClass('active');
		$(contentLis[this.tab_index]).addClass('active');
		navLis.forEach(function(item, index){
			item.classList.add('header_nav_list_item_'+index);
			item.addEventListener('click', function(){
				let data = item.getAttribute('class');
				let index = data.lastIndexOf('_');
				data = parseInt(data.substr(index+1));
				let contentLi = contentLis[data];
				navLis.forEach(function(inner_item){
					inner_item.classList.remove('active');
				});
				contentLis.forEach(function(inner_item){
					inner_item.classList.remove('active');
				});
				contentLi.classList.add('active');
				item.classList.add('active');
			});
		});
		contentLis.forEach(function(item, index){
			item.classList.add('header_nav_content_item_'+index);
		});
	}

	loading_content(){
		this._refresh_tree();
		this._refresh_content(window.location.pathname + window.location.search);
	}

	refresh_tree(){
		this._refresh_tree();
		this.load();
	}

	load(){
		let THIS = this;
		let id = setInterval(function(){
			if(THIS.content_loaded && THIS.tree_loaded){
				clearInterval(id);
				THIS.onload();
			}
		}, 5);
	}

	onload(){
		this.cms_load = true;
		this.content_loader.hide();
		this.onload_func();
	}

	


	redirect(uri){
		this._refresh_content(uri);
		let THIS = this;
		let id = setInterval(function(){
			if(THIS.content_loaded){
				clearInterval(id);
				THIS.onrefresh_func();
			}
		}, 5);
	}

	_refresh_tree(){
		this.tree_loaded = false;
		let THIS = this;
		EASY_CMS.getJSON('/admin/api/site_tree', 'site tree', function callback(data){
			if(data){
				let tree_parent = document.getElementById(THIS.site_tree_box_id);
				tree_parent.className = Components.tree_parent__class_name();
				tree_parent.innerHTML = '';
				tree_parent.innerHTML = Components.get_tree(data, THIS.LINK_SITE_PAGE);
				THIS._refresh_tree_scroll();
				THIS.tree_loaded = true;
			}
		});
	}

	_refresh_tree_scroll(){
		let tree_parent = document.getElementById(this.site_tree_box_id);
		//включаем развёртывание подразделов
		tree_parent.querySelectorAll('.'+Components.tree_item__title__class_name()).forEach(function(item, index){
			item.addEventListener('click', function(){
				let content = this.nextSibling;
				let parent = this.parentElement;
				if (parent.classList.contains('active')) {
					parent.classList.remove('active');
					$(content).stop().slideUp(400);
				} else {
					tree_parent.querySelectorAll('.'+Components.tree_item__class_name()+'.active').forEach(function(item, index){
						item.classList.remove('active');
						item.querySelectorAll('.'+Components.tree_item__list__class_name()).forEach(function(item, index){
							$(item).stop().slideUp(400);
						});
					});
					parent.classList.add('active');
					$(content).stop().slideDown(400);
				}
			});
		});
		//включаем скролл
		$(tree_parent).mCustomScrollbar();
	}


	_refresh_content(url = '', is_refresh_modal = true){
		this.content_loaded = false;
		let THIS = this;
		EASY_CMS.getJSON(url, 'content', function callback(data){
			if(data && data.CONTENT){
				/* load data and buttons */
				let content__component;
				let TITLE = data.CONTENT.TITLE || '';
				delete data.CONTENT.TITLE;
				let CONTENT = data.CONTENT,
					BUTTONS = data.BUTTONS || null,
					ADDITIONS = data.ADDITIONS || null;

				if(BUTTONS != null){
					BUTTONS.forEach(function(button, index){
						BUTTONS[index] = '<button class="' + (button.class || '') + '" onclick="' + (button.onclick || '') + '">' + (button.text || '') + '</button>';
					});
					BUTTONS = BUTTONS.join('');
				}

				switch(data.TYPE){
					case PAGE_TYPES.CONFIG():
					case PAGE_TYPES.PAGE():
						content__component = Components._get_page__simple_page(TITLE, CONTENT, BUTTONS);
						break;
					case PAGE_TYPES.REPORT():
					case PAGE_TYPES.CATALOG():
						content__component = Components._get_page__catalog(TITLE, CONTENT.COLUMNS, CONTENT.ROWS, BUTTONS);
						break;
					default:
						content__component = false;
						break;
				}

				if(content__component){
					document.getElementById(THIS.content_box_id).innerHTML = content__component;
					$(".main_content_info").mCustomScrollbar();
				}else{
					THIS.show_message('error load content data', false);
				}

				/* load additions */
				let modal_wnd__component;
				if(ADDITIONS != null){
					let MODAL_WND = ADDITIONS.MODAL_WND || null;
					if(MODAL_WND != null && is_refresh_modal){
						MODAL_WND.FIELDS.forEach(function(item, index){
							if(item.TYPE__PARENT_BOX && item.TYPE__PARENT_BOX != ''){
								parent = MODAL_WND[item.TYPE__PARENT_BOX];
							}
							MODAL_WND.FIELDS[index] = Components._get_modal_field(item, parent);
							if(MODAL_WND.FIELDS[index] == 'false' || MODAL_WND.FIELDS[index] == false){
								MODAL_WND.FIELDS[index] = '';
							}
							parent = null;
						});

						modal_wnd__component 	= "<div class='modal_wnd_head'><div class='buttons'><button onclick='modalClose()' class='remove'>Отмена</button><button onclick='" + (MODAL_WND.OK || '') + "' class='save'>Ок</button></div></div>"
												+ '<div class="modal_wnd_content"><div class="modal_wnd_form"><form id="modal_form">'
												+ '<input type="text" name="ID" value="" style="display:none;">'
												+ MODAL_WND.FIELDS.join('')
												+ '</form></div></div>';
						
						document.getElementById(THIS.modal_wnd_id).innerHTML = modal_wnd__component;
					}

					/* something else from additions */
				}

			}		
			THIS.content_loaded = true;
		});
	}


	modalClear(){
		let modal_wnd = document.getElementById(this.modal_wnd_id);
		//inputs & textareas
		modal_wnd.querySelectorAll('input[type=text], textarea').forEach(function(item){
			item.value = item.defaultValue = '';
		});
		//files
		modal_wnd.querySelectorAll('input[type=file]').forEach(function(item){
			item.title = item.value = '';
		});
		//selects
		modal_wnd.querySelectorAll('select').forEach(function(item){
			item.selectedIndex = 0;
		});
	}

	modalShow(url, THIS = null){
		this.modalClear();
		let modal_wnd = document.getElementById(this.modal_wnd_id);
		if(url == 0){
			let id_field = modal_wnd.querySelector('input[name=ID]');
			id_field.value = id_field.defaultValue = 0;
		}else{
			EASY_CMS.getJSON(url, '', function callback(data){
				let FIELDS = data.FIELDS;
				let ADDITIONS = data.ADDITIONS;
				for(let field in FIELDS){
					let value = FIELDS[field];
					//input
					let text_field = modal_wnd.querySelector('input[type=text][name=' + field + '], textarea[name=' + field + ']');
					if(text_field){
						text_field.value = text_field.defaultValue = value;
					}
					//file
					let file_field = modal_wnd.querySelector('input[type=file][name=' + field + ']');
					if(file_field){
						file_field.title = value;
						file_field.value = '';
					}
					//select
					let select_field = modal_wnd.querySelector('select[name=' + field + ']');
					if(select_field){
						select_field.childNodes.forEach(function(option){
							if(option.value == value && value != null){
								option.selected = true;
							}
							if(option.value == 0 && value == null){
								option.selected = true;
							}
						});
					}
				}
			});
			
		}
		modalOpen();
		return false;
	}

	modalClose(id, THIS = null){
		console.log(id, THIS);
		modalClose();
	}
}




//add
//save


















/******************************* class for CMS  *******************************/
class Components{

	/* PUBLIC METHODS */
	static header(title, version, username, menu, header_box_id){
		return Components._get_header(title, version, username, menu, header_box_id);
	}

	static wrapper(site_tree_box_id, content_box_id, loader_box_id, modal_wnd_id, modal_loader_box_id){
		return Components._get_wrapper(site_tree_box_id, content_box_id, loader_box_id, modal_wnd_id, modal_loader_box_id);
	}

	static footer(){
		return '<div class="footer"></div>';
	}

	static get_tree(site_tree=[], link_site_page = ''){
		return Components._get_site_tree(site_tree, link_site_page);
	}

	static get_content(data_content){
		
	}
	/* PUBLIC METHODS END */


	/* STATIC VARIABLES */
	static header_nav_parent__class_name(){			return 'header_nav_list'; }
	static header_nav_menu__item__class_name(){		return 'header_nav_list_item'; }
	static header_content_parent__class_name(){		return 'header_nav_content'; }
	static header_content_menu__item__class_name(){	return 'header_nav_content_item'; }

	static tree_parent__class_name(){				return 'main_nav'; }
	static tree_item__title__class_name(){			return 'main_nav_list_title'; }
	static tree_item__list__class_name(){			return 'main_nav_list_item'; }
	static tree_item__class_name(){					return 'main_nav_list'; }

	static loader__count_elements(){				return 10; }
	/* STATIC VARIABLES END */


	/* PRIVATE METHODS */

	static _get_page__simple_page(title = '', data = [], buttons = ''){
		//console.log(title);
		//console.log(data);
		//console.log(buttons);
		let body = '';
		let common = data.FIELDS.COMMON,
			content = data.FIELDS.CONTENT;
		let parent = null;

		if(common && common.length > 0){
			common.forEach(function(item, index){
				if(item.CMS_TYPE__PARENT_BOX && item.CMS_TYPE__PARENT_BOX != ''){
					parent = data[item.CMS_TYPE__PARENT_BOX];
					//console.log(parent);
				}
				common[index] = Components._get_html_field(item, parent);
				if(common[index] == 'false' || common[index] == false){
					common[index] = '';
				}
				parent = null;
			});
		}
		let common_container = Components._get_field_container(common.join(''), 'Общие');

		let content_container = '';
		if(content){
			for(let group_index in content){
				content[group_index].forEach(function(field_item, field_index){
					if(field_item.CMS_TYPE__PARENT_BOX && field_item.CMS_TYPE__PARENT_BOX != ''){
						parent = data[field_item.CMS_TYPE__PARENT_BOX];
					}
					content[group_index][field_index] = Components._get_html_field(field_item, parent);
					if(content[group_index][field_index] == 'false' || content[group_index][field_index] == false){
						content[group_index][field_index] = '';
					}
					parent = null;
				});
				content[group_index] = Components._get_field_container(content[group_index].join(''), 'Контент ' + group_index);
			}
			content_container = Object.keys(content).map(key => content[key]).join('');
		}

		return	"<div class='main_content_head'>\
					<p class='main_content_head_title'>" + title + "</p>\
					<div id='content_btn' class='buttons'>" + buttons + "</div>\
				</div>\
				<div class='main_content_info'>"
					+ common_container
					+ content_container +
				'</div>';
	}
	

	static _get_page__catalog(title = '', columns = [], rows = [], buttons = ''){
		//console.log(title);
		//console.log(columns);
		//console.log(rows);
		//console.log(buttons);
		let thead = '',
			tbody = '';

		columns.forEach(function(item, index){
			thead += "<td>" + item.NAME + "</td>";
		});
		thead = '<tr><td>#</td>' + thead + '</tr>';

		if(rows && rows.length > 0){
			rows.forEach(function(item, index){
				let tr = '<td>' + (index + 1) + '</td>';
				columns.forEach(function(colItem, colIndex){
					let valCol = item.DATA[colItem.COL];
					switch(colItem.TYPE){
						case 'text':
							tr += '<td>'+valCol+'</td>';
							break;
						case 'text_img':
						case 'img':
							let text = valCol.alt && valCol.alt != '' ? valCol.alt + ' ' : '';
							let style = valCol.style && valCol.style != '' ? ' style="' + valCol.style + '"' : '';
							let link = '"' + valCol.link + '"';
							tr += '<td>' + text + '<img' + style + ' src='+ link + '></td>';
							break;
						case 'btn':
							let classList = (valCol.classList && valCol.classList != '' ? ' class="' + valCol.classList + '"' : '');
							let events = '';
							Object.keys(valCol.events).forEach(function(eventName){
								let eventFunc = valCol.events[eventName];
								if(eventFunc != ''){
									events += ' ' + eventName + '="' + eventFunc + '"';
								}
							});
							tr += '<td><button' + classList + events + '>' + valCol.text + '</button></td>';
							break;
					}
				});
				let redirect = item.REDIRECT;
				let redir_func = redirect && redirect != '' ? ' style="cursor:pointer" onclick="Redirect.handler(\'' + redirect + '\')" ' : '';	
				tbody += '<tr' + redir_func + '>' + tr + '</tr>';
			});
		}else{
			tbody = '<tr><td colspan="' + (columns.length + 1) + '"><center>Нет записей</center></td></tr>';
		}

		return '<div class="main_content_head"><p class="main_content_head_title">' + title + '</p><div class="buttons">' + buttons + '</div></div>\
				<div class="main_content_info"><form class="general block_form" style="text-align:center;"><div class="table_info forma_group">\
				<table><thead>' + thead + '</thead><tbody>' + tbody + '</tbody></table>\
				</div></form></div>';
	}

	static _get_field_container(content = '', title = ''){
		return	'<form id="data" class="block_form">\
				<div class="block_settings">\
					<div class="buttons">\
						<button class="add block_hide" onclick="return hideThis(this)">Cвернуть</button>\
					</div>\
				</div>\
				<p class="form_title">' + title + '</p>\
				<div class="form_content">'
				+ content +
				'</div>\
			</form>';
	}


	static _get_site_tree(tree = [], href){	
		tree.forEach(function(item, index){
			let ID = item.ID,
				TITLE = item.TITLE,
				CAN_BE_SUPPLEMENTED = item.CAN_BE_SUPPLEMENTED;
			let CHILDRENS = '';
			if(CAN_BE_SUPPLEMENTED && item.CHILDRENS && item.CHILDRENS.length > 0){
				TITLE += ' (' + item.CHILDRENS.length + ')';
				CHILDRENS = Components._get_site_tree_childrens(item.CHILDRENS, href);
			}
			tree[index] = '<ul class="' + Components.tree_item__class_name() + '"><a class="main_nav_list_add Go" href="' + href + ID + '">C</a><a class="' + Components.tree_item__title__class_name() + '"><b>' + TITLE + '</b></a>' + CHILDRENS + '</ul>';
		});
		return tree.join('');
	}

	static _get_site_tree_childrens(childrens, href){
		childrens.forEach(function(item, index){
			let ID = item.ID,
				TITLE = item.TITLE,
				CAN_BE_SUPPLEMENTED = item.CAN_BE_SUPPLEMENTED;
			let CHILDRENS = '';
			if(CAN_BE_SUPPLEMENTED && item.CHILDRENS && item.CHILDRENS.length > 0){
				TITLE += ' (' + item.CHILDRENS.length + ')';
				/*
				GET CHILDRENS FOR CHILDRENS WITH Components._get_site_tree_childrens(item.CHILDRENS, href)
				*/
				//CHILDRENS = Components._get_site_tree_childrens(tree[i].CHILDRENS, href);
			}
			childrens[index] = '<li class="main_nav_list_item"><a class="Go" href="' + href + ID + '">' + TITLE + '</a></li>';
		});
		return childrens.join('');
	}

	static _get_header(title, version, username, menu, header_box_id){
		return "<div class='header'>\
				<div class='header_nav' id='" + header_box_id + "'>" + Components._get_header_menu(menu) + "</div>\
				<div class='header_settings'>\
					<div class='logo'>\
						<img src='/application/views/mainAdmin/img/logo.png' alt=''>\
						<div class='logo_text'>\
							<p>" + title + "<span> " + version + "</span></p>\
						</div>\
					</div>\
					<p class='name'>" + username + "</p>\
					<a class='Go' href='/admin/config' class='settings'>Настройки</a>\
					<a href='/admin/logout' class='logaut'>Выход</a>\
				</div>\
			</div>";
	}

	static _get_header_menu(menu){
		let menu_list = [], 
			menu_content = [];
		menu.forEach(function(item_list, index_list){
			let TITLE = item_list.title,
				URI = item_list.uri,
				CHILDRENS = item_list.childrens ? item_list.childrens : [];
			let go = URI ? ' class="Go" href="' + URI + '"' : '';
			menu_list[index_list] = '<li class="header_nav_list_item"><a'+go+'>' + TITLE + '</a></li>';
			menu_content[index_list] = '';
			CHILDRENS.forEach(function(item_content, index_content){
				let TITLE = item_content.title,
					URI = item_content.uri;
				menu_content[index_list] += '<li><a class="Go" href="' + URI + '">' + TITLE + '</a></li>';	
			});
			menu_content[index_list] = '<li class="header_nav_content_item"><ul>' + menu_content[index_list] + '</ul></li>';
		});
		return '<div class="header_nav_list"><ul>' + menu_list.join('') + '</ul></div><div class="header_nav_content"><ul>' + menu_content.join('') + '</ul></div>';
	}


	static _get_wrapper(site_tree_box_id, content_box_id, loader_box_id, modal_wnd_id, modal_loader_box_id){
		return "<div class='main_wrapper'>\
			<div class='main'>\
				<div id='"+site_tree_box_id+"' class='" + Components.tree_parent__class_name() + "'></div>\
				<div class='content_box'>"
					+ Components._get_wrapper__loader(loader_box_id) +
					"<div class='main_content'>\
						<div class='add_case' id='" + content_box_id + "'></div>\
						<div class='modal_wnd'><div class='modal_wnd_wrapper' id='wrap' onclick='modalClose()'></div><div class='modal_wnd_inner' id='" + modal_wnd_id + "'></div></div>\
					</div>\
				</div>\
			</div>\
		</div>";
	}

	static _get_wrapper__loader(loader_box_id){
		return '<div id="' + loader_box_id + '" class="loader_box"><div class="loader">' + ('<div class="element_box"><div class="element"></div></div>'.repeat(Components.loader__count_elements())) + '</div></div>';
	}
	/* PRIVATE METHODS END */

	/* FIELDS */
	static _get_html_field(item, parent = null){
		let disabled = item.DISABLED || false,
			type = item.CMS_TYPE || null,
			value = item.VAL,
			variable = item.VAR,
			cmsTitle = item.CMS_TITLE,
			cmsDescr = item.CMS_DESCR,
			cmsParent = type == FIELD_TYPES.CMB() ? parent : null,
			events = item.EVENTS && item.EVENTS.length != 0 ? item.EVENTS : null,
			style = item.STYLE || null;

		let events_str = '';
		if(events != null){
			Object.keys(events).forEach(function(key){
				events_str += " " + key + "='" + events[key] + "'";
			});
		}

		if(type == null){
			console.log(item);
		}

		switch(type){
			case FIELD_TYPES.TEXT():
				return Components._get_html_field__text(cmsTitle, cmsDescr, value, variable, disabled, events_str, style);
			case FIELD_TYPES.NUMBER():
				return Components._get_html_field__number(cmsTitle, cmsDescr, value, variable, disabled, events_str, style);
			case FIELD_TYPES.TEXT_AREA():
				return Components._get_html_field__text_area(cmsTitle, cmsDescr, value, variable, disabled, events_str, style);
			case FIELD_TYPES.NUMBER_BTN():
				return Components._get_html_field__number_btn(cmsTitle, cmsDescr, value, variable, disabled, events_str, style);
			case FIELD_TYPES.FILE():
				return Components._get_html_field__file(cmsTitle, cmsDescr, value, variable, disabled, events_str, style);
			case FIELD_TYPES.CMB():
				return Components._get_html_field__cmb(cmsTitle, cmsDescr, value, variable, disabled, events_str, style, cmsParent);
			case FIELD_TYPES.CB():
				return Components._get_html_field__cb(cmsTitle, cmsDescr, value, variable, disabled, events_str, style);
			case FIELD_TYPES.TABLE():
				return Components._get_html_field__table(value.ID || 0, value.DATA || [[]], value.ROWS || 1, value.COLS || 1);
			case FIELD_TYPES.MULTITABLE():
				return Components._get_html_field__multitable(value.ID || 0, value.TABLES || []);
			case FIELD_TYPES.IMAGES():
				return Components._get_html_field__images(value);
			case null:
				return false;
		}
	}

		static _get_modal_field(item, parent = null){
		let type = item.TYPE || null,
			variable = item.NAME,
			cmsTitle = item.TITLE,
			cmsDescr = '',
			cmsParent = type == FIELD_TYPES.CMB() ? parent : null,
			events = item.EVENTS && item.EVENTS.length != 0 ? item.EVENTS : null,
			style = item.STYLE || null;

		let events_str = '';
		if(events != null){
			Object.keys(events).forEach(function(key){
				events_str += " " + key + "='" + events[key] + "'";
			});
		}

		if(type == null){
			console.log(item);
		}

		switch(type){
			case FIELD_TYPES.TEXT():
				return Components._get_html_field__text(cmsTitle, cmsDescr, '', variable, false, events_str, style);
			case FIELD_TYPES.NUMBER():
				return Components._get_html_field__number(cmsTitle, cmsDescr, '', variable, false, events_str, style);
			case FIELD_TYPES.TEXT_AREA():
				return Components._get_html_field__text_area(cmsTitle, cmsDescr, ' ', variable, false, events_str, style);
			case FIELD_TYPES.NUMBER_BTN():
				return Components._get_html_field__number_btn(cmsTitle, cmsDescr, '', variable, false, events_str, style);
			case FIELD_TYPES.FILE():
				return Components._get_html_field__file(cmsTitle, cmsDescr, '', variable, false, events_str, style);
			case FIELD_TYPES.CMB():
				return Components._get_html_field__cmb(cmsTitle, cmsDescr, '', variable, false, events_str, style, cmsParent);
			case FIELD_TYPES.CB():
				return Components._get_html_field__cb(cmsTitle, cmsDescr, false, variable, false, events_str, style);
			case null:
				return false;
		}
	}

	/* BOX FOR SIMPLE FIELDS */
	static __get_html_field__startBox(text = ''){
		return "<div class='forma_group'><p>" + text + "</p>";
	}
	static __get_html_field__endBox(text){
		return (text ? ("<p class='forma_group_item_description'>" + text + "</p>") : '') + "</div></div>";
	}
	/* BOX FOR SIMPLE FIELDS END */



	/* SIMPLE FIELDS */
	static _get_html_field__text(textTitle, textDescr, value, varName, disabled, events, style){
		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item text'><input " + (disabled ? 'disabled ': '') + (events ? events : '') + "autocomplete='off' type='text' name='" + (!disabled ? varName : '') + "' value='" + value + "'>" +
				Components.__get_html_field__endBox(textDescr);
	}

	static _get_html_field__number(textTitle, textDescr, value, varName, disabled, events, style){
		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item text'><input " + (disabled ? 'disabled ': '') + (events ? events : '') + "autocomplete='off' type='text' name='" + (!disabled ? varName : '') + "' value='" + value + "' pattern='[0-9]{1,}'>" +
				Components.__get_html_field__endBox(textDescr);
	}

	static _get_html_field__text_area(textTitle, textDescr, value, varName, disabled, events, style){
		let minheigth = '';
		if(value.length > 499){
			minheigth = ' style="min-height:150px"'
		}else if(value.length > 999){
			minheigth = ' style="min-height:450px"'
		}else if(value.length > 1999){
			minheigth = ' style="min-height:650px"'
		}

		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item textarea'><textarea" + minheigth + " " + (disabled ? 'disabled ': '') + (events ? events : '') + "autocomplete='off' name='" + (!disabled ? varName : '') + "'>" + (value != '' ? value : '<p></p>') + "</textarea>" +
				Components.__get_html_field__endBox(textDescr);
	}

	static _get_html_field__number_btn(textTitle, textDescr, value, varName, disabled, events, style){
		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item text_btn'><input " + (disabled ? 'disabled ': '') + (events ? events : '') + "autocomplete='off' type='text' name='" + (!disabled ? varName : '') + "' value='" + value + "' pattern='[0-9]{1,}'><div class='text_btns'><div class='btn_next' onclick='plus(this)'><p>+</p></div><div class='btn_prev' onclick='minus(this)'><p>-</p></div></div>" +
				Components.__get_html_field__endBox(textDescr);
	}

	static _get_html_field__file(textTitle, textDescr, value, varName, disabled, events, style){
		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item file'><input " + (disabled ? 'disabled ': '') + (events ? events : '') + "autocomplete='off' type='file' name='" + (!disabled ? varName : '') + "' title='" + value + "'>" +
				Components.__get_html_field__endBox(textDescr);
	}

	static _get_html_field__cmb(textTitle, textDescr, value, varName, disabled, events, style, parent){
		let selected = ' selected',
			curselected = '';
		if(parent != null){
			parent.forEach(function(item, index){
				if(item.VALUE == value){
					curselected = ' selected';
					selected = '';
				}
				parent[index] = item.VALUE && item.TEXT ? "<option value='" + item.VALUE + "'" + curselected + ">" + item.TEXT + "</option>" : '';
				curselected = '';
			});
			parent = !(disabled && selected != '') ? "<option value='0'" + selected + "> ---Выберите раздел--- </option>" + parent.join('') : '';
		}else{
			parent = '';
		}
		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item select'><select " + (disabled ? 'disabled ': '') + (events ? events : '') + "name='" + (!disabled ? varName : '') + "'>" + parent + "</select>" +
				Components.__get_html_field__endBox(textDescr);
	}

	static _get_html_field__cb(textTitle, textDescr, value, varName, disabled, events, style){
		let checked;
		if(value && value == 1){
			checked = ' checked';
		}else{
			checked = '';
		}

		return	Components.__get_html_field__startBox(textTitle) +
				"<div class='forma_group_item checkbox'><input " + (disabled ? 'disabled ': '') + (events ? events : '') + " type='checkbox' name='" + varName + "'" + checked + ">" +
				Components.__get_html_field__endBox(textDescr);
	}
	/* SIMPLE FIELDS END */



	static _get_html_field__table(table_id = 0, table = [[]], rows = 1, cols = 1, multitable_component = false, multitable_id = 0){
		let body = '';

		for(let row_index = 1; row_index <= rows; row_index++){
			body += '<tr><td><button class="remove" onclick="return tableRow_Delete(this, ' + table_id + ')">X</button></td>';
			for(let col_index = 1; col_index <= cols; col_index++){
				let val = table[row_index] && table[row_index][col_index] ? table[row_index][col_index] : '';
				body += '<td><input autocomplete="off" name="CELL_TABLE' + table_id + '_' + (row_index) + '_' + (col_index) + '" type="text" value="' + val + '"></td>';
			}
			body += '</tr>';
		}

		return '<div class="table_info forma_group"><div class="table_info_btns"><button class="add" onclick="return tableRow_Add(this, ' + table_id + ')">Добавить Строку</button><button class="add" onclick="return tableCol_Add(this, ' + table_id + ')">Добавить Столбец</button></div>\
			<table ' + (multitable_component ? 'data-multitable-id="' + multitable_id + '" data-multitable-component-id="' + table_id + '"' : 'data-table-id="'+table_id+'"') + ' class="forma_group_item">\
				<tbody>\
					<tr class="table_info_head">\
						<th></th>'
						+ ('<th><button class="remove" onclick="return tableCol_Delete(this, ' + table_id + ')">X</button></th>').repeat(cols) +
					'</tr>'
					+ body +
				'</tbody>\
			</table>\
		</div><hr>';
	}

	static _get_html_field__multitable(multitable_id = 0, multitable = []){
		let content = '<hr>';
		if(multitable.length > 0){
			multitable.forEach(function(table, table_index){
				//console.log(table);
				let table_data = table.DATA || [[]],
					table_id = table.ID || 0,
					rows = table.ROWS || 1,
					cols = table.COLS || 1,
					subtitle = table.SUBTITLE || '';
				//console.log(table_index, Components._get_html_field__table(table_index, table_data, rows, cols, true, multitable_id));
				content += 
					Components._get_html_field__text('Подзаголовок мультитаблицы', '', subtitle, 'TITLE_TABLE' + table_index) +
					Components._get_html_field__table(table_index, table_data, rows, cols, true, multitable_id);
			});
		}else{
			content += Components._get_html_field__text('Подзаголовок мультитаблицы', '', '', 'TITLE_TABLE0') + Components._get_html_field__table(0, [[]], 1, 1, true, 0);
		}
		
		content += '<div class="forma_group">\
			<p>Добавление таблицы</p>\
			<div class="forma_group_item add_table">\
				<div class="add_table_inputs">\
					<label>\
						Количество строк:\
						<input name="rowCount" type="text" value="1">\
					</label>\
					<label>\
						Количество столбцов:\
						<input name="colCount" type="text" value="1">\
					</label>\
				</div>\
				<div class="add_table_btn">\
					<button class="add" onclick="return addMultiTable(this)">Добавить</button>\
				</div>\
			</div>\
		</div>';
		return content;
	}



	static _get_html_field__image(id_image = 0, subtitle_val = '', subtitle_var = '', file_val = '', file_var = '', sign_val = '', sign_var = ''){
		let index = id_image + 1;
		let subtitle_text = 'Подзаголовок картинки ' + index,
			file_text = 'Картинка ' + index,
			sign_text = 'Подпись картинки ' + index;
		subtitle_var += id_image;
		file_var += id_image;
		sign_var += id_image;

		return	'' +
				Components._get_html_field__text(subtitle_text, '', subtitle_val, subtitle_var)+
				Components._get_html_field__file(file_text, '', file_val, file_var) +
				Components._get_html_field__text_area(sign_text, '', sign_val, sign_var) + 
				'<hr>';
	}

	static _get_html_field__images(images = []){
		let content = '<hr>';
		if(images.length > 0){
			images.forEach(function(image, image_index){
				let link = image.LINK || '',
					subtitle = image.SUBTITLE || '',
					sign = image.SIGN || '';

				content += Components._get_html_field__image(image_index,
					subtitle, 'IMAGES_IMAGE_SUBTITLE',
					link, 'IMAGES_IMAGE_LINK',
					sign, 'IMAGES_IMAGE_SIGN');

			});
		}else{
			content += Components._get_html_field__image(0,
				'', 'IMAGES_IMAGE_SUBTITLE',
				'', 'IMAGES_IMAGE_LINK',
				'', 'IMAGES_IMAGE_SIGN');
		}

		content +=
				'<div class="forma_group">\
					<p>Добавление Картинки</p>\
					<div class="forma_group_item add_table">\
						<div class="add_table_inputs"><label for="">Количество:<input name="imgCount" type="text" value="1"></label></div>\
						<div class="add_table_btn"><button class="add" onclick="return addImage(this)">Добавить</button></div>\
					</div>\
				</div>\
			</div>';

		return content;
	}
	/* FIELDS END */
}




class PAGE_TYPES{
	static PAGE(){		return 1; }
	static REPORT(){	return 2; }
	static CATALOG(){	return 3; }
	static CONFIG(){	return 4; }
}

class FIELD_TYPES{
	static TEXT(){		return 'TEXT'; }
	static NUMBER(){	return 'NUMBER'; }
	static TEXT_AREA(){	return 'TEXT_AREA'; }
	static NUMBER_BTN(){return 'NUMBER_BTN'; }
	static FILE(){		return 'FILE'; }
	static CMB(){		return 'CMB'; }
	static CB(){		return 'CB'; }

	static TABLE(){		return 'TABLE'; }
	static MULTITABLE(){return 'MULTITABLE'; }
	static IMAGES(){	return 'IMAGES'; }
}






class Cookie{

	static set(name, value, options){
		Cookie._setCookie(name, value, options);
	}

	static get(name = ''){
		let matches = document.cookie.match(new RegExp(
			"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
		return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	static delete(name){
		Cookie._setCookie(name, '', {
			expires: -1
		});
	}

	static _setCookie(name, value, options){
		options = options || {};

		let expires = options.expires;

		if (typeof expires == "number" && expires) {
			let d = new Date();
			d.setTime(d.getTime() + expires * 1000);
			expires = options.expires = d;
		}
		if (expires && expires.toUTCString) {
			options.expires = expires.toUTCString();
		}

		value = encodeURIComponent(value);

		let updatedCookie = name + "=" + value;

		for (let propName in options) {
			updatedCookie += "; " + propName;
			let propValue = options[propName];
			if (propValue !== true) {
				updatedCookie += "=" + propValue;
			}
		}

		document.cookie = updatedCookie;
	}

}

class Local_Components{

}