<?php
/**
 * Guess my number, a POST/SESSION version.
 */
require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

// Start a named session
session_name("mosstud");
session_start();


// Deal with incoming variables
$guess   = $_POST["guess"] ?? null;
$doInit  = $_POST["doInit"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$doCheat = $_POST["doCheat"] ?? null;

// Get current settings from the SESSION
$number  = $_SESSION["number"] ?? null;
$tries   = $_SESSION["tries"] ?? null;
$game = null;



if ($doInit || $number === null) {
    // Init the game
    $game = new Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
} elseif ($doGuess) {
    // Do a guess
    $game = new Guess($number, $tries);
    $res = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
}



// Render the page through the views
require __DIR__ . "/view/guess_my_number_session.php";
require __DIR__ . "/view/debug_session_post_get.php";
