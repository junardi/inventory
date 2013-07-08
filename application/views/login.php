<div class="container clearfix">
	<div id="wrap" class="grid_12">
		<div id="intro" class="grid_7">
			<h1>Manage products easily, quickly.</h1>
			<p>Powerful system to manage your business that automatically calculates your revenue. Determines where my money go? what, why and when</p>
		</div>
		<div id="login" class="grid_4 omega">
			<form id="login_form" action="<?php echo base_url(); ?>index.php/login/validate" method="post">
				<h1>Sign in</h1>
				<p class="login_prompt">Hello this is the prompt</p>
				<label for="username">Username</label>
				<input type="text" name="username" id="username" class="required"/>
				<label for="password">Password</label>
				<input type="password" name="password" id="password" class="required" />
				<input type="hidden" name="valid" value="false" />
				<input type="submit" value="Sign in" />
				<img src="<?php echo base_url(); ?>images/waiting.gif" alt="execute loading" class="side_loading"/>
			</form>
		</div>
	</div>
</div>