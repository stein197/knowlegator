@extends('template.menu')

@section('content')
	<x-alert type="danger" icon="exclamation-triangle-fill">{{ $message }}</x-alert>
	{{ $form->view() }}
@endsection
