@extends('template.menu')

@section('content')
	<x-alert callout type="info" icon="info-circle-fill">{{ $desc }}</x-alert>
@endsection
