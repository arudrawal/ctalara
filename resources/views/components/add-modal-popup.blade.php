
<!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
<div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-labelledby="{{$titleId}}" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="{{$titleId}}">{{$title}}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i aria-hidden="true" class="ki ki-close"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger" id="alert-{{$bodyId}}" style="display:none" role="alert">
				</div>
				<div id="{{$bodyId}}">
					{{-- form contents goes here --}}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary font-weight-bold" id="{{$saveId}}">Save changes</button>
			</div>
		</div>
	</div>
</div>    
