<?php
	include "header.php";
	include "../koneksi.php";

	$idorder = $_GET['id'];

	if(isset($_POST['confirm'])){
		$userid = $_SESSION['id'];
		$veriv = mysqli_query($conn, "SELECT * FROM cart WHERE orderid='$idorder'");
		$fetch = mysqli_fetch_array($veriv);
		$liat = mysqli_num_rows($veriv);

		if($fetch>0){
			$nama = $_POST['nama'];
			$metode = $_POST['metode'];
			$tanggal = $_POST['tanggal'];

			$konfirmasi = mysqli_query($conn, "INSERT INTO konfirmasi (orderid, userid, payment, namarekening, tglbayar)
			VALUES ('$idorder','$userid','$metode','$nama','$tanggal')");

			if($konfirmasi){
				$update = mysqli_query($conn, "UPDATE cart SET status='Confirmed' WHERE orderid='$idorder'");
				
				echo 
				"<script>
                alert('Tim akan memverifikasi pesanan anda');
                document.location.href = 'daftarorder.php';
                </script>";
			} else{
				echo 
				"<script>
                alert('Gagal Submit, Ulangi lagi!');
                document.location.href = 'daftarorder.php';
                </script>";
			}
		} else{
			echo 
				"<script>
                alert('Kode Order tidak ditemukan! Harap masukan dengan benar');
                document.location.href = 'daftarorder.php';
                </script>";
		}
	}

?>
    <!-- END nav -->

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Pembayaran</span></p>
            <h1 class="mb-0 bread">Konfirmasi Pembayaran</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-7 ftco-animate">
			
			<form method="post" class="billing-form">
	          	<div class="row align-items-end">
	          		<div class="col-md-12">
	                	<div class="form-group">
	                		<label for="firstname">Kode Orderan</label>
							<strong>
								<input type="text" class="form-control" name="orderid" value="<?php echo $idorder?>" disabled>
							</strong>
	                	</div>
	              	</div>
					  <div class="col-md-12">
	                	<div class="form-group">
	                		<label for="firstname">Nama Pemilik Rekening / Sumber Dana</label>
	                  		<input type="text" class="form-control" name="nama" required>
	                	</div>
	              	</div>
		            <div class="w-100"></div>
		            <div class="col-md-12">
		            	<div class="form-group">
	                		<label for="streetaddress">Rekening Tujuan</label>
	                  		<select name="metode" class="form-control">
								<?php
									$metode = mysqli_query($conn, "SELECT * FROM pembayaran");
									while($a=mysqli_fetch_array($metode)){
								?>
									<option value="<?php echo $a['metode']?>"><?php echo $a['metode']?>&nbsp;|&nbsp;<?php echo $a['norek']?></option>
								<?php		
									}
								?>
							</select>
	                	</div>
		            </div>
		            
		            <div class="w-100"></div>
		            	<div class="col-md-12">
	                		<div class="form-group">
	                			<label for="tanggalbayar">Tanggal Bayar</label>
	                  			<input type="date" class="form-control" name="tanggal">
	                		</div>
	              		</div>
					
					<div class="w-100"></div>
		            	<div class="col-md-12">
	                		<div class="form-group">
								<label for="submittt">&nbsp;&nbsp;</label>
								<input type="submit" name="confirm" value="Kirim Pembayaran" class="btn btn-primary btn-block py-3 px-4">
	                		</div>
	              		</div>		
	          </form><!-- END -->
			</div>
			 <!-- .col-md-8 -->
        </div>
      </div>
    </section> <!-- .section -->

	<script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		            
		            $('#quantity').val(quantity + 1);

		          
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });
		    
		});
	</script>

<?php include"footer.php"; ?>