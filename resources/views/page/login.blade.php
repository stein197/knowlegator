@extends('template.index')

@section('main')
	<section class="flex-grow-1 d-flex align-items-center">
		<div class="container">
			<div class="row">
				<div class="col col-12 col-sm-8 col-md-6 offset-sm-2 offset-md-3">
					<x-form
						action="{{ lroute('login') }}"
						method="POST"
						title="{{ __('page.login.title') }}"
						:fields="[
							'email' => [
								'label' => __('form.field.email'),
								'type' => 'email',
								'required' => true
							],
							'password' => [
								'label' => __('form.field.password'),
								'type' => 'password',
								'required' => true
							],
							'remember' => [
								'label' => __('form.field.remember'),
								'type' => 'checkbox'
							]
						]"
						:buttons="[
							[
								'label' => __('form.button.login'),
								'type' => 'primary',
								'name' => 'action',
								'value' => 'login'
							],
							[
								'label' => __('form.button.register'),
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
