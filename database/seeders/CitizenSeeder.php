<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Citizen;
use App\Models\Village;
use Faker\Factory as Faker;

class CitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $villages = Village::all();
        
        if ($villages->isEmpty()) {
            $this->command->warn('No villages found. Please run VillageSeeder first.');
            return;
        }

        $religions = ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu'];
        $maritalStatuses = ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati'];
        $educations = ['tidak_sekolah', 'sd', 'smp', 'sma', 'diploma', 'sarjana', 'magister', 'doktor'];
        $occupations = ['petani', 'pedagang', 'pegawai_negeri', 'pegawai_swasta', 'wiraswasta', 'buruh', 'guru', 'dokter', 'bidan', 'polisi', 'tentara', 'pensiunan', 'ibu_rumah_tangga', 'pelajar', 'mahasiswa'];

        // Generate citizens for each village
        foreach ($villages as $village) {
            $citizenCount = rand(200, 500); // Random number of citizens per village
            
            for ($i = 0; $i < $citizenCount; $i++) {
                $gender = $faker->randomElement(['L', 'P']);
                $birthDate = $faker->dateTimeBetween('-80 years', '-1 year');
                $age = (new \DateTime())->diff($birthDate)->y;
                
                // Determine marital status based on age
                if ($age < 17) {
                    $maritalStatus = 'belum_kawin';
                } else {
                    $maritalStatus = $faker->randomElement($maritalStatuses);
                }
                
                // Determine education based on age
                if ($age < 6) {
                    $education = 'tidak_sekolah';
                } elseif ($age < 12) {
                    $education = $faker->randomElement(['tidak_sekolah', 'sd']);
                } elseif ($age < 15) {
                    $education = $faker->randomElement(['sd', 'smp']);
                } elseif ($age < 18) {
                    $education = $faker->randomElement(['smp', 'sma']);
                } else {
                    $education = $faker->randomElement($educations);
                }
                
                // Determine occupation based on age and education
                if ($age < 6) {
                    $occupation = 'balita';
                } elseif ($age < 18) {
                    $occupation = 'pelajar';
                } elseif ($age >= 60) {
                    $occupation = $faker->randomElement(['pensiunan', 'petani', 'pedagang']);
                } else {
                    $occupation = $faker->randomElement($occupations);
                }

                Citizen::create([
                    'nik' => $faker->unique()->numerify('##########'),
                    'kk_number' => $faker->numerify('################'),
                    'name' => $faker->name($gender === 'L' ? 'male' : 'female'),
                    'birth_date' => $birthDate,
                    'birth_place' => $faker->city(),
                    'gender' => $gender,
                    'religion' => $faker->randomElement($religions),
                    'marital_status' => $maritalStatus,
                    'occupation' => $occupation,
                    'education' => $education,
                    'address' => $faker->streetAddress(),
                    'village_id' => $village->id,
                    'rt' => $faker->numberBetween(1, 20),
                    'rw' => $faker->numberBetween(1, 10),
                    'postal_code' => $faker->postcode(),
                    'phone' => $faker->optional(0.7)->phoneNumber(),
                    'email' => $faker->optional(0.3)->email(),
                    'family_members' => $faker->optional(0.5)->numberBetween(1, 6),
                    'is_active' => $faker->boolean(95), // 95% active
                ]);
            }
        }
        
        $this->command->info('Citizens seeded successfully!');
    }
}
