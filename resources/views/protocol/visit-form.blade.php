    <form class="form" id="protocol-visit-form">
		<input type="hidden" name="id" value="" />	
		<input type="hidden" name="sponsor_id" value="{{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}}" />
		<input type="hidden" name="protocol_id" value="" />
		@csrf
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Code:
					<span class="text-danger">*</span>
				</label>
				<div class="col-lg-8">
					<input type="text" name="code" class="form-control" placeholder="Enter code"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Revision:</label>
				<div class="col-lg-8">
					<input type="text" name="rev" class="form-control" placeholder="Enter revision"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Desription:</label>
				<div class="col-lg-8">
					<textarea class="form-control" name="description" placeholder="Enter description" rows="3"></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Phase:</label>
				<div class="col-lg-8">
					<input type="text" name="phase" class="form-control" placeholder="Trial phase"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Product:</label>
				<div class="col-lg-8">
					<input type="text" name="product" class="form-control" placeholder="Enter product"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Draft date:</label>
				<div class="col-lg-8">
					<div class="input-group date">
						<input type="text" name="drafted_at" class="form-control" readonly="readonly" value="">
							<div class="input-group-append">{{-- pass click to date input --}}
								<span class="input-group-text">
									<i class="la la-calendar"></i>
								</span>
							</div>
						</input>
					</div>
				</div>
			</div>
	</form>