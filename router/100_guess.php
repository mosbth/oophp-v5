<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the game
    $game = new Mos\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // Get current settings from the SESSION
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;

    // Unset the flash values from the processing page,
    // read once and remove
    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;

    $data = [
        "guess" => $guess ?? null,
        "tries" => $tries,
        "number" => $number ?? null,
        "res" => $res,
        "doCheat" => false,
    ];

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Cheat by showing the current number.
 */
$app->router->get("guess/cheat", function () use ($app) {
    $title = "Play the game (cheating)";

    // Get current settings from the SESSION
    $number  = $_SESSION["number"] ?? null;
    $tries   = $_SESSION["tries"] ?? null;

    $data = [
        "guess" => null,
        "tries" => $tries,
        "number" => $number,
        "res" => null,
        "doCheat" => true,
    ];

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    // Deal with incoming variables
    $guess = $_POST["guess"] ?? null;

    // Get current settings from the SESSION
    $number  = $_SESSION["number"] ?? null;
    $tries   = $_SESSION["tries"] ?? null;

    // Do a guess
    $game = new Mos\Guess\Guess($number, $tries);
    $res = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
    $_SESSION["res"] = $res;
    $_SESSION["guess"] = $guess;

    return $app->response->redirect("guess/play");
});
