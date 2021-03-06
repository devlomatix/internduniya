@extends('client.pages.student.layout')



@section('main_content')

<div class="col-lg-10 column">
	<div class="padding-left">
		<div class="manage-jobs-sec addscroll">
			<h3>Create Resume</h3>
			

            <div class="profile-form-edit">
                <form method="post" action="{{route('company.profile.update')}}" enctype="multipart/form-data">
                    @csrf

                    @if (session('message'))
                    <div class="alert alert-primary alert-dismissible fade show mt-2" role="alert">
                        <strong>Wola ! </strong> {{ session('message') }}
                        <button type="button" class="close alert_close_button" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        
                        
                        

                        <div class="col-lg-12 mb-4 mt-4">
                            <button type="submit">Update Profile</button>
                        </div>

                    </div>
                </form>
            </div>
		</div>
	</div>
</div>


@endsection