<form action="{{ lroute('theme') }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<button class="reset d-flex align-items-center fs-6 cursor-pointer mx-2">
		<i class="bi bi-sun-fill"></i>
		<div class="form-check form-switch p-0 mb-0 mx-2 d-flex align-items-center">
			<input class="form-check-input cursor-pointer m-0 float-none pe-none" type="checkbox" @checked(app('theme')->dark()) />
		</div>
		<i class="bi bi-moon-fill"></i>
	</button>
</form>
