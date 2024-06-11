<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    DB::unprepared('
        CREATE TRIGGER kurangi_stok_setelah_keluar
        AFTER INSERT ON barangkeluar
        FOR EACH ROW
        BEGIN
            DECLARE barang_stok INT;

            -- Ambil stok saat ini dari tabel barang
            SELECT stok INTO barang_stok FROM barang WHERE id = NEW.barang_id;

            -- Update stok di tabel barang
            UPDATE barang
            SET stok = barang_stok - NEW.qty_keluar
            WHERE id = NEW.barang_id;
        END
    ');

    DB::unprepared('
        CREATE TRIGGER update_stok_setelah_perubahan_qty
        AFTER UPDATE ON barangkeluar
        FOR EACH ROW
        BEGIN
            DECLARE barang_stok INT;
            DECLARE qty_diff INT;

            -- Ambil perbedaan qty_keluar baru dan lama
            SET qty_diff = NEW.qty_keluar - OLD.qty_keluar;

            -- Ambil stok saat ini dari tabel barang
            SELECT stok INTO barang_stok FROM barang WHERE id = NEW.barang_id;

            -- Update stok di tabel barang
            UPDATE barang
            SET stok = barang_stok - qty_diff
            WHERE id = NEW.barang_id;
        END
    ');
}

public function down()
{
    DB::unprepared('DROP TRIGGER IF EXISTS kurangi_stok_setelah_keluar');
    DB::unprepared('DROP TRIGGER IF EXISTS update_stok_setelah_perubahan_qty');
}
};
