<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity'
    ];

    // jumlah kursi per baris (A1-A10, B1-B10, dst). Sesuaikan dengan seeder kursi kamu
const SEATS_PER_ROW = 10;

public function seats()
{
    return $this->hasMany(Seat::class);
}

// bikin daftar nama kursi berdasarkan kapasitas: A1, A2, ... A10, B1, ...
public static function seatNamesFor(int $capacity): array
{
    $names = [];
    for ($i = 0; $i < $capacity; $i++) {
        $names[] = chr(65 + intdiv($i, self::SEATS_PER_ROW)) . (($i % self::SEATS_PER_ROW) + 1);
    }
    return $names;
}

// samakan isi tabel seats dengan kapasitas studio saat ini
    public function syncSeats(): void
    {
        $wanted   = self::seatNamesFor($this->capacity);
        $existing = $this->seats()->pluck('seat_name')->toArray();

        DB::transaction(function () use ($wanted, $existing) {
            // hapus kursi yang kelebihan (kapasitas dikurangi)
            $this->seats()->whereNotIn('seat_name', $wanted)->delete();

            // tambah kursi yang belum ada (studio baru / kapasitas ditambah)
            foreach (array_diff($wanted, $existing) as $name) {
                $this->seats()->create(['seat_name' => $name]);
            }
        });
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

}
