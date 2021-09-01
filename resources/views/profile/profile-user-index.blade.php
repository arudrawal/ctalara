@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/profile-user.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_study_id = {{($selectedStudy && $selectedStudy->id) ? $selectedStudy->id: 0}};
	//$('#kt_datatable_search_protocol').selectpicker();
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableProfileUser.init(csrf_token, selected_study_id);
});
</script>
<script id='profile-user-form-text' type="text/html">
	@include('profile.profile-user-form')
</script>
@endsection

@section('page_content')
{{-- add popup modal --}}
<x-add-modal-popup title="Assign Prfoile to user" modal-id="profileUserModalPopovers"
	title-id='profileUserModalTitle' body-id="profileUserModalBody" save-id="profile_user_save_id" />
{{-- end add popup modal --}}

	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Assign Profile to user
						{{--<span class="d-block text-muted pt-2 font-size-sm">Datatable initialized from HTML table</span>--}}
						</h3>
					</div>
					<div class="card-toolbar">
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin::Search Form-->
					<div class="mb-5">
						<div class="row align-items-center">
							<div class="col-lg-10 col-xl-9">
								<div class="row align-items-center">
									<div class="col-md-12 my-2 my-md-0">
										<div class="d-flex align-items-center">
											<label class="mr-3 mb-0 d-none d-md-block">Study:</label>
											<select class="form-control" id="kt_datatable_search_study">
											<option value="0" {{$filter_study==0?'selected':''}}>ALL</option>
											@isset($studies)
												@foreach ($studies as $study)
												<option value="{{$study->id}}" {{$filter_study==$study->id?'selected':''}}>{{$study->name}} - {{$study->code}}</option>
												@endforeach
											@endisset
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-xl-3 mt-5 mt-lg-0">
								<a href="#" class="btn btn-light-primary px-6 font-weight-bold">Search</a>
							</div>
						</div>
					</div>
					<!--end::Search Form-->
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_profile_user">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection