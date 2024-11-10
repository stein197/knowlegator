<form class="mb-3" action="{{ $action }}" method="GET" enctype="multipart/form-data">
	<div class="input-group">
		<input class="form-control" type="text" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}" required="" />
		<a class="btn btn-outline-primary" href="{{ $action }}">
			<i class="bi bi-x-lg color-inherit"></i>
		</a>
		<button class="btn btn-primary">
			<i class="bi bi-search color-inherit"></i>
		</button>
	</div>
</form>
