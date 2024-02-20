<?php
	include "header.php";
	include "../koneksi.php";

	$idorder = $_GET['id'];

	$uid = $_SESSION['id'];
	$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
	$fetc = mysqli_fetch_array($caricart);
	$orderidd = isset($fetc['orderid']) ? $fetc['orderid'] : null;
	$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
	$itungtrans2 = mysqli_fetch_assoc($itungtrans);
	$itungtrans3 = $itungtrans2['jumlahtrans'];

	if(isset($_POST["hapus"])){
		$kode = $_POST['idproduknya'];
		$q2 = mysqli_query($conn, "delete from detailorder where idproduk='$kode' and orderid='$orderidd'");
		if($q2){
			echo 
				"<script>
                alert('Pesanan berhasil dihapus!');
                document.location.href = 'cart.php';
                </script>";
		} else {
			echo 
				"<script>
                alert('Pesanan gagal dihapus!');
                document.location.href = 'cart.php';
                </script>";
		}
	}
?>
    <!-- END nav -->
	

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
            <h1 class="mb-0 bread">My Cart</h1>
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
						        <th>&nbsp;</th>
						        <th>Nama Produk</th>
						        <th>Harga</th>
						        <th>Quantity</th>
						        <th>Total</th>
						      </tr>
						    </thead>
						    <tbody>
							<?php 
								$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$idorder' and d.idproduk=p.idproduk order by d.idproduk ASC");
								while($b=mysqli_fetch_array($brg)){
							?>

						      <tr class="text-center">
						        
						        <td class="image-prod"><div class="img"  style="background-image:url(../produk/<?php echo $b['gambar']?>)"></div></td>
						        
						        <td class="product-name">
						        	<h3><?php echo $b['namaproduk']?></h3>
						        </td>
						        
						        <td class="price">Rp.<?php echo number_format($b['hargaafter'])?></td>
						        
						        <td class="quantity">
						        	<div class="input-group mb-3">
					             	<input type="number" name="quantity" class="form-control" value="<?php echo $b['qty']?>" readonly>
					          	</div>
					          </td>
						        
						        <td class="total">Rp.<?php $totalharga = $b['hargaafter']*$b['qty']?><?= $totalharga?></td>
						      </tr><!-- END TR-->
							<?php
								}
							?>
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
    		<div class="row justify-content-end">
    			<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
						<?php
							$barang = mysqli_query($conn, "SELECT * FROM detailorder d, produk p WHERE orderid='$idorder' AND d.idproduk=p.idproduk ORDER BY d.idproduk ASC");
							$totalharga1 = 10000;
							while($b=mysqli_fetch_array($barang)){
								$harga = $b['hargaafter'];
								$qtyy = $b['qty'];
								$totalsemua = $harga*$qtyy;
								$totalharga1+=$totalsemua;
							}
						?>
						<h3>Cart Totals</h3>
    					<p class="d-flex">
    						<span>Subtotal</span>
    						<span>Rp.&nbsp;<?php echo number_format($totalharga1-10000)?></span>
    					<p class="d-flex">
    						<span>Delivery</span>
    						<span>Rp.&nbsp;<?php echo number_format(10000)?></span>
    					</p>
    					<hr>
    					<p class="d-flex total-price">
    						<span>Total</span>
    						<span>Rp.&nbsp;<?php echo number_format($totalharga1)?></span>
    					</p>
    				</div>
    				<p><a href="daftarorder.php" class="btn btn-primary btn-block py-3 px-4">Kembali ke Daftar Order</a></p>
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

<?php include"footer.php"; ?>