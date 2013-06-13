	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/validEmail.js"></script>
	
	<!--Below are the scripts for The SEARCH, UPDATE, ADD and DELETE modules-->
	<!--To use the plugin, change the action in every form and the name of the search input and its ID-->
	
	<script type="text/javascript">
		
		<!--Add of User Module-->
		
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
			
			var $search_input = $("#search_form #user_search");
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
				});
			}
			
			function add_form_submit() {
				$("#add_form").on("submit", function(){
					$('.execute_loading').fadeIn();
					if(isEmpty()) {
						$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('success').addClass('error').text("Please fill in all of the fields");
					} else if (!isEmpty() && $email.validEmail() == true) {
						var form = $(this);
						$.post(form.attr('action'), form.serialize(), function(data){
							if(data.status) {
								$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('error').addClass('success').text("User added successfully.");
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
					return false;
				});
			}
		
			return {
				cursor: cursor,
				add_click: add_click,
				pop_close_click: pop_close_click,
				add_again_button_click: add_again_button_click,
				isEmpty: isEmpty,
				reset_click: reset_click,
				add_form_submit: add_form_submit
			} 
		
		})()
	
		<!--Execute Add User Module-->
		
		addModule.cursor();
		addModule.add_click();
		addModule.pop_close_click();
		addModule.add_again_button_click();
		addModule.isEmpty();
		addModule.reset_click();
		addModule.add_form_submit();
		
		
		<!--Search of Users Module-->
		
		var searchModule = (function() {
		
			var $search_form = $("#search_form");
			var $search_input_execute = $("#search_form #user_search");
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
					var confirm_delete = confirm("Are you sure you want to delete selected user?");
					if(confirm_delete == true) {
						var form = $(this);
						$.post(form.attr('action'), form.serialize(), function(data){
							if(data.status) {
								<!--Trigger search and alert-->
								$(document).find("#search_form").trigger('submit');
								alert('Deleted Successfully');
							} else {
								alert('Select User to delete');
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
			
			var $email = $("#pop_update #update_form #email");
		
			var $search_input = $("#search_form #user_search");
			var $search_form = $("#search_form");
			
			function update_link_click() {
				$(document).on("click", "#main #delete_form a.update_link", function(){
					$('.center_loading').fadeIn();
					var link = $(this);
					$.get(link.attr('href'), link.serialize(), function(data){
						$pop_update.fadeIn().css('height', $(document).height());
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
					} else if (!isEmpty() && $email.validEmail() == true) {
						var form = $(this);
						$.post(form.attr('action'), form.serialize(), function(data){
							if(data.status) {
								$prompt.fadeIn(function(){$('.execute_loading').fadeOut();}).removeClass('error').addClass('success').text("User updated successfully.");
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
				});
			}
			
			return {
				update_link_click: update_link_click,
				pop_close_click: pop_close_click,
				isEmpty: isEmpty,
				update_form_submit: update_form_submit
			}
			
		})()
		
		<!--Execute Update User Module-->
		updateModule.update_link_click();
		updateModule.pop_close_click();
		updateModule.isEmpty();
		updateModule.update_form_submit();
		
		<!--Waiting Script-->
		
		$('.center_loading').css({
			left: ($(window).width() - $('.center_loading').width()) / 2,
			top: ($(window).width() - $('.center_loading').width()) / 7,
			position:'absolute'
		});
		
	</script>
</body>
</html>