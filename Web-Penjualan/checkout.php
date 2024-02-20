<?php
	include "header.php";
	include "../koneksi.php";

	if(!isset($_SESSION['log'])){
		echo 
		"<script>
		alert('Harap Login Terlebih Dahulu!');
		document.location.href='../AdminPanel/login2.php';
		</script>
		";
		//header('location:login.php');
	} else {
		
	};

	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = isset($fetc['orderid']) ? $fetc['orderid'] : null;
	$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];

	if(isset($_POST["checkout"])){
		$q3 = mysqli_query($conn, "UPDATE cart SET status='Payment' WHERE orderid='$orderidd'");
		if($q3){
			echo 
				"<script>
                alert('Checkout Berhasil!');
                document.location.href = 'index.php';
                </script>";
		} else{
			echo 
				"<script>
                alert('Checkout Gagal!');
                document.location.href = 'index.php';
                </script>";
		}
	}

?>
    <!-- END nav -->

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-7 ftco-animate">
			<form action="#" class="billing-form">
				<h3 class="mb-4 billing-heading">Billing Details</h3>
				<?php
					$brg1 = mysqli_query($conn, "SELECT * FROM login l, cart c WHERE l.userid='$uid' AND l.userid=c.userid ORDER BY l.userid ASC");
					$b = mysqli_fetch_array($brg1);

					
				?>

	          	<div class="row align-items-end">
	          		<div class="col-md-12">
	                	<div class="form-group">
	                		<label for="firstname">Kode Orderan</label>
	                  		<input type="text" class="form-control" value="<?php echo $orderidd?>" readonly>
	                	</div>
	              	</div>
					  <div class="col-md-12">
	                	<div class="form-group">
	                		<label for="firstname">Nama Pelanggan</label>
	                  		<input type="text" class="form-control" value="<?php echo $b['namalengkap']?>" readonly>
	                	</div>
	              	</div>
		            <div class="w-100"></div>
		            <div class="col-md-12">
		            	<div class="form-group">
	                		<label for="streetaddress">Alamat Lengkap</label>
	                  		<input type="text" class="form-control" value="<?php echo $b['alamat']?>" readonly>
	                	</div>
		            </div>

		            <div class="w-100"></div>
		            	<div class="col-md-12">
	                		<div class="form-group">
	                			<label for="phone">Nomor Telepon</label>
	                  			<input type="text" class="form-control" value="<?php echo $b['notelp']?>" readonly>
	                		</div>
	              		</div>
	              		
                	<div class="w-100"></div>
						<div class="col-md-12">
	                		<div class="form-group">
	                			<label for="emailaddress">Email</label>
	                  			<input type="text" class="form-control" value="<?php echo $b['email']?>" readonly>
	                		</div>
                		</div>

	            </div>
	          </form><!-- END -->
			  <?php
					
			  ?>
					</div>
					<div class="col-xl-5">
	          <div class="row mt-5 pt-3">
	          	<div class="col-md-12 d-flex mb-5">
	          		<div class="cart-detail cart-total p-3 p-md-4">

	          			<h3 class="billing-heading mb-4">Order ID:<p><b><?php echo $orderidd?></b></p></h3>
						  <?php
							$barang = mysqli_query($conn, "SELECT * FROM detailorder d, produk p WHERE orderid='$orderidd' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
							$totalharga1 = 0;
							$ongkir = 10000;
							while($b=mysqli_fetch_array($barang)){
								$harga = $b['hargaafter'];
								$qtyy = $b['qty'];
								$totalsemua = $harga*$qtyy;
								$totalharga1 += $totalsemua;
							}
						?>
	          			<p class="d-flex">
    						<span>Subtotal</span>
    						<span>Rp.&nbsp;<?php echo number_format($totalharga1)?></span>
    					<p class="d-flex">
    						<span>Delivery</span>
    						<span>Rp.&nbsp;<?php echo number_format($ongkir)?></span>
    					</p>
    					<hr>
    					<p class="d-flex total-price">
    						<span>Total</span>
    						<span>Rp.&nbsp;<?php $ttl = $totalharga1 += $ongkir?><?= number_format($ttl)?></span>
    					</p>
					</div>
	          	</div>
	          	<div class="col-md-12">
	          		<div class="cart-detail p-3 p-md-4">
	          			<h3 class="billing-heading mb-4">Payment Method</h3>
									<div class="form-group">
										<div class="col-md-12">
											<label><img src="../produk/metode/bca.jpg" alt="" width="30%"></label>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label><img src="../produk/metode/mandiri.jpg" alt="" width="35%"></label>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label><img src="../produk/metode/uangdana.png" alt="" width="35%"></label>
										</div>
									</div>
									
									<div class="form-group">
										<div class="col-md-12">
											<div class="checkbox">
											   <label><input type="checkbox" value="" class="mr-2"> I have read and accept the terms and conditions</label>
											</div>
										</div>
									</div>
									<form action="" method="post">
										<p><input type="submit" name="checkout" value="Place an Order" class="btn btn-primary py-3 px-4"></p>
									</form>
								</div>
	          	</div>
	          </div>
          </div> <!-- .col-md-8 -->
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