<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">

		<title>{{ $title . ' | ' . config('app.name') }}</title>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		<link href="{{ asset('asset/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
	</head>

	<body>
		<div class="container py-5">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title"><h3>{{ strtoupper(config('app.name')) }}</h3></h3>
				</div>

				<div class="card-body">
					<div class="form-group">
						<button type="button" class="btn btn-primary" id="btnAdd">Tambah</button>
						<a href="{{ route('logout') }}" class="btn btn-link">Logout</a>
					</div>

					<div class="row">
						<div class="form-group col-lg-2">
							<select type="text" class="form-control">
								<option value="">-- Pilih Bulan --</option>
								<option value="1">Januari</option>
								<option value="2">Februari</option>
								<option value="3">Maret</option>
								<option value="4">April</option>
								<option value="5">Mei</option>
								<option value="6">Juni</option>
								<option value="7">Juli</option>
								<option value="8">Agustus</option>
								<option value="9">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
	
						<div class="form-group col-lg-2">
							<select type="text" class="form-control">
								<option value="">-- Pilih Tahun --</option>
								@for($i=2019; $i<=date('Y'); $i++)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</div>

						<div class="form-group col-lg-2">
							<select type="text" class="form-control">
								<option value="">-- Pilih Tipe --</option>
								<option value="1">Pemasukan</option>
								<option value="0">Pengeluaran</option>
							</select>
						</div>
	
						<div class="form-group col-lg-4">
							<button class="btn btn-info">Filter</button>
							<button class="btn btn-success">Cetak</button>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table" width="100%" cellspacing="0" id="transactionTable">
							<thead>
								<tr>
									<th>No.</th>
									<th>Invoice</th>
									<th>Tanggal</th>
									<th>Judul</th>
									<th>Tipe</th>
									<th>Jumlah</th>
									<th>Aksi</th>
								</tr>
							</thead>

							<tbody>
							</tbody>
						</table>
					</div>

					<!-- Modal Add/Edit -->
					<div class="modal fade" id="transactionModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="modalTitle"></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<form id="transactionForm" method="post" enctype="multipart/form-data">
									@csrf

									<input type="hidden" name="transaction_id" id="transaction_id">

									<div class="modal-body">
										<div class="form-group">
											<label>Tanggal</label>
											<input type="date" name="date" id="date" class="form-control" placeholder="Tanggal">
											<span class="text-danger" id="date_error"></span>
										</div>

										<div class="form-group">
											<label>Tipe</label>
											<select name="type" id="type" class="form-control">
												<option value="">-- Pilih Tipe --</option>
												<option value="1">Pemasukan</option>
												<option value="0">Pengeluaran</option>
											</select>
											<span class="text-danger" id="type_error"></span>
										</div>

										<div class="form-group">
											<label>Judul</label>
											<input type="text" name="title" id="title" class="form-control" placeholder="Judul">
											<span class="text-danger" id="title_error"></span>
										</div>

										<div class="form-group">
											<label>Total (Rp.)</label>
											<input type="text" name="total" id="total" class="form-control" placeholder="Total">
											<span class="text-danger" id="total_error"></span>
										</div>

										<div class="form-group">
											<label>Invoice</label>
											<input type="file" name="invoice" id="invoice" class="form-control-file">
											<span class="text-danger" id="invoice_error"></span>
										</div>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
										<button type="submit" class="btn btn-primary" id="btnSave"></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<!-- Delete Confirmation -->
					<div class="modal fade" data-backdrop="static" data-keyboard="false" id="confirmModal" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-body">
									<div class="text-center my-3">
										<img src="{{ asset('asset/img/confirm-delete.svg') }}">
										<h5 class="my-3" style="color: #1f1f1f">Hapus Transaksi Ini?</h5>
										<button type="button" class="btn btn-secondary mr-1" id="btnNo" data-dismiss="modal"></button>
										<button type="submit" class="btn btn-danger ml-1" id="btnYes"></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="{{ asset('asset/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<script src="{{ asset('asset/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('asset/datatables/dataTables.bootstrap4.min.js') }}"></script>

		<script>
			$(document).ready(function () {
				// Datatables
				var table	=	$('#transactionTable').DataTable({
					processing: true,
					serverSide: true,

					ajax:{
						url: "{{ route('home') }}",
					},

					oLanguage: {
						sEmptyTable: 'Data Masih Kosong',
						sZeroRecords: 'Tidak Ada Data Yang Sesuai'
					},

					columns: [
						{
							data: 'DT_RowIndex',
							name: 'DT_RowIndex',
							orderable: false,
							searchable: false
						},
						{
							data: 'invoice',
							name: 'invoice'
						},
						{
							data: 'date',
							name: 'date'
						},
						{
							data: 'title',
							name: 'title'
						},
						{
							data: 'type',
							name: 'type'
						},
						{
							data: 'total',
							name: 'total'
						},
						{
							data: 'action',
							name: 'action',
							orderable: false,
							searchable: false
						},
					],

					columnDefs: [
						{
							targets: 0,
							className: 'text-center',
							width: '10%'
						},
						{
							targets: 1,
							className: 'text-center',
						},
						{
							targets: 2,
							width: '15%'
						},
						{
							targets: 3,
							width: '25%'
						},
						{
							targets: 4,
							width: '10%'
						},
						{
							targets: 5,
							width: '15%'
						},
						{
							targets: 6,
							className: 'text-center',
							width: '15%'
						}
					]
				});

				// Form modal add
				$('#btnAdd').click(function() {
					$('#modalTitle').text("Tambah Transaksi");
					$('#btnSave').text("Simpan");
					$('#transactionForm').trigger("reset");
					$('#transactionModal').modal("show");
				});

				// Form modal Edit
				$(document).on('click', '.btnEdit', function () {
					var url = '{{ route("transaction.show", ":id") }}';
					transaction_id = $(this).attr("id");

					$.ajax({
						url: url.replace(":id", transaction_id),
						dataType: "json",
						success: function (html) {
							$('#modalTitle').text("Edit Transaksi");
							$('#btnSave').text("Update");
							$('#transactionForm').trigger("reset");
							$('#transactionModal').modal("show");

							$('#transaction_id').val(html.data.id);
							$('#date').val(html.data.date);
							$('#type').val(html.data.type);
							$('#title').val(html.data.title);
							$('#total').val(html.data.total);
							$('#invoice').text(html.data.invoice);
						}
					});
				});

				// Submit data
				$('#transactionForm').on('submit', function (e) {
					e.preventDefault();

					if ($('#btnSave').text() == 'Simpan') {
						$('#date_error').text();
						$('#type_error').text();
						$('#title_error').text();
						$('#total_error').text();
						$('#invoice_error').text();

						$.ajax({
							url: "{{ route('transaction.store') }}",
							method: "POST",
							data: new FormData(this),
							contentType: false,
							cache: false,
							processData: false,
							dataType:"json",

							beforeSend: function() {
								$('#btnSave').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...');
							},

							success: function(res) {
								setTimeout(function() {
									$('#transactionForm')[0].reset();
									$('#transactionModal').modal('hide');
									$('#transactionTable').DataTable().ajax.reload();
								});

								toastr.options =
								{
									"closeButton" : true,
									"progressBar" : false,
									"preventDuplicates": true,
									"timeOut": "3000",
									"positionClass": "toast-top-center"
								}
								toastr.success(res.messages);
							},

							error: function(reject) {
								setTimeout(function() {
									$('#btnSave').text('Simpan');
									var response = $.parseJSON(reject.responseText);
									$.each(response.errors, function (key, val) {
										$('#' + key + "_error").text(val[0]);
										$('#' + key).addClass('is-invalid');
									});
								});
							}
						});
					}

					if ($('#btnSave').text() == 'Update') {
						$('#date_error').text();
						$('#type_error').text();
						$('#title_error').text();
						$('#total_error').text();
						$('#invoice_error').text();

						$.ajax({
							url: "{{ route('transaction.update') }}",
							method: "POST",
							data: new FormData(this),
							contentType: false,
							cache: false,
							processData: false,
							dataType:"json",

							beforeSend: function() {
								$('#btnSave').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...');
							},

							success: function(res) {
								setTimeout(function() {
									$('#transactionForm')[0].reset();
									$('#transactionModal').modal('hide');
									$('#transactionTable').DataTable().ajax.reload();
								});

								toastr.options =
								{
									"closeButton" : true,
									"progressBar" : false,
									"preventDuplicates": true,
									"timeOut": "3000",
									"positionClass": "toast-top-center"
								}
								toastr.success(res.messages);
							},

							error: function(reject) {
								setTimeout(function() {
									$('#btnSave').text('Simpan');
									var response = $.parseJSON(reject.responseText);
									$.each(response.errors, function (key, val) {
										$('#' + key + "_error").text(val[0]);
										$('#' + key).addClass('is-invalid');
									});
								});
							}
						});
					}
				});

				// Confirmation Delete
				var url	=	'{{ route("transaction.delete", ":id") }}';

				$(document).on('click', '.btnDelete', function () {
					transaction_id	=   $(this).attr('id');
					$('#btnNo').text("Batal");
					$('#btnYes').text("Ya, Hapus");
					$('#confirmModal').modal("show");
				});

				// Delete
				$('#btnYes').click(function () {
					$.ajax({
						url: url.replace(":id", transaction_id),
						beforeSend: function() {
								$('#btnYes').text('Menghapus...');
						},

						success: function (res) {
							setTimeout(function() {
								$('#confirmModal').modal('hide');
								$('#transactionTable').DataTable().ajax.reload();
							});

							toastr.options =
							{
								"closeButton" : true,
								"progressBar" : false,
								"preventDuplicates": true,
								"timeOut": "3000",
								"positionClass": "toast-top-center"
							}
							toastr.success(res.messages);
						}
					});
				});
			});
		</script>
	</body>
</html>