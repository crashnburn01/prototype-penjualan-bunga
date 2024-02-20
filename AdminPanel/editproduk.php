<?php 
    include "../koneksi.php";

    $idproduk = $_GET["idproduk"];
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk = $idproduk");
    $p = mysqli_fetch_array($query);

    if(isset($_POST["ubahproduk"]))
    {
        $id_produk  = $_POST['idproduk'];
        $namaproduk = $_POST['namaproduk'];
        $idkategori = $_POST['idkategori'];
        $deskripsi = $_POST['deskripsi'];
        $stok = $_POST['stok'];
        $rate = $_POST['rate'];
        $hargaproduk = $_POST['hargaproduk'];
        $gambarlama = $_POST['gambarlama'];

        if($_FILES['gambar']['error'] === 4){
            $gambar = $gambarlama;
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
                $gambar = uniqid();
                $gambar .= '.'.$imageext;

                move_uploaded_file($tmpnama, '../produk/'.$gambar);
            }
        }
        $query = "UPDATE produk SET
                    idkategori = '$idkategori',
                    namaproduk = '$namaproduk',
                    gambar = '$gambar', 
                    deskripsi = '$deskripsi',
                    rate = '$rate',
                    hargaafter = '$hargaproduk',
                    stok = '$stok'
                WHERE idproduk = $id_produk;
        ";

        $execute = mysqli_query($conn, $query);

        if($execute){
            echo "  <script>
                        alert('Produk berhasil Diubah!');
                        document.location.href = 'kelolaproduk.php';
                    </script>";
        } else{
            echo "  <script>
                        alert('Produk gagal Diubah!');
                        document.location.href = 'kelolaproduk.php';
                    </script>";
        }
    }


    include "header.php";
?>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Edit Produk</h4><br>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div>
                                                <input type="hidden" name="idproduk" value="<?= $p["idproduk"];?>">
                                                <input type="hidden" name="gambarlama" value="<?= $p["gambar"];?>">    
                                            </div>

                                            <div class="form-group">
                                                <label for="Nama Produk" class="col-form-label">Nama Produk</label>
                                                <input class="form-control" name="namaproduk" type="text" value="<?= $p["namaproduk"]?>" require>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Kategori</label>
                                                <select class="custom-select" name="idkategori">
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
                                                <input class="form-control" name="deskripsi" rows="4" value="<?= $p["deskripsi"]?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah Stok</label>
                                                <input name="stok" type="number" class="form-control" value="<?= $p["stok"]?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Rating Produk</label>
                                                <input name="rate" type="number" class="form-control" min="1" max="5" value="<?= $p["rate"]?>" require>
                                            </div>
                                            <div class="form-group">
                                                <label>Harga Produk</label>
                                                <input name="hargaproduk" type="number" class="form-control" value="<?= $p["hargaafter"]?>">
                                            </div>

                                            <div class="form-group">
                                                <label>Gambar Produk</label>
                                                <input name="gambar" type="file" class="form-control">
                                            </div>

                                            <div class="modal-footer">
                                                <input name="ubahproduk" type="submit" class="btn btn-primary" value="Ubah">
                                            </div>   

                                        </form>

                                        <br><br>
                                            <label">Gambar :</label>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div>
                                                        <br>
                                                        <img src="../produk/<?= $p['gambar']; ?>" width="280"><br>
                                                    </div>                                                                    
                                                 </form> 
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>


<?php include "footer.php"; ?>