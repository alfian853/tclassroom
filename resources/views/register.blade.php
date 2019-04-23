@extends('layouts.master')

@section('title', 'Register')

@section('add-script')
	@parent
<script>
	$(document).ready(function(){
		$('select[name=user_type]').on('change',function () {
			let sut = $('select[name=user_type]')[0];
			if(sut.value == 'teacher'){
				$('#dynamic-field').html(
						'<label for="nip" class="container control-label">NIP\n' +
						'\t\t\t</label>\n' +
						'\t\t\t<div class="col-sm-12">\n' +
						'\t\t\t\t<input type="text" name="nip" placeholder="NIP" class="form-control">\n' +
						'\t\t\t</div>'
				)
			}
			else if(sut.value == 'student'){
				$('#dynamic-field').html(
						'<label for="nrp" class="container control-label">NRP\n' +
						'\t\t\t</label>\n' +
						'\t\t\t<div class="col-sm-12">\n' +
						'\t\t\t\t<input type="text" name="nrp" placeholder="NRP" class="form-control">\n' +
						'\t\t\t</div>'
				)
			}
		})
	});

</script>
@endsection

@section('content')
<div class="container">
  <form class="form-horizontal" style="margin-top:10%" role="form" action="{{route('post.register')}}" method="post">
	<h2 class="col-lg-12 d-flex justify-content-center">Registration Form</h2>
	<hr>
	{{ csrf_field() }}
	<div class="form-group">
		<div class="form-group">
			<label for="name" class="container control-label">Full Name
        		{!! $errors->first('name','<span class="help-block text-danger">*:message</span>') !!}
			</label>
			<div class="col-sm-12">
				<input type="text" name="name" placeholder="Name" class="form-control" value="{{old('name')}}" autofocus>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="container control-label">Password
        		{!! $errors->first('password','<span class="help-block text-danger">*:message</span>') !!}
      		</label>
			<div class="col-sm-12">
				<input type="password" name="password" placeholder="Password" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="password_confirmation" class="container control-label">Re-type Password
	        	{!! $errors->first('password_confirmation','<span class="help-block text-danger">*:message</span>') !!}
		  	</label>
			<div class="col-sm-12">
				<input type="password" name="password_confirmation" placeholder="Re-Type password" class="form-control">
			</div>
		</div>

		<div class="form-group">
      		<label for="email" class="container control-label">Email
        		{!! $errors->first('email','<span class="help-block text-danger">*:message</span>') !!}
      		</label>
			<div class="col-sm-12">
				<input type="email" name="email" placeholder="Email" value="{{old('email')}}" class="form-control">
			</div>
		</div>
		<div class="form-group">
      		<label for="usertype" class="container control-label">User Type
        		{!! $errors->first('user_type','<span class="help-block text-danger">*:message</span>') !!}
      		</label>
			<div class="col-sm-12">
				<select name="user_type">
					<option value="student" selected>Student</option>
					<option value="teacher">Teacher</option>
				</select>
			</div>
		</div>
		<div class="form-group" id="dynamic-field">
			<label for="nrp" class="container control-label">NRP</label>
			<div class="col-sm-12">
			<input type="text" name="nrp" placeholder="NRP" class="form-control">
			</div>

		</div>
		<hr>
		<div class="form-group">
			<div class="col-sm-12 col-sm-offset-3">
				<input type="submit" value="Register" class="btn btn-primary btn-block">
			</div>
		</div>
	</div>
	</form>
</div>

@endsection
