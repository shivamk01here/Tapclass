<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            // User requested cities
            ['name' => 'Lucknow', 'state' => 'Uttar Pradesh', 'latitude' => 26.8467, 'longitude' => 80.9462],
            ['name' => 'Gurgaon', 'state' => 'Haryana', 'latitude' => 28.4595, 'longitude' => 77.0266],
            ['name' => 'Delhi', 'state' => 'Delhi', 'latitude' => 28.7041, 'longitude' => 77.1025],
            ['name' => 'Noida', 'state' => 'Uttar Pradesh', 'latitude' => 28.5355, 'longitude' => 77.3910],
            ['name' => 'Gorakhpur', 'state' => 'Uttar Pradesh', 'latitude' => 26.7606, 'longitude' => 83.3732],
            
            // Major metro cities
            ['name' => 'Mumbai', 'state' => 'Maharashtra', 'latitude' => 19.0760, 'longitude' => 72.8777],
            ['name' => 'Bengaluru', 'state' => 'Karnataka', 'latitude' => 12.9716, 'longitude' => 77.5946],
            ['name' => 'Hyderabad', 'state' => 'Telangana', 'latitude' => 17.3850, 'longitude' => 78.4867],
            ['name' => 'Chennai', 'state' => 'Tamil Nadu', 'latitude' => 13.0827, 'longitude' => 80.2707],
            ['name' => 'Kolkata', 'state' => 'West Bengal', 'latitude' => 22.5726, 'longitude' => 88.3639],
            ['name' => 'Pune', 'state' => 'Maharashtra', 'latitude' => 18.5204, 'longitude' => 73.8567],
            ['name' => 'Ahmedabad', 'state' => 'Gujarat', 'latitude' => 23.0225, 'longitude' => 72.5714],
            
            // Other major cities
            ['name' => 'Jaipur', 'state' => 'Rajasthan', 'latitude' => 26.9124, 'longitude' => 75.7873],
            ['name' => 'Surat', 'state' => 'Gujarat', 'latitude' => 21.1702, 'longitude' => 72.8311],
            ['name' => 'Kanpur', 'state' => 'Uttar Pradesh', 'latitude' => 26.4499, 'longitude' => 80.3319],
            ['name' => 'Nagpur', 'state' => 'Maharashtra', 'latitude' => 21.1458, 'longitude' => 79.0882],
            ['name' => 'Indore', 'state' => 'Madhya Pradesh', 'latitude' => 22.7196, 'longitude' => 75.8577],
            ['name' => 'Thane', 'state' => 'Maharashtra', 'latitude' => 19.2183, 'longitude' => 72.9781],
            ['name' => 'Bhopal', 'state' => 'Madhya Pradesh', 'latitude' => 23.2599, 'longitude' => 77.4126],
            ['name' => 'Visakhapatnam', 'state' => 'Andhra Pradesh', 'latitude' => 17.6868, 'longitude' => 83.2185],
            ['name' => 'Patna', 'state' => 'Bihar', 'latitude' => 25.5941, 'longitude' => 85.1376],
            ['name' => 'Vadodara', 'state' => 'Gujarat', 'latitude' => 22.3072, 'longitude' => 73.1812],
            ['name' => 'Ghaziabad', 'state' => 'Uttar Pradesh', 'latitude' => 28.6692, 'longitude' => 77.4538],
            ['name' => 'Ludhiana', 'state' => 'Punjab', 'latitude' => 30.9010, 'longitude' => 75.8573],
            ['name' => 'Agra', 'state' => 'Uttar Pradesh', 'latitude' => 27.1767, 'longitude' => 78.0081],
            ['name' => 'Nashik', 'state' => 'Maharashtra', 'latitude' => 19.9975, 'longitude' => 73.7898],
            ['name' => 'Faridabad', 'state' => 'Haryana', 'latitude' => 28.4089, 'longitude' => 77.3178],
            ['name' => 'Meerut', 'state' => 'Uttar Pradesh', 'latitude' => 28.9845, 'longitude' => 77.7064],
            ['name' => 'Rajkot', 'state' => 'Gujarat', 'latitude' => 22.3039, 'longitude' => 70.8022],
            ['name' => 'Varanasi', 'state' => 'Uttar Pradesh', 'latitude' => 25.3176, 'longitude' => 82.9739],
            ['name' => 'Chandigarh', 'state' => 'Chandigarh', 'latitude' => 30.7333, 'longitude' => 76.7794],
            ['name' => 'Coimbatore', 'state' => 'Tamil Nadu', 'latitude' => 11.0168, 'longitude' => 76.9558],
            ['name' => 'Kochi', 'state' => 'Kerala', 'latitude' => 9.9312, 'longitude' => 76.2673],
            ['name' => 'Kota', 'state' => 'Rajasthan', 'latitude' => 25.2138, 'longitude' => 75.8648],
            ['name' => 'Mysore', 'state' => 'Karnataka', 'latitude' => 12.2958, 'longitude' => 76.6394],
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => $city['name'],
                'state' => $city['state'],
                'country' => 'India',
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
                'is_active' => true,
            ]);
        }
    }
}
