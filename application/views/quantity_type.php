<div class="container clearfix">
	<div class="grid_12">
		<div id="main">
			<h1>Quantity Types</h1>
			<form id="search_form" action="<?php echo site_url('quantity_type/search_quantity_type'); ?>" method="post">
				<input type="text" name="quantity_type_search" id="data_search" placeholder="quantity type"  />
				<input type="hidden" name="do_search" value="do" />
				<input type="submit" value="Search" />
			</form>
			<form id="delete_form" action="<?php echo site_url('quantity_type/delete_quantity_type'); ?>" method="post">
				<table>
					
				</table>
				<p class="search_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="loading" /></p>
				<input type="submit" id="add" value="Add Quantity Type" />
				<input type="submit" id="delete" value="Delete Quantity Type" />
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>

<!--Popups the addition of quantity types-->

	<div id="pop_add">
		<div id="pop_add_content">
			<h1 class="left">Add Quantity Type</h1>
			<span class="close right">&#215;</span>
			<div class="clear"></div>
			<p class="prompt error">This is the prompt</p>
			<button class="add_again_button">Add another quantity type</button>
			<form id="add_form" action="<?php echo site_url('quantity_type/add_quantity_type'); ?>" method="post">
				<table>
					<tr>
						<td><label for="quantity_type">Quantity Type</label></td>
						<td><input type="text" name="quantity_type" id="quantity_type" class="required"/></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Add" /> <input type="reset" value="Clear" /> <span class="execute_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="execute loading" /></span></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	
	<!--Below popups the html code for the update of quantity_type-->
	
	<div id="pop_update">
		<div id="pop_update_content">
			<h1 class="left">Update Quantity Type</h1>
			<span class="close right">&#215;</span>
			<div class="clear"></div>
			<p class="prompt error">This is the prompt</p>
			<form id="update_form" action="<?php echo site_url('quantity_type/update_quantity_type'); ?>" method="post">
				<table>
					<tr>
						<td><label for="quantity_type">Quantity Type</label></td>
						<td><input type="text" name="quantity_type" id="quantity_type" class="required"/></td>
					</tr>
					<input type="hidden" name="id" id="id" />
					<tr>
						<td colspan="2"><input type="submit" value="Update" /> <span class="execute_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="execute loading" /></span></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	
	<span class="center_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="" /></span>




















