"use strict";

var KTDatatableUserStudy = function() {

	// initialize study table
	var initUserStudies = function(csrf_token, sponsor_id=0) {

        var datatable = $('#kt_datatable_user_studies').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: {
                    read: {
						method: 'GET',
						url: '/api/user/study/index/'+sponsor_id,
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
                title: 'Study/Code',
                sortable: 'asc',
                //width: 60,
                //type: 'number',
                selector: false,
                textAlign: 'center',
				template: function(row) {
					return row.name + ' / ' + row.code;
				},
			}, {
				field: 'description',
				title: 'Description',
            }, {
                field: 'sponsor_name',
                title: 'Sponsor',
            }, {
                field: 'start_at',
                title: 'Period',
				template: function(row) {
					return row.start_at + ' - ' + row.end_at;
				},
            }, {
                field: 'Actions',
                title: 'Actions',
                sortable: false,
                width: 125,
                overflow: 'visible',
                autoHide: false,
                template: function(row) {
                    var btnSelect =  `<form method="POST" action="/user/study/select" style="display:inline">
							<input type="hidden" name="_token" value="${csrf_token}"/>
							<input type="hidden" name="id" value="${row.id}"/>
							<a href="javascript:;" data-select="select"
							class="btn btn-sm btn-clean btn-icon mr-2" title="Select Study">
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
	};
	// return a object with public function init().
    return {
        // public functions
        init: function(csrf_token, sponsor_id) {
            initUserStudies(csrf_token, sponsor_id);
        },
    };
}();
