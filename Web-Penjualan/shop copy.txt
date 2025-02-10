<?php 
include "header.php"; 
include "../koneksi.php";

// Query to fetch categories
$sql = "SELECT idkategori, namakategori FROM kategori";
$result = $conn->query($sql);

// Fetch all products
$productSql = "SELECT idproduk, namaproduk, hargaafter, gambar FROM produk";
$productResult = $conn->query($productSql);

// Store products in an array
$products = [];
if ($productResult->num_rows > 0) {
    while ($product = $productResult->fetch_assoc()) {
        $products[] = $product;
    }
}

// Function to compare product names for sorting
function compareByName($a, $b) {
    return strcasecmp($a['namaproduk'], $b['namaproduk']);
}

// Sort products by name
usort($products, 'compareByName');

// Binary search function
function binarySearch($array, $key) {
    $low = 0;
    $high = count($array) - 1;
    $key = strtolower($key);
    
    while ($low <= $high) {
        $mid = floor(($low + $high) / 2);
        $midVal = strtolower($array[$mid]['namaproduk']);
        
        if ($midVal == $key) {
            return $array[$mid];
        } elseif ($midVal < $key) {
            $low = $mid + 1;
        } else {
            $high = $mid - 1;
        }
    }
    return null;
}

// Check if search query is set
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$searchResult = null;
if ($searchQuery) {
    $searchResult = binarySearch($products, $searchQuery);
}
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
        <div class="row justify-content-center mb-5">
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 text-center">
                <form action="shop.php" method="get">
                    <input type="text" name="search" placeholder="Search for products..." class="form-control">
                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <?php
            if ($searchQuery && $searchResult) {
                // Display search result
                ?>
                <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="product">
                        <a href="product-single.php?idproduk=<?=$searchResult["idproduk"];?>" class="img-prod"><img class="img-fluid" src="../produk/<?php echo $searchResult["gambar"]; ?>" alt="<?php echo $searchResult["namaproduk"]; ?>">
                            <div class="overlay"></div>
                        </a>
                        <div class="text py-3 pb-4 px-3 text-center">
                            <h3><a href="product-single.php?idproduk=<?=$searchResult["idproduk"];?>"><?php echo $searchResult["namaproduk"]; ?></a></h3>
                            <div class="d-flex">
                                <div class="pricing">
                                    <p class="price"><span>Rp.<?php echo $searchResult["hargaafter"]; ?></span></p>
                                </div>
                            </div>
                            <div class="bottom-area d-flex px-3">
                                <div class="m-auto d-flex">
                                    <a href="product-single.php?idproduk=<?=$searchResult["idproduk"];?>" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                        <span><i class="ion-ios-eye"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else if ($searchQuery && !$searchResult) {
                // Display no result found message
                echo "<p class='text-center'>Product not found.</p>";
            } else {
                // Display all products
                foreach ($products as $product) {
                    ?>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="product">
                            <a href="product-single.php?idproduk=<?=$product["idproduk"];?>" class="img-prod"><img class="img-fluid" src="../produk/<?php echo $product["gambar"]; ?>" alt="<?php echo $product["namaproduk"]; ?>">
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="product-single.php?idproduk=<?=$product["idproduk"];?>"><?php echo $product["namaproduk"]; ?></a></h3>
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
        console.log('Category ID:', categoryId);
    });
});
</script>

<?php include "footer.php"; ?>
