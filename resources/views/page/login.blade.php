@extends('template.index')

@section('main')
	<section class="flex-grow-1 d-flex align-items-center">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-sm-8 col-md-6 offset-sm-2 offset-md-3">
					<x-form
						action="{{ route('login', [], false) }}"
						method="POST"
						title="{{ __('form.login.title') }}"
						:fields="[
							'email' => [
								'label' => __('form.login.field.email'),
								'type' => 'email',
								'required' => true
							],
							'password' => [
								'label' => __('form.login.field.password'),
								'type' => 'password',
								'required' => true
							],
							'remember' => [
								'label' => __('form.login.field.remember'),
								'type' => 'checkbox'
							]
						]"
						:buttons="[
							[
								'label' => __('form.login.button.login'),
								'type' => 'primary',
								'name' => 'action',
								'value' => 'login'
							],
							[
								'label' => __('form.login.button.register'),
								'type' => 'success',
								'name' => 'action',
								'value' => 'register'
							]
						]" />
				</div>
			</div>
		</div>
	</section>
@endsection
