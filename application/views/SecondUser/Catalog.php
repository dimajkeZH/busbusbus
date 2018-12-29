<div class="services_other_header">
	<?php if(isset($CONTENT['LINKS_TITLE'])AND($CONTENT['LINKS_TITLE'])): ?>
	<div class="services_other_title">
		<h1><?php echo $CONTENT['LINKS_TITLE']; ?></h1>
		<div class="services_other_line"></div>
	</div>
	<?php endif; ?>
</div>

<div class="catalog_wrapper">

	<h2 class="catalog_title"></h2>
	<?php //<h2 class="catalog_title">$CONTENT['LINKS_TITLE']</h2> ?>

	<?php if(isset($CONTENT['LIST_BUSES']) && count($CONTENT['LIST_BUSES'])  > 0): ?>
	<div class="catalog_items">
		<?php foreach($CONTENT['LIST_BUSES'] as $key => $val): ?>
		<div class="catalog_item">
			<div class="catalog_item_text">
				<h3 class="catalog_item_title"><?php echo $val['TITLE'] ? 'Модели из '.$val['TITLE'] : ''; ?></h3>
				<ul>
					<?php foreach($val['LIST'] as $listkey => $listval): ?>
						<?php if($listval['URI']): ?>
						<li class="catalog_item_link"><a href="/<?php echo $listval['URI'] ? $listval['URI'] : ''; ?>"><?php echo $listval['TITLE'] ? $listval['TITLE'] : ''; ?></a></li>
						<?php else: ?>
						<li class="catalog_item_link"><?php echo $listval['TITLE'] ? $listval['TITLE'] : ''; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="catalog_item_img"><img src="/assets/img/static/cities/<?php echo $val['IMAGE'] ? $val['IMAGE'] : ''; ?>.png" alt=""></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif;?>


	<?php if(isset($CONTENT['LIST_MINIVANS']) && count($CONTENT['LIST_MINIVANS'])  > 0): ?>
	<div class="catalog_items">
		<?php foreach($CONTENT['LIST_MINIVANS'] as $key => $val): ?>
		<div class="catalog_item">
			<div class="catalog_item_text">
				<h3 class="catalog_item_title"><?php echo $val['TITLE'] ? 'Модели из '.$val['TITLE'] : ''; ?></h3>
				<ul>
					<?php foreach($val['LIST'] as $listkey => $listval): ?>
						<?php if($listval['URI']): ?>
						<li class="catalog_item_link"><a href="/<?php echo $listval['URI'] ? $listval['URI'] : ''; ?>"><?php echo $listval['TITLE'] ? $listval['TITLE'] : ''; ?></a></li>
						<?php else: ?>
						<li class="catalog_item_link"><?php echo $listval['TITLE'] ? $listval['TITLE'] : ''; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="catalog_item_img"><img src="/assets/img/static/cities/<?php echo $val['IMAGE'] ? $val['IMAGE'] : ''; ?>.png" alt=""></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif;?>
</div>

















<div class="text_wrapper">
	<?php if(isset($CONTENT['TEXT_TITLE'])AND($CONTENT['TEXT_TITLE']!='')): ?>
	<h2 class="text_title"><?php  echo $CONTENT['TEXT_TITLE']; ?></h2>
	<div class="main_line"></div>
	<?php endif; ?>
	<?php if(isset($CONTENT['TEXT_CONTENT'])AND($CONTENT['TEXT_CONTENT']!='')): ?>
	<div class="text"><?php  echo $CONTENT['TEXT_CONTENT']; ?></div>
	<?php endif; ?>
</div>