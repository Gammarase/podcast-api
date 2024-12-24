<?php

namespace Database\Factories\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait HasFakeImages
{
    private function storeFakeImage(string $folderName = 'podcasts'): string
    {
        $fakeImage = UploadedFile::fake()->image(Str::uuid()->toString().'.jpg', 640, 480);

        return $fakeImage->store($folderName, 'public');
    }

    private function storeRandomColorImage(string $folderName = 'podcasts'): string
    {
        $width = 640;
        $height = 480;
        $fileName = Str::uuid().'.png';
        $filePath = storage_path('app/public/'.$folderName.DIRECTORY_SEPARATOR.$fileName);

        // Create a blank image
        $image = imagecreatetruecolor($width, $height);

        // Generate a random color
        $randomColor = imagecolorallocate(
            $image,
            rand(0, 255), // Red
            rand(0, 255), // Green
            rand(0, 255)  // Blue
        );

        // Fill the image with the random color
        imagefill($image, 0, 0, $randomColor);

        // Add text to the center
        $text = $this->getRandomPodcastPhrase(); // Random 6-letter text
        $fontPath = base_path('resources/fonts/imageFont.ttf'); // Path to your TTF font
        $fontSize = 24;
        $textColor = imagecolorallocate($image, 255, 255, 255); // White text

        // Calculate text position to center it
        $textBox = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth = $textBox[2] - $textBox[0];
        $textHeight = $textBox[1] - $textBox[7];
        $x = ($width - $textWidth) / 2;
        $y = ($height - $textHeight) / 2 + $textHeight;

        // Add text to the image
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);

        // Save the image as PNG
        imagepng($image, $filePath);

        // Free memory
        imagedestroy($image);

        // Return the storage URL
        return 'podcasts/'.$fileName;
    }

    private function getRandomPodcastPhrase(): string
    {
        $phrases = [
            // 🎧 Technology & Innovation
            'Tech Talks Weekly',
            'The Future of AI',
            'Innovation Insights',
            'Code & Coffee',
            'Silicon Valley Stories',
            'Startup Secrets',
            'Cyber Chronicles',
            'The Digital Frontier',
            'AI & You',
            'Blockchain Breakdown',

            // 📚 Education & Knowledge
            'Knowledge Nuggets',
            'Brain Boost',
            'Learn Something New',
            'The Smart Hour',
            'Deep Dive Discussions',
            'EduPod: Smart Learning',
            'Science Explained',
            'History Uncovered',
            'Quick Facts Daily',
            'Mind Matters',

            // 💼 Business & Finance
            'Business Blueprint',
            'Invest Wisely',
            'Money Matters',
            'The CEO Diaries',
            'Market Pulse',
            'Wealth Wizards',
            'Financial Freedom',
            'Startup Survival Guide',
            'The Business Brain',
            'Career Compass',

            // 🎭 Entertainment & Pop Culture
            'Pop Culture Unplugged',
            'Behind the Scenes',
            'Hollywood Headlines',
            'The Movie Lounge',
            'Series Spotlight',
            'Comic Conversations',
            'Fandom Files',
            'The Entertainment Edit',
            'Screen Time Stories',
            'Reel Talk',

            // 🧘 Health & Wellness
            'Health & Wellness Hour',
            'Fitness First',
            'Mental Health Matters',
            'Mindful Moments',
            'Wellness Weekly',
            'Nutrition Nation',
            'The Sleep Podcast',
            'Healthy Habits',
            'Yoga & Chill',
            'The Happiness Project',

            // 🕵️ True Crime & Mystery
            'True Crime Stories',
            'Unsolved Mysteries',
            'Cold Case Chronicles',
            'Dark Secrets',
            'Crime & Justice',
            'The Mystery Files',
            'Undercover Truths',
            'Shadow Stories',
            'Crime Scene Weekly',
            'Hidden Evidence',

            // 🎵 Music & Audio
            'Music Masters',
            'The Songwriters Lounge',
            'Beats & Beyond',
            'Soundwaves',
            'Behind the Music',
            'Vinyl Vibes',
            'Top Tracks Podcast',
            'Rhythm & Groove',
            'Music Unfiltered',
            'The DJ Diaries',

            // 🗺️ Travel & Adventure
            'Wanderlust Weekly',
            'Travel Tales',
            'The Explorer\'s Podcast',
            'Adventure Awaits',
            'Backpacking Diaries',
            'Globetrotter Stories',
            'Journey Beyond',
            'Off the Beaten Path',
            'Scenic Routes',
            'The Travel Lounge',

            // 💬 Personal Stories & Interviews
            'Inspiring Journeys',
            'Stories That Matter',
            'Life Unscripted',
            'Real People, Real Stories',
            'Interview Insights',
            'Voices of Change',
            'Heartfelt Conversations',
            'The Story Circle',
            'Life & Lessons',
            'Everyday Heroes',

            // 🌍 Society & Culture
            'Cultural Chronicles',
            'Voices of the World',
            'Community Corner',
            'Modern Perspectives',
            'Tradition & Today',
            'Global Gossip',
            'Life in the City',
            'Suburbia Stories',
            'Around the Globe',
            'Cultural Connect',

            // 🌟 Motivational & Self-Improvement
            'The Daily Dose',
            'Motivation Minute',
            'Powerful Perspectives',
            'Level Up Podcast',
            'Success Stories',
            'Achieve Your Goals',
            'Daily Motivation',
            'The Growth Mindset',
            'Positivity Podcast',
            'Dream Big, Act Bigger',

            // 🛋️ Casual & Fun
            'Late Night Laughs',
            'Coffee Table Talks',
            'Chill Chat Sessions',
            'Random Ramblings',
            'The Fun Zone',
            'Banter & Beans',
            'Laugh Out Loud',
            'Friends & Feels',
            'The Casual Cast',
            'Lighthearted Talks',

            // 🧠 Thought-Provoking
            'Deep Thinkers',
            'Question Everything',
            'Beyond the Surface',
            'Thought Experiments',
            'The Big Questions',
            'Mind Benders',
            'The Philosophers’ Den',
            'Reflections Podcast',
            'Ideas Worth Sharing',
            'The Think Tank',

            // 🚀 Science & Future
            'Future Trends Today',
            'The Science Sphere',
            'Space Explorers',
            'Physics Unplugged',
            'Tomorrow\'s World',
            'Innovation Hour',
            'Science Simplified',
            'Exploring the Unknown',
            'Beyond Earth',
            'Quantum Thoughts',

            // 🎮 Gaming & Tech Culture
            'Game On Podcast',
            'Level Up Lounge',
            'The Gaming Grid',
            'Esports Arena',
            'Pixelated Perspectives',
            'Player One Podcast',
            'Retro Gaming Talks',
            'Quest Complete',
            'The Loot Box',
            'Game Night Stories',

            // 📰 News & Current Affairs
            'Daily Briefing',
            'The Update Hour',
            'Morning Headlines',
            'News & Views',
            'World Today',
            'Breaking It Down',
            'The Roundup',
            'Insightful News',
            'The Big Story',
            'Weekly Recap',

            // 🐾 Niche & Hobbies
            'Pet Lovers Podcast',
            'Gardening Gurus',
            'Cooking Chronicles',
            'DIY Diaries',
            'Photography Focus',
            'Collector\'s Corner',
            'Crafting Hour',
            'Board Game Nights',
            'The Hobby Hub',
            'Knitting Stories',
        ];

        return $phrases[array_rand($phrases)];
    }
}
