<?php
    include "../koneksi.php";

    if(isset($_POST['tambahmetode']))
    {
        $metode = $_POST['metode'];
        $norek = $_POST['norek'];
        $logo = $_POST['logo'];
        $an = $_POST['an'];

        $query = "INSERT INTO pembayaran (metode, norek, logo, an) VALUES ('$metode','$norek','$logo','$an')";
        $exec = mysqli_query($conn, $query);

        if($exec){
            echo "  <script>
                        alert('Metode Pembayaran berhasil Ditambahkan!');
                        document.location.href = 'kelolametode.php';
                    </script>";
        }
        else{
            echo "  <script>
                        alert('Metode Pembayaran Gagal Ditambahkan!');
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
                                        <h4 class="header-title">Tambah Metode</h4><br>
                                        <form action="" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label for="Nama Metode" class="col-form-label">Nama Metode</label>
                                                <input class="form-control" name="metode" type="text" require>
                                            </div>
                                            <div class="form-group">
                                                <label for="Nomor Rekening" class="col-form-label">Nomor Rekening</label>
                                                <input class="form-control" name="norek" type="text" require>
                                            </div>
                                            <div class="form-group">
                                                <label for="URL Logo" class="col-form-label">URL Logo</label>
                                                <input class="form-control" name="logo" type="text" require>
                                            </div>
                                            <div class="form-group">
                                                <label for="Atas Nama" class="col-form-label">Atas Nama</label>
                                                <input class="form-control" name="an" type="text" require>
                                            </div>

                                            <div class="modal-footer">
                                                <input name="tambahmetode" type="submit" class="btn btn-primary" value="Tambah">
                                            </div>   

                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>


<?php include "footer.php"; ?>