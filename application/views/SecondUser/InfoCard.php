<div class="text_wrapper">
	<?php if(isset($CONTENT['TEXT_TITLE'])AND($CONTENT['TEXT_TITLE']!='')): ?>
	<h2 class="text_title"><?php  echo $CONTENT['TEXT_TITLE']; ?></h2>
	<div class="main_line"></div>
	<?php endif; ?>
	<?php if(isset($CONTENT['TEXT_CONTENT'])AND($CONTENT['TEXT_CONTENT']!='')): ?>
	<div class="text"><?php  echo $CONTENT['TEXT_CONTENT']; ?></div>
	<?php endif; ?>
</div>