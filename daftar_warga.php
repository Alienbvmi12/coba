	<?php
	include "structure/head.php";
	include "koneksi_db.php";

	?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data warga</h1>
                    <p class="mb-4">Halaman data warga untuk admin</p>
					<button class="btn btn-love m-1" data-toggle="modal" data-target="#myModal" onclick="resetVal(false);">Add data ++</button>
					<br>
					<?php
						if(isset($_SESSION['konfirm'])){
							if($_SESSION['konfirm'] == true){
								if(isset($_SESSION['warning'])){
									print '
									<script>swal({
									  title: "Success!",
									  text: "'.$_SESSION["message"].'",
									  icon: "success",
									  button: "Ok"
									}).then(value => {
										swal({
										  title: "Warning!",
										  text: "'.$_SESSION["warning"].'",
										  icon: "warning",
										  button: "Ok"
										});
									});
									</script>';
								}
								else{
									print '
									<script>swal({
									  title: "Success!",
									  text: "'.$_SESSION["message"].'",
									  icon: "success",
									  button: "Ok"
									});</script>';
								}
							}
							else{
								if(isset($_SESSION['warning'])){
									print '
									<script>swal({
									  title: "Fail!",
									  text: "'.$_SESSION["message"].'",
									  icon: "error",
									  button: "Ok"
									}).then(value => {
										swal({
										  title: "Warning!",
										  text: "'.$_SESSION["warning"].'",
										  icon: "warning",
										  button: "Ok"
										});
									});</script>';
								}
								else{
									print '
									<script>swal({
									  title: "Fail!",
									  text: "'.$_SESSION["message"].'",
									  icon: "error",
									  button: "Ok"
									});</script>';
								}
							}
							unset($_SESSION['konfirm']);
							unset($_SESSION['message']);
							unset($_SESSION['warning']);
						}
						
					?>
					
					<br>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold" style="color:hotpink">Table</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
											<th>No</th>
											<th>Foto</th>
											<th>Nik</th>
											<th>Nama</th>
											<th>TTL</th>
											<th>Agama</th>
											<th>Pekerjaan</th>
											<th>Alamat</th>
											<th>Telepon</th>
											<th>Email</th>
											<th>Aksi</th>
										</tr>
                                    </thead>
                                    <tfoot>
										<tr>
											<th>No</th>
											<th>Foto</th>
											<th>Nik</th>
											<th>Nama</th>
											<th>TTL</th>
											<th>Agama</th>
											<th>Pekerjaan</th>
											<th>Alamat</th>
											<th>Telepon</th>
											<th>Email</th>
											<th>Aksi</th>
										</tr>
                                    </tfoot>
                                    <tbody>
                                     <?php
										$sql = mysqli_query($koneksi, "select * from data_warga order by nama");
										$no = 1;
										while($data = mysqli_fetch_array($sql)){
											echo "
											<tr>
												<td>{$no}</td>
												<td><img src=\"../XI_PPLG-1/Daftar_warga/{$data['gambar']}\" width=\"60px\" data-toggle=\"modal\" data-target=\"#imgModal\" onclick=\"zooom('../XI_PPLG-1/Daftar_warga/".$data['gambar']."')\" style=\"cursor : pointer;\"></td>
												<td>{$data['nik']}</td>
												<td>{$data['nama']}</td>
												<td>{$data['ttl']}</td>
												<td>{$data['agama']}</td>
												<td>{$data['pekerjaan']}</td>
												<td>{$data['alamat']}</td>
												<td>{$data['telepon']}</td>
												<td>{$data['email']}</td>
												<td>
													<a class='badge badge-warning' data-toggle=\"modal\" data-target=\"#myModal\" onclick=\"resetVal(true, '".$data['nik']."');\">Edit</a>
													<a class='badge badge-danger' onclick=\"aletManis('proses.php?nik=".$data['nik']."&hapus=true', '".$data['nama']."')\">Hapus</a>
												</td>
											</tr>
											";
											$no++;
										}
										
										if(isset($_SESSION['img']) AND $_SESSION['delete'] == true){
											$file= $_SESSION['img'];
											$file= explode("/", $file);
											$file = end($file);
											if(file_exists(__DIR__."\\img\\".$file)){
												unlink(__DIR__."\\img\\".$file);
											}
											unset($_SESSION['img']);
											unset($_SESSION['delete']);
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-love" href="proses.php?logout=true">Logout</a>
                </div>
            </div>
        </div>
    </div>
	
	<!--form-->
	
	 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabela">Form</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
					<form class="needs-validation" id="core-form" action="proses.php" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Nik:</label>
									<input type="search" class="form-control" minlength="16" maxlength="16" name="nik" id="nik" oninput="verif('nik', 'cover')" required></td>
								</div>
								
								<div class="form-group">
									<label>Nama:</label>
									<textarea type="search" class="form-control" maxlength="50" name="nama" id="nama" required></textarea>
								</div>
								
								<div class="form-group">
									<label>Tempat/tanggal lahir:</label>
									<div class="input-group">
										<input type="search" name="ttl" id="ttl" class="form-control" maxlength="39" required><input class="form-control" type="date" name="ttl2" id="ttl2" required>
									</div>
								</div>
								
								<div class="form-group">
									<label>Agama:</label>
									<select name="agama" id="agama" class="form-control" required>
										<option value="">--pilih agama--</option>
										<option value="Islam">Islam</option>
										<option value="Protestan">Protestan</option>
										<option value="Katolik">Katolik</option>
										<option value="Hindu">Hindu</option>
										<option value="Buddha">Buddha</option>
										<option value="Konghucu">Konghucu</option>
										<option value="Lainnya">Lainnya</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								
								<div class="form-group">
									<label>Pekerjaan:</label>
									<input type="search" class="form-control" maxlength="30" name="pekerjaan" id="pekerjaan" required>
								</div>
								
								<div class="form-group">
									<label>Alamat:</label>
									<textarea name="alamat" id="alamat" class="form-control" maxlength="50" required></textarea>
								</div>
								
								<div class="form-group">
									<label>Telepon:</label>
									<input type="search" name="telepon" id="telepon" class="form-control" maxlength="13" id="telepon" oninput="verif('telepon', 'cover2')" required>
								</div>
								
								<div class="form-group">
									<label>Email:</label>
									<input type="email" class="form-control" name="email" id="email" maxlength="40" required>
								</div>
								
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Foto:</label><br>
									<button class="btn btn-love" type="button" style="" onclick="document.querySelector('#gambar').click();"> Select Photo</button>
									<input type="file" class="form-control" name="gambar" id="gambar" accept="image/*" style="display : none;" required>
								</div>
								<div style="height : 265px; overflow : auto;">
									<img src="" id="gambar-prev" style="width : 100%;">
								</div>
								<br>
								<br>
							</div>
						</div>
						<data id="cover"></data>
						<data id="cover2"></data>
						<data id="cover3"></data>
				</div>
                <div class="modal-footer">	
					<input type="hidden" name="nik-toedit" id="nik-toedit">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-love" id="submit" name="add">
				</form>
                </div>
            </div>
        </div>
    </div>
	
	<!--Zoom Image-->
	
	<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
					<div class="container">
						<img src="" style="width:100%" id="img-for-zoom">
					</div>
				</div>
				<div class="modal-footer">	
                    <button class="btn btn-secondary	" type="button" data-dismiss="modal">Close</button>
				</div>
            </div>
        </div>
    </div>
	

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
	
	<script>
		function verif(nik, cover){
			if(document.getElementById(nik).value.match(/[a-z]/i) || document.getElementById(nik).value.match(/[~`!#$%\^&*=\-\[\]\\;'._@,/{}|\\":<>\?()]/g)){
					
					document.getElementById(nik).value = document.getElementById(cover).value;
					
				}
				else{
					document.getElementById(cover).value = document.getElementById(nik).value;
				}
			}
			
			
			let upload = document.getElementById("gambar");
			let preview = document.getElementById("gambar-prev");
			
			upload.onchange = () => {
				const reader = new FileReader();
				reader.readAsDataURL(upload.files[0]);
				console.log(upload.files[0]);
				var ext = upload.value.split(".").pop();
				reader.onload = () => {
					preview.setAttribute("src", reader.result);
					preview.setAttribute("width", "200px");
					swal({
					title: "Info",
					text: "Image size : "+(upload.files[0].size / 1000)+" KB \n"
					+"Extension : "+ext+" \n"
					+"Resolution : "+preview.naturalWidth+" x "+preview.naturalHeight,
					icon: "info",
					button: "Ok"
				});
				}
			}
			
			function resetVal(type = true, nik = 0){
				if(type == true){
					var file = document.getElementById("gambar");
					file.value = file.defaultValue;
					console.log("run");
					 $.ajax({
						 method: 'post',
						 url: 'proses.php',
						 data: "nik="+nik+"&getubah=ok",
						 dataType : 'json',
						 success: function(data){
							 let ttl = data.ttl.split("/");
							 $('#nik').val(data.nik);
							 $('#nik-toedit').val(data.nik);
							 $('#nama').val(data.nama);
							 $('#ttl').val(ttl[0]);
							 $('#ttl2').val(ttl[1]);
							 $('#agama').val(data.agama);
							 $('#pekerjaan').val(data.pekerjaan);
							 $('#alamat').val(data.alamat);
							 $('#telepon').val(data.telepon);
							 $('#email').val(data.email);
							 document.getElementById("gambar-prev").src = "http://localhost:8080/XI_PPLG-1/Daftar_warga/"+data.gambar;
						 }
					 });
					document.querySelector("#submit").name = "edit";
					document.querySelector("#gambar").required = false;
					document.querySelector("#exampleModalLabela").innerHTML = "Edit";
				}
				else{
					document.querySelector("#submit").name = "add";
					document.querySelector("#gambar").required = true;
					$('#nik').val("");
					$('#nik-toedit').val("");
					$('#nama').val("");
					$('#ttl').val("");
					$('#ttl2').val("");
					$('#agama').val("");
					$('#pekerjaan').val("");
					$('#alamat').val("");
					$('#telepon').val("");
					$('#email').val("");
					document.getElementById("gambar-prev").src = "";
					document.querySelector("#exampleModalLabela").innerHTML = "Add";
				}
			}
			
			function zooom(link){
				document.getElementById("img-for-zoom").src = link;
			}
			
			function aletManis(link, tumbal){
				swal({
				  title: "Confirm",
				  text: "Are you sure to delete "+tumbal+"?",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
					window.location.href = link;
				  }
				});
			}
	</script>
	<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

	


</body>

</html>