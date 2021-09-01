"use strict";

var KTDatatableStudy = function() {

	// initialize protocol table
	var initStudy = function(csrf_token, sponsor_id) {

        var datatable = $('#kt_datatable_studies').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
						method: 'GET',
						url: '/api/study/index/'+sponsor_id,
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
                field: 'name',
                title: 'Name',
                sortable: 'asc',
                //width: 60,
                //type: 'number',
                selector: false,
                textAlign: 'center',
            }, {
                field: 'code',
                title: 'Code',
            }, {
                field: 'description',
                title: 'Description',
            }, {
                field: 'start_at',
                title: 'Period',
				template: function(row) {
					return row.display_start_at + ' - ' + row.display_end_at;
				},
            }, {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 125,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
					var btnEdit = `<a href="javascript:;" data-action="edit" data-record-id="${row.id}"
							data-row="${JSON.stringify(row)}"
							class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                    </g>
                                </svg>
                            </span>
                        </a>`;
					var btnDel = `<a href="javascript:;" data-action="delete" data-record-id="${row.id}" 
							data-study-code="${row['code']}"
							class="btn btn-sm btn-clean btn-icon" title="Delete">
                            <span class="svg-icon svg-icon-md">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                        <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                        </a>`;
                    return btnEdit + btnDel;
                },
            }],

        });
        datatable.on('click', '[data-record-id]', function() {
			const modalTitle = document.getElementById('studyModalTitle');
			const modalBody = document.getElementById('studyModalBody');
			modalBody.innerHTML = document.getElementById('study-form-text').innerHTML;
			$("#alert-studyModalBody").empty().css('display', 'none');
			const studyID = this.dataset.recordId; // dash converted to camelCase
			
			if (this.dataset.action == 'edit') {
				$(modalBody).find('#id').value = studyID;
				modalTitle.innerHTML = 'Edit Study';
				let rowJsonObj  = getDataObj(datatable, studyID);
				if (rowJsonObj) {
					$(modalBody).find('input[name=id]').val(protocolID);
					$(modalBody).find('input[name=name]').val(rowJsonObj.name);
					$(modalBody).find('input[name=code]').val(rowJsonObj.code);
					$(modalBody).find('textarea[name=description]').val(rowJsonObj.description);
					$(modalBody).find('input[name=start_at]').val(rowJsonObj.start_at);
					$(modalBody).find('input[name=end_at]').val(rowJsonObj.end_at);
					$(modalBody).find('input[name=drafted_at]').val(rowJsonObj.drafated_at);
				}
			} else { // if (this.dataset.action == 'delete')				
				modalTitle.innerHTML = 'Confirm delete study: ' + this.dataset.studyCode;
				if (window.confirm(modalTitle.innerHTML)) {
					const post_data = JSON.stringify({id: studyID, _token: csrf_token});
					//console.log(post_data);
					fetch('/api/study/delete', {
					  method: 'POST', // or 'PUT'
					  headers: {
						'Content-Type': 'application/json',
						'Accept': 'application/json',
						'X-XSRF-TOKEN': csrf_token,
					  },
					  body: post_data,
					}).then(function (response) {
						console.log(response);
						$('#studyModalPopovers').modal('hide');
						datatable.reload();
					});
				}
				return;
			}
            $('#studyModalPopovers').modal('show');
			const fv = setStudyFormValidator();
			initDatePicker();
        });
		$('#btn-add-study').on('click', function() {
			const modalTitle = document.getElementById('studyModalTitle');
			const modalBody = document.getElementById('studyModalBody');
			modalTitle.innerHTML = 'Add Study';
			modalBody.innerHTML = document.getElementById('study-form-text').innerHTML;
			$('#alert-studyModalBody').empty().css('display', 'none');
			$('#studyModalPopovers').modal('show');
			const fv = setStudyFormValidator();
			initDatePicker();
		});
		
		$('#study_save_id').on('click', function() {
            const studyForm = document.getElementById('study-form');
			const formData = new FormData(studyForm);
			const jsonObject = Object.fromEntries(formData.entries());
			$("#study-form :input").prop('readonly', true);
			const fv = setStudyFormValidator();
			fv.validate().then(function(validation_status) {
				// status can be one of the following value
				// 'NotValidated': The form is not yet validated
				// 'Valid': The form is valid
				// 'Invalid': The form is invalid
				if (validation_status == 'Valid') {
					// submit the form
					var xhttp = new XMLHttpRequest();
					xhttp.open("POST", "/api/study/create", true);
					xhttp.setRequestHeader("Content-Type", "application/json");
					xhttp.setRequestHeader("Accept", "application/json");
					xhttp.setRequestHeader("X-XSRF-TOKEN", formData.get('_token'));
					//xhttp.setRequestHeader("X-XSRF-TOKEN", csrf_token);
					xhttp.onreadystatechange = function() {
					   if (this.readyState == 4 && this.status == 200) {
						 $('#studyModalPopovers').modal('hide');
						 datatable.reload(); // reload table
					   }  else if (this.readyState == 4 && this.status == 422) {
							const objResp = JSON.parse(this.response);
							for (const [key, value] of Object.entries(objResp.errors)) {
								const keyName = `[name="${key}"]`;
								const element = $('#studyModalPopovers').find(keyName);
								if (element) {
									element.removeClass().addClass('form-control is-invalid');
									$('#alert-studyModalBody').append(value+'<br/>').css('display', 'block');
								}
						  	}
				   		}
					};
					xhttp.send(JSON.stringify(jsonObject));
					/*fetch('/api/protocl/create', {
					  method: 'POST', // or 'PUT'
					  headers: {
						'Content-Type': 'application/json',
						//'X-XSRF-TOKEN': data.get('_token'),
					  },
					  body: data,
					}).then(function (response) { 
						console.log(response);
					});*/
				} else {
					fv.resetForm();
				}
			});
			$("#study-form :input").prop('readonly', false);
        });		
	};
	var setStudyFormValidator = function () {
		const protoForm = document.getElementById('protocol-form');
		const fv = FormValidation.formValidation(protoForm, {
			fields: { 
				name: {
					validators: {
						notEmpty: {
							message: 'Name is required'
						},
					},
				},
			},
			plugins: {
				trigger: new FormValidation.plugins.Trigger(),
				bootstrap: new FormValidation.plugins.Bootstrap({
					eleInvalidClass: '',
					eleValidClass: '',
				   }),
			},
		});
		return fv;
	}
	var initDatePicker = function() {
        const arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
		$('input[name=start_at]').datepicker({
			rtl: false,
			todayBtn: "linked",
			clearBtn: true,
			todayHighlight: true,
			templates: arrows,
		   });
	};
	var getDataObj = function (ktDatatable, rowID) {
		const row = ktDatatable.getRecord(rowID);
		if (row) {
			//console.log(row);
			console.log(row.dataSet);
			for (let idx=0; idx < row.dataSet.length; idx++) {
				if (row.dataSet[idx].id==rowID) {
					return row.dataSet[idx];
				}
			}
		}
		return {};
	};
	// return a object with public function init().
    return {
        // public functions
        init: function(csrf_token, sponsor_id) {
            initStudy(csrf_token, sponsor_id);
        },
    };
}();
