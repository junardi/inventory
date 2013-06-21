<div class="container clearfix">
	<div class="grid_12">
		<div id="main">
			<h1>Products</h1>
			<div id="main_search">
				<form id="search_form" action="<?php echo site_url('home/search_product'); ?>" method="post">
					<input type="text" name="product_search" id="data_search" placeholder="product"  />
					<input type="hidden" name="do_search" value="do" />
					<input type="submit" value="Search" />
				</form>
				<form id="delete_form" action="<?php echo site_url('home/delete_product'); ?>" method="post">
					<table>
						
					</table>
					<p class="search_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="loading" /></p>
					<input type="submit" id="add_main" value="Add Product -->" />
					<input type="submit" id="delete_main" value="Delete Product" />
					<div class="clear"></div>
				</form>
			</div>
			<div id="main_add">
				<p class="prompt error">This is the prompt</p>
				<form action="<?php echo site_url('home/add_product'); ?>" method="post">
					<table>
						<tr>
							<td><label for="product_name">Product</label></td>
							<td><input type="text" name="product_name" id="product_name" class="required no_space" /></td>
						</tr>
						<tr>
							<td><label for="quantity_type">Quantity Type</label></td>
							<td><input type="text" name="quantity_type" id="quantity_type" class="required no_space" /></td>
							<td><label for="quantity_no">No.</label></td>
							<td><input type="text" name="quantity_no" id="quantity_no" class="required no_space numeric"/></td>
							<td class="next_error">Enter number</td>
							<td><label for="quantity_price">Price</label></td>
							<td><input type="text" name="quantity_price" id="quantity_price" class="required no_space numeric" /></td>
							<td class="next_error">Enter number</td>
							<td><button class="breakdown">Breakdown</button></td>
						</tr>
						<tr class="breakdowns">
							<td><label for="breakdown_quantity_type">Breakdown Type</label></td>
							<td><input type="text" name="breakdown_quantity_type" id="breakdown_quantity_type" class="no_space" /></td>
							<td><label for="breakdown_quantity_no">No.</label></td>
							<td><input type="text" name="breakdown_quantity_no" id="breakdown_quantity_no" class="no_space numeric" /></td>
							<td class="next_error">Enter number</td>
							<td><label for="breakdown_quantity_price">Price</label></td>
							<td><input type="text" name="breakdown_quantity_price" id="breakdown_quantity_price" class="required no_space numeric" /></td>
							<td class="next_error">Enter number</td>
							<td><button class="breakdowns_add">Add</button></td>
						</tr>
						<tr class="breakdowns_value">
							<td colspan="9">This is reserved for breakdowns values</td>
						</tr>
						<tr class="hide_breakdowns">
							<td colspan="9"><a class="hide_link" href="#">Hide</a></td>
						</tr>
						
						<tr>
							<td><label for="selling_type">Selling Type</label></td>
							<td><input type="text" name="selling_type" id="selling_type" class="required no_space" /></td>
						</tr>
						<tr>
							<td><label for="selling_price">Selling Price</label></td>
							<td><input type="text" name="selling_price" id="selling_price" class="required no_space numeric" /></td>
							<td class="next_error">Enter number</td>
						</tr>
						<tr>
							<td><input type="submit" id="add_main_content" value="Add Product" /></td>
							<td><input type="submit" id="search_main_content" value="<-- Back to search" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<span class="center_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="" /></span>
