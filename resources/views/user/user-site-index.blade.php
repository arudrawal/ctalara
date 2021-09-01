@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/user-site.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_study_id = {{($selectedStudy && $selectedStudy->id) ? $selectedStudy->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableUserSite.init(csrf_token, selected_study_id);
});
</script>
@endsection

@section('page_content')
	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			@if ($selectedSponsor && $selectedSponsor->id)
			<div class="card card-custom">
				 <div class="card-header">
					<div class="card-title"><small>Selected Study</small></div>
				 </div>
				 <div class="card-body">
					<table cellpadding="5px">
					<tr><th>Sponsor:</th><td>{{$selectedSponsor->name}} ({{$selectedSponsor->code}})</td></tr>
					<tr><th>Study:</th><td>{{$selectedStudy->name}} ({{$selectedStudy->code}})</td></tr>
					</table>
				 </div>
			</div>
			@endif
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Select Site</h3>
					</div>
					<div class="card-toolbar">
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_user_sites">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection