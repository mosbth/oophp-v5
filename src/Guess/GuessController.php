<?php

namespace Mos\Guess;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GuessController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    // 
    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "INDEX!!";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game!!";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        // Init the game
        $game = new Guess();
        // $_SESSION["number"] = $game->number();
        // $_SESSION["tries"] = $game->tries();
        $session->set("number", $game->number());
        $session->set("tries", $game->tries());

        return $response->redirect("guess1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Play the game (1)";
        $page = $this->app->page;
        $session = $this->app->session;

        // Get current settings from the SESSION
        // $tries = $_SESSION["tries"] ?? null;
        // $res = $_SESSION["res"] ?? null;
        // $guess = $_SESSION["guess"] ?? null;
        $tries = $session->get("tries");
        $res = $session->get("res");
        $guess = $session->get("guess");

        // Unset the flash values from the processing page,
        // read once and remove
        // $_SESSION["res"] = null;
        // $_SESSION["guess"] = null;
        $session->set("res", null);
        $session->set("guess", null);


        $data = [
            "guess" => $guess ?? null,
            "tries" => $tries,
            "number" => $number ?? null,
            "res" => $res,
            "doCheat" => false,
        ];

        $page->add("guess1/play", $data);
        //$page->add("guess/debug");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function cheatAction() : object
    {
        $title = "Play the game (cheating)";
        $page = $this->app->page;
        $session = $this->app->session;

        // Get current settings from the SESSION
        // $number  = $_SESSION["number"] ?? null;
        // $tries   = $_SESSION["tries"] ?? null;
        $tries = $session->get("tries");
        $number = $session->get("number");

        $data = [
            "guess" => null,
            "tries" => $tries,
            "number" => $number,
            "res" => null,
            "doCheat" => true,
        ];

        $page->add("guess1/play", $data);
        //$page->add("guess/debug");

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        $request = $this->app->request;
        $response = $this->app->response;
        $session = $this->app->session;

        // Deal with incoming variables
        // $guess = $_POST["guess"] ?? null;
        $guess = $request->getPost("guess");

        // Get current settings from the SESSION
        // $number  = $_SESSION["number"] ?? null;
        // $tries   = $_SESSION["tries"] ?? null;
        $number  = $session->get("number");
        $tries   = $session->get("tries");

        // Do a guess
        $game = new Guess($number, $tries);
        $res = $game->makeGuess($guess);
        // $_SESSION["tries"] = $game->tries();
        // $_SESSION["res"] = $res;
        // $_SESSION["guess"] = $guess;
        $session->set("tries", $game->tries());
        $session->set("res", $res);
        $session->set("guess", $guess);

        return $response->redirect("guess1/play");
    }
}
