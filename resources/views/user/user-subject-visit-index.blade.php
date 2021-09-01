@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/user-subject-visit.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	//var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//var selected_study_id = {{($selectedStudy && $selectedStudy->id) ? $selectedStudy->id: 0}};
	//var selected_site_id = {{($selectedSite && $selectedSite->id) ? $selectedSite->id: 0}};
	var selected_subject_id = {{($selectedSubject && $selectedSubject->id) ? $selectedSubject->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    KTDatatableUserSubjectVisit.init(csrf_token, selected_subject_id);
});
</script>
<template id='subject-visit-form-text' type="text/html">
	@include('user.subject-visit-form')
</template>

@endsection

@section('page_content')
{{-- add popup modal --}}
	<x-add-modal-popup title="Add Visit" modal-id="subjectVisitModalPopovers"
		title-id='subjectVisitModalTitle' body-id="subjectVisitModalBody" save-id="subject_visit_save_id" />
{{-- end add popup modal --}}
	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Select Visit</h3>
					</div>
					<div class="card-toolbar">
						<a href="javascript:KTDatatableUserSubjectVisit.reload()" class="btn btn-icon btn-primary mr-2"><i class="ki ki-refresh"></i></a>
						<button type="button" id="btn-add-subject" class="btn btn-primary">New Visit</button>	
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_user_subject_visits">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection