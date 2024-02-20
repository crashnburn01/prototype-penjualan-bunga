<?php 
    include "../koneksi.php";

    $no = $_GET["no"];
    $query = mysqli_query($conn, "SELECT * FROM pembayaran WHERE no = $no");
    $p = mysqli_fetch_array($query);

    if(isset($_POST["ubahmetode"]))
    {
        $no_metode  = $_POST['no'];
        $metode = $_POST['metode'];
        $norek = $_POST['norek'];
        $logo = $_POST['logo'];
        $an = $_POST['an'];

        $query = "UPDATE pembayaran SET
                    metode = '$metode',
                    norek = '$norek',
                    logo = '$logo',
                    an = '$an'
                WHERE no = $no_metode;
        ";

        $execute = mysqli_query($conn, $query);

        if($execute){
            echo "  <script>
                        alert('Metode Pembayaran berhasil Diubah!');
                        document.location.href = 'kelolametode.php';
                    </script>";
        } else{
            echo "  <script>
                        alert('Metode Pembayaran gagal Diubah!');
                        document.location.href = 'kelolametode.php';
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
                                        <h4 class="header-title">Edit Metode</h4><br>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div>
                                                <input type="hidden" name="no" value="<?= $p["no"];?>"> 
                                            </div>

                                            <div class="form-group">
                                                <label for="Nama Metode" class="col-form-label">Nama Metode</label>
                                                <input class="form-control" name="metode" type="text" value="<?= $p["metode"]?>" require>
                                            </div>
                                            <div class="form-group">
                                                <label for="No. Rek" class="col-form-label">Nomor Rekening</label>
                                                <input class="form-control" name="norek" type="text" value="<?= $p["norek"]?>" require>
                                            </div>
                                            <div class="form-group">
                                                <label for="Atas Nama" class="col-form-label">Atas Nama</label>
                                                <input class="form-control" name="an" type="text" value="<?= $p["an"]?>" require>
                                            </div>
                                            <div class="form-group">
                                                <label for="URL" class="col-form-label">URL Logo</label>
                                                <input class="form-control" name="logo" type="text" value="<?= $p["logo"]?>" require>
                                            </div>

                                            <div class="modal-footer">
                                                <input name="ubahmetode" type="submit" class="btn btn-primary" value="Ubah">
                                            </div>   

                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>


<?php include "footer.php"; ?>