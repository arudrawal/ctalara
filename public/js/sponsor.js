"use strict";
// Class definition

var KTDatatableSponsor = function() {
    // Private functions

    // initialize sponsors table
    var initSponsor = function(csrf_token, sponsor_id) {

        var datatable = $('#kt_datatable_sponsors').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
						method: 'GET',
                        //url: HOST_URL + '/api/sponsor/index',
						url: '/api/sponsor/index',
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'Content-Type': 'the value'},
						headers: {'X-XSRF-TOKEN': csrf_token,
								  'Accept': "application/json"
								},
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

            search: { // not a column specific search
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

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
                field: 'address',
                title: 'Address',
            }, {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 125,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var btnSelect =  `<form method="POST" action="/sponsor/select" style="display:inline">
							<input type="hidden" name="_token" value="${csrf_token}"/>
							<input type="hidden" name="id" value="${row.id}"/>
							<a href="javascript:;" data-select="select"
							class="btn btn-sm btn-clean btn-icon mr-2" title="Select Sponsor">
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
							data-sponsor-name="${row['name']}"
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
                    return btnSelect + btnEdit + btnDel;
                },
            }],

        });
		$('#kt_datatable_search_name').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Name');
        });
		datatable.on('click', '[data-select]', function() {
			var form = $(this).closest('form');
			form.submit();
			/*if (this.dataset.action == 'select') {
				//modalTitle.innerHTML = 'Select sponsor: ' + sponsorID;
				const form_data = 'id='+sponsorID+'&'+ '_token='+csrf_token;
				const post_data = encodeURIComponent(form_data);
				console.log(post_data);
				fetch('/sponsor/select', {
				  method: 'POST', // or 'PUT'
				  headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				  },
				  redirect: 'follow',
				  body: post_data,
				}).then(function (response) {
					console.log(response);
				});
				return;
			}*/
		});
        datatable.on('click', '[data-record-id]', function() {
			const modalTitle = document.getElementById('sponsorModalTitle');
			const modalBody = document.getElementById('sponsorModalBody');
			modalBody.innerHTML = document.getElementById('sponsor-form-text').innerHTML;
			$("#alert-sponsorModalBody").empty().css('display', 'none');
			const sponsorID = this.dataset.recordId; // dash converted to camelCase
			
			if (this.dataset.action == 'edit') {
				$(modalBody).find('#id').value = sponsorID;
				modalTitle.innerHTML = 'Edit Sponsor';
				let rowJsonObj  = getDataObj(datatable, sponsorID);
				if (rowJsonObj) {
					$(modalBody).find('input[name=id]').val(sponsorID);
					$(modalBody).find('input[name=name]').val(rowJsonObj.name);
					$(modalBody).find('input[name=code]').val(rowJsonObj.code);
					$(modalBody).find('textarea[name=address]').val(rowJsonObj.address);
				}
			} else { // if (this.dataset.action == 'delete')				
				modalTitle.innerHTML = 'Confirm delete sponsor: ' + this.dataset.sponsorName;
				if (window.confirm(modalTitle.innerHTML)) {
					const post_data = JSON.stringify({id: sponsorID, _token: csrf_token});
					console.log(post_data);
					fetch('/api/sponsor/delete', {
					  method: 'POST', // or 'PUT'
					  headers: {
						'Content-Type': 'application/json',
						'Accept': 'application/json',
						'X-XSRF-TOKEN': csrf_token,
					  },
					  body: post_data,
					}).then(function (response) {
						console.log(response);
						$('#sponsorModalPopovers').modal('hide');
						datatable.reload();
					});
				}
				return;
			}
            //initSubDatatable($(this).data('record-id'));
            $('#sponsorModalPopovers').modal('show');
			const fv = setSponsorFormValidator();
        });
		$('#btn-add-sponsor').on('click', function() {
			const modalTitle = document.getElementById('sponsorModalTitle');
			const modalBody = document.getElementById('sponsorModalBody');
			modalTitle.innerHTML = 'Add Sponsor';
			modalBody.innerHTML = document.getElementById('sponsor-form-text').innerHTML;
			$('#alert-sponsorModalBody').empty().css('display', 'none');
			$('#sponsorModalPopovers').modal('show');
			const fv = setSponsorFormValidator();
		});
		
		$('#sponsor_save_id').on('click', function() {
            const spForm = document.getElementById('sponsor-form');
			const formData = new FormData(spForm);
			const jsonObject = Object.fromEntries(formData.entries());
			//console.log(JSON.stringify(jsonObject));
			$("#sponsor-form :input").prop('readonly', true);
			const fv = setSponsorFormValidator();
			fv.validate().then(function(validation_status) {
				// status can be one of the following value
				// 'NotValidated': The form is not yet validated
				// 'Valid': The form is valid
				// 'Invalid': The form is invalid
				if (validation_status == 'Valid') {
					// submit the form
					var xhttp = new XMLHttpRequest();
					xhttp.open("POST", "/api/sponsor/create", true);
					xhttp.setRequestHeader("Content-Type", "application/json");
					xhttp.setRequestHeader("Accept", "application/json");
					xhttp.setRequestHeader("X-XSRF-TOKEN", formData.get('_token'));
					//xhttp.setRequestHeader("X-XSRF-TOKEN", csrf_token);
					xhttp.onreadystatechange = function() {
					   if (this.readyState == 4 && this.status == 200) {
						 $('#sponsorModalPopovers').modal('hide');
						 datatable.reload(); // reload table
					   }  else if (this.readyState == 4 && this.status == 422) {
							const objResp = JSON.parse(this.response);
							for (const [key, value] of Object.entries(objResp.errors)) {
								const keyName = `[name="${key}"]`;
								const element = $('#sponsorModalPopovers').find(keyName);
								if (element) {
									element.removeClass().addClass('form-control is-invalid');
									$('#alert-sponsorModalBody').append(value+'<br/>').css('display', 'block');
								}
						  	}
				   		}
					};
					xhttp.send(JSON.stringify(jsonObject));
					/*fetch('/api/sponsor/create', {
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
			$("#sponsor-form :input").prop('readonly', false);
        });
	};
	var setSponsorFormValidator = function() {
		const sponsorForm = document.getElementById('sponsor-form');
		const fv = FormValidation.formValidation(sponsorForm, {
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
				//submitButton: new FormValidation.plugins.SubmitButton(),
				bootstrap: new FormValidation.plugins.Bootstrap({
					eleInvalidClass: '',
					eleValidClass: '',
				   }),
			},
		});
		return fv;
	};
	// initialize sponsor contact table
	var initSponsorContact = function(csrf_token, sponsor_id) {
		var contactDatatable = $('#kt_datatable_contacts').KTDatatable({
			data: {
                type: 'remote',
                source: {
                    read: {
						method: 'GET',
						url: `/api/sponsor/contact/index/${sponsor_id}`,
                        // sample custom headers
                        // headers: {'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
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
                pageSize: 5,
                serverPaging: true,
                serverFiltering: true,
                serverSorting: true,			
			},
			columns: [{
					field: 'name',
					title: 'Contact Name',
				}, {
					field: 'address',
					title: 'Address',
				}, {
					field: 'phone',
					title: 'Phone',
				}, {
					field: 'email',
					title: 'Email',
				},{
				field: 'Actions',
				title: 'Actions',
                sortable: false,
                width: 100,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
					var btnEdit = `<a href="javascript:;" data-contact-edit="contact-edit" data-record-id="${row.id}"
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
					var btnDel = `<a href="javascript:;" data-contact-delete="contact-delete" data-record-id="${row.id}" 
							data-contact-name="${row['name']}"
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
		// delete contact
		contactDatatable.on('click', '[data-contact-delete]', function() {
			const contactName = this.dataset.contactName;
			if (window.confirm('Confirm delete contact: '+ contactName+'?')) {
				const contactId = this.dataset.recordId;
				const post_data = JSON.stringify({id: contactId, _token: csrf_token});
				console.log(post_data);
				fetch('/api/sponsor/contact/delete', {
				  method: 'POST', // or 'PUT'
				  headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-XSRF-TOKEN': csrf_token,
				  },
				  body: post_data,
				}).then(function (response) {
					console.log(response);
					$('#sponsorModalPopovers').modal('hide');
					contactDatatable.reload();
				});
			}
		});
		// edit contact
		contactDatatable.on('click', '[data-contact-edit]', function() {
			const contactId = this.dataset.recordId;
			const modalTitle = document.getElementById('contactModalTitle');
			const modalBody = document.getElementById('contactModalBody');
			modalTitle.innerHTML = 'Edit Contact';
			modalBody.innerHTML = document.getElementById('contact-form-text').innerHTML;
			$(modalBody).find('input[name=id]').val(contactId);
			let rowJsonObj  = getDataObj(contactDatatable, contactId);
			if (rowJsonObj) {
				$(modalBody).find('input[name=sponsor_id]').val(rowJsonObj.sponsor_id);
				$(modalBody).find('input[name=name]').val(rowJsonObj.name);
				$(modalBody).find('textarea[name=address]').val(rowJsonObj.address);
				$(modalBody).find('input[name=phone]').val(rowJsonObj.phone);
				$(modalBody).find('input[name=email]').val(rowJsonObj.email);
				$('#contactModalPopovers').find('.form-control').each(function() {
					$(this).removeClass().addClass('form-control');	
				});
				$('#alert-contactModalBody').empty().css('display','none');
				$('#contactModalPopovers').modal('show');
				setContactFormValidator();
			}
		});
		$('#btn-add-contact').on('click', function() {
			const modalTitle = document.getElementById('contactModalTitle');
			const modalBody = document.getElementById('contactModalBody');
			modalTitle.innerHTML = 'Add Contact';
			modalBody.innerHTML = document.getElementById('contact-form-text').innerHTML;
			$('#contactModalPopovers').find('.form-control').each(function() {
				$(this).removeClass().addClass('form-control');	
			});
			$('#alert-contactModalBody').empty().css('display','none');
			$('#contactModalPopovers').modal('show');
			const fv = setContactFormValidator();
		});
		$('#contact_modal_save_id').on('click', function() {
            const contactForm = document.getElementById('contact-form');
			$("#contact-form :input").prop('readonly', true);
			const formData = new FormData(contactForm);
			const jsonObject = Object.fromEntries(formData.entries());
			$('#alert-contactModalBody').empty().css('display', 'none');
			//console.log(JSON.stringify(jsonObject));
			const fv = setContactFormValidator();
			fv.validate().then(function(validation_status) {
				// status can be one of the following value
				// 'NotValidated': The form is not yet validated
				// 'Valid': The form is valid
				// 'Invalid': The form is invalid
				if (validation_status == 'Valid') {
					// submit the form
					var xhttp = new XMLHttpRequest();
					xhttp.open("POST", "/api/sponsor/contact/create", true);
					xhttp.setRequestHeader("Content-Type", "application/json");
					xhttp.setRequestHeader("Accept", "application/json");
					xhttp.setRequestHeader("X-XSRF-TOKEN", formData.get('_token'));
					//xhttp.setRequestHeader("X-XSRF-TOKEN", csrf_token);
					xhttp.onreadystatechange = function() {
					   if (this.readyState == 4 && this.status == 200) {
						 $('#contactModalPopovers').modal('hide');
						 contactDatatable.reload(); // reload table
					   } else if (this.readyState == 4 && this.status == 422) { // show error message
							const objResp = JSON.parse(this.response);
							//console.log(objResp.message);
							for (const [key, value] of Object.entries(objResp.errors)) {
								//console.log(`${key}: ${value}`);
								const keyName = `[name="${key}"]`;
								const element = $('#contactModalPopovers').find(keyName);
								if (element) {
									element.removeClass().addClass('form-control is-invalid');
									$('#alert-contactModalBody').append(value+'<br/>').css('display', 'block');
								}
						  	}
					   }
					};
					xhttp.send(JSON.stringify(jsonObject));
				} else { 
					// get rid of messages added by manual validation on click save
					fv.resetForm();
				}
			});
			$("#contact-form :input").prop('readonly', false);
        });
	};
	var setContactFormValidator = function() {
		const contactForm = document.getElementById('contact-form');
		const fv = FormValidation.formValidation(contactForm, {
			fields: { 
				name: {
					validators: {
						notEmpty: {
							message: 'Name is required'
						},
					},
				},
				address: { // blank for Ajax errors
					validators: {
						blank: {},
					},
				},
				email: { // blank for Ajax errors
					validators: {
						emailAddress: {
                            message: 'The value is not a valid email address'
                        },
					},
				},
				phone: { // blank for Ajax errors
					validators: {
						blank: {},
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
				/*message: new FormValidation.plugins.Message({
					clazz: 'fv-help-block',
					container: ".fv-plugins-message-container",
				}),*/
			},
		});
		return fv;
	}
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
            initSponsor(csrf_token);
			if (sponsor_id) {
				initSponsorContact(csrf_token, sponsor_id);
			}
        },
    };
}();

/*jQuery(document).ready(function() {
    KTDatatableSponsor.init();
});*/
