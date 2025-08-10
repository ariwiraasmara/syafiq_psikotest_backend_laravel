<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Pranker {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     protected array $expectedHeaders = [
        'X-Master-Key' => 'X-Ultimate-Armor',
        'X-Name-Key' => 'Sy4h12i-R4m4dH4n-W1r44sm4r4',
        'X-API-Key' => '0N3P13C3-x-F41rY_741L-x-130Ku_n0_H312o_Ac4D3m14-x-D347H_N073',
        'X-Authorization-Key' => '5T12rH47-P11273-x-3l_t0_Y46aM1',
        'X-Token-Key' => 'S0f14_D3_S41n73_Q0qu1ll3',
        'X-Super-Key' => 'Zero',
        'X-Your-Key' => 'Y0r F0rG3r',
        'X-Unique-Key' => 'I am unique!',
        'X-Secret-Key' => "There is no such as 'No Secret Key Here'...",
        'X-Castle-Key' => 'Kimetsu no Yaiba - Infinity Castle Theme',
        'X-H-Triple-Key' => 'Julia Boin',
        'isvalid' => 'VALID!',
        'key' => null,
        'values' => null,
        'believer' => 'YES! I AM THE IMAGINE DRAGON!',
        'challenger' => 'of course',
        'how_sure' => 'not sure',
        'isallowed' => null,
        'rumbling' => 'Call Eren Jaeger!',
        'summon' => 'I Summon Dark Magician!',
        'your_favorite_music' => null,
        'impossible' => 'Two Steps From Hell - Impossible',
        'birthday' => "I fucking don't care!",
        'still_continue' => "let and get me out of here!!",
        'i_see_you_still_here' => "brave enough...",
        'take_your_journey_sweetheart' => "I'm sorry I can't go with you anymore",
        'sure_take_your_time' => null,
        'the_journey_still_long_you_know' => "how far?",
        'i_will_tell_you_there_are_still_100_left_questions_of_security_to_passed' => "are you joking?",
        'lets_dance_i_like_to_move_it_move_it_i_like_to_move_it_move_it_i_like_to_move_it_move_it_you_like_to' => "MOVE IT!! https://www.youtube.com/watch?v=PLEQRIisP_Q",
        'do_you_know_fireworks' => 'Daoko x Kenshi Yonezu MUSIC VIDEO https://www.youtube.com/watch?v=-tKVN2mAKRI',
        'pranked' => 'absolutely',
        'trolled' => 'Roller Coaster',
        'you_know_that_you_are_very_dumb' => 'yes',
        'shadow' => 'Hiroyuki Sawano - Solo Leveling OST - Dark Aria LV2 (https://www.youtube.com/watch?v=ZGXOWPZ64DA)',
        'i_want_to_honest_that_i_am_a_demon_lord' => "My name is Rimuru Tempest. My friend name's is Anos Voldigoad",
        'okay_you_may_pass' => 'really?',
        'like_i_said_there_are_still_100_questions_left' => null,
        'i_am_joking' => "I don't believe you...",
        'i_am_serious_here_and_this_is_the_real_100_questions_to_pass_this_middleware' => null,
        'first_praise_the_god' => 'SymphonicSuite-Lv.8',
        'second_noble_phantasm' => 'Unlimited Blade Works - Brave Shine! https://www.youtube.com/watch?v=XeI8E20ZUE4',
        'and_fake_it' => 'Fate/Strange Fake',
        'thats_it' => 'done! Thank you so much!',
    ];

    protected array $devWhitelist = [
        '127.0.0.1',
        '::1'
    ];

    public function handle(Request $request, Closure $next): Response {
        if(env('HIGH_SECURITY_V2_ENABLED')) {
            if (!$this->hasValidHeaders($request)) {
                $this->applySadisticDelay($request);
                return response()->json(['message' => $this->getErrorMessage($request)], 404);
            }
        }
        return $next($request);
    }

    protected function reject(string $message): Response {
        Log::warning("Pranker blocked a request: $message");
        return response()->json(['message' => $message], 404);
    }

    protected function applySadisticDelay(Request $request): void {
        $sleep_time = 60 * 60; // menit * detik
        if (
            app()->environment('production') &&
            !in_array($request->ip(), $this->devWhitelist)
        ) {
            if(env('HIGH_SECURITY_V2_DELAY')) {
                sleep($sleep_time); // 😈 Delay brutal
            }
        }
    }


    /**
     * Check if the request has all the required headers with valid values.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function hasValidHeaders(Request $request): bool
    {
        return $request->hasHeader('X-Master-Key') && $request->header('X-Master-Key') === 'X-Ultimate-Armor'
            && $request->hasHeader('X-Name-Key') && $request->header('X-Name-Key') === 'Sy4h12i-R4m4dH4n-W1r44sm4r4'
            && $request->hasHeader('X-API-Key') && $request->header('X-API-Key') === '0N3P13C3-x-F41rY_741L-x-130Ku_n0_H312o_Ac4D3m14-x-D347H_N073'
            && $request->hasHeader('X-Authorization-Key') && $request->header('X-Authorization-Key') === '5T12rH47-P11273-x-3l_t0_Y46aM1'
            && $request->hasHeader('X-Token-Key') && $request->header('X-Token-Key') === 'S0f14_D3_S41n73_Q0qu1ll3'
            && $request->hasHeader('X-Super-Key') && $request->header('X-Super-Key') === 'Zero'
            && $request->hasHeader('X-Your-Key') && $request->header('X-Your-Key') === 'Y0r F0rG3r'
            && $request->hasHeader('X-Unique-Key') && $request->header('X-Unique-Key') === 'I am unique!'
            && $request->hasHeader('X-Secret-Key') && $request->header('X-Secret-Key') === "There is no such as 'No Secret Key Here'..."
            && $request->hasHeader('X-Castle-Key') && $request->header('X-Castle-Key') === 'Kimetsu no Yaiba - Infinity Castle Theme'
            && $request->hasHeader('X-H-Triple-Key') && $request->header('X-H-Triple-Key') === 'Julia Boin'
            && $request->hasHeader('isvalid') && $request->header('isvalid') === 'VALID!'
            && $request->hasHeader('key') && $request->header('key') !== ''
            && $request->hasHeader('values') && $request->header('values') !== ''
            && $request->hasHeader('believer') && $request->header('believer') === 'YES! I AM THE IMAGINE DRAGON!'
            && $request->hasHeader('challenger') && $request->header('challenger') === 'of course'
            && $request->hasHeader('how_sure') && $request->header('how_sure') === 'not sure'
            && $request->hasHeader('isallowed')
            && $request->hasHeader('rumbling') && $request->header('rumbling') === 'Call Eren Jaeger!'
            && $request->hasHeader('summon') && $request->header('summon') === 'I Summon Dark Magician!'
            && $request->hasHeader('your_favorite_music') && $request->header('your_favorite_music') !== ''
            && $request->hasHeader('impossible') && $request->header('impossible') === 'Two Steps From Hell - Impossible'
            && $request->hasHeader('birthday') && $request->header('birthday') === "I fucking don't care!"
            && $request->hasHeader('still_continue') && $request->header('still_continue') === "let and get me out of here!!"
            && $request->hasHeader('i_see_you_still_here') && $request->header('i_see_you_still_here') === "brave enough..."
            && $request->hasHeader('take_your_journey_sweetheart') && $request->header('take_your_journey_sweetheart') === "I'm sorry I can't go with you anymore"
            && $request->hasHeader('sure_take_your_time') && $request->header('sure_take_your_time') !== ""
            && $request->hasHeader('the_journey_still_long_you_know') && $request->header('the_journey_still_long_you_know') === "how far?"
            && $request->hasHeader('i_will_tell_you_there_are_still_100_left_questions_of_security_to_passed') && $request->header('i_will_tell_you_there_are_still_100_left_questions_of_security_to_passed') === "are you joking?"
            && $request->hasHeader('lets_dance_i_like_to_move_it_move_it_i_like_to_move_it_move_it_i_like_to_move_it_move_it_you_like_to') && $request->header('lets_dance_i_like_to_move_it_move_it_i_like_to_move_it_move_it_i_like_to_move_it_move_it_you_like_to') === "MOVE IT!! https://www.youtube.com/watch?v=PLEQRIisP_Q"
            && $request->hasHeader('do_you_know_fireworks') && $request->header('do_you_know_fireworks') === 'Daoko x Kenshi Yonezu MUSIC VIDEO https://www.youtube.com/watch?v=-tKVN2mAKRI'
            && $request->hasHeader('pranked') && $request->header('pranked') === 'absolutely'
            && $request->hasHeader('trolled') && $request->header('trolled') === 'Roller Coaster'
            && $request->hasHeader('you_know_that_you_are_very_dumb') && $request->header('you_know_that_you_are_very_dumb') === 'yes'
            && $request->hasHeader('shadow') && $request->header('shadow') === 'Hiroyuki Sawano - Solo Leveling OST - Dark Aria LV2 (https://www.youtube.com/watch?v=ZGXOWPZ64DA)'
            && $request->hasHeader('i_want_to_honest_that_i_am_a_demon_lord') && $request->header('i_want_to_honest_that_i_am_a_demon_lord') === "My name is Rimuru Tempest. My friend name's is Anos Voldigoad"
            && $request->hasHeader('okay_you_may_pass') && $request->header('okay_you_may_pass') === 'really?'
            && $request->hasHeader('like_i_said_there_are_still_100_questions_left') && $request->header('like_i_said_there_are_still_100_questions_left') !== ""
            && $request->hasHeader('i_am_joking') && $request->header('i_am_joking') === "I don't believe you..."
            && $request->hasHeader('i_am_serious_here_and_this_is_the_real_100_questions_to_pass_this_middleware') && $request->header('i_am_serious_here_and_this_is_the_real_100_questions_to_pass_this_middleware') !== ''
            && $request->hasHeader('first_praise_the_god') && $request->header('first_praise_the_god') === 'SymphonicSuite-Lv.8'
            && $request->hasHeader('second_noble_phantasm') && $request->header('second_noble_phantasm') === 'Unlimited Blade Works - Brave Shine! https://www.youtube.com/watch?v=XeI8E20ZUE4'
            && $request->hasHeader('and_fake_it') && $request->header('and_fake_it') === 'Fate/Strange Fake'
            && $request->hasHeader('thats_it') && $request->header('thats_it') === 'done! Thank you so much!'
            ;
    }

    /**
     * Get the appropriate error message based on the request headers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    private function getErrorMessage(Request $request) {
        if (!$request->hasHeader('X-Master-Key') && $request->header('X-Master-Key') !== 'X-Ultimate-Armor') {
            return 'Invalid Master Key!';
        }

        if (!$request->hasHeader('X-Name-Key') && $request->header('X-Name-Key') !== 'Sy4h12i-R4m4dH4n-W1r44sm4r4') {
            return 'Invalid Name Key!';
        }

        if (!$request->hasHeader('X-API-Key') && $request->header('X-API-Key') !== '0N3P13C3-x-F41rY_741L-x-130Ku_n0_H312o_Ac4D3m14-x-D347H_N073') {
            return 'Invalid API Key!';
        }

        if (!$request->hasHeader('X-Authorization-Key') && $request->header('X-Authorization-Key') !== '5T12rH47-P11273-x-3l_t0_Y46aM1') {
            return 'Invalid Authorization Key!';
        }

        if (!$request->hasHeader('X-Token-Key') && $request->header('X-Token-Key') !== 'S0f14_D3_S41n73_Q0qu1ll3') {
            return 'Invalid Token Key!';
        }

        if (!$request->hasHeader('X-Super-Key') && $request->header('X-Super-Key') !== 'Zero') {
            return 'Invalid Super Key!';
        }

        if (!$request->hasHeader('X-Your-Key') && $request->header('X-Your-Key') !== 'Y0r F0rG3r') {
            return 'Invalid Your Key!';
        }

        if (!$request->hasHeader('X-Unique-Key') && $request->header('X-Unique-Key') !== 'I am unique!') {
            return 'Where is the uniqueness?';
        }

        if (!$request->hasHeader('X-Secret-Key') && $request->header('X-Secret-Key') !== "There is no such as 'No Secret Key Here'...") {
            return 'Forbidden! Secret Forever!';
        }

        if (!$request->hasHeader('X-Castle-Key') && $request->header('X-Castle-Key') !== 'Kimetsu no Yaiba - Infinity Castle Theme') {
            return 'Where is the castle?';
        }

        if (!$request->hasHeader('X-H-Triple-Key') && $request->header('X-H-Triple-Key') !== 'Julia Boin') {
            return 'Where is the triple key?';
        }

        if (!$request->hasHeader('isvalid') && $request->header('isvalid') !== 'VALID!') {
            return 'IT IS VALID! BUT NOT VALID AS WELL!';
        }

        if (!$request->hasHeader('key') && empty($request->header('key'))) {
            return 'Where\'s the key?';
        }

        if (!$request->hasHeader('values') && empty($request->header('values'))) {
            return 'Where\'s the values?';
        }

        if(
            (!$request->hasHeader('key') && empty($request->header('key')))
            && (!$request->hasHeader('values') && empty($request->header('values')))
        ) {
            return 'Where\'s the key and values?';
        }

        if (!$request->hasHeader('believer') && $request->header('believer') !== 'YES! I AM THE IMAGINE DRAGON!') {
            return 'You are not a believer!';
        }

        if (!$request->hasHeader('challenger') && $request->header('challenger') !== 'of course') {
            return "I see. So you're a challenger, eh...";
        }

        if (!$request->hasHeader('how_sure') && $request->header('how_sure') !== 'not sure') {
            return 'How sure are you?';
        }

        if (!$request->hasHeader('isallowed')) {
            return 'This not even valid! Or Even allowed!';
        }

        if (!$request->hasHeader('rumbling') && $request->header('rumbling') !== 'Call Eren Jaeger!') {
            return "Those who has made humanity decreased to 80% of the world's population, are the ones who will be called 'Rumbling'!";
        }

        if (!$request->hasHeader('summon') && $request->header('summon') !== 'I Summon Dark Magician!') {
            return "What to Summon? You don't even have a card!";
        }

        if (!$request->hasHeader('your_favorite_music') && empty($request->header('your_favorite_music'))) {
            return 'Where is your favorite music?';
        }

        if (!$request->hasHeader('impossible') && $request->header('impossible') !== 'Two Steps From Hell - Impossible') {
            return 'Impossible is nothing! But you are impossible!';
        }

        if (!$request->hasHeader('birthday') && $request->header('birthday') !== "I fucking don't care!") {
            return 'I don\'t care about your birthday!';
        }

        if (!$request->hasHeader('still_continue') && $request->header('still_continue') !== "let and get me out of here!!") {
            return 'Shoo! Go away from here!';
        }

        if (!$request->hasHeader('i_see_you_still_here') && $request->header('i_see_you_still_here') !== "brave enough...") {
            return 'You are still here?';
        }

        if (!$request->hasHeader('take_your_journey_sweetheart') && $request->header('take_your_journey_sweetheart') !== "I'm sorry I can't go with you anymore") {
            return 'I can\'t go with you anymore!';
        }

        if (!$request->hasHeader('sure_take_your_time') && empty($request->header('sure_take_your_time'))) {
            return 'Sit and relax... don\'t even forget of your cups of mongoose coffee';
        }

        if (!$request->hasHeader('the_journey_still_long_you_know') && $request->header('the_journey_still_long_you_know') !== "how far?") {
            return 'The journey is still long, you know?';
        }

        if (!$request->hasHeader('i_will_tell_you_there_are_still_100_left_questions_of_security_to_passed') && $request->header('i_will_tell_you_there_are_still_100_left_questions_of_security_to_passed') !== "are you joking?") {
            return 'There are still 100 questions left to pass this security middleware!';
        }

        if (!$request->hasHeader('lets_dance_i_like_to_move_it_move_it_i_like_to_move_it_move_it_i_like_to_move_it_move_it_you_like_to') && $request->header('lets_dance_i_like_to_move_it_move_it_i_like_to_move_it_move_it_i_like_to_move_it_move_it_you_like_to') !== "MOVE IT!! https://www.youtube.com/watch?v=PLEQRIisP_Q") {
            return 'Let\'s dance! Move your body!';
        }

        if (!$request->hasHeader('do_you_know_fireworks') && $request->header('do_you_know_fireworks') !== 'DAOKO × 米津玄師『打上花火』MUSIC VIDEO https://www.youtube.com/watch?v=-tKVN2mAKRI') {
            return 'You must be poor single... no couples? HAHAHA!';
        }

        if (!$request->hasHeader('pranked') && $request->header('pranked') !== 'absolutely') {
            return 'You are not pranked yet?';
        }

        if (!$request->hasHeader('trolled') && $request->header('trolled') !== 'Roller Coaster') {
            return 'You are not trolled yet?';
        }

        if (!$request->hasHeader('you_know_that_you_are_very_dumb') && $request->header('you_know_that_you_are_very_dumb') !== 'yes') {
            return 'You are very dumb!';
        }

        if (!$request->hasHeader('shadow') && $request->header('shadow') !== 'Hiroyuki Sawano - Solo Leveling OST - Dark Aria LV2 (https://www.youtube.com/watch?v=ZGXOWPZ64DA)') {
            return 'You are not even a shadow!';
        }

        if (!$request->hasHeader('i_want_to_honest_that_i_am_a_demon_lord') && $request->header('i_want_to_honest_that_i_am_a_demon_lord') !== "My name is Rimuru Tempest. My friend name's is Anos Voldigoad") {
            return 'You are not even a shadow!';
        }

        if (!$request->hasHeader('okay_you_may_pass') && $request->header('okay_you_may_pass') !== 'really?') {
            return 'You may pass? Really?';
        }

        if (!$request->hasHeader('like_i_said_there_are_still_100_questions_left') && empty($request->header('like_i_said_there_are_still_100_questions_left'))) {
            return 'You are not ready yet.';
        }

        if (!$request->hasHeader('i_am_joking') && $request->header('i_am_joking') !== "I don't believe you...") {
            return 'I am joking...';
        }

        if (!$request->hasHeader('i_am_serious_here_and_this_is_the_real_100_questions_to_pass_this_middleware') && empty($request->header('i_am_serious_here_and_this_is_the_real_100_questions_to_pass_this_middleware'))) {
            return 'I am serious here! This is the real 100 questions to pass this middleware!';
        }

        if (!$request->hasHeader('first_praise_the_god') && $request->header('first_praise_the_god') !== 'SymphonicSuite-Lv.8') {
            return 'Praise the God!';
        }

        if (!$request->hasHeader('second_noble_phantasm') && $request->header('second_noble_phantasm') !== 'Unlimited Blade Works - Brave Shine! https://www.youtube.com/watch?v=XeI8E20ZUE4') {
            return 'Noble Phantasm is not even a joke!';
        }

        if (!$request->hasHeader('and_fake_it') && $request->header('and_fake_it') !== 'Fate/Strange Fake') {
            return 'Fake it until you make it!';
        }

        if (!$request->hasHeader('thats_it') && $request->header('thats_it') !== 'done! Thank you so much!') {
            return 'That\'s it?';
        }
        return 'Unknown error';
    }
}
