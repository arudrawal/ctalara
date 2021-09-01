@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/profile.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//$('#kt_datatable_search_protocol').selectpicker();
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableProfile.init(csrf_token, selected_sponsor_id);
});
</script>
<script id='profile-form-text' type="text/html">
	@include('profile.profile-form')
</script>
@endsection

@section('page_content')
{{-- add popup modal --}}
<x-add-modal-popup title="Add Prfoile" modal-id="profileModalPopovers"
	title-id='profileModalTitle' body-id="profileModalBody" save-id="profile_save_id" />
{{-- end add popup modal --}}

	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Profile
						{{--<span class="d-block text-muted pt-2 font-size-sm">Datatable initialized from HTML table</span>--}}
						</h3>
					</div>
					<div class="card-toolbar">
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_profile">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection