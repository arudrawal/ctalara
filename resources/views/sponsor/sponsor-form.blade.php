    <form class="form" id="sponsor-form">
		<input type="hidden" name="id" value="" />
		@csrf
		<div class="mb-15">
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Name:</label>
				<div class="col-lg-6">
					<input type="text" name="name" class="form-control" placeholder="Enter sponsor name"/>
					<div class="fv-plugins-message-container"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Code:</label>
				<div class="col-lg-6">
					<input type="text" name="code" class="form-control" placeholder="Enter sponsor code"/>
					<div class="fv-plugins-message-container"></div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Address:</label>
				<div class="col-lg-6">
					<textarea class="form-control" name="address" placeholder="Enter address" rows="3"></textarea>
					<div class="fv-plugins-message-container"></div>
				</div>
			</div>
		</div>
	</form>