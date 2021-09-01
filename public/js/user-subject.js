"use strict";

var KTDatatableUserSubject = function() {
	// initialize study table
	var initUserSubjects = function(csrf_token, study_id) {

        var datatable = $('#kt_datatable_user_subjects').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
						method: 'GET',
						url: '/api/user/subject/index/'+study_id,
						headers: {'X-XSRF-TOKEN': csrf_token},
                        map: function(raw) {
                            // sample data mapping
                            var dataSet = raw;
                            if (typeof raw.data !== 'undefined') {
                                dataSet = raw.data;
                            }
                            return dataSet;
                        },
                    },
                },
                pageSize: 10,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
            },

            // column sorting
            sortable: true,

            pagination: true,

            // columns definition
            columns: [{
                field: 'code',
                title: 'Code/Initials',
                sortable: 'asc',
                //width: 60,
                //type: 'number',
                selector: false,
                textAlign: 'center',
				template: function(row) {
					return row.code + ' / ' + row.initials;
				},
			}, {
				field: 'gender',
				title: 'Gender',
            }, {
                field: 'dob',
                title: 'Birth Date',
            }, {
                field: 'enrolled_at',
                title: 'Enrolled At',
				template: function(row) {
					return row.enrolled_at;
				},
            }, {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 125,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var btnSelect =  `<form method="POST" action="/user/subject/select" style="display:inline">
							<input type="hidden" name="_token" value="${csrf_token}"/>
							<input type="hidden" name="id" value="${row.id}"/>
							<a href="javascript:;" data-select="select"
							class="btn btn-sm btn-clean btn-icon mr-2" title="Select Subject">
							<span class="svg-icon svg-icon-md">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
										<path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
										<path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
									</g>
								</svg>
							</span>
						</a></form>`;
                    return btnSelect;
                },
            }],

        });
		datatable.on('click', '[data-select]', function() {
			var form = $(this).closest('form');
			form.submit();
		});
		$('#btn-add-subject').on('click', function() {
			const modalTitle = document.getElementById('subjectModalTitle');
			const modalBody = document.getElementById('subjectModalBody');
			modalTitle.innerHTML = 'Add Subject';
			modalBody.innerHTML = document.getElementById('subject-form-text').innerHTML;
			$('#alert-subjectModalBody').empty().css('display', 'none');
            initDatePicker();
			$('#subjectModalPopovers').modal('show');
			const fv = setSubjectFormValidator();
		});
		$('#subject_save_id').on('click', function() {
            const subjectForm = document.getElementById('subject-form');
			const formData = new FormData(subjectForm);
			const jsonObject = Object.fromEntries(formData.entries());
			$("#subject-form :input").prop('readonly', true);
			const fv = setSubjectFormValidator();
			fv.validate().then(function(validation_status) {
				// status can be one of the following value
				// 'NotValidated': The form is not yet validated
				// 'Valid': The form is valid
				// 'Invalid': The form is invalid
				if (validation_status == 'Valid') {
					// submit the form
					var xhttp = new XMLHttpRequest();
					xhttp.open("POST", "/api/user/subject/create", true);
					xhttp.setRequestHeader("Content-Type", "application/json");
					xhttp.setRequestHeader("Accept", "application/json");
					xhttp.setRequestHeader("X-XSRF-TOKEN", formData.get('_token'));
					//xhttp.setRequestHeader("X-XSRF-TOKEN", csrf_token);
					xhttp.onreadystatechange = function() {
					   if (this.readyState == 4 && this.status == 200) {
						 $('#subjectModalPopovers').modal('hide');
						 datatable.reload(); // reload table
					   }  else if (this.readyState == 4 && this.status == 422) {
							const objResp = JSON.parse(this.response);
							for (const [key, value] of Object.entries(objResp.errors)) {
								const keyName = `[name="${key}"]`;
								const element = $('#subjectModalPopovers').find(keyName);
								if (element) {
									element.removeClass().addClass('form-control is-invalid');
									$('#alert-subjectModalBody').append(value+'<br/>').css('display', 'block');
								}
						  	}
				   		}
					};
					xhttp.send(JSON.stringify(jsonObject));
				} else {
					//fv.resetForm(false);
                    //fv.resetField('code', false);
				}
			});
			$("#subject-form :input").prop('readonly', false);
        });
        var setSubjectFormValidator = function() {
            const subjectForm = document.getElementById('subject-form');
            const fv = FormValidation.formValidation(subjectForm, {
                fields: { 
                    code: {
                        validators: {
                            notEmpty: {
                                message: 'Code is required'
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    //submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        eleInvalidClass: '',
                        eleValidClass: '',
                       }),
                },
            });
            return fv;
        };
        var initDatePicker = function() {
            const arrows = {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>'
            }
            $('input[name=enrolled_at]').datepicker({
                rtl: false,
                todayBtn: "linked",
                clearBtn: true,
                todayHighlight: true,
                templates: arrows,
               });
        };
        return datatable;
	};
	// return a object with public function init().
    return {
        user_datatable: null,
        // public functions
        init: function(csrf_token, study_id) {
            this.user_datatable = initUserSubjects(csrf_token, study_id);
        },
        reload: function() {
            if (this.user_datatable) {
                this.user_datatable.reload();
            }
        }
    };
}();
