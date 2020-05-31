<?php

use Illuminate\Database\Seeder;
use App\PaymentType;
use App\Setting;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s = Setting::first();
        // subscribtion plans
        $paymentType1 = new PaymentType();
        $paymentType1->name = "Weekly Plan";
        $paymentType1->type = "subscribtion";
        $paymentType1->likes_per_day = 1000000;
        $paymentType1->super_likes_per_day = 5;
        $paymentType1->view_likes_per_day = 100000;
        $paymentType1->boost_minutes = 0;
        $paymentType1->number_of_days = 7;
        $paymentType1->price = 30;
        $paymentType1->short_desc = "See who Likes You, unlimited Likes, 5 Super Likes a day, Set advanced preferences, No ads";
        $paymentType1->long_desc = 
                                    "     Unlimited Likes\n" .
                                    "     ".$paymentType1->super_likes_per_day . "Super Likes a day\n". 
                                    "     See everyone who “liked” you in one view\n". 
                                    "     Unlock advanced preferences\n". 
                                    "     No ads\n\n\n\n".
                                    "Super likes: Want to let a potential match know they stand out? When Like is not enough, tap the star icon to send a Super Like! Your profile will appear in their cardstack with a bright gold color border and star, highlighting that you Super Liked them. If they Like you back, it’ll be an immediate match!\n\n"
                                    ."Unlimited Likes: The biggest advantage of being a member is the unlimited “likes.” Free users are limited to “liking” 10 profiles a day, which can get used up quickly if you live in an area with a ton of users.\n\n"
                                    ."See Who Liked You: As a Member, you can also see all the users at once who have already “liked” your profile. Without being a member, you can only view the profiles one at a time, making a “like” or “skip” decision as you go through them.\n\n"
                                    ."Advanced Preferences: These are additional filters you can use to pre-screen your matches. Without being a member, you’re limited to gender, location, age range, maximum distance, height, and religion. The Preferred Preferences allow you to screen more in-depth for bigger compatibility considerations, including Children, Family Plans, Education, Drinking, Smoking.\n\n"
                                    ."Our daily like limit for free users is pretty low, Upgrading is likely worth it just to avoid the frustration of having to wait until the next day for more.\n\n"
                                    ."If your profile gets a lot of action (and it will if you optimize your photos and prompt answers), being able to see who already expressed interest in one grid view is convenient, and potentially a huge time saver. You can start with the singles who interest you most, rather than deciding on one profile in order to see the next one, and so on.\n\n"
                                    ;
        $paymentType1->save();







        
        $paymentType2 = new PaymentType();
        $paymentType2->name = "Monthly Plan";
        $paymentType2->type = "subscribtion";
       
        $paymentType2->likes_per_day = 1000000;
        $paymentType2->super_likes_per_day = 5;
        $paymentType2->view_likes_per_day = 100000;
        $paymentType2->boost_minutes = 1;
        $paymentType2->number_of_days = 30;
        $paymentType2->price = 30;
        $paymentType2->long_desc = 
                                    "     ".$paymentType2->boost_minutes . " boost a month\n".
                                    "     Unlimited Likes \n" .
                                    "     Unlimited Likes\n" .
                                    "     ".$paymentType2->super_likes_per_day . "Super Likes a day\n". 
                                    "     See everyone who “liked” you in one view\n". 
                                    "     Unlock advanced preferences\n". 
                                    "     No ads\n\n\n\n"
                                    ."Boosts: makes your profile one of the top ones in your area for certain minutes. That means when local singles fire up the app, your profile will be one of the first ones they see. \n\n"                                    
                                    ."Super likes: Want to let a potential match know they stand out? When Like is not enough, tap the star icon to send a Super Like! Your profile will appear in their cardstack with a bright gold color border and star, highlighting that you Super Liked them. If they Like you back, it’ll be an immediate match!\n\n"
                                    ."Unlimited Likes: The biggest advantage of being a member is the unlimited “likes.” Free users are limited to “liking” 10 profiles a day, which can get used up quickly if you live in an area with a ton of users.\n\n"
                                    ."See Who Liked You: As a Member, you can also see all the users at once who have already “liked” your profile. Without being a member, you can only view the profiles one at a time, making a “like” or “skip” decision as you go through them.\n\n"
                                    ."Advanced Preferences: These are additional filters you can use to pre-screen your matches. Without being a member, you’re limited to gender, location, age range, maximum distance, height, and religion. The Preferred Preferences allow you to screen more in-depth for bigger compatibility considerations, including Children, Family Plans, Education, Drinking, Smoking.\n\n"
                                    ."Our daily like limit for free users is pretty low, Upgrading is likely worth it just to avoid the frustration of having to wait until the next day for more.\n\n"
                                    ."If your profile gets a lot of action (and it will if you optimize your photos and prompt answers), being able to see who already expressed interest in one grid view is convenient, and potentially a huge time saver. You can start with the singles who interest you most, rather than deciding on one profile in order to see the next one, and so on.\n\n"
                                    ;
        $paymentType2->short_desc = "See who Likes You, 1 Boost a month, unlimited Likes, 5 Super Likes a day, Set advanced preferences, No ads";
        $paymentType2->save();

        
        $paymentType3 = new PaymentType();
        $paymentType3->name = "3 Month Plan";
        $paymentType3->type = "subscribtion";
        $paymentType3->likes_per_day = 1000000;
        $paymentType3->super_likes_per_day = 5;
        $paymentType3->view_likes_per_day = 100000;
        $paymentType3->boost_minutes = 3;
        $paymentType3->number_of_days = 90;
        $paymentType3->price = 90;
        $paymentType3->short_desc = "See who Likes You, 1 Boost a month, unlimited Likes, 5 Super Likes a day, Set advanced preferences, No ads";
        $paymentType3->long_desc = 
                                    "     ".$paymentType3->boost_minutes . " boost a month\n".
                                    "     Unlimited Likes \n" .
                                    "     Unlimited Likes\n" .
                                    "     ".$paymentType3->super_likes_per_day . "Super Likes a day\n". 
                                    "     See everyone who “liked” you in one view\n". 
                                    "     Unlock advanced preferences\n". 
                                    "     No ads\n\n\n\n".
                                    "Boosts: makes your profile one of the top ones in your area for certain minutes. That means when local singles fire up the app, your profile will be one of the first ones they see. \n\n"                                    
                                    ."Super likes: Want to let a potential match know they stand out? When Like is not enough, tap the star icon to send a Super Like! Your profile will appear in their cardstack with a bright gold color border and star, highlighting that you Super Liked them. If they Like you back, it’ll be an immediate match!\n\n"
                                    ."Unlimited Likes: The biggest advantage of being a member is the unlimited “likes.” Free users are limited to “liking” 10 profiles a day, which can get used up quickly if you live in an area with a ton of users.\n\n"
                                    ."See Who Liked You: As a Member, you can also see all the users at once who have already “liked” your profile. Without being a member, you can only view the profiles one at a time, making a “like” or “skip” decision as you go through them.\n\n"
                                    ."Advanced Preferences: These are additional filters you can use to pre-screen your matches. Without being a member, you’re limited to gender, location, age range, maximum distance, height, and religion. The Preferred Preferences allow you to screen more in-depth for bigger compatibility considerations, including Children, Family Plans, Education, Drinking, Smoking.\n\n"
                                    ."Our daily like limit for free users is pretty low, Upgrading is likely worth it just to avoid the frustration of having to wait until the next day for more.\n\n"
                                    ."If your profile gets a lot of action (and it will if you optimize your photos and prompt answers), being able to see who already expressed interest in one grid view is convenient, and potentially a huge time saver. You can start with the singles who interest you most, rather than deciding on one profile in order to see the next one, and so on.\n\n"
                                    ;
            $paymentType3->save();



        //Boost plans
        $paymentType4 = new PaymentType();
        $paymentType4->name = "Boosts";
        $paymentType4->type = "boost";
        $paymentType4->likes_per_day = 0;
        $paymentType4->super_likes_per_day = 0;
        $paymentType4->view_likes_per_day = 0;
        $paymentType4->boost_minutes = $s->boost_minutes;
        $paymentType4->number_of_days = 1;
        $paymentType4->price = 15;
        $paymentType4->long_desc = 
                                "Boosts make your profile one of the top ones in your area for ".$s->boost_minutes." minutes. That means when local singles fire up Shimmer, your profile will be one of the first ones they see.\n"
                                ."You can get up to 10x more profile views while a boost is activated, which can lead to more matches. You’ll get periodic reminders of how much juice is left in your Boost.\n"
                                ."When you boost your profile you will get more views leading to more likes and matches, but no one will know you boosted your profile except you.\n\n\n"
                                ;
        $paymentType4->short_desc = "Not getting enough likes? Be the top profile in your area for ".$s->boost_minutes ." minutes and get 10x more likes.";
        $paymentType4->save();


        $paymentType5 = new PaymentType();
        $paymentType5->name = "Boosts";
        $paymentType5->type = "boost";
        $paymentType5->likes_per_day = 0;
        $paymentType5->super_likes_per_day = 0;
        $paymentType5->view_likes_per_day = 0;
        $paymentType5->boost_minutes = $s->boost_minutes;
        $paymentType5->number_of_days = 5;
        $paymentType5->price = 50;
        $paymentType5->long_desc = 
                                "Boosts make your profile one of the top ones in your area for ".$s->boost_minutes." minutes. That means when local singles fire up Shimmer, your profile will be one of the first ones they see.\n"
                                ."You can get up to 10x more profile views while a boost is activated, which can lead to more matches. You’ll get periodic reminders of how much juice is left in your Boost.\n"
                                ."When you boost your profile you will get more views leading to more likes and matches, but no one will know you boosted your profile except you.\n\n\n"
                                ;
        $paymentType5->short_desc = "Not getting enough likes? Be the top profile in your area for ".$s->boost_minutes ." minutes and get 10x more likes.";
        $paymentType5->save();
        

        $paymentType6 = new PaymentType();
        $paymentType6->name = "Boosts";
        $paymentType6->type = "boost";
        $paymentType6->likes_per_day = 0;
        $paymentType6->super_likes_per_day = 0;
        $paymentType6->view_likes_per_day = 0;
        $paymentType6->boost_minutes = $s->boost_minutes;
        $paymentType6->number_of_days = 10;
        $paymentType6->price = 80;
        $paymentType6->long_desc = 
                                "Boosts make your profile one of the top ones in your area for ".$s->boost_minutes." minutes. That means when local singles fire up Shimmer, your profile will be one of the first ones they see.\n"
                                ."You can get up to 10x more profile views while a boost is activated, which can lead to more matches. You’ll get periodic reminders of how much juice is left in your Boost.\n"
                                ."When you boost your profile you will get more views leading to more likes and matches, but no one will know you boosted your profile except you.\n\n\n"
                                ;
        $paymentType6->short_desc = "Not getting enough likes? Be the top profile in your area for ".$s->boost_minutes." minutes and get 10x more likes.";
        $paymentType6->save();
        


    }
}
