@extends('template.index')

@section('main')
	<section class="flex-grow-1 d-flex align-items-center">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-sm-8 col-md-6 offset-sm-2 offset-md-3">
					{{ $form->view() }}
				</div>
			</div>
		</div>
	</section>
@endsection
