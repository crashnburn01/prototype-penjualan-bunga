<?php
    include "../koneksi.php";

    if(isset($_POST['tambahkategori']))
    {
        $namakategori = $_POST['namakategori'];
        $tambahkat = mysqli_query($conn,"INSERT INTO kategori (namakategori) VALUES ('$namakategori')");
        if($tambahkat){
            echo "  <script>
                        alert('Kategori berhasil Ditambahkan!');
                        document.location.href = 'kategori.php';
                    </script>";
        }
        else{
            echo "  <script>
                        alert('Data Gagal Ditambahkan!');
                        document.location.href = 'kategori.php';
                    </script>";
        }
    };
    

    include "header.php";

?>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Tambah Kategori</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <input name="namakategori" type="text" class="form-control">
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <input name="tambahkategori" type="submit" class="btn btn-primary" value="Tambah">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>

<?php include "footer.php"; ?>