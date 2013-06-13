<div class="container clearfix">
	<div class="grid_12">
		<div id="main">
			<h1>User</h1>
			<form id="search_form" action="<?php echo base_url(); ?>index.php/user/search_user" method="post">
				<input type="text" name="user_search" id="user_search" placeholder="username"  />
				<input type="submit" value="Search" />
			</form>
			<form id="delete_form" action="<?php echo base_url(); ?>index.php/user/delete_user" method="post">
				<table>
					
				</table>
				<p class="search_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="loading" /></p>
				<input type="submit" id="delete" value="Delete User" />
				<input type="submit" id="add" value="Add User" />
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
	
	<!--Below popups the  html code for the addition of users-->
	
	<div id="pop_add">
		<div id="pop_add_content">
			<h1 class="left">Add User</h1>
			<span class="close right">&#215;</span>
			<div class="clear"></div>
			<p class="prompt error">This is the prompt</p>
			<button class="add_again_button">Add another user</button>
			<form id="add_form" action="<?php echo base_url(); ?>index.php/user/add_user" method="post">
				<table>
					<tr>
						<td><label for="first_name">First Name</label></td>
						<td><input type="text" name="first_name" id="first_name" class="required"/></td>
						<td><label for="last_name">Last Name</label></td>
						<td><input type="text" name="last_name" id="last_name"  class="required" /></td>
					</tr>
					<tr>
						<td><label for="middle_name">Middle Name</label></td>
						<td><input type="text" name="middle_name" id="middle_name" class="required"/></td>
						<td><label for="gender">Gender</label></td>
						<td>
							<select name="gender" id="gender" class="required">
								<option value=""></option>
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="email">Email Address</label></td>
						<td><input type="text" name="email" id="email" class="required"/></td>
						<td><label for="role">Role</label></td>
						<td>
							<select name="role" id="role" class="required">
								<option value=""></option>
								<option value="user">User</option>
								<option value="admin">Admin</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="username">Username</label></td>
						<td><input type="text" name="username" id="username" class="required"/></td>
						<td><label for="password">Password</label></td>
						<td><input type="text" name="password" id="password" class="required"/></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Add" /> <input type="reset" value="Clear" /> <span class="execute_loading"><img src="<?php echo base_url(); ?>images/waiting.gif" alt="execute loading" /></span></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	
	<!--Below popups the html code for the update of users-->
	
	<div id="pop_update">
		<div id="pop_update_content">
			<h1 class="left">Update User</h1>
			<span class="close right">&#215;</span>
			<div class="clear"></div>
			<p class="prompt error">This is the prompt</p>
			<p class="reminder">Leave password blank if you don't want to change current password</p>
			<form id="update_form" action="<?php echo base_url(); ?>index.php/user/update_user" method="post">
				<table>
					<tr>
						<td><label for="first_name">First Name</label></td>
						<td><input type="text" name="first_name" id="first_name" class="required"/></td>
						<td><label for="last_name">Last Name</label></td>
						<td><input type="text" name="last_name" id="last_name"  class="required" /></td>
					</tr>
					<tr>
						<td><label for="middle_name">Middle Name</label></td>
						<td><input type="text" name="middle_name" id="middle_name" class="required"/></td>
						<td><label for="gender">Gender</label></td>
						<td>
							<select name="gender" id="gender" class="required">
								<option value=""></option>
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="email">Email Address</label></td>
						<td><input type="text" name="email" id="email" class="required"/></td>
						<td><label for="role">Role</label></td>
						<td>
							<select name="role" id="role" class="required">
								<option value=""></option>
								<option value="user">User</option>
								<option value="admin">Admin</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="username">Username</label></td>
						<td><input type="text" name="username" id="username" class="required"/></td>
						<td><label for="password">Password</label></td>
						<td><input type="text" name="password" id="password" /></td>
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
	
	



