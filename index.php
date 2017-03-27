<?php 
include_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="panel panel-primary">
						  <div class="panel-heading">
								<h3 class="panel-title">Tugas KCB (Representasi Algoritma Top Index Google)</h3>
						  </div>
						  <div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<form action="proses.php" method="POST" role="form" enctype="multipart/form-data">
											<div class="form-group">
												<label for="">FILE</label>
												<input type="file" name="file" class="form-control" id="" placeholder="Input field">
											</div>

												<button type="submit" class="btn btn-primary pull-right">Proses</button>
										</form>
									</div>
								</div><br>



								<div class="row">
									<div class="col-md-12">
										<div class="panel panel-danger">
											  <div class="panel-heading">
													<h3 class="panel-title">Daftar File</h3>
											  </div>
											  <div class="panel-body">
													<table class="table table-condensed table-hover">
														<thead>
															<tr>
																<th>Nama File</th>
																<th>Aksi</th>
															</tr>
														</thead>
														<?php 
												  		$data_file=resultset("SELECT * FROM file");
												  		foreach($data_file as $data){
												  		 ?>
												  		<tbody>
												  			<tr>
												  				<td><?php echo $data['nama_file'];?></td>
												  				<td><a type="button" href="view.php?id_file=<?php echo $data['id_file'];?>" class="btn btn-warning">Lihat</a></td>
												  			</tr>
												  		</tbody>
												  		<?php

												  		}?>
													</table>
											  </div>
										</div>
									</div>
								</div>
						  </div>
					</div>
				</div>
			</div>
		</div>
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>