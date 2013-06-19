	<div class="container clearfix">
		<div class="grid_12">
			<div id="footer">
				<ul class="left">
					<li><a href="#">Terms</a></li>
					<li><a href="#">Privacy</a></li>
				</ul>
				<ul class="right">
					<li id="copyright">&copy; <?php echo date("Y"); ?> Mastermind Technology, Inc. All rights reserved.</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/validEmail.js"></script>
	
	<!--Below are the scripts for The SEARCH, UPDATE, ADD and DELETE modules-->
	<!--To use the plugin, change the action in every form and the name of the search input and its ID-->
	
	<script type="text/javascript">
		
		<!--Add Module-->
		
		var addModule = (function() {
		
			var $add = $("#delete_form #add");
			var $pop_add = $("#pop_add");
			var $pop_close = $("#pop_add #pop_add_content .close");
			
			var $required = $("#pop_add #add_form .required");
			var $prompt = $("#pop_add_content .prompt");
			var $email = $("#pop_add #add_form #email");
			var $add_again_button = $("#pop_add_content .add_again_button");
			var $add_form = $("#pop_add #add_form");
			var $reset = $("#pop_add #add_form input[type='reset']");
			var $submit = $("#pop_add #add_form input[type='submit']");
			
			var $search_input = $("#search_form #data_search");
			var $search_form = $("#search_form");
			
			function cursor() {
				$("form input[type='submit']").css('cursor', 'pointer');
				$reset.css('cursor', 'pointer');
				$reset.css('cursor', 'pointer');
			}
			
			function add_click() {
				$add.click(function(){
					$('.center_loading').fadeIn();
					
					$pop_add.fadeIn(function(){
						$('.center_loading').fadeOut();
					}).css('height', $(document).height());
					
					$add_form.fadeIn(); 
					$(window).scrollTop('slow');
					return false;
				});
			}
			
			function pop_close_click() {
				$pop_close.click(function(){
					$pop_add.fadeOut();
					$prompt.fadeOut();
					$add_again_button.fadeOut();
					$required.val("");
					$search_input.val("");
					$(document).find($search_form).trigger('submit');
				});
			}
			
			function add_again_button_click() {
				$add_again_button.click(function(){
					$required.val("");
					$add_form.fadeIn(); 
					$prompt.fadeOut();
					$(this).fadeOut();
				});
			}
			
			function isEmpty(){
				var empty = $required.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, empty) != -1;
			}
			
			function reset_click() {
				$reset.click(function(){
					$prompt.fadeOut();
					$required.css('border', '1px solid #ABADB3');
				});
			}
			
			function add_form_submit() {
				$("#add_form").on("submit", function(){

					$('.execute_loading').fadeIn();
					if(isEmpty()) {
						$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').text("Please fill in all of the field.");
					} else {
						
						if($email.val() == undefined) {
						
							var form = $(this);
							$.post(form.attr('action'), form.serialize(), function(data){
								if(data.status) {
									$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('error').addClass('success').text("Added successfully.");
									$add_again_button.fadeIn();
									$add_form.fadeOut(); 
								} else {
									$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').html(data.error);
								}
							
							}, "json");
							
							return false;
							
						} else {
							
							if ($email.validEmail() == true) {
								var form = $(this);
								$.post(form.attr('action'), form.serialize(), function(data){
									if(data.status) {
										$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('error').addClass('success').text("Added successfully.");
										$add_again_button.fadeIn();
										$add_form.fadeOut(); 
									} else {
										$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').html(data.error);
									}
								
								}, "json");
								
								return false;
								
							} else {
								$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').text("Invalid Email");
							
							}
						}
		
					}
				
					return false;
				});
			}
			
			function check_white_spaces() {
	
				$required.keyup(function(){			
					if(checkBeginningWhiteSpace($(this).val()) == true) {
						$(this).css('border', '1px solid red');
						$(this).addClass('space');
						$prompt.fadeIn().removeClass('success').addClass('error').text("Must have no space before the start of input.");
						$submit.attr('disabled', 'disabled');
					} else {
						$(this).css('border', '1px solid #ABADB3');
						$(this).removeClass('space');
						
						if($('#pop_add #add_form .space').length == 0) {
							$prompt.fadeOut();
							$submit.removeAttr('disabled');
						}
					}
				});
				
			}
			
			function checkBeginningWhiteSpace(str){
			   return /^\s/.test(str);
			}
		
			return {
				cursor: cursor,
				add_click: add_click,
				pop_close_click: pop_close_click,
				add_again_button_click: add_again_button_click,
				isEmpty: isEmpty,
				reset_click: reset_click,
				add_form_submit: add_form_submit,
				check_white_spaces: check_white_spaces
			} 
		
		})()
	
		<!--Execute Add Module-->
		
		addModule.cursor();
		addModule.add_click();
		addModule.pop_close_click();
		addModule.add_again_button_click();
		addModule.isEmpty();
		addModule.reset_click();
		addModule.add_form_submit();
		addModule.check_white_spaces();
		
		
		<!--Search of Users Module-->
		
		var searchModule = (function() {
		
			var $search_form = $("#search_form");
			var $search_input_execute = $("#search_form #data_search");
			var $delete_table = $("#delete_form table");
			
			function search_input_execute_focus() {
				$search_input_execute.on("focus", function(){
					$(document).find($search_form).trigger('submit');
				}).on("keyup", function(){
					$(document).find($search_form).trigger('submit');
				});
			}
			
			function search_form_submit() {
				$search_form.on("submit", function(){
					var form = $(this);
					$('.search_loading').fadeIn();
					$.post(form.attr('action'), form.serialize(), function(data){
						$delete_table.html(data.content);
						$('.search_loading').fadeOut();
					}, "json");
				
					return false;
				});
			}
			
			function search_form_trigger_submit_on_load() {
				$(document).find($search_form).trigger('submit');
			}
			
			return {
				search_input_execute_focus: search_input_execute_focus,
				search_form_submit: search_form_submit,
				search_form_trigger_submit_on_load: search_form_trigger_submit_on_load
			}
		
		})()	
		
		<!--Execute Search of User Module-->
		
		searchModule.search_input_execute_focus();
		searchModule.search_form_submit();
		searchModule.search_form_trigger_submit_on_load();
		
		
		<!--Delete of User Module-->
		
		var deleteModule = (function() {
		
			var $delete_form = $("#delete_form");
			var $delete_table = $("#delete_form table");
			
			jQuery.fn.extend({
				check: function() {
					return this.each(function() { this.checked = true; });
				},
				uncheck: function() {
					return this.each(function() { this.checked = false; });
				}
			});

			function execute_checkbox () {
				$(document).on('change', $delete_table, function(){
					
					$(this).find("#delete_form .head_check").click(function(){
						console.log($(this));
						
						if($('input.head_check').is(':checked')) {
							$('input.sub_check').check();
						} else {
							$('input.sub_check').uncheck();
						}
					});
					
					$(this).find("#delete_form .sub_check").click(function(){
						if($('input.sub_check:checked').length == $('input.sub_check').length) {
							$('input.head_check').check();
						} else {
							$('input.head_check').uncheck();
						}
					});
					
				}).change();
			}
			
			function delete_form_submit() {
				$delete_form.on('submit', function(){
					var confirm_delete = confirm("Are you sure you want to delete selected item?");
					if(confirm_delete == true) {
						var form = $(this);
						$.post(form.attr('action'), form.serialize(), function(data){
							if(data.status) {
								<!--Trigger search and alert-->
								$(document).find("#search_form").trigger('submit');
								alert('Deleted Successfully');
							} else {
								alert('Select item delete');
							}
						}, "json");
					} 
					
					return false;
				});
			}
			
			return {
				execute_checkbox: execute_checkbox,
				delete_form_submit: delete_form_submit
			}
		
		})()
		
		<!--Execute Delete of User Module-->
	
		deleteModule.execute_checkbox();
		deleteModule.delete_form_submit();
		
		
		<!--Update User Module-->
		
		var updateModule = (function() {
		
			var $pop_update = $("#pop_update");
			var $pop_close = $("#pop_update #pop_update_content .close");
			var $required = $("#pop_update #update_form .required");
			var $prompt = $("#pop_update_content .prompt");
			var $reminder = $("#pop_update_content .reminder");
			var $submit = $("#pop_update #update_form input[type='submit']");
			
			var $email = $("#pop_update #update_form #email");
		
			var $search_input = $("#search_form #data_search");
			var $search_form = $("#search_form");
			
			function update_link_click() {
				$(document).on("click", "#main #delete_form a.update_link", function(){
					$('.center_loading').fadeIn();
					var link = $(this);
					$.get(link.attr('href'), link.serialize(), function(data){
						$pop_update.fadeIn().css('height', $(document).height());
						
						if(data.value == 'user') {
							$reminder.fadeIn();
							$("#update_form").fadeIn(function(){
								$('.center_loading').fadeOut();
							});
							$(window).scrollTop('slow');
							$('#pop_update #update_form #first_name').val(data.first_name);
							$('#pop_update #update_form #last_name').val(data.last_name);
							$('#pop_update #update_form #middle_name').val(data.middle_name);
							$('#pop_update #update_form #gender').val(data.gender);
							$('#pop_update #update_form #email').val(data.email);
							$('#pop_update #update_form #role').val(data.role);
							$('#pop_update #update_form #username').val(data.username);
							$('#pop_update #update_form #id').val(data.id);
						} else if (data.value == 'quantity_type') {
							$("#update_form").fadeIn(function(){
								$('.center_loading').fadeOut();
							});
							$(window).scrollTop('slow');
							$('#pop_update #update_form #quantity_type').val(data.quantity_type);
							$('#pop_update #update_form #id').val(data.id);
						}
					}, "json");
					return false;
				});
			}
			
			function pop_close_click() {
				$pop_close.click(function(){
					$pop_update.fadeOut();
					$prompt.fadeOut();
					$required.val("");
					$search_input.val("");
					$(document).find($search_form).trigger('submit');
				});
			}
			
			
			function isEmpty(){
				var empty = $required.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, empty) != -1;
			}
			
			function update_form_submit() {
				$("#update_form").on("submit", function(){
					$('.execute_loading').fadeIn();
					if(isEmpty()) {
						$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').text("Please fill in all of the required fields");
					} else  {
						if($email.val() == undefined) {
							var form = $(this);
							$.post(form.attr('action'), form.serialize(), function(data){
								if(data.status) {
									$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('error').addClass('success').text("Updated successfully.");
									$reminder.fadeOut();
									form.fadeOut();
								} else {
									$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').html(data.error);
								}
							
							}, "json");
							
							return false;
						} else {
							if (!isEmpty() && $email.validEmail() == true) {
								var form = $(this);
								$.post(form.attr('action'), form.serialize(), function(data){
									if(data.status) {
										$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('error').addClass('success').text("Updated successfully.");
										$reminder.fadeOut();
										form.fadeOut();
									} else {
										$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').html(data.error);
									}
								
								}, "json");
								
								return false;
								
							} else {
								$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').text("Invalid Email");
							}
						
							return false;
						}
						
					}
				
				});
			}
			
			function check_white_spaces() {
	
				$required.keyup(function(){			
					if(checkBeginningWhiteSpace($(this).val()) == true) {
						$(this).css('border', '1px solid red');
						$(this).addClass('space');
						$prompt.fadeIn().removeClass('success').addClass('error').text("Must have no space before the start of input.");
						$submit.attr('disabled', 'disabled');
					} else {
						$(this).css('border', '1px solid #ABADB3');
						$(this).removeClass('space');
						
						if($('#pop_add #add_form .space').length == 0) {
							$prompt.fadeOut();
							$submit.removeAttr('disabled');
						}
					}
				});
				
			}
			
			function checkBeginningWhiteSpace(str){
			   return /^\s/.test(str);
			}
			
			return {
				update_link_click: update_link_click,
				pop_close_click: pop_close_click,
				isEmpty: isEmpty,
				update_form_submit: update_form_submit,
				check_white_spaces: check_white_spaces
			}
			
		})()
		
		<!--Execute Update User Module-->
		updateModule.update_link_click();
		updateModule.pop_close_click();
		updateModule.isEmpty();
		updateModule.update_form_submit();
		updateModule.check_white_spaces();
		
		<!--crudLoading Module-->
		
		var crudLoading = (function(){
			function center_loading () {
				$('.center_loading').css({
					left: ($(window).width() - $('.center_loading').width()) / 2,
					top: ($(window).width() - $('.center_loading').width()) / 7,
					position:'absolute'
				});
			}
			
			return {
				center_loading: center_loading
			}
			
		})()
		
		<!-- execute crudLoading Module-->
		
		crudLoading.center_loading();
		
		<!--Login Module-->
		
		var loginModule = (function(){
		
			$login_form = $("#login_form");
			$required = $("#login_form .required");
			$login_prompt = $("#login_form .login_prompt");
			$loading = $("#login_form .side_loading");
		
			function focusing(){
				$required.focus(function(){
					$(this).css('border', '1px solid #51A7E8');
				}).blur(function(){
					$(this).css('border', '1px solid #ABADB3');
				});
			}
			
			function isEmpty(){
				var empty = $required.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, empty) != -1;
			}
			
			function login_form_submit() {
				$login_form.on("submit", function(){
					$loading.fadeIn();
					var form = $(this);
					$.post(form.attr('action'), form.serialize(), function(data){
						if(isEmpty()) {
							$login_prompt.fadeIn(function(){$loading.fadeOut();}).addClass('error').text('Fill in all of the fields.');
						} else if(!isEmpty() && data.status == false) {
							$login_prompt.fadeIn(function(){$loading.fadeOut();}).addClass('error').text('Invalid username or password.');
						} else {
							$loading.fadeOut();
							window.location = data.home;
						}
					}, "json");
				
					return false;
				});
			}
			
			return {
				login_form_submit: login_form_submit,
				focusing: focusing
			}
			
		})()
		
		<!--Execute Login Module-->
		
		loginModule.login_form_submit();
		loginModule.focusing();
	

		<!--Navigation Module-->
		
		var navModule = (function(){
		
			$nav_sub_link = $('#header li li a');
			$nav_sub_wrap = $('.nav_sub_wrap');
			
			function redirect(location) {
				window.location = location;
			}
			
			/* Account Dropdown */
			function account_intact_click() {
				$(document).on('click', '.account_intact', function(){
					$(this).next().fadeIn();
					$(this).attr('class', 'account_extract');
					$(document).find('.maintenance_extract').trigger('click');
					return false;
				});
			}
			
			function account_extract_click() {
				$(document).on('click', '.account_extract', function(){
					$(this).next().fadeOut();
					$(this).attr('class', 'account_intact');
					return false;
				});
			}
			
			/* Maintenance Dropdown */
			
			function maintenance_intact_click() {
				$(document).on('click', '.maintenance_intact', function(){
					$(this).next().fadeIn().css('right', '100px');
					$(this).attr('class', 'maintenance_extract');
					$(document).find('.account_extract').trigger('click');
					return false;
				});
			}
			
			function maintenance_extract_click() {
				$(document).on('click', '.maintenance_extract', function(){
					$(this).next().fadeOut();
					$(this).attr('class', 'maintenance_intact');
					return false;
				});
			}
			
			/* Parent Click */
			
			function parent_click() {
				$(document).click(function(e){
					if($(e.target).is('.nav_sub_wrap, .nav_sub_wrap *:not(.nav_sub_wrap li a)')) {
						return false;
					} else {
						$nav_sub_wrap.fadeOut();
						$(document).find('.account_extract').attr('class', 'account_intact');
						$(document).find('.maintenance_extract').attr('class', 'maintenance_intact');
					}
				});
			}
			
			/* Overall hover of the nav_sub */
			function hover_list() {
				$nav_sub_link.hover(load_highlight, unload_highlight);
			}
			
			function load_highlight() {
				$(this).css({
					'color': 'blue',
					'background-color': '#FAFAFA',
					'border-top': '1px solid #D5D6D6',
					'border-bottom': '1px solid #D5D6D6'
				});
			}
			
			function unload_highlight() {
				$(this).css({
					'color': '#333',
					'background-color': '#FFF',
					'border-top': 'none',
					'border-bottom': 'none'
				});
			}
			
			// return all functions
			return {
				hover_list: hover_list,
				account_intact_click: account_intact_click,
				account_extract_click: account_extract_click,
				maintenance_intact_click: maintenance_intact_click,
				maintenance_extract_click: maintenance_extract_click,
				parent_click: parent_click
			}
		
		})()
		
		<!--Execute Navigation Module-->

		navModule.hover_list();
		navModule.account_intact_click();
		navModule.account_extract_click();
		navModule.maintenance_intact_click();
		navModule.maintenance_extract_click();
		navModule.parent_click();
		
	</script>
</body>
</html>
















