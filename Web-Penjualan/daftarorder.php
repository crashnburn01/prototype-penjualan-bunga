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
	//$caricart = mysqli_query($conn, "SELECT * FROM cart WHERE userid='3' AND STATUS='Cart'");
	//$fetc = mysqli_fetch_array($caricart);
	//$orderidd = isset($fetc['orderid']) ? $fetc['orderid'] : null;


?>

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Order</span></p>
            <h1 class="mb-0 bread">Daftar Order</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>No.</th>
						        <th>Kode Order</th>
						        <th>Tanggal Order</th>
						        <th>Total</th>
						        <th>Status</th>
						      </tr>
						    </thead>

						    <tbody>
							<?php
								$brg = mysqli_query($conn, "SELECT DISTINCT(idcart), c.orderid, tglorder, status FROM cart c, detailorder d WHERE c.userid='$uid' AND d.orderid=c.orderid AND status!='Cart' ORDER BY tglorder DESC");
								$no=1;

								while($b=mysqli_fetch_array($brg)){

							?>
						      <tr class="rem1"><form method="post">
						        <td class="invert"><?php echo $no++ ?></td>
						        
						        <td class="price"><a href="order.php?id=<?php echo $b['orderid']?>"><?php echo $b['orderid']?></a></td>
						        
						        <td class="price"><?php echo $b['tglorder']?></td>
						        
						        <td class="price">
									Rp.<?php
											$ongkir = 10000;
											$ordid = $b['orderid'];
											$result1 = mysqli_query($conn, "SELECT SUM(qty*hargaafter)+$ongkir AS count FROM detailorder d, produk p WHERE d.orderid='$ordid' AND p.idproduk=d.idproduk ORDER BY d.idproduk ASC");
											$cekrow = mysqli_num_rows($result1);
											$row1 = mysqli_fetch_assoc($result1);
											$count = $row1['count'];
											if($cekrow>0){
												echo number_format($count);
											} else{
												echo 'No Data';
											}
										?>
								</td>

								<td class="invert">
									<div class="rem">
										<?php
											if($b['status']=='Payment'){
												echo
												'
												<a href="konfirmasi.php?id='.$b['orderid'].'" class="btn btn-black py-3 px-5">Konfirmasi Pembayaran</a>
												';
											} else if($b['status']=='Diproses'){
												echo 'Pesanan Diproses (Pembayaran Diterima)';
											} else if($b['status']=='Pengiriman'){
												echo 'Pesanan Dikirim';
											} else if($b['status']=='Selesai'){
												echo 'Pesanan Selesai';
											} else if($b['status']=='Dibatalkan'){
												echo 'Pesanan Dibatalkan';
											} else{
												echo 'Konfirmasi Diterima';
											}
										?>
										</form>
									</div>
									<script>
										$(document).ready(function(c ){
											$('.close1').on('click', function(c){
												$('.rem1').fadeOut('slow', function(c){
													$('.rem1').remove();
												});
											});
										});
									</script>
								</td>
						      </tr><!-- END TR-->
							  <?php
								} 
							  ?>
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
			</div>
		</section>

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

<?php include "footer.php"; ?>