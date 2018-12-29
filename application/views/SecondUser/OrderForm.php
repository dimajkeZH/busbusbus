			<div class="order_header">
				<?php if(isset($CONTENT['HEADER_TITLE'])AND($CONTENT['HEADER_TITLE']!='')): ?>
				<div class="order_header_info">	
					<h1 class="order_header_info_title"><?php echo $CONTENT['HEADER_TITLE']; ?></h1><div class="order_header_line"></div>
				</div>
				<?php endif; ?>
				<div class="order_header_img_one">
					<?php if(isset($CONTENT['HEADER_LEFT_IMAGE'])&&($CONTENT['HEADER_LEFT_IMAGE'] != '')): ?>
					<img src=<?php echo '"/assets/img/templates/header_page/'.$CONTENT['HEADER_LEFT_IMAGE'].'.png"'; ?> alt="">
					<?php endif; ?>
					<?php if(isset($CONTENT['HEADER_LEFT_IMAGE_SIGN'])&&($CONTENT['HEADER_LEFT_IMAGE_SIGN'] != '')): ?>
					<div class="order_header_img_one_text"><p><?php echo $CONTENT['HEADER_LEFT_IMAGE_SIGN']; ?></p></div>
					<?php endif; ?>
				</div>
				<div class="order_form">
					<div class="order_form_title"><p>Заказ ОN-LINE</p></div>
					<form action="" method="POST">
						<div class="forma_group"><input type="text" placeholder="Дата и время подачи" name="to_date"></div>
						<div class="forma_group"><input type="text" placeholder="Адрес подачи" name="addr_from"></div>
						<div class="forma_group"><input type="text" placeholder="Адрес назначения" name="addr_to"></div>
						<div class="forma_group"><input type="text" placeholder="Ваш телефон или email" name="email_phone"></div>
						<div class="forma_group">
							<select name="user_choice"><?php echo $USER_CHOICE; ?></select>
						</div>
						<div class="forma_group"><input type="text" placeholder="Предложите цену" name="cost"></div>
						<div class="forma_group"><input type="text" placeholder="Комментарий" name="message"></div>
						<button onclick="return order('order_form')"><p>Заказать</p></button>
					</form>
				</div>
				<div class="order_header_img_two">
					<?php if(isset($CONTENT['HEADER_RIGHT_IMAGE'])AND($CONTENT['HEADER_RIGHT_IMAGE']!='')): ?>
					<img src=<?php echo '"/assets/img/templates/header_page/'.$CONTENT['HEADER_RIGHT_IMAGE'].'.png"'; ?> alt="">
					<?php endif; ?>
					<?php if(isset($CONTENT['HEADER_RIGHT_IMAGE_SIGN'])AND($CONTENT['HEADER_RIGHT_IMAGE_SIGN']!='')): ?>
					<div class="order_header_img_two_text"><p><?php echo $CONTENT['HEADER_RIGHT_IMAGE_SIGN']; ?></p></div>
					<?php endif; ?>
				</div>
			</div>





















<div class="table_type_two">
	<div class="table_info">
		<?php if(isset($CONTENT['TABLE_TITLE'])AND($CONTENT['TABLE_TITLE']!='')): ?>
		<h2 class="table_info_title"><?php echo $CONTENT['TABLE_TITLE']; ?></h2>
		<div class="table_line"></div>
		<?php endif; ?>
		<?php if(isset($CONTENT['TABLE_SUBTITLE'])AND($CONTENT['TABLE_SUBTITLE']!='')): ?>
		<p class="table_info_title_type_two"><?php echo $CONTENT['TABLE_SUBTITLE']; ?></p>
		<?php endif; ?>
		<?php if(isset($CONTENT['TABLE_DESCR'])AND($CONTENT['TABLE_DESCR']!='')): ?>
		<p class="table_info_main_text"><?php echo $CONTENT['TABLE_DESCR']; ?></p>
		<?php endif; ?>
	</div>
	<div class="table_type_two_info">
		<?php if(isset($CONTENT['TABLE'])AND(count($CONTENT['TABLE'])>0)): ?>
		<div class="table_type_two_info_table">
			<table>
				<?php foreach($CONTENT['TABLE'] as $row): ?>
					<tr>
					<?php foreach($row as $val): ?>
						<td><?php echo $val; ?></td>
					<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
	</div>
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



















<div class="images_text">
	<div class="images_text_info">
		<?php if(isset($CONTENT['IMAGES_TITLE'])AND($CONTENT['IMAGES_TITLE']!='')): ?>
		<h2 class="images_text_title"><?php echo $CONTENT['IMAGES_TITLE']; ?></h2>
		<div class="images_line"></div>
		<?php endif; ?>
		<?php if(isset($CONTENT['IMAGES_DESCR'])AND($CONTENT['IMAGES_DESCR']!='')): ?>
		<p class="images_text_info_content"><?php echo $CONTENT['IMAGES_DESCR']; ?></p>
		<?php endif; ?>
	</div>
	<?php if(isset($CONTENT['IMAGES']) && count($CONTENT['IMAGES'])>0): ?>
	<div class="images_text_items">
		<?php foreach($CONTENT['IMAGES'] as $image): ?>
		<div class="images_text_item">
			<?php if($image['LINK']): ?>
			<img class="images_text_item_img"  src="/assets/img/templates/block_images/<?php echo $image['LINK']; ?>.png" alt="">
			<?php endif; ?>
			<?php if((isset($image['SUBTITLE']) && $image['SUBTITLE'] != '') || (isset($image['SIGN']) && $image['SIGN'] != '<p></p>' && $image['SIGN'] != '')): ?>
			<div class="images_text_item_info">
				<h3 class="images_text_item_info_title"><?php echo $image['SUBTITLE'] ?? ''; ?></h3>
				<p class="images_text_item_info_content"><?php echo $image['SIGN'] ?? ''; ?></p>
			</div>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>		
</div>