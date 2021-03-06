	<div class="container clearfix">
		<div class="grid_12">
			<div id="footer">
				<ul class="left">
					<li><a href="#">Terms</a></li>
					<li><a href="#">Privacy</a></li>
				</ul>
				<ul class="right">
					<li id="copyright">&copy; <?php echo date("Y"); ?> <a target="_blank" href="http://mastermindtechnology.org/">Mastermind Technology, Inc.</a> All rights reserved.</li>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	
	<!--external javascripts are link below-->
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/jquery2.js"></script>
	
	<!--Email validation plugin-->
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/validEmail.js"></script>
	
	<!--Notification plugin-->
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/noty/layouts/center.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>scripts/noty/themes/default.js"></script>
	
	<!--Below are the scripts for The SEARCH, UPDATE, ADD and DELETE modules-->
	<!--To use the plugin, change the action in every form and the name of the search input and its ID-->
	
	<script type="text/javascript">
	
		<!--Below is the main prompt-->
		
		var prompt = function(message, type) {
			var n = noty({
				layout: 'center',
				theme: 'defaultTheme',
				type: type,
				text: message,
				modal: true,
				buttons: [
					{ text: 'Close', onClick: function($noty) 
						{

							// this = button element
							// $noty = $noty element
						
							$noty.close();
						}
					}
				],
				animation: {
					open: {height: 'toggle'},
					close: {height: 'toggle'},
					easing: 'swing',
					speed: 10 // opening & closing animation speed
				}
			});
		};
		
		<!--Below is for the delays-->
		
		var delay = (function(){
			var timer = 0;
			return function(callback, ms){
				clearTimeout (timer);
				timer = setTimeout(callback, ms);
			};
		})();
		
		
		<!--Main Add Module-->
		
		var mainAddModule = (function(){
			
			var $loading = $("#main_add table td .side_loading");
		
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
			var $breakdowns_value_container = $("#main_add .breakdowns_value td.breakdown_type_area");
			var $breakdowns_value_description = $("#main_add .breakdowns_value .breakdown_type_area span.description");
			var $breakdowns_add = $("#main_add table td button.breakdowns_add")
			var $hide_breakdowns = $("#main_add .hide_breakdowns");
			var $selling_types = $("#main_add .selling_types");
			
			var $breakdown_prerequisite = $("#main_add table td .breakdown_prerequisite");
			var $breakdown_prerequisite_no = $("#main_add table td .breakdown_prerequisite_no");
			var $breakdown_prerequisite_no_space_status;
			
			
			var $breakdown_data_type = $("#main_add table td .breakdown_data_type");
			var $breakdown_data_no = $("#main_add table td .breakdown_data_no");
			var $breakdown_space_status;
			var $breakdown_no_status;
			var $breakdown_space_no_status;
			
			
			var $capital = $("#main_add button.main_capital");
			var $product_capital = $("#main_add #product_capital");
			
			var $quantity_type = $("#main_add table td #quantity_type");
			var $quantity_no = $("#main_add table td #quantity_no");
			var $quantity_price = $("#main_add table td #quantity_price");
			
			var $breakdown_type = $("#main_add table td #breakdown_quantity_type");
			var $breakdown_no = $("#main_add table td #breakdown_quantity_no");
			var $breakdown_price = $("#main_add table td #breakdown_quantity_price");
			
			var $select_option = $("#main_add table td .select_option");
			
			var $selling_types_add = $("#main_add table td button.selling_types_add");
			var $selling_type = $("#main_add table .selling_types td #selling_type");
			var $selling_price = $("#main_add table .selling_types td #selling_price");
			var $selling_type_error;
			var $selling_types_value_container = $("#main_add .selling_types_value td.selling_type_area");
			var $selling_types_value_description = $("#main_add .selling_types_value td.selling_type_area span.description");
			var $selling_profit;
			var $converted_selling_profit;
			var $selling_profit_button = $("#main_add .selling_types td button.selling_profit_button")
			
			var $add_main_content_form = $("#main_add #add_main_content_form");
			
			var $is_selling_type_undefined;
			var $is_breakdown_type_undefined; 
			
			var $back_to_search = $("#main_add .add_another_area #back_to_search")
			var $add_another = $("#main_add .add_another_main_content");
			var $form = $("#main_add #add_main_content_form");
			
			var $space_status;
			var $no_status;
			
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
						//$prompt.fadeIn().removeClass('success').addClass('error').text("Must have no space before the start of input.");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Must have no space before the start of input.", "warning");
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
					$(this).parent().siblings('td').children('#selling_price').val("").css('color', '#333');
					$selling_profit_button.text(0);
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
			
			function is_required_empty() {
				var required_empty = $required.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, required_empty) != -1;
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
			
			function check_space_in_breakdown_prerequisite() {
				$breakdown_prerequisite.keyup(function(){
					if(checkBeginningWhiteSpace($(this).val()) == true) {
						$hide_breakdowns.find('.hide_link').trigger('click');
						$space_status = true;
					} else {
						$space_status = false;
					}

					$hide_breakdowns.find('.hide_link').trigger('click');
					$(document).find('.close_selling_data').trigger('click');
					$selling_price.val("");
					$selling_profit_button.text(0);
				});	
			}
			
			function check_number_and_space_in_breakdown_prerequisite_no() {
				$breakdown_prerequisite_no.keyup(function(){
					if($.isNumeric($(this).val()) == false) {
						$hide_breakdowns.find('.hide_link').trigger('click');
						$no_status = false;
					} else if(checkBeginningWhiteSpace($(this).val())) {
						$breakdown_prerequisite_no_space_status = true;
					} else {
						$no_status = true;
						$breakdown_prerequisite_no_space_status = false;
					}
					
					$hide_breakdowns.find('.hide_link').trigger('click');
					$(document).find('.close_selling_data').trigger('click');
					$selling_price.val("");
					$selling_profit_button.text(0);
					
				});
			}
			
			function breakdown_click() {
				$breakdown_button.click(function(){
					if(is_required_breakdown_prerequisite_empty() || is_required_breakdown_prerequisite_no_empty() || $space_status  == true || $no_status == false || $breakdown_prerequisite_no_space_status == true) {
						//$prompt.fadeIn().text('Product name, Quantity type, No. and Price must have a valid value');
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Product name, Quantity type, No. and Price must have a valid value", "warning");
					
						$loading.fadeOut();
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

			}
		
			function hide_breakdown_click() {
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
					return false;
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
					} else if(checkBeginningWhiteSpace($(this).val())) {
						$breakdown_space_no_status = true;
					} else {
						$breakdown_no_status = true;
						$breakdown_space_no_status = false;
					}
				});
		
			}
			
			function breakdown_add() {
				var pre_generated_breakdown_type = $("#main_add .breakdowns_value td .breakdown_data .breakdown_type");
				
				if(pre_generated_breakdown_type.val() == undefined) {
					$is_breakdown_type_undefined = true;
					
					if($is_breakdown_type_undefined == true) {
						$breakdowns_value_description.fadeIn();
					}
				}
				
				$breakdowns_add.click(function(){
					if($breakdown_no.val() == "" && $breakdown_type.val() == "") {
						//$prompt.fadeIn().text("Enter Breakdown Type and No. to calculate price");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter Breakdown Type and No.", "warning");
					} else if($breakdown_no.val() == "") {
						//$prompt.fadeIn().text("Enter No. for breakdown type to automatically calculate price");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter No. for breakdown type", "warning");
					} else if($breakdown_type.val() == "")  {
						//$prompt.fadeIn().text("Enter Breakdown type");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter Breakdown type", "warning");
					} else if($breakdown_space_status == true && $breakdown_no_status == false) {
						//$prompt.fadeIn().text("Enter valid Breakdown Type and No. to calculate price");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter valid Breakdown Type and No.", "warning");
					} else if ($breakdown_space_status == true && $breakdown_no_status == true) {
						//$prompt.fadeIn().text("Enter valid Breakdown Type");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter valid Breakdown Type", "warning");
					} else if($breakdown_space_status == false && $breakdown_no_status == false) {
						//$prompt.fadeIn().text("Enter valid No. for quantity type to calculate price");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter valid No. for breakdown type", "warning");
					} else if($breakdown_space_no_status) {
						//$prompt.fadeIn().text("Enter valid No. for quantity type to calculate price");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Enter valid No. for breakdown type", "warning");
					} else if($breakdown_price.text() == 0) {
						//$prompt.fadeIn().text("Not valid. The price is zero");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Not valid. The price is zero", "warning");
					} else if($breakdown_type.val() == $quantity_type.val()) {
						//$prompt.fadeIn().text("Breakdown type must not be the same to Quantity type");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Breakdown type must not be the same to Quantity type", "warning");
					} else {
						
						var break_down_type = $.trim($breakdown_type.val());
						var break_down_no = $.trim($breakdown_no.val());
						var break_down_price = $.trim($breakdown_price.text());
						
						var generated_breakdown_type = $("#main_add .breakdowns_value td .breakdown_data .breakdown_type");
						//var breakdown_data = $("#main_add .breakdowns_value td .breakdown_data");
						
						if(generated_breakdown_type.val() == undefined) {
							$is_breakdown_type_undefined = false;
							$breakdowns_value_description.fadeOut(function(){
								$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + break_down_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + break_down_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + break_down_price + "' />" + "<span class='label_data'>Type:</span> " + $breakdown_type.val() + "<br />" + "<span class='label_data'>No:</span> "  + $breakdown_no.val() + "<br />" + "<span class='label_data'>Price:</span> " + $breakdown_price.text() + "<span class='close_data'>&#215;</span></span>");
								get_quantity_type_and_breakdown_types();
							});
						} else {
							
							function exist_breakdown_type(type) {
								var exist = generated_breakdown_type.map(function(){
									return $(this).val() == type;
								});
								
								return $.inArray(true, exist) != -1;
							}
							
							if(exist_breakdown_type(break_down_type)) {
								//$prompt.fadeIn().text("Breakdown type already exists");
								$('body').animate({scrollTop: 0}, 'slow');
								prompt("Breakdown type already exists", "warning");
							} else {
								$is_breakdown_type_undefined = false;
								$breakdowns_value_description.fadeOut(function(){
									$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + break_down_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + break_down_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + break_down_price + "' />" + "<span class='label_data'>Type:</span> " + $breakdown_type.val() + "<br />" + "<span class='label_data'>No:</span> "  + $breakdown_no.val() + "<br />" + "<span class='label_data'>Price:</span> " + $breakdown_price.text() + "<span class='close_data'>&#215;</span></span>");
									get_quantity_type_and_breakdown_types();
								});
							}
						}
						
					}
					
					return false;
				});
			}

			function get_quantity_type_and_breakdown_types() {
				
				//var quantity_type = $("#main_add table td #quantity_type");
				var all_breakdown_data = $('#main_add .breakdowns_value td.breakdown_type_area .breakdown_data .breakdown_type');
				//var all_breakdown_data = $(document).find('.breakdown_type');
				//var selling_option;
				
				$quantity_type.keyup(function(){
					$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
						return "<option>" + $(this).val() +"</option>";
					}).get() );
				});
				
				$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
					return "<option>" + $(this).val() +"</option>";
				}).get() );
			
			}
			
			function check_selling_price() {
			
				function exist_quantity_type(type) {
					if(type == $quantity_type.val()) {
						return true;
					} else {
						return false;
					}
				}
			
				function exist_breakdown_type(type) {
					var exist = generated_breakdown_type.map(function(){
						return $(this).val() == type;
					});
					
					return $.inArray(true, exist) != -1;
				}
				
				function numeric() {
					if($selling_price.val() !== "" && $.isNumeric($selling_price.val())) {
						return 1;
					} else {
						return 0;
					}							
				}
				
				$selling_price.on('keyup', function(){
					
					var selling_type = $selling_price.parent().parent().children("td").children("#selling_type").val();
					var generated_breakdown_type = $("#main_add .breakdowns_value td .breakdown_data .breakdown_type");
					
					var breakdown_data = $("#main_add .breakdowns_value td .breakdown_data");
					var selected_data;
					
					var standard_price;
					var value_input;
					
					delay(function(){
					
						if(exist_quantity_type(selling_type)) {
							standard_price = parseFloat($quantity_price.val());
							value_input = parseFloat($selling_price.val());
							
							if(numeric()) {
								if(value_input == standard_price) {
									
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
									
									$selling_price.css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
									
								} else if(value_input < standard_price) {
									
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
									
									$selling_price.css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
								
									
								} else if(value_input > standard_price) {
									$selling_price.css('color', '#333');
									$selling_type_error = false;
									$selling_profit = value_input - standard_price;
									$converted_selling_profit = $selling_profit.toFixed(2);
									$selling_profit_button.text($converted_selling_profit);
								}
							} 
						
						} else {
							if(numeric()) {
								breakdown_data.each(function(){
									if(breakdown_data.children(".breakdown_type").val() == selling_type) {
										breakdown_data.siblings('.selected_data').removeClass('selected_data');
										breakdown_data.addClass('selected_data');
										selected_data = $(document).find("span.selected_data");
									}
								});
								
								standard_price = parseFloat(selected_data.children('.breakdown_price').val());
								value_input = parseFloat($(this).val());
								
								if(value_input == standard_price) {
								
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
								
									$selling_price.css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
									
								} else if(value_input < standard_price) {
									
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
									
									$selling_price.css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
									
								} else if(value_input > standard_price) {
									$selling_price.css('color', '#333');
									$selling_type_error = false;
									$selling_profit = value_input - standard_price;
									$converted_selling_profit = $selling_profit.toFixed(2);
									$selling_profit_button.text($converted_selling_profit);
								}
							} 
						}
						
						/*if(exist_quantity_type(selling_type)) {
						
							standard_price = parseFloat($quantity_price.val());
							value_input = parseFloat($(this).val());
							
							
							if($(this).val() != "" && $.isNumeric($(this).val())) {
								if(value_input == standard_price) {
									
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
									
									$(this).css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
									
								} else if(value_input < standard_price) {
									
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
									
									$(this).css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
								
									
								} else if(value_input > standard_price) {
									$(this).css('color', '#333');
									$selling_type_error = false;
									$selling_profit = value_input - standard_price;
									$converted_selling_profit = $selling_profit.toFixed(2);
									$selling_profit_button.text($converted_selling_profit);
								}
							} 

						} else {
							
							if($(this).val() != "" && $.isNumeric($(this).val())) {
								
								breakdown_data.each(function(){
									if($(this).children(".breakdown_type").val() == selling_type) {
										$(this).siblings('.selected_data').removeClass('selected_data');
										$(this).addClass('selected_data');
										selected_data = $(document).find("span.selected_data");
									}
								});
								
								standard_price = parseFloat(selected_data.children('.breakdown_price').val());
								value_input = parseFloat($(this).val());
								
								if(value_input == standard_price) {
								
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
								
									$(this).css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
									
								} else if(value_input < standard_price) {
									
									$('body').animate({scrollTop: 0}, 'slow');
									//prompt("No profit for the selling price entered", "warning");
									$prompt.fadeIn().text('No profit for the selling price entered');
									
									$(this).css('color', 'red');
									$selling_type_error = true;
									$selling_profit_button.text(0);
									
								} else if(value_input > standard_price) {
									$(this).css('color', '#333');
									$selling_type_error = false;
									$selling_profit = value_input - standard_price;
									$converted_selling_profit = $selling_profit.toFixed(2);
									$selling_profit_button.text($converted_selling_profit);
								}
							}
						} // end else */
					}, 1000 );
					
				}); // end keyup
			}
			
			function selling_type_add() {
				
				var pre_generated_selling_type = $("#main_add .selling_types_value td .selling_type_data .selling_type");
				
				if(pre_generated_selling_type.val() == undefined) {
					$is_selling_type_undefined = true;
					
					if($is_selling_type_undefined == true) {
						$selling_types_value_description.fadeIn();
					}
				}
			
				$selling_types_add.click(function(){ 
					if($selling_price.val() == "" || $selling_type_error == true || $.isNumeric($selling_price.val()) == false) {
						//$prompt.fadeIn().text("Please enter valid selling price.");
						$('body').animate({scrollTop: 0}, 'slow');
						prompt("Please select selling type and enter valid selling price.", "warning");
					} else {
						var selling_type = $.trim($selling_type.val());
						var selling_price = $.trim($selling_price.val());
						var selling_profit = $.trim($converted_selling_profit);
						
						var generated_selling_type = $("#main_add .selling_types_value td .selling_type_data .selling_type");
						
						if(generated_selling_type == undefined) {
							$is_selling_type_undefined = false;
							$selling_types_value_description.fadeOut(function(){
								$selling_types_value_container.append("<span class='selling_type_data'>" + "<input type='hidden' name='selling_type[]' class='selling_type' value='"  + selling_type + "' />" + "<input type='hidden' name='selling_price[]' class='selling_price' value='"  + selling_price + "' />" + "<input type='hidden' name='selling_profit[]' class='selling_profit' value='"  + selling_profit + "' />" + "<span class='label_data'>Type:</span> " + $selling_type.val() + "<br />" + "<span class='label_data'>Price:</span> " + $selling_price.val() + "<br />" + "<span class='label_data'>Profit:</span> " + $converted_selling_profit + "<span class='close_selling_data'>&#215;</span></span>");
							});
						} else {
						
							function exist_selling_type(type) {
								var exist = generated_selling_type.map(function(){
									return $(this).val() == type;
								});
								
								return $.inArray(true, exist) != -1;
							}
							
							if(exist_selling_type(selling_type)) {
								//$prompt.fadeIn().text("Selling type already exists");
								$('body').animate({scrollTop: 0}, 'slow');
								prompt("Selling type already exists", "warning");
							} else {
								$is_selling_type_undefined = false;
								$selling_types_value_description.fadeOut(function(){
									$selling_types_value_container.append("<span class='selling_type_data'>" + "<input type='hidden' name='selling_type[]' class='selling_type' value='"  + selling_type + "' />" + "<input type='hidden' name='selling_price[]' class='selling_price' value='"  + selling_price + "' />" + "<input type='hidden' name='selling_profit[]' class='selling_profit' value='"  + selling_profit + "' />" + "<span class='label_data'>Type:</span> " + $selling_type.val() + "<br />" + "<span class='label_data'>Price:</span> " + $selling_price.val() + "<br />" + "<span class='label_data'>Profit:</span> " + $converted_selling_profit + "<span class='close_selling_data'>&#215;</span></span>");
								});
							}
						}
						
					}
					
					return false;
				});
			}
			
			function close_data() {
				$(document).on('click', '.close_data', function(){
					var breakdown_type = $(this).parent().children('.breakdown_type').val(); 
					var selling_type_data = $("#main_add .selling_types_value td .selling_type_data");
					var remove_selected_data;
					
					var post_generated_breakdown_type = $("#main_add .breakdowns_value td .breakdown_data .breakdown_type");
					var post_generated_selling_type = $("#main_add .selling_types_value td .selling_type_data .selling_type");
					
					selling_type_data.each(function(){
						if($(this).children(".selling_type").val() == breakdown_type) {
							$(this).addClass('remove_selected_data');
							remove_selected_data = $(document).find("span.remove_selected_data");
						}
					});
					
				
					$(this).parent().fadeOut(function(){
						$(this).remove();
						get_quantity_type_and_breakdown_types();
						
						if(remove_selected_data == undefined) {
							$prompt.fadeOut();
							if($(document).find(post_generated_breakdown_type).val() == undefined) {
								$is_breakdown_type_undefined = true;
						
								if($is_breakdown_type_undefined == true) {
									$breakdowns_value_description.fadeIn();
								}
							}
						} else {
							remove_selected_data.fadeOut().remove();
							$prompt.fadeOut();
							if($(document).find(post_generated_breakdown_type).val() == undefined) {
								$is_breakdown_type_undefined = true;
						
								if($is_breakdown_type_undefined == true) {
									$breakdowns_value_description.fadeIn();
								}
							}
							
							if($(document).find(post_generated_selling_type).val() == undefined){
								$is_selling_type_undefined = true;
								if($is_selling_type_undefined == true) {
									$selling_types_value_description.fadeIn();
								}
							}
						}
					
					});
					
				});
			}
			
			function close_selling_data() {
				$(document).on('click', '.close_selling_data', function(){
					
					var post_generated_selling_type = $("#main_add .selling_types_value td .selling_type_data .selling_type");
					
					$(this).parent().fadeOut(function(){
						$(this).remove();
						$prompt.fadeOut();
						
						if($(document).find(post_generated_selling_type).val() == undefined){
							$is_selling_type_undefined = true;
							if($is_selling_type_undefined == true) {
								$selling_types_value_description.fadeIn();
							}
						}
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
						$product_capital.val(capital_total.toFixed(2));
					} else {
						$capital.text(0);
						$product_capital.val(0);
					}
				});
				
				$quantity_price.keyup(function(){
					if(check_valid_no($(this).val()) && check_valid_no($quantity_no.val()) ) {
						var capital_total = $(this).val() * $quantity_no.val();
						$capital.text(capital_total.toFixed(2));
						$product_capital.val(capital_total.toFixed(2));
					} else {
						$capital.text(0);
						$product_capital.val(0);
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
					$(document).find('.close_selling_data').trigger('click');
					$capital.text(0);
					$selling_profit_button.text(0);
					$select_option.html("<option value=''></option>");
				});
			}
			
			function add_main_content_form_submit() {
				$add_main_content_form.on('submit', function(){
					$loading.fadeIn();
					var generated_breakdown_type = $("#main_add .breakdowns_value td .breakdown_data .breakdown_type");
					var generated_selling_type = $("#main_add .selling_types_value td .selling_type_data .selling_type");
					var breakdown_type_is_empty;
					var selling_type_is_empty;
					var found_required_empty;
					
					if(generated_breakdown_type.val() == undefined) {
						breakdown_type_is_empty = true;
					} else {
						breakdown_type_is_empty = false;
					}
					
					if(generated_selling_type.val() == undefined) {
						selling_type_is_empty = true;
					} else {
						selling_type_is_empty = false;
					}
					
					if(is_required_empty()) {
						//$prompt.fadeIn().text("Required fields must not be empty. Indicated by red border");
						
						$required.each(function(){
							if($(this).val() == "") {
								$(this).addClass("found_required_empty");
								found_required_empty = $(document).find('.found_required_empty');
							}							
						});
						
						found_required_empty.css('border', '1px solid red');
						$('body').animate({scrollTop: 0}, 'fast');
						prompt("Required fields must not be empty. Indicated by red border", "warning");
						$loading.fadeOut();
					} else if (!is_required_empty() && selling_type_is_empty) {
						//$prompt.fadeIn().text("There must be selling types.");
						$('body').animate({scrollTop: 0}, 'fast');
						prompt("There must be selling types.", "warning");
						$loading.fadeOut();
					} else {					
						var form = $(this);
						$.post(form.attr('action'), form.serialize(), function(data){
							console.log(data.breakdown_quantity_type_inserted);
							console.log(data.selling_type_inserted);
							if(data.status) {
								$prompt.fadeIn(function(){
									$form.fadeOut();
									$("p.capital").fadeOut();
									$add_another.fadeIn();
									$back_to_search.fadeIn();
								}).removeClass('error').addClass('success').text("Product succesfully added");
					
								$loading.fadeOut();
								
							} else {
								//$prompt.fadeIn().removeClass('success').addClass('error').text("Product already exists in the database");
								$('body').animate({scrollTop: 0}, 'fast');
								prompt("Product already exists in the database.", "warning");
								$loading.fadeOut();
							}
						}, "json");
						
					}
					
					return false;
				});	
			}
		
			function add_another_click() {
				$add_another.click(function(){
					$(this).fadeOut(function(){
						$back_to_search.fadeOut();
						$("p.capital").fadeIn(function(){
							$capital.text(0);
						});
						$reset.trigger('click');
						$form.fadeIn(function(){
							$prompt.removeClass('success').addClass('error');
						});
					});
				});
			}
		
			return {
				check_white_spaces: check_white_spaces,
				check_numeric: check_numeric,
				check_space_in_breakdown_prerequisite: check_space_in_breakdown_prerequisite,
				check_number_and_space_in_breakdown_prerequisite_no: check_number_and_space_in_breakdown_prerequisite_no,
				breakdown_click: breakdown_click,
				hide_breakdown_click: hide_breakdown_click,
				check_errors_in_breakdown_data: check_errors_in_breakdown_data,
				breakdown_add: breakdown_add,
				get_quantity_type_and_breakdown_types: get_quantity_type_and_breakdown_types,
				check_selling_price: check_selling_price,
				selling_type_add: selling_type_add,
				close_data: close_data,
				close_selling_data: close_selling_data,
				solve_capital: solve_capital,
				solve_breakdown_price: solve_breakdown_price,
				reset_click: reset_click,
				add_main_content_form_submit: add_main_content_form_submit,
				add_another_click: add_another_click
			}
		
		})()
		
		<!--Execute Main Add Module-->
	
		mainAddModule.check_white_spaces();
		mainAddModule.check_numeric();
		mainAddModule.check_space_in_breakdown_prerequisite();
		mainAddModule.check_number_and_space_in_breakdown_prerequisite_no();
		mainAddModule.breakdown_click();
		mainAddModule.hide_breakdown_click();
		mainAddModule.check_errors_in_breakdown_data();
		mainAddModule.breakdown_add();
		mainAddModule.get_quantity_type_and_breakdown_types();
		mainAddModule.check_selling_price();
		mainAddModule.selling_type_add();
		mainAddModule.close_data();
		mainAddModule.close_selling_data();
		mainAddModule.solve_capital();
		mainAddModule.solve_breakdown_price();
		mainAddModule.reset_click();
		mainAddModule.add_main_content_form_submit();
		mainAddModule.add_another_click();
		
		<!--Main content exchange module-->
		
		var exchangeModule = (function() {
			
			var $main_search = $("#main_search");
			var $main_add = $("#main_add");
			var $main_update = $("#main_update");
			
			var $reset = $("#main_add table td input[type='reset']");
			var $hide_breakdowns = $("#main_add .hide_breakdowns");
			
			var $search_form = $("#search_form");
			
			var $back_to_search = $("#main_add .add_another_area #back_to_search")
			var $add_another = $("#main_add .add_another_main_content");
			
			var $back_to_search_in_update = $("#main_update .add_another_area #back_to_search");
			var $add_another_in_update = $("#main_update .add_another_main_content");
			
			var $form = $("#main_update #update_main_content_form");
			var $prompt =$("#main_update .prompt");
			
			
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
				
				$("#search_main_content_in_add").click(function(){
					$('.center_loading').fadeIn(function(){
						$(document).find($reset).trigger('click');
						$hide_breakdowns.find('.hide_link').trigger('click');
						$(document).find('.close_data').trigger('click');
						$(document).find('.close_selling_data').trigger('click');
					});
					
					$main_add.fadeOut(function(){
						$main_search.fadeIn(function(){
							$('.center_loading').fadeOut();
							$(document).find($search_form).trigger('submit');
						});
					});
					return false;
				});
				
				$("#search_main_content_in_update").click(function(){
					$('.center_loading').fadeIn();
					
					$main_update.fadeOut(function(){
						$main_search.fadeIn(function(){
							$('.center_loading').fadeOut();
							$(document).find($search_form).trigger('submit');
							$("#main_update table td input[type='reset']").trigger('click');
						});
					});
					
					return false;
				});
				
				$back_to_search.click(function(){
					$(document).find($add_another).trigger('click');
					$(document).find("#search_main_content_in_add").trigger('click');
					return false;
				});
				
				$back_to_search_in_update.click(function(){
					$('.center_loading').fadeIn();
					$prompt.fadeOut();
					$(this).fadeOut(function(){
						$form.fadeIn(function(){
							$("#main_update p.capital").fadeIn();
							$(document).find("#main_update table td input[type='reset']").trigger('click');
							$main_update.fadeOut();
						});
					});
					
					$main_search.fadeIn(function(){
						$('.center_loading').fadeOut(function(){
							$(document).find($search_form).trigger('submit');
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
		
		<!--Main Content Update Module-->
		
		var mainUpdateModule = (function() {
			
			// variables from exchange module
			var $main_search = $("#main_search");
			var $main_update = $("#main_update");
			
			// variables from mainAddModule change to update
			var $loading = $("#main_update table td .side_loading");
			
			var $prompt =$("#main_update .prompt");
			
			var $submit = $("#main_update table td input[type='submit']");
			var $reset = $("#main_update table td input[type='reset']");
			var $required = $("#main_update table td .required");
			var $no_space = $("#main_update table td .no_space");
			var $numeric = $("#main_update table td .numeric");
			var $next_error = $("#main_update table td.next_error");
			
			var $breakdown_button = $("#main_update table td button.breakdown_button");
			var $breakdowns_space = $("#main_update .breakdowns");
			var $breakdowns_value = $("#main_update .breakdowns_value"); 
			var $breakdowns_value_container = $("#main_update .breakdowns_value td.breakdown_type_area");
			var $breakdowns_value_description = $("#main_update .breakdowns_value .breakdown_type_area span.description");
			var $breakdowns_add = $("#main_update table td button.breakdowns_add")
			var $hide_breakdowns = $("#main_update .hide_breakdowns");
			var $selling_types = $("#main_update .selling_types");
			
			var $breakdown_prerequisite = $("#main_update table td .breakdown_prerequisite");
			var $breakdown_prerequisite_no = $("#main_update table td .breakdown_prerequisite_no");
			var $breakdown_prerequisite_no_space_status;
			
			var $breakdown_data_type = $("#main_update table td .breakdown_data_type");
			var $breakdown_data_no = $("#main_update table td .breakdown_data_no");
			var $breakdown_space_status;
			var $breakdown_no_status;
			var $breakdown_space_no_status;
			
			var $capital = $("#main_update button.main_capital");
			var $product_capital = $("#main_update #product_capital");
			
			var $quantity_type = $("#main_update table td #quantity_type");
			var $quantity_no = $("#main_update table td #quantity_no");
			var $quantity_price = $("#main_update table td #quantity_price");
			
			var $breakdown_type = $("#main_update table td #breakdown_quantity_type");
			var $breakdown_no = $("#main_update table td #breakdown_quantity_no");
			var $breakdown_price = $("#main_update table td #breakdown_quantity_price");
			
			var $select_option = $("#main_update table td .select_option");
			
			var $selling_types_add = $("#main_update table td button.selling_types_add");
			var $selling_type = $("#main_update table .selling_types td #selling_type");
			var $selling_price = $("#main_update table .selling_types td #selling_price");
			var $selling_type_error;
			var $selling_types_value_container = $("#main_update .selling_types_value td.selling_type_area");
			var $selling_types_value_description = $("#main_update .selling_types_value td.selling_type_area span.description");
			var $selling_profit;
			var $converted_selling_profit;
			var $selling_profit_button = $("#main_update .selling_types td button.selling_profit_button")
			
			var $update_main_content_form = $("#main_update #update_main_content_form");
			
			var $is_selling_type_undefined;
			var $is_breakdown_type_undefined; 
			
			var $back_to_search = $("#main_update .add_another_area #back_to_search");
			var $add_another = $("#main_update .add_another_main_content");
			var $form = $("#main_update #update_main_content_form");
			
			var $space_status;
			var $no_status;
			
			function update_main_content_link_click() {
				$(document).on('click', '#main #delete_form a.main_update_link', function(){
					
					$('.center_loading').fadeIn();
					
					$main_search.fadeOut(function(){
						$main_update.fadeIn(function(){
							$('.center_loading').fadeOut();
						});
					});
					
					get_quantity_type_and_breakdown_types();
					
					var link = $(this);
					$.get(link.attr('href'), link.serialize(), function(data){
						
						$("#main_update .main_capital").text(data.capital);
						$("#main_update #update_main_content_form #product_id").val(data.product_id);
						$("#main_update #update_main_content_form #product_capital").val(data.capital);
						$("#main_update #update_main_content_form table #product_name").val(data.product_name);
						$("#main_update #update_main_content_form table #quantity_type").val(data.quantity_type);
						$("#main_update #update_main_content_form table #quantity_no").val(data.quantity_no);
						$("#main_update #update_main_content_form table #quantity_price").val(data.quantity_price);
						
						var exist_breakdown_data_status;
						
						if(data.breakdown_quantity_types.length != 0) {
							$breakdown_button.trigger('click');
							
							if($breakdowns_value_container.children('.breakdown_data').html() == undefined){
								exist_breakdown_data_status = true;
							} else {
								exist_breakdown_data_status = false;
							}
							
							if(exist_breakdown_data_status == true) {
								$breakdowns_value_description.fadeOut(function(){
									for(var $i = 0; $i < data.breakdown_quantity_types.length; $i++) { 
										//console.log(data.breakdown_quantity_types[$i].breakdown_quantity_type + " " + data.breakdown_quantity_types[$i].breakdown_quantity_no + " " + data.breakdown_quantity_types[$i].breakdown_quantity_price);
										$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + data.breakdown_quantity_types[$i].breakdown_quantity_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + data.breakdown_quantity_types[$i].breakdown_quantity_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + data.breakdown_quantity_types[$i].breakdown_quantity_price + "' />" + "<span class='label_data'>Type:</span> " + data.breakdown_quantity_types[$i].breakdown_quantity_type + "<br />" + "<span class='label_data'>No:</span> "  + data.breakdown_quantity_types[$i].breakdown_quantity_no + "<br />" + "<span class='label_data'>Price:</span> " + data.breakdown_quantity_types[$i].breakdown_quantity_price + "<span class='close_data'>&#215;</span></span>");
									}
								});
								
								get_quantity_type_and_breakdown_types();
							}
						
						}
						
						if(data.selling_types.length != 0) {
							
							$selling_types_value_description.fadeOut(function(){
								for(var $i = 0; $i < data.selling_types.length; $i++) {
									//console.log(data.selling_types[$i].selling_type + " " + data.selling_types[$i].selling_price + " " + data.selling_types[$i].selling_profit);
									$selling_types_value_container.append("<span class='selling_type_data'>" + "<input type='hidden' name='selling_type[]' class='selling_type' value='"  + data.selling_types[$i].selling_type + "' />" + "<input type='hidden' name='selling_price[]' class='selling_price' value='"  + data.selling_types[$i].selling_price + "' />" + "<input type='hidden' name='selling_profit[]' class='selling_profit' value='"  + data.selling_types[$i].selling_profit + "' />" + "<span class='label_data'>Type:</span> " + data.selling_types[$i].selling_type + "<br />" + "<span class='label_data'>Price:</span> " + data.selling_types[$i].selling_price + "<br />" + "<span class='label_data'>Profit:</span> " + data.selling_types[$i].selling_profit + "<span class='close_selling_data'>&#215;</span></span>");
								}
								
								get_quantity_type_and_breakdown_types();
								
							});
						}
			
					}, "json");
					
					return false;
				});
			}
			
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
						
						if($('#main_update table td .space').length == 0) {
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
					$(this).parent().siblings('td').children('#selling_price').val("").css('color', '#333');
					$selling_profit_button.text(0);
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
			
			function is_required_empty() {
				var required_empty = $required.map(function(){
					return $(this).val() == "";
				});
				
				return $.inArray(true, required_empty) != -1;
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
			
			function check_space_in_breakdown_prerequisite() {
				$breakdown_prerequisite.keyup(function(){
					if(checkBeginningWhiteSpace($(this).val()) == true) {
						$hide_breakdowns.find('.hide_link').trigger('click');
						$space_status = true;
					} else {
						$space_status = false;
					}

					$hide_breakdowns.find('.hide_link').trigger('click');
					$(document).find('.close_selling_data').trigger('click');
					$selling_price.val("");
					$selling_profit_button.text(0);
				});	
			}
			
			function check_number_and_space_in_breakdown_prerequisite_no() {
				$breakdown_prerequisite_no.keyup(function(){
					if($.isNumeric($(this).val()) == false) {
						$hide_breakdowns.find('.hide_link').trigger('click');
						$no_status = false;
					} else if(checkBeginningWhiteSpace($(this).val())) {
						$breakdown_prerequisite_no_space_status = true;
					} else {
						$no_status = true;
						$breakdown_prerequisite_no_space_status = false;
					}
					
					$hide_breakdowns.find('.hide_link').trigger('click');
					$(document).find('.close_selling_data').trigger('click');
					$selling_price.val("");
					$selling_profit_button.text(0);
					
				});
			}
			
			function breakdown_click() {
				$breakdown_button.click(function(){
					if(is_required_breakdown_prerequisite_empty() || is_required_breakdown_prerequisite_no_empty() || $space_status  == true || $no_status == false || $breakdown_prerequisite_no_space_status == true) {
						$prompt.fadeIn().text('Product name, Quantity type, No. and Price must have a valid value');
						$loading.fadeOut();
					} else {
					
						$("#main_update table tr:nth-child(2)").children('td').css({
							'border': 'none',
							'border-top': '1px solid #D5D6D6'
						});
					
						$("#main_update table tr:nth-child(2)").children('td:first-child').css({
							//'border-left': '1px solid #6F8696'
						});
						
						$("#main_update table tr:nth-child(3)").children('td').css({
							'border': 'none'
						});
					
						
						$("#main_update table tr:nth-child(4)").children('td').css({
							'border': 'none'
						});
						
						
						$("#main_update table tr:nth-child(5)").children('td').css({
							'border': 'none'
						});
					
						// set the background to #FFF for the tr scope
						$("#main_update table tr:nth-child(2), #main_update table tr:nth-child(3), #main_update table tr:nth-child(4), #main_update table tr:nth-child(5)").css({
							'background-color': '#FFF'
						});  
				
						$breakdowns_space.fadeIn();
						$breakdowns_value.fadeIn();
						$hide_breakdowns.fadeIn();
						
					}
					return false;
				});

			}
		
			function hide_breakdown_click() {
				$hide_breakdowns.children('td').children('.hide_link').click(function(){
					$breakdowns_value.fadeOut();
					$hide_breakdowns.fadeOut();
					$breakdowns_space.slideUp('slow', function(){
						$("#main_update table td").css('border', '1px solid #D5D6D6');
						// set the background to #FFF for the tr scope
						$("#main_update table tr:nth-child(2), #main_update table tr:nth-child(3), #main_update table tr:nth-child(4), #main_update table tr:nth-child(5)").css({
							'background-color': '#FAFAFA'
						}); 
						
						$(this).children('td').children('input').val("");
					});
					
					$breakdown_price.text(0);
					$(document).find('.close_data').trigger('click');
					return false;
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
					} else if(checkBeginningWhiteSpace($(this).val())) {
						$breakdown_space_no_status = true;
					} else {
						$breakdown_no_status = true;
						$breakdown_space_no_status = false;
					}
				});
		
			}
			
			function breakdown_add() {
				var pre_generated_breakdown_type = $("#main_update .breakdowns_value td .breakdown_data .breakdown_type");
				
				if(pre_generated_breakdown_type.val() == undefined) {
					$is_breakdown_type_undefined = true;
					
					if($is_breakdown_type_undefined == true) {
						$breakdowns_value_description.fadeIn();
					}
				}
				
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
					} else if($breakdown_space_no_status) {
						$prompt.fadeIn().text("Enter valid No. for quantity type to calculate price");
					} else if($breakdown_price.text() == 0) {
						$prompt.fadeIn().text("Not valid. The price is zero");
					} else if($breakdown_type.val() == $quantity_type.val()) {
						$prompt.fadeIn().text("Breakdown type must not be the same to Quantity type");
					} else {
						
						var break_down_type = $.trim($breakdown_type.val());
						var break_down_no = $.trim($breakdown_no.val());
						var break_down_price = $.trim($breakdown_price.text());
						
						var generated_breakdown_type = $("#main_update .breakdowns_value td .breakdown_data .breakdown_type");
						//var breakdown_data = $("#main_add .breakdowns_value td .breakdown_data");
						
						if(generated_breakdown_type.val() == undefined) {
							$is_breakdown_type_undefined = false;
							$breakdowns_value_description.fadeOut(function(){
								$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + break_down_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + break_down_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + break_down_price + "' />" + "<span class='label_data'>Type:</span> " + $breakdown_type.val() + "<br />" + "<span class='label_data'>No:</span> "  + $breakdown_no.val() + "<br />" + "<span class='label_data'>Price:</span> " + $breakdown_price.text() + "<span class='close_data'>&#215;</span></span>");
								get_quantity_type_and_breakdown_types();
							});
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
								$is_breakdown_type_undefined = false;
								$breakdowns_value_description.fadeOut(function(){
									$breakdowns_value_container.append("<span class='breakdown_data'>" + "<input type='hidden' name='breakdown_type[]' class='breakdown_type' value='"  + break_down_type + "' />" + "<input type='hidden' name='breakdown_no[]' class='breakdown_no' value='"  + break_down_no + "' />" + "<input type='hidden' name='breakdown_price[]' class='breakdown_price' value='"  + break_down_price + "' />" + "<span class='label_data'>Type:</span> " + $breakdown_type.val() + "<br />" + "<span class='label_data'>No:</span> "  + $breakdown_no.val() + "<br />" + "<span class='label_data'>Price:</span> " + $breakdown_price.text() + "<span class='close_data'>&#215;</span></span>");
									get_quantity_type_and_breakdown_types();
								});
							}
						}
						
					}
					
					return false;
				});
			}

			function get_quantity_type_and_breakdown_types() {
				
				var all_breakdown_data = $('#main_update .breakdowns_value td.breakdown_type_area .breakdown_data .breakdown_type');
				
				$quantity_type.keyup(function(){
					$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
						return "<option>" + $(this).val() +"</option>";
					}).get() );
				});
				
				$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
					return "<option>" + $(this).val() +"</option>";
				}).get());
		
			}
			
			function check_selling_price() {
				$selling_price.keyup(function(){
					var selling_type = $(this).parent().parent().children("td").children("#selling_type").val();
					var generated_breakdown_type = $("#main_update .breakdowns_value td .breakdown_data .breakdown_type");
					
					var breakdown_data = $("#main_update .breakdowns_value td .breakdown_data");
					var selected_data;
					
					var standard_price;
					var value_input;
					
					function exist_quantity_type(type) {
						if(type == $quantity_type.val()) {
							return true;
						} else {
							return false;
						}
					}
				
					function exist_breakdown_type(type) {
						var exist = generated_breakdown_type.map(function(){
							return $(this).val() == type;
						});
						
						return $.inArray(true, exist) != -1;
					}
				
				
					if(exist_quantity_type(selling_type)) {
						
						standard_price = parseFloat($quantity_price.val());
						value_input = parseFloat($(this).val());
						
						if($(this).val() != "" && $.isNumeric($(this).val())) {
						
							if(value_input == standard_price) {
								$prompt.fadeIn().text('No profit');
								$(this).css('color', 'red');
								$selling_type_error = true;
								$selling_profit_button.text(0);
							} else if(value_input < standard_price) {
								$prompt.fadeIn().text('No profit');
								$(this).css('color', 'red');
								$selling_type_error = true;
								$selling_profit_button.text(0);
							} else if(value_input > standard_price) {
								$(this).css('color', '#333');
								$selling_type_error = false;
								$selling_profit = value_input - standard_price;
								$converted_selling_profit = $selling_profit.toFixed(2);
								$selling_profit_button.text($converted_selling_profit);
							}
							
						} 
					} else {
						
						if($(this).val() != "" && $.isNumeric($(this).val())) {
							
							breakdown_data.each(function(){
								if($(this).children(".breakdown_type").val() == selling_type) {
									$(this).siblings('.selected_data').removeClass('selected_data');
									$(this).addClass('selected_data');
									selected_data = $(document).find("span.selected_data");
								}
							});
							
							standard_price = parseFloat(selected_data.children('.breakdown_price').val());
							value_input = parseFloat($(this).val());
							
							if(value_input == standard_price) {
								$prompt.fadeIn().text('No profit');
								$(this).css('color', 'red');
								$selling_type_error = true;
								$selling_profit_button.text(0);
							} else if(value_input < standard_price) {
								$prompt.fadeIn().text('No profit');
								$(this).css('color', 'red');
								$selling_type_error = true;
								$selling_profit_button.text(0);
							} else if(value_input > standard_price) {
								$(this).css('color', '#333');
								$selling_type_error = false;
								$selling_profit = value_input - standard_price;
								$converted_selling_profit = $selling_profit.toFixed(2);
								$selling_profit_button.text($converted_selling_profit);
							}
							
						}
					
					}
					
				}); // end keyup
			}
			
			function selling_type_add() {
				
				var pre_generated_selling_type = $("#main_update .selling_types_value td .selling_type_data .selling_type");
				
				if(pre_generated_selling_type.val() == undefined) {
					$is_selling_type_undefined = true;
					
					if($is_selling_type_undefined == true) {
						$selling_types_value_description.fadeIn();
					}
					
				}
			
				$selling_types_add.click(function(){ 
					if($selling_price.val() == "" || $selling_type_error == true || $.isNumeric($selling_price.val()) == false) {
						$prompt.fadeIn().text("Please enter valid selling price.");
					} else {
						var selling_type = $.trim($selling_type.val());
						var selling_price = $.trim($selling_price.val());
						var selling_profit = $.trim($converted_selling_profit);
						
						var generated_selling_type = $("#main_update .selling_types_value td .selling_type_data .selling_type");
						
						if(generated_selling_type == undefined) {
							$is_selling_type_undefined = false;
							$selling_types_value_description.fadeOut(function(){
								$selling_types_value_container.append("<span class='selling_type_data'>" + "<input type='hidden' name='selling_type[]' class='selling_type' value='"  + selling_type + "' />" + "<input type='hidden' name='selling_price[]' class='selling_price' value='"  + selling_price + "' />" + "<input type='hidden' name='selling_profit[]' class='selling_profit' value='"  + selling_profit + "' />" + "<span class='label_data'>Type:</span> " + $selling_type.val() + "<br />" + "<span class='label_data'>Price:</span> " + $selling_price.val() + "<br />" + "<span class='label_data'>Profit:</span> " + $converted_selling_profit + "<span class='close_selling_data'>&#215;</span></span>");
							});
						} else {
						
							function exist_selling_type(type) {
								var exist = generated_selling_type.map(function(){
									return $(this).val() == type;
								});
								
								return $.inArray(true, exist) != -1;
							}
							
							if(exist_selling_type(selling_type)) {
								$prompt.fadeIn().text("Selling type already exists");
							} else {
								$is_selling_type_undefined = false;
								$selling_types_value_description.fadeOut(function(){
									$selling_types_value_container.append("<span class='selling_type_data'>" + "<input type='hidden' name='selling_type[]' class='selling_type' value='"  + selling_type + "' />" + "<input type='hidden' name='selling_price[]' class='selling_price' value='"  + selling_price + "' />" + "<input type='hidden' name='selling_profit[]' class='selling_profit' value='"  + selling_profit + "' />" + "<span class='label_data'>Type:</span> " + $selling_type.val() + "<br />" + "<span class='label_data'>Price:</span> " + $selling_price.val() + "<br />" + "<span class='label_data'>Profit:</span> " + $converted_selling_profit + "<span class='close_selling_data'>&#215;</span></span>");
								});
							}
						}
						
					}
					
					return false;
				});
			}
			
			function close_data() {
				$(document).on('click', '.close_data', function(){
					var breakdown_type = $(this).parent().children('.breakdown_type').val(); 
					var selling_type_data = $("#main_update .selling_types_value td .selling_type_data");
					var remove_selected_data;
					
					var post_generated_breakdown_type = $("#main_update .breakdowns_value td .breakdown_data .breakdown_type");
					var post_generated_selling_type = $("#main_update .selling_types_value td .selling_type_data .selling_type");
						
					//get_quantity_type_and_breakdown_types
					
					selling_type_data.each(function(){
						if($(this).children(".selling_type").val() == breakdown_type) {
							$(this).addClass('remove_selected_data');
							remove_selected_data = $(document).find("span.remove_selected_data");
						}
					});
				
					$(this).parent().remove();
					$(this).parent().children().remove();
					
					var all_breakdown_data = $('#main_update .breakdowns_value td.breakdown_type_area .breakdown_data .breakdown_type');
					$select_option.html("<option>" + $quantity_type.val() + "</option>" + all_breakdown_data.map(function(){
						return "<option>" + $(this).val() +"</option>";
					}).get());		
					
					if(remove_selected_data == undefined) {	
					
						$prompt.fadeOut();
						if($(document).find(post_generated_breakdown_type).val() == undefined) {
							$is_breakdown_type_undefined = true;
					
							if($is_breakdown_type_undefined == true) {
								$breakdowns_value_description.fadeIn();
							}
						}
					} else {
						remove_selected_data.fadeOut().remove();
						$prompt.fadeOut();
						if($(document).find(post_generated_breakdown_type).val() == undefined) {
							$is_breakdown_type_undefined = true;
					
							if($is_breakdown_type_undefined == true) {
								$breakdowns_value_description.fadeIn();
							}
						}
						
						if($(document).find(post_generated_selling_type).val() == undefined){
							$is_selling_type_undefined = true;
							if($is_selling_type_undefined == true) {
								$selling_types_value_description.fadeIn();
							}			
						}
					}
					
					
				});
			}
			
			function close_selling_data() {
				
				$(document).on('click', '#main_update .close_selling_data', function(){
				
					var post_generated_selling_type = $("#main_update .selling_types_value td .selling_type_data .selling_type");
				
					$(this).parent().remove();
					$(this).parent().children().remove();
					$prompt.fadeOut();
					
					if($(document).find(post_generated_selling_type).val() == undefined){
						$is_selling_type_undefined = true;
						if($is_selling_type_undefined == true) {
							$selling_types_value_description.fadeIn();
						}			
					}
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
						$product_capital.val(capital_total.toFixed(2));
					} else {
						$capital.text(0);
						$product_capital.val(0);
					}
				});
				
				$quantity_price.keyup(function(){
					if(check_valid_no($(this).val()) && check_valid_no($quantity_no.val()) ) {
						var capital_total = $(this).val() * $quantity_no.val();
						$capital.text(capital_total.toFixed(2));
						$product_capital.val(capital_total.toFixed(2));
					} else {
						$capital.text(0);
						$product_capital.val(0);
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
					$(document).find('.close_selling_data').trigger('click');
					$capital.text(0);
					$selling_profit_button.text(0);
					$select_option.html("<option value=''></option>");
				});
			}
			
			function update_main_content_form_submit() {
				$update_main_content_form.on('submit', function(){
					$loading.fadeIn();
					var generated_breakdown_type = $("#main_update .breakdowns_value td .breakdown_data .breakdown_type");
					var generated_selling_type = $("#main_update .selling_types_value td .selling_type_data .selling_type");
					var breakdown_type_is_empty;
					var selling_type_is_empty;
					var found_required_empty;
					
					if(generated_breakdown_type.val() == undefined) {
						breakdown_type_is_empty = true;
					} else {
						breakdown_type_is_empty = false;
					}
					
					if(generated_selling_type.val() == undefined) {
						selling_type_is_empty = true;
					} else {
						selling_type_is_empty = false;
					}
					
					if(is_required_empty()) {
						$prompt.fadeIn().text("Required fields must not be empty. Indicated by red border");
						$required.each(function(){
							if($(this).val() == "") {
								$(this).addClass("found_required_empty");
								found_required_empty = $(document).find('.found_required_empty');
							}							
						});
						
						found_required_empty.css('border', '1px solid red');
						$loading.fadeOut();
					} else if (!is_required_empty() && selling_type_is_empty) {
						$prompt.fadeIn().text("There must be selling types.");
						$loading.fadeOut();
					} else {					
						var form = $(this);
						$.post(form.attr('action'), form.serialize(), function(data){
							console.log(data.breakdown_quantity_type_inserted);
							console.log(data.selling_type_inserted);
							if(data.status) {
								$prompt.fadeIn(function(){
									$form.fadeOut();
									$("p.capital").fadeOut();
									$add_another.fadeIn();
									$back_to_search.fadeIn();
								}).removeClass('error').addClass('success').text("Product succesfully updated");
								$loading.fadeOut();
							} else {
								$prompt.fadeIn().removeClass('success').addClass('error').text("Product already exists in the database");
								$loading.fadeOut();
							}
						}, "json");
						
					}
					
					return false;
				});	
			}
		
			function add_another_click() {
				$add_another.click(function(){
					$(this).fadeOut(function(){
						$back_to_search.fadeOut();
						$("p.capital").fadeIn(function(){
							$capital.text(0);
						});
						$reset.trigger('click');
						$form.fadeIn(function(){
							$prompt.removeClass('success').addClass('error');
						});
					});
				});
			}
			
			return {
				update_main_content_link_click: update_main_content_link_click,
				check_white_spaces: check_white_spaces,
				check_numeric: check_numeric,
				check_space_in_breakdown_prerequisite: check_space_in_breakdown_prerequisite,
				check_number_and_space_in_breakdown_prerequisite_no: check_number_and_space_in_breakdown_prerequisite_no,
				breakdown_click: breakdown_click,
				hide_breakdown_click: hide_breakdown_click,
				check_errors_in_breakdown_data: check_errors_in_breakdown_data,
				breakdown_add: breakdown_add,
				get_quantity_type_and_breakdown_types: get_quantity_type_and_breakdown_types,
				check_selling_price: check_selling_price,
				selling_type_add: selling_type_add,
				close_data: close_data,
				close_selling_data: close_selling_data,
				solve_capital: solve_capital,
				solve_breakdown_price: solve_breakdown_price,
				reset_click: reset_click,
				update_main_content_form_submit: update_main_content_form_submit,
				add_another_click: add_another_click
			}
			
		})()
		
		<!--Execute Main Content Update Module-->
		
		mainUpdateModule.update_main_content_link_click();
		mainUpdateModule.check_white_spaces();
		mainUpdateModule.check_numeric();
		mainUpdateModule.check_space_in_breakdown_prerequisite();
		mainUpdateModule.check_number_and_space_in_breakdown_prerequisite_no();
		mainUpdateModule.breakdown_click();
		mainUpdateModule.hide_breakdown_click();
		mainUpdateModule.check_errors_in_breakdown_data();
		mainUpdateModule.breakdown_add();
		//mainUpdateModule.get_quantity_type_and_breakdown_types();
		mainUpdateModule.check_selling_price();
		mainUpdateModule.selling_type_add();
		mainUpdateModule.close_data();
		mainUpdateModule.close_selling_data();
		mainUpdateModule.solve_capital();
		mainUpdateModule.solve_breakdown_price();
		mainUpdateModule.reset_click(); 
		mainUpdateModule.update_main_content_form_submit();
		mainUpdateModule.add_another_click();
		
		<!--Main Content Cart Module-->
		
		var mainCartModule = (function() {
		
			var $total_amount = $("#main #container_cart #total_amount");
			var $num_cart = $("#main #container_cart #wrap_cart #num_cart");
			var $cart_link_automatic = $("#main #container_cart #cart_link_automatic");
			
			//below are the variables for the popup of the view cart
			var $view_cart_link = $("#main #container_cart #wrap_cart p #total_cart");
			var $view_cart = $("#view_cart");
			var $view_cart_content = $("#view_cart #view_cart_content");
			var $pop_close = $("#view_cart #view_cart_content .close");
			var $list_products_container = $("#view_cart #view_cart_content form table");
			
			var $check_out_form = $("#view_cart #view_cart_content #check_out_form");
			
			function check_out_form_submit() {
				$check_out_form.on('submit', function(){
					var total_cart_price = $(this).find('#total_cart_price').text();
					var customer_amount = $(this).find('#customer_amount').val();
					var checkout_button = $(this).find("input[type=submit]");
					var checkout_loading = $(this).find("#checkout_loading");
					
					if(customer_amount !== "") {
						if(!$.isNumeric(customer_amount)) {
							prompt("Enter valid number.", "warning");
							return false;
						} else {
							var c_customer_amount = parseFloat(customer_amount, 10);
							var c_total_cart_price = parseFloat(total_cart_price, 10);
							
							if(c_customer_amount < c_total_cart_price) {
								prompt("Not sufficient amount.", "warning");
								return false;
							} else {
								
								checkout_loading.fadeIn(function(){
									checkout_button.attr("disabled", "disabled").val("processing");
								});
								
								var form = $(this);
								$.post(form.attr('action'), form.serialize(), function(data){
									if(data.status) {
										checkout_loading.fadeOut(function(){
											checkout_button.removeAttr("disabled").val("Checkout");
											$pop_close.trigger('click');
										}); 
										
										prompt("Customer's change is " + data.change, "success");
						
									}
								}, "json");
								return false;
							} // end else where ajax is processed
						
						}
					} else {
						prompt("Please enter amount.", "warning");
						return false;
					}
					
				});
			}
			
			var delete_cart_item = function() {
				$(document).on('click', '#view_cart #view_cart_content form table td .delete_cart_item', function(){
					var link = $(this);
					$.get(link.attr('href'), link.serialize(), function(data){
						if(data.status) {
							$(document).find($view_cart_link).trigger('click');
						}
					}, "json");
					
					return false;
				});
			};
			
			$cart_link_automatic.on('click', function(event, action, remaining_stock, current_stock, breakdown_remaining_stock, breakdown_current_stock){
		
				var progress_bar = $(this).parent().siblings("#main_search").children("#delete_form").find(".progress_bar"); 
				var progress_status = $(this).parent().siblings("#main_search").children("#delete_form").find(".progress_bar").children(".progress_status");
				var progress_label = $(this).parent().siblings("#main_search").children("#delete_form").find(".progress_bar").children(".progress_label");
				var progress_loading = $(this).parent().siblings("#main_search").children("#delete_form").find(".progress_bar").children("img");
				
				//console.log(breakdown_current_stock);
				//console.log(breakdown_remaining_stock);
				
				if(remaining_stock !== undefined && current_stock !== undefined) {
					
					var percent_stock = function(total_stock, remain_stock){
						var total_stock = total_stock;
						var remain_stock = remain_stock;
						
						var percent_remaining_stock = Math.round((remain_stock / total_stock) * 100);
						
						return percent_remaining_stock;
					};
					
					var percent_stock_with_breakdown_remaining_stock = function(total_stock, remain_stock, breakdown_total_stock, breakdown_remain_stock) {
						var total_stock = total_stock;
						var remain_stock = remain_stock;
						
						var breakdown_total_stock = breakdown_total_stock;
						var breakdown_remain_stock = breakdown_remain_stock;
						
						var total_convert_breakdown_stock = total_stock * breakdown_total_stock;
						
						var total_convert_remain_stock = (remain_stock * breakdown_total_stock) + breakdown_remain_stock;
						
						var percent_remaining_stock = Math.round((total_convert_remain_stock / total_convert_breakdown_stock) * 100);
						
						return percent_remaining_stock;
					
					};
					
					for(var i = 0; i < remaining_stock.length; i++) {
					
						if(breakdown_remaining_stock !== undefined && breakdown_remaining_stock === 0) {
							$(progress_label[i]).text(percent_stock(current_stock[i], remaining_stock[i]) + "%");
							$(progress_status[i]).css("width", percent_stock(current_stock[i], remaining_stock[i]) + "%");
						
							if(percent_stock(current_stock[i], remaining_stock[i]) < 30) {
								$(progress_status[i]).css("background-color", "#FFBABA");
								$(progress_label[i]).css("color", "#DA000C");
							} else {
								$(progress_status[i]).css("background-color", "#62BA50");
								$(progress_label[i]).css("color", "#6E8A10");
							}
						} else {
							
							$(progress_label[i]).text(percent_stock(current_stock[i], remaining_stock[i], breakdown_current_stock[i], breakdown_remaining_stock[i]) + "%");
							$(progress_status[i]).css("width", percent_stock(current_stock[i], remaining_stock[i], breakdown_current_stock[i], breakdown_remaining_stock[i]) + "%");
						
							if(percent_stock(current_stock[i], remaining_stock[i], breakdown_current_stock[i], breakdown_remaining_stock[i]) < 30) {
								$(progress_status[i]).css("background-color", "#FFBABA");
								$(progress_label[i]).css("color", "#DA000C");
							} else {
								$(progress_status[i]).css("background-color", "#62BA50");
								$(progress_label[i]).css("color", "#6E8A10");
							}
							
						}
						
					}
				}
				
				progress_status.css({
					"opacity": 0.6
				});
				
				progress_loading.fadeOut();
				
				var link = $(this);
				if(action === "preview") {
					$.get(link.attr('href'), link.serialize(), function(data){
						$total_amount.text(data.cart_total);
						$num_cart.text(data.total_items);
					}, "json");
				} else if(action === "view_cart") {
					$.get(link.attr('href'), link.serialize(), function(data){
						$list_products_container.html(data.display_cart_item);
						$total_amount.text(data.cart_total);
						$num_cart.text(data.total_items);
					}, "json");
				}
				return false;
			});
		
			function view_cart() {
				var times_open = 0;
				
				$view_cart_link.click(function(){
					$('body').animate({scrollTop: 0}, 'slow');
					$('.center_loading').fadeIn();
					$(document).find($cart_link_automatic).trigger('click', ["view_cart"]);
					$view_cart.fadeIn(function(){
						
						times_open++;
						$(window).scrollTop('slow');
						var windowWidth = document.documentElement.clientWidth;
						var windowHeight = document.documentElement.clientHeight;
						var cart_content_width = $view_cart_content.width();
						var top_margin;
						
						if(times_open === 1) {
							top_margin = (windowHeight/2-$view_cart_content.height()/2);// - 40;
						} else {
							top_margin = windowHeight/2-$view_cart_content.height()/2;
						}
						
						$view_cart_content.css({
							"top": top_margin,
							"left": windowWidth/2-cart_content_width/2
						});
						
						$('.center_loading').fadeOut();
						
						
					}).css('height', $(document).height());
					
					return false;
				});
			}
			
			function pop_close_click() {
				$pop_close.click(function(){
					$view_cart.fadeOut();
					$(document).find("#search_form").trigger("submit");
				});
			}
			
			function mouse_entering() {
				$(document).mouseenter(function(){
					$(this).find($cart_link_automatic).trigger('click', ["preview"]);
				}); 
				
				$(document).ready(function(){
					$(this).find($cart_link_automatic).trigger('click', ["preview"]);
				});
			}
			
			function set_link_value() {
				$(document).on('click', '#main #delete_form a.cart_link', function(){
					
					var selling_type = $(this).parent().parent().prev().prev().children('.selling_type').val();
					var selling_quantity = $(this).parent().parent().prev().children('.selling_quantity').val();
					var cart_loading = $(this).parent().parent().children('.cart_loading');
					
					var message;
					
					$(this).attr('href', $(this).attr('href') + '&&selling_type=' + selling_type + '&&selling_quantity=' + selling_quantity);
					
					if(selling_type === "" &&  selling_quantity === "") {
						message = "Selling type and Selling quantity must have a value.";
						$('body').animate({scrollTop: 0}, 'slow');
						prompt(message, "warning");
						return false;
					} else if(selling_type !== "" && selling_quantity === "" ) {
						message = "Selling quantity must have a value.";
						$('body').animate({scrollTop: 0}, 'slow');
						prompt(message, "warning");
						return false;
					} else if(selling_type === "" && selling_quantity !== "") {
						message = "Selling type must have a value.";
						if(!$.isNumeric(selling_quantity)) {
							message += "<br /> Selling quantity must be a number.";
						}
						$('body').animate({scrollTop: 0}, 'slow');
						prompt(message, "warning");
						return false; 
					} else if(selling_type !== "" && selling_quantity !== "") {
						
						if(!$.isNumeric(selling_quantity)) {
							message = "<br /> Selling quantity must be a number.";
							$('body').animate({scrollTop: 0}, 'slow');
							prompt(message, "warning");
							return false;
						} else {
							// the process for submmiting the cart item is below
							var link = $(this);
							$.get(link.attr('href'), link.serialize(), function(data){
								cart_loading.fadeIn();
								$total_amount.text(data.cart_total);
								$num_cart.text(data.total_items);
								cart_loading.fadeOut(function(){
									$('body').animate({scrollTop: 0}, 'slow');
									prompt("Addedto cart.", "success");
								});
							}, "json");
							
							$(this).parent().parent().prev().prev().children('.selling_type').val("");
							$(this).parent().parent().prev().children('.selling_quantity').val("");
							
							return false;
						}
					}
				});
			}
			
			function selling_focus_and_keyup() {
				
				// below is for selling type
				$(document).on('focus', '#main #delete_form .selling_type', function(){
					$(this).css('border', '1px solid #51A7E8');
				});
				
				$(document).on('blur', '#main #delete_form .selling_type', function(){
					$(this).css('border', '1px solid #ABADB3');
				});
				
				// below is for selling quantity
				$(document).on('focus', '#main #delete_form .selling_quantity', function(){
					if($(this).val() !== "" && !$.isNumeric($(this).val())) {
						$(this).css('border', '1px solid red');
					} else {
						$(this).css('border', '1px solid #51A7E8');
					}
				});
				
				$(document).on('keyup', '#main #delete_form .selling_quantity', function(){
					if($(this).val() !== "" && !$.isNumeric($(this).val())) {
						$(this).css('border', '1px solid red');
					} else {
						$(this).css('border', '1px solid #51A7E8');
					}
				});
				
				$(document).on('blur', '#main #delete_form .selling_quantity', function(){
					$(this).css('border', '1px solid #ABADB3');
				});
				
			}
			
			function custom_amount_focus_and_keyup() {
				$(document).on('focus', '#view_cart #view_cart_content form table td #customer_amount', function(){
					if($(this).val() !== "" && !$.isNumeric($(this).val())) {
						$(this).css('border', '1px solid red');
					} else {
						$(this).css('border', '1px solid #51A7E8');
					}
				});
				
				$(document).on('keyup', '#view_cart #view_cart_content form table td #customer_amount', function(){
					if($(this).val() !== "" && !$.isNumeric($(this).val())) {
						$(this).css('border', '1px solid red');
					} else {
						$(this).css('border', '1px solid #51A7E8');
					}
				});
				
				$(document).on('blur', '#view_cart #view_cart_content form table td #customer_amount', function(){
					$(this).css('border', '1px solid #ABADB3');
				});
				
			}
			
			return {
				set_link_value: set_link_value,
				selling_focus_and_keyup: selling_focus_and_keyup,
				mouse_entering: mouse_entering,
				view_cart: view_cart,
				pop_close_click: pop_close_click,
				delete_cart_item: delete_cart_item,
				custom_amount_focus_and_keyup: custom_amount_focus_and_keyup,
				check_out_form_submit: check_out_form_submit
			}

		})()
		
		<!--Execute Main Content Cart Module-->
		
		mainCartModule.set_link_value();
		mainCartModule.selling_focus_and_keyup();
		mainCartModule.mouse_entering();
		mainCartModule.view_cart();
		mainCartModule.pop_close_click();
		mainCartModule.delete_cart_item();
		mainCartModule.custom_amount_focus_and_keyup();
		mainCartModule.check_out_form_submit();
		
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
		
		<!--Search Module-->
		
		var searchModule = (function() {
		
			var $search_form = $("#search_form");
			var $search_input_execute = $("#search_form #data_search");
			var $delete_table = $("#delete_form table");
			
			var $cart_link_automatic = $("#main #container_cart #cart_link_automatic");
			
			function search_input_execute_focus() {
				
				var type_searching = function() {
					$(document).find($search_form).trigger('submit');
				};
				
				$search_input_execute.on("focus", function(){
					$(document).find($search_form).trigger('submit');
				}).on("keyup", function(){
					delay(function(){
						$(document).find($search_form).trigger('submit');
					}, 1000 );
				});
			
			}
			
			function search_form_submit() {
			
				var searching = function() {
					var form = $(this);
					$('.search_loading').fadeIn();
					
					$.post(form.attr('action'), form.serialize(), function(data){
					
						$delete_table.html(function(){
							return data.content;
						});
						
						$('.search_loading').fadeOut(function(){
							
							if(data.stock_status !== undefined) {
								
								var remaining_stock = new Array();
								var current_stock = new Array();
								var breakdown_remaining_stock = new Array();
								var breakdown_current_stock = new Array();
								
								for(var i = 0; i < data.stock_status.length; i++) {
									remaining_stock[i] = data.stock_status[i].remaining_stock;
									current_stock[i] = data.stock_status[i].current_stock;
									
									breakdown_remaining_stock[i] = data.stock_status[i].breakdown_remaining_stock;
									breakdown_current_stock[i] = data.stock_status[i].breakdown_current_stock;
								}
							
								$(document).find($cart_link_automatic).trigger('click', ["preview", remaining_stock, current_stock, breakdown_remaining_stock, breakdown_current_stock]);
							}
						});
						
					}, "json");
					
					return false;
				};
				
				$search_form.on("submit", searching);
				
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
		
		<!--Delete Module-->
		
		var deleteModule = (function() {
		
			var $delete_form = $("#delete_form");
			var $delete_table = $("#delete_form table");
			
			var $check_status;
			
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
						
						if($('input.head_check').is(':checked')) {
							$('input.sub_check').check();
						} else {
							$('input.sub_check').uncheck();
						}
					
					});
					
					$(this).find("#delete_form .sub_check").click(function(){
						if($('input.sub_check:checked').length === $('input.sub_check').length) {
							$('input.head_check').check();
						} else {
							$('input.head_check').uncheck();
						}
					});
					
				}).change();
			}
			
			function delete_form_submit() {
				$delete_form.on('submit', function(){
					var item_delete_length = $('input.sub_check:checked').length;
					
					var message; 
				
					var proceed_delete = function(message, type) {
						var n = noty({
							layout: 'center',
							theme: 'defaultTheme',
							type: type,
							text: message,
							modal: true,
							buttons: [
								{ text: 'Ok', onClick: function($noty) 
									{
										$noty.close();
										var form = $($delete_form);
										$.post(form.attr('action'), form.serialize(), function(data){
											
											if(data.status) {
												<!--Trigger search and alert-->
												$(document).find("#search_form").trigger('submit');
												prompt("Deleted successfully", "success");
											} 
										}, "json");
									}
								},
								{ text: 'Cancel', onClick: function($noty) 
									{
										$noty.close();
									}
								}
							],
							animation: {
								open: {height: 'toggle'},
								close: {height: 'toggle'},
								easing: 'swing',
								speed: 10 // opening & closing animation speed
							}
						});
					};
					
				
					if(item_delete_length > 0) {
						
						message = "Are you sure you want do delete the selected items?";
						proceed_delete(message, "alert");
						$check_status = false;
						
					} else {
						message = "Please select item to delete.";
						prompt(message, "warning");
					}
					
					return false;
				});
			}
			
			return {
				execute_checkbox: execute_checkbox,
				delete_form_submit: delete_form_submit
			}
		
		})()
		
		<!--Execute Delete Module-->
	
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
						console.log(data);
						
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
		
			var $login_form = $("#login_form");
			var $required = $("#login_form .required");
			var $login_prompt = $("#login_form .login_prompt");
			var $loading = $("#login_form .side_loading");
			
			var $valid_test = $("#login_form input[name='valid']");
			var $valid_logging_in_form = $("#valid_logging_in_form");
		
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
					
					if(isEmpty()) {
						$login_prompt.fadeIn(function(){$loading.fadeOut();}).addClass('error').text('Fill in all of the fields.');
					} else {
						$.post(form.attr('action'), form.serialize(), function(data){
							if(!isEmpty() && data.status == false) {
								$login_prompt.fadeIn(function(){$loading.fadeOut();}).addClass('error').text('Invalid username or password.');
							} else {
								$loading.fadeOut();
								location.reload();
							}
						}, "json");
					}
				
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
				
					var active_status = $(this).hasClass('active');
					$(this).next().fadeIn().css('right', '100px');
					if(active_status) {
						$(this).attr('class', 'active maintenance_extract');
					} else {
						$(this).attr('class', 'maintenance_extract');
					}
					$(document).find('.account_extract').trigger('click');
					return false;
				});
			}
			
			function maintenance_extract_click() {
				$(document).on('click', '.maintenance_extract', function(){
				
					var active_status = $(this).hasClass('active');
					$(this).next().fadeOut();
					if(active_status) {
						$(this).attr('class', 'active maintenance_intact');
					} else {
						$(this).attr('class', 'maintenance_intact');
					}
					
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
					
						var maintenance_active_status = $(document).find('.maintenance_extract').hasClass('active');
				
						$(document).find('.account_extract').attr('class', 'account_intact');
						
						if(maintenance_active_status) {
							$(document).find('.maintenance_extract').attr('class', 'active maintenance_intact');
						} else {
							$(document).find('.maintenance_extract').attr('class', 'maintenance_intact');
						}
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
















