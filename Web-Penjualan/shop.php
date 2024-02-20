<?php include "header.php"; 
	include "../koneksi.php";

	// Query untuk mengambil data kategori
	$sql = "SELECT idkategori, namakategori FROM kategori";
	$result = $conn->query($sql);

?>

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Products</span></p>
            <h1 class="mb-0 bread">Products</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
    	<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10 mb-5 text-center">
					<ul class="product-category">
						<li><a href="#" class="active">All</a></li>
						<?php
						// Memeriksa apakah query mengembalikan hasil
						if ($result->num_rows > 0) {
							// Menampilkan data kategori dalam list
							while ($row = $result->fetch_assoc()) {
								echo '<li><a href="#" data-category-id="' . $row["idkategori"] . '">' . $row["namakategori"] . '</a></li>';
							}
						}
						?>
					</ul>
				</div>
			</div>
    		<div class="row">

				<?php
				// Query untuk mengambil data produk
				$productSql = "SELECT idproduk, namaproduk, hargaafter, gambar FROM produk";
				$productResult = $conn->query($productSql);
				?>

				<?php
				if ($productResult->num_rows > 0) {
					while ($product = $productResult->fetch_assoc()) {
						?>
						<div class="col-md-6 col-lg-3 ftco-animate">
							<div class="product">
								<a href="product-single.php?idproduk=<?=$product["idproduk"];?>" class="img-prod"><img class="img-fluid" src="../produk/<?php echo $product["gambar"]; ?>" alt="<?php echo $product["namaproduk"]; ?>">
									<div class="overlay"></div>
								</a>
								<div class="text py-3 pb-4 px-3 text-center">
									<h3><a href="#"><?php echo $product["namaproduk"]; ?></a></h3>
									<div class="d-flex">
										<div class="pricing">
											<p class="price"><span>Rp.<?php echo $product["hargaafter"]; ?></span></p>
										</div>
									</div>
									<div class="bottom-area d-flex px-3">
										<div class="m-auto d-flex">
											<a href="product-single.php?idproduk=<?=$product["idproduk"];?>" class="add-to-cart d-flex justify-content-center align-items-center text-center">
												<span><i class="ion-ios-eye"></i></span>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
				} else {
					echo "Tidak ada produk yang ditemukan.";
				}
				?>


    		</div>
    	</div>
    </section>

	<script>
    $(document).ready(function () {
        // Saat sebuah kategori diklik
        $('.product-category a').on('click', function (e) {
            e.preventDefault();

            // Menghapus kelas aktif dari semua kategori
            $('.product-category a').removeClass('active');

            // Menambahkan kelas aktif ke kategori yang diklik
            $(this).addClass('active');

            // Dapatkan id kategori yang diklik
            var categoryId = $(this).data('category-id');

            // Lakukan apa pun yang diperlukan dengan id kategori, seperti mengirimnya ke server atau menampilkan produk sesuai dengan kategori
            console.log('Category ID:', idkategori);
        	});
    	});
	</script>


<?php include "footer.php"?>