@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/user.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableUserHome.init(csrf_token, selected_sponsor_id);
});
</script>
<script id='user-form-text' type="text/html">
	{{--@include('user.user-form') --}}
</script>
@endsection

@section('page_content')
{{-- popup modal --}}
<x-add-modal-popup title="Update User" modal-id="userModalPopovers"
	title-id='userModalTitle' body-id="userModalBody" save-id="user_save_id" />
{{-- end popup modal --}}

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
						<h3 class="card-label">Select Sponsor</h3>
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_sponsors">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection