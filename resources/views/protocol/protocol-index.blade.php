@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/protocol.js')}}"></script>
{{--<script src="{{asset('js/pages/features/forms/widgets/bootstrap-datepicker.js')}}"></script> --}}
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableProtocol.init(csrf_token, selected_sponsor_id);
});
</script>
<template id='protocol-form-text' type="text/html">
	@include('protocol.protocol-form')
</script>
@endsection

@section('page_content')
{{-- add popup modal --}}
<x-add-modal-popup title="Add Protocol" modal-id="protocolModalPopovers"
	title-id='protocolModalTitle' body-id="protocolModalBody" save-id="protocol_save_id" />
{{-- end add popup modal --}}

	<div class="d-flex flex-column-fluid">
		<!-- begin container -->
		<div class='container'>
			<div class="card card-custom">
				<div class="card-header flex-wrap border-0 pt-6 pb-0">
					<div class="card-title">
						<h3 class="card-label">Protocols</h3>
					</div>
					<div class="card-toolbar">
						<!--begin::Button-->
						<button type="button" id="btn-add-protocol" class="btn btn-primary">New Protocol</button>
						<!--end::Button-->
					</div>
				</div> <!-- end:: card header -->
				<div class="card-body">
					<!--begin: Datatable-->
					<div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_protocols">
					</div>
					<!--end: Datatable-->
				</div>
			</div>
		</div>
	</div>
@endsection