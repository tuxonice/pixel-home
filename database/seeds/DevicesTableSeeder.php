<?php

use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    
    private $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker\Factory::create();
        
        for($i=1;$i<=10;$i++) {
            $record = $this->generateDevice();
            DB::table('devices')->insert($record);
        }
    }
    
    protected function generateDevice()
    {
        return [
                'name' => (rand(1,100) > 50 ? 'Shelly ': 'Arduino '). $this->faker->regexify('[A-Z0-9]{5}'),
                'location' => $this->faker->city,
                'code' => $this->faker->regexify('[A-Z0-9]{10}'),
                'active' => rand(1,100) > 20 ? 1 : 0
            ];
    }
}
