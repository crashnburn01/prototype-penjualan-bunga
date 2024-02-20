<?php 
    include "../koneksi.php";

    if(isset($_POST["tambahproduk"]))
    {
        $namaproduk = $_POST['namaproduk'];
        $idkategori = $_POST['idkategori'];
        $deskripsi = $_POST['deskripsi'];
        $stok = $_POST['stok'];
        $rate = $_POST['rate'];
        $hargaproduk = $_POST['hargaproduk'];

        //Supaya bisa up gambar
        if($_FILES["gambar"]["error"] === 4){
            echo "<script>alert('Gambar tidak ada'); </script>";
        } else{
            $namafile = $_FILES["gambar"]["name"];
            $ukuranfile = $_FILES["gambar"]["size"];
            $tmpnama = $_FILES["gambar"]["tmp_name"];

            $validext = ['jpg','jpeg','png'];
            $imageext = explode('.', $namafile);
            $imageext = strtolower(end($imageext));
            
            if(!in_array($imageext, $validext)){
                echo "<script>alert('Invalid'); </script>";
            } else if($ukuranfile > 5000000){
                echo "<script>alert('Ukuran file terlalu besar'); </script>";
            }
            else{
                $newimagename = uniqid();
                $newimagename .= '.'.$imageext;

                move_uploaded_file($tmpnama, '../produk/'.$newimagename);
                $query = "INSERT INTO produk (idkategori, namaproduk, gambar, deskripsi, rate, hargaafter, stok)
                VALUES ('$idkategori','$namaproduk','$newimagename','$deskripsi','$rate','$hargaproduk','$stok')";
                mysqli_query($conn, $query);
                echo "
                <script>
                    alert('Data Berhasil Disimpan');
                    document.location.href = 'kelolaproduk.php';
                </script>";
            }
        }

    }

    include "header.php"; 
?>

            <div class="main-content-inner">
                <div class="row">

                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Produk</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="tambahproduk.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Nama Produk</label>
                                                <input name="namaproduk" type="text" class="form-control" required autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <select name="idkategori" class="custom-select">
                                                    <option selected>Pilih Kategori</option>
                                                    <?php
                                                    $kategori = mysqli_query($conn,"SELECT * FROM kategori ORDER BY namakategori ASC") or die(mysqli_error());
                                                    while($ktg = mysqli_fetch_array($kategori))
                                                    {
                                                    ?>
                                                    <option value="<?php echo $ktg['idkategori']?>"><?php echo $ktg['namakategori']?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi Produk</label>
                                                <textarea class="form-control" name="deskripsi" rows="4" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah Stok</label>
                                                <input class="form-control" type="number" name="stok" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Rating Produk</label>
                                                <input name="rate" type="number" class="form-control" min="1" max="5" required>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Harga Produk</label>
                                                <input name="hargaproduk" type="number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Gambar Produk</label>
                                                <input name="gambar" type="file" class="form-control">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <input name="tambahproduk" type="submit" class="btn btn-primary" value="Tambah">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

					

            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->

<?php include "footer.php"; ?>