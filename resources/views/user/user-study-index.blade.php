@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/user-study.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableUserStudy.init(csrf_token, selected_sponsor_id);
});
</script>
@endsection

@section('page_content')
	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Select Study</h3>
					</div>
					<div class="card-toolbar">
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_user_studies">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection