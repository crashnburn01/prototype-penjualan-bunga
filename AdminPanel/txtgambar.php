$namafile = $_FILES['uploadgambar']['name'];
        $ekstensi = pathinfo($namafile, PATHINFO_EXTENSION);
        $random = crypt($namafile, time());
        $ukuranfile = $_FILES['uploadgambar']['size'];
        $tipefile = $_FILES['uploadgambar']['type'];
        $tmp_file = $_FILES['uploadgambar']['tmp_name'];
        $path = "../produk/".$random.'.'.$ekstensi;
        $pathdb = "produk/".$random.'.'.$ekstensi;

        //memasukkan gambar ke db
        if($tipefile == "image/jpeg" || $tipefile == "image/png")
        {
            //ukuran file
            if($ukuranfile <= 5000000){
                if(move_uploaded_file($tmp_file, $path)){
                    $query = "INSERT INTO produk (idkategori, namaproduk, gambar, deskripsi, rate, hargaafter)
                    VALUES ('$idkategori','$namaproduk','$pathdb','$deskripsi','$rate','$hargaproduk')";

                    //Execute Query
                    $exc = mysqli_query($conn, $query);

                    if($exc){
                        //Data Berhasil Ditambahkan
                        echo "
                            <script>
                                alert('Data Berhasil Ditambahkan!');
                                document.location.href = 'kelolaproduk.php';
                            </script>";
                    } else{
                        //Data Gagal Ditambahkan
                        echo "
                            <script>
                                alert('Data Gagal Ditambahkan!');
                                document.location.href = 'kelolaproduk.php';
                            </script>";
                    }
                } else{
                    //Gambar Gagal Diupload
                    echo "
                        <script>
                            alert('Gambar Gagal Diupload!');
                            document.location.href = 'kelolaproduk.php';
                        </script>";
                }
            } else{
                //Jika ukuran gambar terlalu besar
                echo "
                    <script>
                        alert('Size gambar terlalu besar, harus dibawah 1MB!');
                        document.location.href = 'kelolaproduk.php';
                    </script>";
            }
        } else{
            //Jika tipe file bukan JPG/JPEG/PNG
            echo "
                <script>
                    alert('Gagal menyimpan, format Gambar Harus JPG/PNG!');
                </script>";
        }