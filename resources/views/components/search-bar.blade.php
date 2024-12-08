<form class="mb-3" action="{{ $action }}" method="GET" enctype="multipart/form-data">
	<div class="input-group">
		<input class="form-control" type="text" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}" required="" />
		<x-button variant="outline-primary" class="color-inherit" icon="x-lg" href="{{ $action }}" />
		<x-button variant="primary" class="color-inherit" type="submit" icon="search" />
	</div>
</form>
