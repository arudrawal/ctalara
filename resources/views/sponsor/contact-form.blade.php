    <form class="form" id="contact-form">
		<input type="hidden" name="id" value="" />	
		<input type="hidden" name="sponsor_id" value="{{($selectedSponsor && $selectedSponsor->id) ? $selectedSponsor->id: 0}}" />
		@csrf
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Name:</label>
				<div class="col-lg-8">
					<input type="text" name="name" class="form-control" placeholder="Enter sponsor name"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Address:</label>
				<div class="col-lg-8">
					<textarea class="form-control" name="address" placeholder="Enter address" rows="3"></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Phone:</label>
				<div class="col-lg-8">
					<input type="text" name="phone" class="form-control" placeholder="Enter phone"/>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Email:</label>
				<div class="col-lg-8">
					<input type="text" name="email" class="form-control" placeholder="Enter email"/>
				</div>
			</div>
	</form>