<?php 
 
namespace Database\Seeders; 
 
use App\Models\Seat; 
use App\Models\Studio; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder; 
 
class StudioSeeder extends Seeder 
{ 
    /** 
     * Run the database seeds. 
     */ 
    public function run(): void 
    { 
        $studios = [ 
            ['name' => 'Studio 1', 'capacity' => 70], 
            ['name' => 'Studio 2', 'capacity' => 60], 
            ['name' => 'Studio 3', 'capacity' => 60], 
        ]; 
 
        foreach ($studios as $data) { 
            $studio = Studio::create($data); //membuatnya ke dlm database, hslnya dsmpn ke studio id, agar bs digunakan utk buat kursi 
            $this->generateSeats($studio); //generateSeats() utk membuat kursi sesuai kapasitas studio 
        } 
    } 
 
    private function generateSeats(Studio $studio): void 
    { 
        $seatsPerRow = 10; //jumlah kursi maks dlm 1 baris 
        $rowCount = (int) ceil($studio->capacity / $seatsPerRow); //menghitung jumlah brs sesuai kapasitas  
        $remainingSeats = $studio->capacity; //menyimpan jumlh kursi yg hrs dibuat 
        for ($row = 0; $row < $rowCount; $row++) { //mengulang proses berdasarkan jmlh baris 
            $rowLetter = chr(65 + $row); //mngbh nmr brs jd hrf bsr 
            $seatsInThisRow = min($seatsPerRow, $remainingSeats); //mntkn jmlh krsi yg dibuat pd brs tsb, mmstkn kursi yg dibuat dn tdk mlbhi. jmlh krsi yg trsdia 
            for ($number = 1; $number <= $seatsInThisRow; $number++) {  //mnglng nmr krsi dr 1-jmlh krsi pd brs tsb 
                Seat::create([ 
                    'studio_id' => $studio->id, //mnghbngkn krsi dg stdio 
                    'seat_name' => $rowLetter . $number, //mmbt nmr krsi spt A1, A2, A3 dst 
                ]); 
            } 
 
            $remainingSeats -= $seatsInThisRow; //mngrngi jmlh krsi yg sdh dbwt dr jmlh krsi yg msh hrs dibwt 
        } 
    } 
}