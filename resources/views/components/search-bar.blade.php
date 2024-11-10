<form class="mb-3" action="{{ $action }}" method="GET" enctype="multipart/form-data">
	<div class="input-group">
		<input class="form-control" type="text" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}" required="" />
		<button class="btn btn-primary">
			<i class="bi bi-search color-inherit"></i>
		</button>
	</div>
</form>
