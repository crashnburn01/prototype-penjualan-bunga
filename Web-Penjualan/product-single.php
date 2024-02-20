<?php
	include "header.php";
	require "coba.php";


	$idproduk = $_GET['idproduk'];

	if(isset($_POST['addprod'])){
		if(!isset($_SESSION['log'])){
			echo 
			"<script>
			alert('Harap Login Terlebih Dahulu!');
			document.location.href='../AdminPanel/login2.php';
			</script>
			";
		} else{
			$ui = $_SESSION['id'];
			$cek = mysqli_query($conn, "SELECT * FROM cart WHERE userid='$ui' AND status='Cart'");
			$liat = mysqli_num_rows($cek);
			$f = mysqli_fetch_array($cek);
			$orid = $f['orderid'];

			if($liat>0){
				$cekbrg = mysqli_query($conn, "SELECT * FROM detailorder WHERE idproduk='$idproduk' AND orderid='$orid'");
				$liatbrg = mysqli_num_rows($cekbrg);
				$brpbanyak = mysqli_fetch_array($cekbrg);
				$jmlh = isset($brpbanyak['qty']) ? $brpbanyak['qty'] : null;

				if($liatbrg>0){
					$i=1;
					$baru = $jmlh+$i;

					$updateaja = mysqli_query($conn, "UPDATE detailorder SET qty='$baru' WHERE orderid='$orid' AND idproduk='$idproduk'");

					if($updateaja){
						echo 
						"<script>
        	            alert('Barang sudah pernah dimasukkan ke keranjang, jumlah akan ditambahkan');
        	            document.location.href = 'product-single.php?idproduk=".$idproduk."';
        	        </script>";
					} else{
						echo 
						"<script>
        	            alert('Gagal menambahkan ke keranjang');
        	            document.location.href = 'product-single.php?idproduk=".$idproduk."';
        	        </script>";
					}
				} else{
					$tambahdata = mysqli_query($conn, "INSERT INTO detailorder (orderid, idproduk, qty) VALUES('$orid','$idproduk','1')");
					if($tambahdata){
						echo 
						"<script>
        	            alert('Berhasil menambahkan ke keranjang');
        	            document.location.href = 'product-single.php?idproduk=".$idproduk."';
        	        </script>";
					} else{
						echo 
						"<script>
        	            alert('Gagal menambahkan ke keranjang');
        	            document.location.href = 'product-single.php?idproduk=".$idproduk."';
        	        </script>";
					}
				}
			} else{
				$oi = crypt(rand(22,999),time());
				$bikincart = mysqli_query($conn, "INSERT INTO cart (orderid, userid) VALUES('$oi','$ui')");

				if($bikincart){
					$tambahuser = mysqli_query($conn, "INSERT INTO detailorder (orderid, idproduk, qty) VALUES('$oi','$idproduk','1')");
					if($tambahuser){
						echo 
						"<script>
        	            alert('Berhasil menambahkan ke keranjang');
        	            document.location.href = 'product-single.php?idproduk=".$idproduk."';
        	        </script>";
					} else{
						echo 
						"<script>
        	            alert('Gagal menambahkan ke keranjang');
        	            document.location.href = 'product-single.php?idproduk=".$idproduk."';
        	        </script>";
					}
				} else{
					echo "Gagal bikin cart";
				}
			}

		}
		
	}
?>
    <!-- END nav -->

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span class="mr-2"><a href="shop.php">Product</a></span> <span>Product Single</span></p>
            <h1 class="mb-0 bread">Product Single</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row">

				<?php
					// Periksa apakah 'idproduk' tersedia di URL
					if (isset($_GET['idproduk'])) {
						$idproduk = $_GET['idproduk'];
						
							$barang = query("SELECT * FROM produk
								WHERE idproduk = $idproduk");
							if ($barang) {
								// Tampilkan informasi barang dan barang-barangnya
								$row = $barang[0]; // Ambil salah satu baris data
				?>

    			<div class="col-lg-6 mb-5 ftco-animate">
    				<a href="../produk/<?= $row["gambar"];?>" class="image-popup"><img src="../produk/<?= $row["gambar"];?>" width="390px" class="img-fluid" alt="Colorlib Template"></a>
    			</div>
    			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
    				<h3><?= $row["namaproduk"];?></h3>
    				<div class="rating d-flex">
							<p class="text-left mr-4">
								<a href="#" class="mr-2"><?= $row["rate"];?></a>
								<?php
								$bintang = '<i class="ion-ios-star-outline"></i>';
								$rate = $row['rate'];
								
								for($n=1;$n<=$rate;$n++){
								echo '<a href="#"><span class="ion-ios-star-outline"></span></a>';
								};
								?>
							</p>
							<p class="text-left">
								<a href="#" class="mr-2" style="color: #000;">Stok&nbsp;<span style="color: #bbb;"><?php echo $row["stok"]?></span></a>
							</p>
						</div>
    				<p class="price"><span>Rp.<?= number_format($row["hargaafter"], 0, ',', '.')?></span></p>
    				<p><?= $row["deskripsi"];?></p>
					<div class="row mt-4">
						<div class="col-md-6">
    						<p>
        						<?php if ($row["stok"] > 0): ?>
            						<form action="#" method="post">
                						<fieldset>
                    						<input type="hidden" name="idprod" value="<?php echo $idproduk ?>">
                    						<input type="submit" name="addprod" value="Add to cart" class="btn btn-black py-3 px-5">
                						</fieldset>
            						</form>
        						<?php else: ?>
            					<script>
                					alert("Stok Kosong");
            					</script>
            						<button class="btn btn-black py-3 px-5" disabled>Add to cart</button>
        						<?php endif; ?>
    						</p>
						</div>
    		</div>
    	</div>
	</section>

	<?php
        } else {
            echo "Transaksi dengan barang No $idproduk tidak ditemukan.";
        }
    } else {
        echo "Parameter id_barang tidak ditemukan dalam URL.";
    }
    ?>

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

<?php
	include "footer.php";
?> 