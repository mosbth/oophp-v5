<?php
/**
 * Guess my number, a POST version.
 */
require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";


// Deal with incoming variables
$number  = $_POST["number"] ?? null;
$tries   = $_POST["tries"] ?? null;
$guess   = $_POST["guess"] ?? null;
$doInit  = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;



if ($doInit || $number === null) {
    // Init the game
    $number = rand(1, 100);
    $tries = 5;
    //header("Location: index_get.php?tries=$tries&number=$number");
} elseif ($doGuess) {
    // Do a guess
    $tries -= 1;
    if ($guess === $number) {
        $res = "CORRECT";
    } elseif ($guess > $number) {
        $res = "TOO HIGH";
    } else {
        $res = "TOO LOW";
    }
}


// Render the page
require __DIR__ . "/view/guess_my_number_post.php";
