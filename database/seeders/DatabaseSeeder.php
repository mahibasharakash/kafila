<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GeneralSettings;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        User::firstOrCreate(
            [
                'name' => 'Admin User',
                'email' => 'admin@kafila.com',
                'password' => bcrypt('12345678!@'),
                'phone' => '01400125289',
                'address' => 'Jessore Sadar, Jessore, Bangladesh',
                'user_type' => 'Admin',
                'email_verified_at' => now(),
                'verification_code' => null,
                'reset_code' => null,
            ]
        );

        GeneralSettings::updateOrCreate(
            [
                'id' => null,
                'logo_file_path' => null,
                'logo_name' => 'kafila',
                'short_description' => "At kafila, we bring you a curated selection of high-quality furniture that blends style, comfort, and functionality. From modern minimalism to classic charm, our pieces are designed to complement every taste and transform any space into a home you'll love.",
                'long_description' => "We believe furniture should be more than just beautiful — it should be durable, practical, and made to last. Every item in our collection is thoughtfully crafted with premium materials to ensure long-lasting use and timeless appeal. Discover the perfect balance of elegance and everyday comfort at Furnimal Store.",
                'location' => 'Mollapara, Bashtola, Jessore Sadar, Jessore, Bangladesh',
                'cover_file_path' => null,
                'breadcrumb_file_path' => null,
                'times' => [
                    ['working_time' => 'Mon-Fri: 9am - 5pm | first Shift'],
                    ['working_time' => 'Mon-Fri: 7pm - 11am | Second Shift'],
                ],
                'phone_numbers' => [
                    ['phone' => '01400125289'],
                    ['phone' => '01753036144'],
                ],
                'emails' => [
                    ['email' => 'kafilaInfo@gmail.com'],
                    ['email' => 'kafilaSupport@gmail.com'],
                ],
                'timelines' => [
                    [
                        'year' => '2025',
                        'timeline' => 'AR Furniture Placement Feature',
                        'short_description' => 'Integrated Augmented Reality (AR) into the website so users can visualize furniture in their space using mobile devices.',
                    ],
                    [
                        'year' => '2024',
                        'timeline' => 'Showroom Network Established',
                        'short_description' => 'Opened physical showrooms in three major cities to enhance customer experience and trust.',
                    ],
                    [
                        'year' => '2023',
                        'timeline' => 'Custom Furniture Designer Tool',
                        'short_description' => 'Released an online tool allowing customers to customize and visualize furniture before purchase.',
                    ],
                    [
                        'year' => '2022',
                        'timeline' => 'National Shipping Launched',
                        'short_description' => 'Expanded delivery services across the country with improved logistics and packaging solutions.',
                    ],
                    [
                        'year' => '2021',
                        'timeline' => 'Sustainable Materials Initiative',
                        'short_description' => 'Began using eco-friendly and sustainable materials in all furniture products, promoting green manufacturing.',
                    ],
                    [
                        'year' => '2020',
                        'timeline' => 'Expanded Product Line',
                        'short_description' => 'Introduced new product categories including sofas, dining sets, and office furniture to meet growing demand.',
                    ],
                    [
                        'year' => '2019',
                        'timeline' => 'First Online Store',
                        'short_description' => 'Developed and launched the first e-commerce website to reach customers beyond the local area.',
                    ],
                    [
                        'year' => '2018',
                        'timeline' => 'Company Founded',
                        'short_description' => 'Launched the furniture business with a focus on handcrafted wooden pieces, starting from a small local workshop.',
                    ]
                ],
                'slider_file_path' => null,
                'video_file_path' => null,
                'slider_small_title' => 'Home & Living',
                'slider_text_color' =>  '#ffffff',
                'slider_background_opacity' => 55,
                'slider_big_title' => 'Modern Comfort, Timeless Style',
                'slider_small_short_description' => "Transform your living space into the home of your dreams with inspiring ideas and curated products that blend style, comfort, and functionality. From cozy decor accents to innovative furniture and smart home solutions, discover everything you need to personalize your space and reflect your unique taste. Whether you're revamping a single room or undertaking a full makeover, the right touches can elevate any house into a haven of warmth and inspiration.",
            ]
        );

    }

}
