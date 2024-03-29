	/*  Wizard */
	jQuery(function ($) {
		"use strict";
		// Chose here which method to send the email, available:
		// Simple phpmail text/plain > quotation.php (default)
		// Phpmaimer text/html > phpmailer/quotation_phpmailer.php
		// Phpmaimer text/html SMPT > phpmailer/quotation_phpmailer_smtp.php
		// PHPmailer with html template > phpmailer/quotation_phpmailer_template.php
		// PHPmailer with html template SMTP> phpmailer/quotation_phpmailer_template_smtp.php
		$("#wizard_container").wizard({
			stepsWrapper: "#wrapped",
			submit: ".submit",
			beforeSelect: function (event, state) {
				if ($('input#website').val().length != 0) {
					return false;
				}
				if (!state.isMovingForward)
					return true;
				var inputs = $(this).wizard('state').step.find(':input');
				return !inputs.length || !!inputs.valid();
			}
		}).validate({
			errorPlacement: function (error, element) {
				if (element.is(':radio') || element.is(':checkbox')) {
					error.insertBefore(element.next());
				} else {
					error.insertAfter(element);
				}
			}
		});
		//  progress bar
		$("#progressbar").progressbar();
		$("#wizard_container").wizard({
			afterSelect: function (event, state) {
				$("#progressbar").progressbar("value", state.percentComplete);
				$("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
			}
		});
		// Validate select
		$('#wrapped').validate({
			ignore: [],
			rules: {
				select: {
					required: true
				}
			},
			errorPlacement: function (error, element) {
				if (element.is('select:hidden')) {
					error.insertAfter(element.next('.nice-select'));
				} else {
					error.insertAfter(element);
				}
			}
		});
	});

/* File upload validate size and file type - For details: https://github.com/snyderp/jquery.validate.file*/
		$("form#wrapped")
			.validate({
				rules: {
					fileupload: {
						fileType: {
							types: ["jpg", "jpeg", "gif", "png", "pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"]
						},
						maxFileSize: {
							"unit": "MB",
							"size": 10
						},
						minFileSize: {
							"unit": "KB",
							"size": "2"
						}
					}
				}
			});
// Summary 
$("#propertytype_select").on("change", function () {
	$("#propertytype").text($("#propertytype_select").val());
}).trigger("change");

$("#propertysize_select").on("change", function () {
	$("#propertysize").text($("#propertysize_select").val());
}).trigger("change");

$("#propertyfurnishing_select").on("change", function () {
	$("#propertyfurnishing").text($("#propertyfurnishing_select").val());
}).trigger("change");

$("#tenancytype_select").on("change", function () {
	$("#tenancytype_span").text($("#tenancytype_select").val());
}).trigger("change");

$("#managementcategory_select").on("change", function () {
	$("#managementcategory_span").text($("#managementcategory_select").val());
}).trigger("change");

$("#movingsameday_select").on("change", function () {
	$("#tend_movingtoday_span").text($("#movingsameday_select").val());
}).trigger("change");

$("#internallkeyref_inp").on("change", function () {
  $("#tend_internalpropertyref_span").text($("#internallkeyref_inp").val());
}).trigger("change");


function getVals(formControl, controlType) {
	switch (controlType) {

		case 'question_1':
			// Get name for set of checkboxes
			var checkboxName = $(formControl).attr('name');

			// Get all checked checkboxes
			var value = [];
			$("input[name*='" + checkboxName + "']").each(function () {
				// Get all checked checboxes in an array
				if (jQuery(this).is(":checked")) {
					value.push($(this).val());
				}
			});
			$("#question_1").text(value.join(", "));
			break;

		case 'agentname':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#agentname").text(value);
			break;

		case 'firstname':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#firstname").text(value);
			break;

		case 'lastname':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#lastname").text(value);
			break;

		case 'agentemail':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#agentemail").text(value);
			break;

		case 'firstline':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#firstline").text(value);
			break;

		case 'secondline':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#secondline").text(value);
			break;

		case 'area':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#area").text(value);
			break;

		case 'towncity':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#towncity").text(value);
			break;

		case 'postcode':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#postcode").text(value);
			break;

		case 'agentphone':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#agentphone").text(value);
			break;

		case 'tt1name':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#tt1name").text(value);
			break;

		case 'tt1phone':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#tt1phone").text(value);
			break;

		case 'tt1email':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#tt1email").text(value);
			break;

		case 'tt2name':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#tt2name").text(value);
			break;

		case 'tt2email':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#tt2email").text(value);
			break;

		case 'tt2phone':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#tt2phone").text(value);
			break;

		case 'jobdate':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#jobdate").text(value);
			break;

		case 'keycollection':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#keycollection").text(value);
			break;

		case 'keyreturn':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#keyreturn").text(value);
			break;

		case 'furtherinfo':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#furtherinfo").text(value);
			break;
    

		case 'fileupload':
			// Get the value for a textarea
			var value = $(formControl).val();
			$("#fileupload").text(value);
			break;
	}
}
