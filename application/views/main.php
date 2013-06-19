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
					<input type="submit" id="add_main" value="Add Product" />
					<input type="submit" id="delete_main" value="Delete Product" />
					<div class="clear"></div>
				</form>
			</div>
			<div id="main_add">
				<form action="<?php echo site_url('home/add_product'); ?>" method="post">
					<table>
						<tr>
							<td><label for="product_name">Product</label></td>
							<td><input type="text" name="product_name" id="product_name" /></td>
						</tr>
						<tr>
							<td><label for="quantity">Quantity Type</label></td>
							<td><input type="text" name="quantity" id="quantity" /></td>
						</tr>
						<tr>
							<td><label for="price">Price</label></td>
							<td><input type="text" name="price" id="price" /></td>
						</tr>
						<tr>
							<td><label for="selling_type">Selling Type</label></td>
							<td><input type="text" name="selling_type" id="selling_type" /></td>
						</tr>
						<tr>
							<td><label for="selling_price">Selling Price</label></td>
							<td><input type="text" name="selling_price" id="selling_price" /></td>
						</tr>
						<tr>
							<td><input type="submit" id="add_main_content" value="Add Product" /></td>
							<td><input type="submit" id="search_main_content" value="<-- Back to serach" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>

<span class="center_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="" /></span>
