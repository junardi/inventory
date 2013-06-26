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
		
		<!--Main Add Module-->
		
		var mainAddModule = (function(){
			
			var $prompt =$("#main_add .prompt");
			
			var $submit = $("#main_add table td input[type='submit']");
			var $reset = $("#main_add table td input[type='reset']");
			var $required = $("#main_add table td .required");
			var $no_space = $("#main_add table td .no_space");
			var $numeric = $("#main_add table td .numeric");
			var $next_error = $("#main_add table td.next_error");
			
			var $breakdown_button = $("#main_add table td button.breakdown_button");
			var $breakdowns_space = $("#main_add .breakdowns");
			var $breakdowns_value = $("#main_add .breakdowns_value"); 
			var $breakdowns_value_container = $("#main_add .breakdowns_value td");
			var $breakdowns_add = $("#main_add table td button.breakdowns_add")
			var $hide_breakdowns = $("#main_add .hide_breakdowns");
			var $selling_types = $("#main_add .selling_types");
			
			var $breakdown_prerequisite = $("#main_add table td .breakdown_prerequisite");
			var $breakdown_prerequisite_no = $("#main_add table td .breakdown_prerequisite_no");
			var $space_status;
			var $no_status;

			var $breakdown_data_type = $("#main_add table td .breakdown_data_type");
			var $breakdown_data_no = $("#main_add table td .breakdown_data_no");
			var $breakdown_space_status;
			var $breakdown_no_status;
			
			var $capital = $("#main_add button.main_capital");
			
			var $quantity_type = $("#main_add table td #quantity_type");
			var $quantity_no = $("#main_add table td #quantity_no");
			var $quantity_price = $("#main_add table td #quantity_price");
			
			var $breakdown_type = $("#main_add table td #breakdown_quantity_type");
			var $breakdown_no = $("#main_add table td #breakdown_quantity_no");
			var $breakdown_price = $("#main_add table td #breakdown_quantity_price");
			
			var $select_option = $("#main_add table td .select_option");
			
			var $selling_types_add = $("#main_add table td button.selling_types_add");
			
			function checkBeginningWhiteSpace(str){
			   return /^\s/.test(str);
			}
			
			function check_white_spaces() {	
				$no_space.focus(function(){
					if(checkBeginningWhiteSpace($(this).val()) == false) {
						$(this).css('border', '1px solid #51A7E8');
					}
				}).keyup(function(){			
					if(checkBeginningWhiteSpace($(this).val()) == true) {
						$(this).css('border', '1px solid red');
						$(this).addClass('space');
						$prompt.fadeIn().removeClass('success').addClass('error').text("Must have no space before the start of input.");
						
						$submit.attr('disabled', 'disabled');
					} else {
						$(this).css('border', '1px solid #51A7E8');
						$(this).removeClass('space');
						
						if($('#main_add table td .space').length == 0) {
							$prompt.fadeOut();
							$submit.removeAttr('disabled');
						}
					} 
				}).blur(function(){
					if(checkBeginningWhiteSpace($(this).val()) == false) {
						$(this).css('border', '1px solid #ABADB3');
					}
				});
				
				// focusing the select option
				$select_option.focus(function(){
					$(this).css('border', '1px solid #51A7E8');
				}).blur(function(){
					$(this).css('border', '1px solid #ABADB3');
				});
				
			}
			
			function check_numeric() {
				$next_error.prev('td').css('border-right', 'none');
				$numeric.keyup(function(){
					if($(this).val() != "" && $.isNumeric($(this).val()) == false) {
						$(this).css('color', 'red');
						$(this).parent().next(".next_error").fadeIn();
						$submit.attr('disabled', 'disabled');
					} else {
						$(this).css('color', '#333');
						$(this).parent().next(".next_error").fadeOut();
						$submit.removeAttr('disabled');
					}
				});
			}
			
			function is_required_breakdown_prerequisite_empty() {
				
				var main_quantity_empty = $breakdown_prerequisite.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, main_quantity_empty) != -1;
			}
			
			function is_required_breakdown_prerequisite_no_empty() {
				
				var main_no_quantity_empty = $breakdown_prerequisite_no.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, main_no_quantity_empty) != -1;
			}
			
			function breakdown_click() {
				$breakdown_button.click(function(){
				
					if(is_required_breakdown_prerequisite_empty() || is_required_breakdown_prerequisite_no_empty() || $space_status  == true || $no_status == false) {
						$prompt.fadeIn().text('Product name, Quantity type, No. and Price must have a valid value');
					} else {
					
						$("#main_add table tr:nth-child(2)").children('td').css({
							'border': 'none',
							'border-top': '1px solid #D5D6D6'
						});
					
						$("#main_add table tr:nth-child(2)").children('td:first-child').css({
							//'border-left': '1px solid #6F8696'
						});
						
						$("#main_add table tr:nth-child(3)").children('td').css({
							'border': 'none'
						});
					
						
						$("#main_add table tr:nth-child(4)").children('td').css({
							'border': 'none'
						});
						
						
						$("#main_add table tr:nth-child(5)").children('td').css({
							'border': 'none'
						});
					
						// set the background to #FFF for the tr scope
						$("#main_add table tr:nth-child(2), #main_add table tr:nth-child(3), #main_add table tr:nth-child(4), #main_add table tr:nth-child(5)").css({
							'background-color': '#FFF'
						});  
				
						$breakdowns_space.fadeIn();
						$breakdowns_value.fadeIn();
						$hide_breakdowns.fadeIn();
					
					}
				
					return false;
				
				});
				
				$hide_breakdowns.children('td').children('.hide_link').click(function(){
					$breakdowns_value.fadeOut();
					$hide_breakdowns.fadeOut();
					$breakdowns_space.slideUp('slow', function(){
						$("#main_add table td").css('border', '1px solid #D5D6D6');
						// set the background to #FFF for the tr scope
						$("#main_add table tr:nth-child(2), #main_add table tr:nth-child(3), #main_add table tr:nth-child(4), #main_add table tr:nth-child(5)").css({
							'background-color': '#FAFAFA'
						}); 
						
						$(this).children('td').children('input').val("");
					});
					
					$breakdown_price.text(0);
					$(document).find('.close_data').trigger('click');
					$prompt.fadeOut();
					
					return false;
				});
				
			}
			
			function breakdown_prerequisite_keyup() {
				$breakdown_prerequisite.keyup(function(){
					if(is_required_breakdown_prerequisite_empty()) {
						$hide_breakdowns.find('.hide_link').trigger('click');
					} 
				});
			}
		
			function breakdown_prerequisite_no_keyup() {
				$breakdown_prerequisite_no.keyup(function(){
					if(is_required_breakdown_prerequisite_no_empty()) {
						$hide_breakdowns.find('.hide_link').trigger('click');
					} 
				});
			}
			
			function check_space_in_breakdown_prerequisite() {
				$breakdown_prerequisite.keyup(function(){
					if(checkBeginningWhiteSpace($(this).val()) == true) {
						$space_status = true;
					} else {
						$space_status = false;
					}					
				});
				
			}
			
			function check_number_in_breakdown_prerequisite() {
				$breakdown_prerequisite_no.keyup(function(){
					if($.isNumeric($(this).val()) == false) {
						$no_status = false;
						$hide_breakdowns.find('.hide_link').trigger('click');
					} else {
						$no_status = true;
					}
				});
			
			}
			
			function check_errors_in_breakdown_data() {
				$breakdown_data_type.keyup(function(){
					if(checkBeginningWhiteSpace($(this).val())) {
						$breakdown_space_status = true;
					} else {
						$breakdown_space_status = false;
					}
				});
				
				$breakdown_data_no.keyup(function(){
					if($.isNumeric($(this).val()) == false) {
						$breakdown_no_status = false;
					} else {
						$breakdown_no_status = true;
					}
				});
				
			}
			
			function breakdown_add() {
			
				$breakdowns_add.click(function(){
				
					if($breakdown_no.val() == "" && $breakdown_type.val() == "") {
						$prompt.fadeIn().text("Enter Breakdown Type and No. to calculate price");
					} else if($breakdown_no.val() == "") {
						$prompt.fadeIn().text("Enter No. for breakdown type to automatically calculate price");
					} else if($breakdown_type.val() == "")  {
						$prompt.fadeIn().text("Enter Breakdown type");
					} else if($breakdown_space_status == true && $breakdown_no_status == false) {
						$prompt.fadeIn().text("Enter valid Breakdown Type and No. to calculate price");
					} else if ($breakdown_space_status == true && $breakdown_no_status == true) {
						$prompt.fadeIn().text("Enter valid Breakdown Type");
					} else if($breakdown_space_status == false && $breakdown_no_status == false) {
						$prompt.fadeIn().text("Enter valid No. for quantity type to calculate price");
					} else if($breakdown_price.text() == 0) {
						$prompt.fadeIn().text("Not valid. The price is zero");
					} else if($breakdown_type.val() == $quantity_type.val()) {
						$prompt.fadeIn().text("Breakdown type must not be the same to Quantity type");
					} else {
						
						var break_down_type = $.trim($breakdown_type.val());
						var break_down_no = $.trim($breakdown_no.val());
						var break_down_price = $.trim($breakdown_price.text());
						
						var generated_breakdown_type = $("#main_add .breakdowns_value td .breakdown_data .breakdown_type");
						var breakdown_data = $("#main_add .breakdowns_value td .breakdown_data");
						
						if(generated_breakdown_type.val() == undefined) {
							$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + break_down_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + break_down_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + break_down_price + "' />" + "<span class='label_data'>Type:</span> " + $breakdown_type.val() + "<br />" + "<span class='label_data'>No:</span> "  + $breakdown_no.val() + "<br />" + "<span class='label_data'>Price:</span> " + $breakdown_price.text() + "<span class='close_data'>&#215;</span></span>");
						
						} else {
							
							function exist_breakdown_type(type) {
								var exist = generated_breakdown_type.map(function(){
									return $(this).val() == type;
								});
								
								return $.inArray(true, exist) != -1;
							}
							
							if(exist_breakdown_type(break_down_type)) {
								$prompt.fadeIn().text("Breakdown type already exists");
							} else {
								$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + break_down_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + break_down_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + break_down_price + "' />" + "<span class='label_data'>Type:</span> " + $breakdown_type.val() + "<br />" + "<span class='label_data'>No:</span> "  + $breakdown_no.val() + "<br />" + "<span class='label_data'>Price:</span> " + $breakdown_price.text() + "<span class='close_data'>&#215;</span></span>");
								
							}
						}
						
						get_quantity_type_and_breakdown_types();
					}
					
					return false;
				});
			}

			function get_quantity_type_and_breakdown_types() {
				
				//var quantity_type = $("#main_add table td #quantity_type");
				//var all_breakdown_data = $('#main_add .breakdowns_value td .breakdown_data .breakdown_type');
				var all_breakdown_data = $(document).find('.breakdown_type');
				var selling_option;
				
				$quantity_type.keyup(function(){
					$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
						return "<option>" + $(this).val() +"</option>";
					}).get() );
				});
				
				$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
					return "<option>" + $(this).val() +"</option>";
				}).get() );
			
			}
			
			function selling_type_add() {
				$selling_types_add.click(function(){ 
					
					return false;
				});
			}
			
			function close_data() {
				$(document).on('click', '.close_data', function(){
					$(this).parent().fadeOut(function(){
						$(this).remove();
						get_quantity_type_and_breakdown_types();
					});
				});
			}
			
			function check_valid_no(value) {
				if(value != "" && $.isNumeric(value)) {
					return true;
				} else {
					return false;
				}				
			}
			
			function solve_capital() {
			
				$quantity_no.keyup(function(){
					if(check_valid_no($(this).val()) && check_valid_no($quantity_price.val()) ) {
						var capital_total = $(this).val() * $quantity_price.val();
						$capital.text(capital_total.toFixed(2));
					} else {
						$capital.text(0);
					}
				});
				
				$quantity_price.keyup(function(){
					if(check_valid_no($(this).val()) && check_valid_no($quantity_no.val()) ) {
						var capital_total = $(this).val() * $quantity_no.val();
						$capital.text(capital_total.toFixed(2));
					} else {
						$capital.text(0);
					}
				});
			}
			
			function solve_breakdown_price() {
				$breakdown_no.keyup(function(){
					if(check_valid_no($quantity_no.val()) && check_valid_no($(this).val())) {
						var breakdown_price_value = $capital.text() / ($quantity_no.val() * $(this).val());
						$breakdown_price.text(breakdown_price_value.toFixed(2));
					} else {
						$breakdown_price.text(0);
					}
				});
			}
			
			function check_prompt_status() {
				if($promp_status == true) {
					$breakdown_button.attr('disabled', 'disabled');
				} else {
					$breakdown_button.removeAttr('disabled');
				}
			}
			
			function reset_click() {
				$reset.click(function(){
					$prompt.fadeOut();
					$next_error.fadeOut();
					$no_space.css('border', '1px solid #ABADB3');
					$hide_breakdowns.find('.hide_link').trigger('click');
					$capital.text(0);
				});
			}
			
			return {
				check_white_spaces: check_white_spaces,
				check_numeric: check_numeric,
				breakdown_click: breakdown_click,
				breakdown_prerequisite_keyup: breakdown_prerequisite_keyup,
				breakdown_prerequisite_no_keyup: breakdown_prerequisite_no_keyup,
				check_space_in_breakdown_prerequisite: check_space_in_breakdown_prerequisite,
				check_number_in_breakdown_prerequisite: check_number_in_breakdown_prerequisite,
				check_errors_in_breakdown_data: check_errors_in_breakdown_data,
				breakdown_add: breakdown_add,
				get_quantity_type_and_breakdown_types: get_quantity_type_and_breakdown_types,
				selling_type_add: selling_type_add,
				close_data: close_data,
				solve_capital: solve_capital,
				solve_breakdown_price: solve_breakdown_price,
				reset_click: reset_click
			}
		
		})()
		
		<!--Execute Main Add Module-->
		
		mainAddModule.check_white_spaces();
		mainAddModule.check_numeric();
		mainAddModule.breakdown_click();
		mainAddModule.breakdown_prerequisite_keyup();
		mainAddModule.breakdown_prerequisite_no_keyup();
		mainAddModule.check_space_in_breakdown_prerequisite();
		mainAddModule.check_number_in_breakdown_prerequisite();
		mainAddModule.check_errors_in_breakdown_data();
		mainAddModule.breakdown_add();
		mainAddModule.get_quantity_type_and_breakdown_types();
		mainAddModule.selling_type_add();
		mainAddModule.close_data();
		mainAddModule.solve_capital();
		mainAddModule.solve_breakdown_price();
		mainAddModule.reset_click();
		
		
		<!--Main content exchange module-->
		
		var exchangeModule = (function() {
			
			var $main_search = $("#main_search");
			var $main_add = $("#main_add");
			
			var $reset = $("#main_add table td input[type='reset']");
			var $hide_breakdowns = $("#main_add .hide_breakdowns");
			
			function change_main_content() {
				$("#add_main").click(function(){
					$('.center_loading').fadeIn();
					$main_search.fadeOut(function(){
						$main_add.fadeIn(function(){
							$('.center_loading').fadeOut();
						});
					});
					return false;
				});
				
				$("#search_main_content").click(function(){
					$('.center_loading').fadeIn(function(){
						$(document).find($reset).trigger('click');
						$hide_breakdowns.find('.hide_link').trigger('click');
						$(document).find('.close_data').trigger('click');
					});
					$main_add.fadeOut(function(){
						$main_search.fadeIn(function(){
							$('.center_loading').fadeOut();
						});
					});
					return false;
				});
				
			}
			
			return {
				change_main_content: change_main_content
			}
			
		})()
		
		<!--Execute exchange module-->
		
		exchangeModule.change_main_content();
		
		
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
















