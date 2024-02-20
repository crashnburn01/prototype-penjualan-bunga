<?php 
    include "../koneksi.php";

    $idkategori = $_GET["idkategori"];
    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE idkategori = $idkategori");
    $p = mysqli_fetch_array($query);

    if(isset($_POST["ubahkategori"]))
    {
        $id_kategori  = $_POST['idkategori'];
        $namakategori = $_POST['namakategori'];

        $query = "UPDATE kategori SET
                    namakategori = '$namakategori'
                WHERE idkategori = $id_kategori;
        ";

        $execute = mysqli_query($conn, $query);

        if($execute){
            echo "  <script>
                        alert('Kategori berhasil Diubah!');
                        document.location.href = 'kategori.php';
                    </script>";
        } else{
            echo "  <script>
                        alert('Kategori gagal Diubah!');
                        document.location.href = 'kategori.php';
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
                                        <h4 class="header-title">Edit Kategori</h4><br>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div>
                                                <input type="hidden" name="idkategori" value="<?= $p["idkategori"];?>"> 
                                            </div>

                                            <div class="form-group">
                                                <label for="Nama Kategori" class="col-form-label">Nama Kategori</label>
                                                <input class="form-control" name="namakategori" type="text" value="<?= $p["namakategori"]?>" require>
                                            </div>

                                            <div class="modal-footer">
                                                <input name="ubahkategori" type="submit" class="btn btn-primary" value="Ubah">
                                            </div>   

                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>


<?php include "footer.php"; ?>