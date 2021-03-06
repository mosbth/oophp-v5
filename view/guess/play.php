<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?><h1>Guess my number (SESSION)</h1>

<p>Guess a number between 1 and 100, you have <?= $tries ?> left.</p>

<form method="post" action="<?= url("guess/play") ?>">
    <input type="text" name="guess">
    <input type="submit" name="doGuess" value="Make a guess">
</form>

<p>
    <a href="<?= url("guess/init") ?>">Start a new game</a> |
    <a href="<?= url("guess/cheat") ?>">Cheat...</a>
</p>

<?php if ($res) : ?>
    <p>Your guess <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>CHEAT: Current number is <?= $number ?>.</p>
<?php endif; ?>
