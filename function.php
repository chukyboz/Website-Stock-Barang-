<?php
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

//menambah barang baru 
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $addtotable = mysqli_query($conn, "INSERT into stock (namabarang, deskripsi, stock) values('$namabarang', '$deskripsi', '$stock')");
    if($addtotable){
        header('location:index.php');
    } else{
        echo 'gagal';
        header('location:index,php');
    }
};

//menambah barang masuk 
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "INSERT into masuk (idbarang, keterangan, qty) values('$barangnya', '$keterangan', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    } else{
        echo 'gagal';
        header('location:masuk.php');
    }
}
//menambahkan barang yang keluar
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtomasuk = mysqli_query($conn, "INSERT into keluar (idbarang, penerima, qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

    if($addtomasuk&&$updatestockmasuk){
        header('location:keluar.php');
    } else{
        echo 'gagal';
        header('location:keluar.php');
    }

}

//update BARANG DARI STOCK
if(isset($_POST['update'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stockupdate = $_POST['stok'];
    
    $update = mysqli_query($conn, "UPDATE stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");

    if($update){
        header('location:index.php');
    } else{
        echo 'gagal';
        header('location:index.php');
    }
}

//menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else{
        echo 'gagal';
        header('location:index.php');
    }
}


//menghapus barang masuk 
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");
    
    if($update&&$hapusdata){
        header('location:masuk.php');


    } else{
        header('location:masuk.php');
    }

}


//menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");
    
    if($update&&$hapusdata){
        header('location:keluar.php');


    } else{
        header('location:keluar.php');
    }

}

?>