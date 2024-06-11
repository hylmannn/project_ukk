<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('CREATE TRIGGER update_stok_setelah_perubahan
        AFTER UPDATE ON barangmasuk
        FOR EACH ROW
        BEGIN
            DECLARE barang_stok INT;
            DECLARE qty_diffe INT;

            -- Ambil perbedaan qty_keluar baru dan lama
            SET qty_diffe = NEW.qty_masuk - OLD.qty_masuk;

            -- Ambil stok saat ini dari tabel barang
            SELECT stok INTO barang_stok FROM barang WHERE id = NEW.barang_id;

            -- Update stok di tabel barang
            UPDATE barang
            SET stok = barang_stok + qty_diffe
            WHERE id = NEW.barang_id;
        END
   '); }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_stok_setelah_perubahan');
    }
    };