@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/sponsor.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableSponsor.init(csrf_token, selected_sponsor_id);
});
</script>
<script id='sponsor-form-text' type="text/html">
	@include('sponsor.sponsor-form')
</script>
<template id='contact-form-text' type="text/html">
	@include('sponsor.contact-form')
</template>
@endsection

@section('page_content')
{{-- add popup modal --}}
<x-add-modal-popup title="Add Sponsor" modal-id="sponsorModalPopovers"
	title-id='sponsorModalTitle' body-id="sponsorModalBody" save-id="sponsor_save_id" />
<x-add-modal-popup title="Add Contact" modal-id="contactModalPopovers"
	title-id='contactModalTitle' body-id="contactModalBody" save-id="contact_modal_save_id" />
{{-- end add popup modal --}}

	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			@if ($selectedSponsor && $selectedSponsor->id)
			<div class="card card-custom"> {{--gutter-b --}}
				 <div class="card-header">
					<div class="card-title"><small>Selected Sponsor</small></div>
					<div class="card-toolbar">
						<button type="button" id="btn-add-contact" class="btn btn-primary">New Contact</button>	
					{{--<a href="#" class="btn btn-sm btn-icon btn-light-success mr-2">
							<i class="flaticon2-gear"></i>
						</a> --}}
					</div>
				 </div>
				 <div class="card-body">
					<table cellpadding="5px">
					<tr><th>Name:</th><td>{{$selectedSponsor ? $selectedSponsor->name : ''}}</td></tr>
					<tr><th>Code:</th><td>{{$selectedSponsor ? $selectedSponsor->code : ''}}</td></tr>
					<tr><th>Address:</th><td>{{$selectedSponsor ? $selectedSponsor->address:''}}</td></tr>
					</table>
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_contacts">
				 	</div>
				 </div>
			</div>
			@endif
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Sponsors
						{{--<span class="d-block text-muted pt-2 font-size-sm">Datatable initialized from HTML table</span>--}}
						</h3>
					</div>
					<div class="card-toolbar">
						<!--begin::Button-->
						<button type="button" id="btn-add-sponsor" class="btn btn-primary">New Sponsor</button>
						{{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sponsorModalPopovers">Launch demo modal</button>--}
						{{--<a href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#sponsorModalPopovers">
						<span class="svg-icon svg-icon-md">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"></rect>
									<circle fill="#000000" cx="9" cy="15" r="6"></circle>
									<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>New Record</a> --}}
						<!--end::Button-->
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin::Search Form-->
					<div class="mb-7">
						<div class="row align-items-center">
							<div class="col-lg-9 col-xl-8">
								<div class="row align-items-center">
									<div class="col-md-4 my-2 my-md-0">
										<div class="input-icon">
											<input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query">
											<span>
												<i class="flaticon2-search-1 text-muted"></i>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
								<a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
							</div>
						</div>
					</div>
					<!--end::Search Form-->
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_sponsors">
					{{--<table><thead><tr>
								<th title="Field #1">Name</th>
								<th title="Field #2">Code</th>
								<th title="Field #3">Address</th>
								<th title="Field #8">Actions</th></tr>
					</thead></table> --}}
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection