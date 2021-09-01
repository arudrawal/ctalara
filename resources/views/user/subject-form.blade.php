    <form class="form" id="subject-form">
		<input type="hidden" name="id" value="" />	
		<input type="hidden" name="study_id" value="{{($selectedStudy && $selectedStudy->id) ? $selectedStudy->id: 0}}" />
		@csrf
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Code:</label>
				<div class="col-lg-8">
					<input type="text" name="code" class="form-control" placeholder="Enter subject code" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Initials:</label>
				<div class="col-lg-8">
					<input type="text" name="initials" class="form-control" placeholder="initials" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Gender:</label>
				<div class="col-lg-8">
					<select class="form-control form-control-sm" name='gender' id="gender">
					@foreach ($gender_options as $gender_option)
						<option value="{{$gender_option['id']}}">{{$gender_option['name']}}</option>
					@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Status:</label>
				<div class="col-lg-8">
					<select class="form-control form-control-sm" name='status' id="status">
					@foreach ($status_options as $status_option)
						<option value="{{$status_option['id']}}">{{$status_option['name']}}</option>
					@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Enrolled On:</label>
				<div class="col-lg-8">
					<div class="input-group date">
						<input type="text" name="enrolled_at" id="enrolled_at" class="form-control" readonly="readonly" value="">
							<div class="input-group-append">{{-- pass click to date input --}}
								<span class="input-group-text">
									<i class="la la-calendar"></i>
								</span>
							</div>
						</input>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-3 col-form-label text-right">Site:</label>
				<div class="col-lg-8">
					<select class="form-control form-control-sm" name='site_id' id="site_id">
					<option value="0">N/A</option>
					@foreach ($study_sites as $study_site)
						<option value="{{$study_site['id']}}">{{$study_site['name']}}</option>
					@endforeach
					</select>
				</div>
			</div>
	</form>