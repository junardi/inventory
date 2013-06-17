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
				<input type="submit" id="delete" value="Delete Quantity Type" />
				<input type="submit" id="add" value="Add Quantity Type" />
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>