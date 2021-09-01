@extends('index')

@section ('page_specific_js')
<script src="{{asset('js/contact.js')}}"></script>
<script>
jQuery(document).ready(function() {
	var csrf_token = "{{csrf_token()}}";
	var selected_sponsor_id = {{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}};
	//var meta_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    KTDatatableContact.init(csrf_token, selected_sponsor_id);
});
</script>
<script id='sponsor-form-text' type="text/html">
	@include('sponsor.sponsor-form')
</script>
<template id='contact-form-text' type="text/html">
	@include('sponsor.contact-form')
</script>
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
					<div class="card-title"><small>Sponsor</small></div>
					<div class="card-toolbar">
						<button type="button" id="btn-add-contact" class="btn btn-primary">Edit Sponsor</button>
						&nbsp;
						<button type="button" id="btn-add-contact" class="btn btn-primary">New Contact</button>	
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
		</div>
	</div>
@endsection