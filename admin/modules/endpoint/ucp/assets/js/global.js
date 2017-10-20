var EndpointC = UCPMC.extend({
	init: function() {

	},
	poll: function(data) {

	},
	displayWidgetSettings: function(widget_id, dashboard_id) {
		//Below is to handle sortable on our ajax calls.
		var EndpointSortable = function() {
		  var hidden, result;
		  hidden = void 0;
		  result = void 0;
		  if ($("#widget_settings .modal-body ul.sortable").length <= 0) {
		    return true;
		  }
		  $("#widget_settings .modal-body ul.sortable").sortable({
		    update: function(event, ui) {
		      var test;
		      test = void 0;
		      var result = [];

		      //Can't use sortable('toArray') here
		      $(this).find('li').each(function(i, el){
		          result.push($(el).attr('id'));
		      });

		      test = result[0].split("_"[0]);
		      //model_keytype_order
		      hidden = test[0] + "_" + test[1] + "_order";

		      $("input[name=" + hidden + "]").val(result);

		    }
		  });
		};

		EndpointSortable();

		$("#widget_settings .modal-body a.info").each(function() {
			var el = $('<span class="help" data-toggle="tooltip" data-placement="auto bottom" title="'+$(this).find("span").html()+'"><i class="fa fa-question-circle"></i></span>');
			$(el).tooltip();
			$(this).after(el);
			$(this).find("span").remove();
			$(this).replaceWith($(this).html());
		});

		$("#widget_settings .modal-body .horDropDown").change(function() {
			var name = $(this).prop('name');
			var length = name.length;
			name = name.substr(0, length - 5);
			var txt = $(this).find("option:selected").text();
			var lTxt = txt.length;
			switch($(this).find("option:selected").text()){
				case 'REST-Apps':
				case 'REST-Call Flow':
				case 'REST-Call Forward':
				case 'REST-Conference':
				case 'REST-Contacts':
				case 'REST-DND':
				case 'REST-Follow Me':
				case 'REST-Login':
				case 'REST-Parking':
				case 'REST-Presence':
				case 'REST-Queues':
				case 'REST-Queue Agent':
				case 'REST-Time Conditions':
				case 'REST-Transfer VM':
				case 'REST-Voicemail':
					txt = txt.substr(5, lTxt);
					$("#" + name + 'label').val(txt);
					break;

				default:
					$("#" + name + 'label').val(txt);
					break;
			}
		});

		$("#widget_settings .modal-body .xmlDropDown").change(function() {
			var name = $(this).prop('name');
			var length = name.length;
			name = name.substr(0, length - 3);
			var txt = $(this).find("option:selected").text();
			var lTxt = txt.length;
			txt = txt.substr(5, lTxt);
			switch($(this).find("option:selected").text()){
				case 'REST-Apps':
				case 'REST-Call Flow':
				case 'REST-Call Forward':
				case 'REST-Conference':
				case 'REST-Contacts':
				case 'REST-DND':
				case 'REST-Follow Me':
				case 'REST-Login':
				case 'REST-Parking':
				case 'REST-Presence':
				case 'REST-Queues':
				case 'REST-Queue Agent':
				case 'REST-Time Conditions':
				case 'REST-Transfer VM':
				case 'REST-Voicemail':
					$("#" + name + 'label').val(txt);
					break;

				default:
					break;
			}
		});

		$("#widget_settings .modal-body .saveTemplate").click(function(event) {
			event.preventDefault();
			event.stopPropagation();

			var e = document.getElementById("task");
			var task = e.options[e.selectedIndex].value;

			var data = $("#widget_settings .modal-body form").formSerialize();

			//save not needed, because we always save, option is just for looks
			data = (task == "rebuild") ? data + "&rebuild=1":data;
			data = (task == "restart") ? data + "&rebuild=1&restart=1":data;
			data = (task == "reset") ? data + "&reset=1":data;

			$.post( UCP.ajaxUrl+"?module=endpoint&command=savesettings", data, function( data ) {
				if (data.status) {
					$("#widget_settings").modal('toggle');
					return true;
				} else {
					return false;
				}
			});
		});

		$("#widget_settings .modal-body .keyType").change(function() {
			var name = $(this).prop('name'),
					length = name.length,
					secname = name.substr(8, length);
			$(".hideKeys").hide();
			if($(this).is(":checked")) {
				$("#" + secname).show();
			}
			//someone should have just used a radio instead of a checkbox
			$("#widget_settings .modal-body .keyType").each(function() {
				if($(this).prop('name') !== name) {
					$(this).prop("checked",false);
				}
			});
		});

		$("#widget_settings .modal-body .hkeyType").change(function() {
			var name = $(this).prop('name');
			$(".hideHorSoftKeys").hide();
			if($(this).is(":checked")) {
				$("." + name).show();
			}
			//someone should have just used a radio instead of a checkbox
			$("#widget_settings .modal-body .hkeyType").each(function() {
				if($(this).prop('name') !== name) {
					$(this).prop("checked",false);
				}
			});
		});

		$("#widget_settings .modal-body .type").change(function() {
			var name = $(this).prop('name');
			var length = name.length;
			name = name.substr(0, length - 4);

			if($("#" + name + 'acct').val() === ''){
				$("#" + name + 'acct').val('account1');
			} else {
				if($(this).find("option:selected").text() == 'Blank'){
					$("#" + name + 'acct').val('');
					$("#" + name + 'label').val('');
					$("#" + name + 'value').val('');
				}
			}


			switch($(this).find("option:selected").text()){
				//line keys first
				case 'Line':
					$("." + name + 'value').hide();
					$("." + name + 'valueFill').show();
					$("." + name + 'label').hide();
					$("." + name + 'labelFill').show();
					$("#" + name + 'xml').hide();
					$("." + name + 'state').hide();
					break;

				//now xml-api
				case 'XML-API':
					$("#" + name + 'xml').show();
					$("." + name + 'value').show();
					$("#" + name + 'value').hide();
					$("." + name + 'valueFill').hide();
					$("." + name + 'label').show();
					$("." + name + 'labelFill').hide();
					$("." + name + 'state').hide();
					break;

				//now park
				case 'Call Park':
					$("#" + name + 'park').show();
					$("#" + name + 'xml').hide();
					$("." + name + 'value').hide();
					$("#" + name + 'value').hide();
					$("." + name + 'valueFill').hide();
					$("." + name + 'label').show();
					$("." + name + 'labelFill').hide();
					$("." + name + 'state').hide();
					break;

				case 'Voicemail':
				case 'Intercom':
				case 'DND':
				case 'Record':
				case 'LDAP':
					$("#" + name + 'park').hide();
					$("#" + name + 'xml').hide();
					$("." + name + 'value').hide();
					$("#" + name + 'value').hide();
					$("." + name + 'valueFill').show();
					$("#" + name + 'label').val($(this).find("option:selected").text());
					$("." + name + 'labelFill').hide();
					$("." + name + 'state').hide();
					break;

				case 'BLF':
					$("." + name + 'state').show();
					break;

				default:
					$("#" + name + 'xml').hide();
					$("#" + name + 'value').show();
					$("." + name + 'value').show();
					$("." + name + 'valueFill').hide();
					$("." + name + 'label').show();
					$("." + name + 'labelFill').hide();
					$("#" + name + 'park').hide();
					$("." + name + 'state').hide();
					break;
			}
		});

		$("#widget_settings .modal-body .blfAlert, #widget_settings .modal-body .none").click(function() {
			var clickedInput = $(this),
					parent = $(this).parent(),
					allChildInputs = clickedInput.hasClass('none') ? parent.children('input.blfAlert') : parent.children('input.none');

			allChildInputs.each(function(k,v) {
				$(this).prop('checked', false);
			});

			clickedInput.prop('checked', true);
		});
	},
	validatePass: function(passInfo){
		if (passInfo.field.val() === undefined) {
			return;
		}
		if (passInfo) {
			//it's NOT valid
			if (passInfo.field.val().length > 0) {
				if(passInfo.field.val().length <6){
					passInfo.field.addClass("globalError");
					passInfo.error.text(passInfo.name + " Password MUST be at least 6 characters");
					passInfo.error.addClass("globalError");
					return false;
				} else { //it's valid
					passInfo.field.removeClass("globalError");
					passInfo.error.text(" ");
					passInfo.error.removeClass("globalError");
					return true;
				}
			}
		}
	}
});
