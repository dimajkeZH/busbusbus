								<form id="data" class="block_form">
									<div class="block_settings">
										<div class="buttons">
											<div class="up_down">
												<div class="btn_up" value="up"><p></p></div>
												<div class="btn_down" value="down"><p></p></div>
											</div>
											<button class="remove" onclick="return removeThis(this)">X</button>
											<button class="add block_hide" onclick="return hideThis(this)">Cвернуть</button>
										</div>
									</div>
									<p class="form_title">Уникальный блок для страниц с экскурсиями	</p>
									<div class="form_content">
										<input type="text" name="ID" value="<?php echo $ID; ?>" style="display:none;">
										<input type="text" name="ID_PAGE_TEMPLATE" value="<?php echo $ID_PAGE_TEMPLATE; ?>" style="display:none;">
										<input type="text" name="TYPE" value="EXC1" style="display:none;">
										<div class="forma_group">
											<p>Заголовок шапки</p>
											<div class="forma_group_item text">
												<input type="text" name="TITLE" value="<?php echo (isset($TITLE))?$TITLE:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>

										<?php /* INFO */ ?>
										<div class="forma_group">
											<p>INFO_TITLE1</p>
											<div class="forma_group_item text">
												<input type="text" name="INFO_TITLE1" value="<?php echo (isset($INFO_TITLE1))?$INFO_TITLE1:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class='forma_group'>
											<p>INFO_DESCR1</p>
											<div class='forma_group_item textarea'>
												<textarea name='INFO_DESCR1'><?php echo (isset($INFO_DESCR1))?$INFO_DESCR1:''; ?></textarea>
												<p class='forma_group_item_description'></p>
											</div>
										</div>
										<div class="forma_group">
											<p>INFO_TITLE2</p>
											<div class="forma_group_item text">
												<input type="text" name="INFO_TITLE2" value="<?php echo (isset($INFO_TITLE2))?$INFO_TITLE2:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class='forma_group'>
											<p>INFO_DESCR2</p>
											<div class='forma_group_item textarea'>
												<textarea name='INFO_DESCR2'><?php echo (isset($INFO_DESCR2))?$INFO_DESCR2:''; ?></textarea>
												<p class='forma_group_item_description'></p>
											</div>
										</div>
										<div class="forma_group">
											<p>INFO_TITLE3</p>
											<div class="forma_group_item text">
												<input type="text" name="INFO_TITLE3" value="<?php echo (isset($INFO_TITLE3))?$INFO_TITLE3:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class='forma_group'>
											<p>INFO_DESCR3</p>
											<div class='forma_group_item textarea'>
												<textarea name='INFO_DESCR3'><?php echo (isset($INFO_DESCR3))?$INFO_DESCR3:''; ?></textarea>
												<p class='forma_group_item_description'></p>
											</div>
										</div>
										<?php /* INFO END */ ?>

										<?php /* PLACE */ ?>
										<div class="forma_group">
											<p>PLACE_TITLE</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TITLE" value="<?php echo (isset($PLACE_TITLE))?$PLACE_TITLE:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										
										<div class="forma_group">
											<p>PLACE_TEXT1</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT1" value="<?php echo (isset($PLACE_TEXT1))?$PLACE_TEXT1:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PLACE_TEXT2</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT2" value="<?php echo (isset($PLACE_TEXT2))?$PLACE_TEXT2:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PLACE_TEXT3</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT3" value="<?php echo (isset($PLACE_TEXT3))?$PLACE_TEXT3:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PLACE_TEXT4</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT4" value="<?php echo (isset($PLACE_TEXT4))?$PLACE_TEXT4:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PLACE_TEXT5</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT5" value="<?php echo (isset($PLACE_TEXT5))?$PLACE_TEXT5:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PLACE_TEXT6</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT6" value="<?php echo (isset($PLACE_TEXT6))?$PLACE_TEXT6:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PLACE_TEXT7</p>
											<div class="forma_group_item text">
												<input type="text" name="PLACE_TEXT7" value="<?php echo (isset($PLACE_TEXT7))?$PLACE_TEXT7:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<?php /* PLACE END */ ?>

										<?php /* PRICE */ ?>
										<div class="forma_group">
											<p>PRICE_TITLE</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_TITLE" value="<?php echo (isset($PRICE_TITLE))?$PRICE_TITLE:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>

										<div class="forma_group">
											<p>PRICE_IMAGE1</p>
											<div class="forma_group_item file">
												<input type="file" name="PRICE_IMAGE1" title="<?php echo (isset($PRICE_IMAGE1))?$PRICE_IMAGE1:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_SUBTITLE1</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_SUBTITLE1" value="<?php echo (isset($PRICE_SUBTITLE1))?$PRICE_SUBTITLE1:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_COST1</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_COST1" value="<?php echo (isset($PRICE_COST1))?$PRICE_COST1:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_TEXT1</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_TEXT1" value="<?php echo (isset($PRICE_TEXT1))?$PRICE_TEXT1:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>

										<div class="forma_group">
											<p>PRICE_IMAGE2</p>
											<div class="forma_group_item file">
												<input type="file" name="PRICE_IMAGE2" title="<?php echo (isset($PRICE_IMAGE2))?$PRICE_IMAGE2:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_SUBTITLE2</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_SUBTITLE2" value="<?php echo (isset($PRICE_SUBTITLE2))?$PRICE_SUBTITLE2:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_COST2</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_COST2" value="<?php echo (isset($PRICE_COST2))?$PRICE_COST2:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_TEXT2</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_TEXT2" value="<?php echo (isset($PRICE_TEXT2))?$PRICE_TEXT2:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_IMAGE3</p>
											<div class="forma_group_item file">
												<input type="file" name="PRICE_IMAGE3" title="<?php echo (isset($PRICE_IMAGE3))?$PRICE_IMAGE3:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_SUBTITLE3</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_SUBTITLE3" value="<?php echo (isset($PRICE_SUBTITLE3))?$PRICE_SUBTITLE3:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_COST3</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_COST3" value="<?php echo (isset($PRICE_COST3))?$PRICE_COST3:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<div class="forma_group">
											<p>PRICE_TEXT3</p>
											<div class="forma_group_item text">
												<input type="text" name="PRICE_TEXT3" value="<?php echo (isset($PRICE_TEXT3))?$PRICE_TEXT3:''; ?>">
												<p class="forma_group_item_description"></p>
											</div>
										</div>
										<?php /* PRICE END */ ?>

										<?php /* INFO */ ?>
										<div class='forma_group'>
											<p>END_TEXT1</p>
											<div class='forma_group_item textarea'>
												<textarea name='END_TEXT1'><?php echo (isset($END_TEXT1))?$END_TEXT1:''; ?></textarea>
												<p class='forma_group_item_description'></p>
											</div>
										</div>
										<div class='forma_group'>
											<p>END_TEXT2</p>
											<div class='forma_group_item textarea'>
												<textarea name='END_TEXT2'><?php echo (isset($END_TEXT2))?$END_TEXT2:''; ?></textarea>
												<p class='forma_group_item_description'></p>
											</div>
										</div>
										<?php /* INFO END */ ?>
									</div>
								</form>