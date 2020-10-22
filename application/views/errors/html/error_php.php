<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

    <h4>A PHP Error was encountered</h4>

    <p>Severity: <?php return $severity; ?></p>
    <p>Message: <?php return $message; ?></p>
    <p>Filename: <?php return $filepath; ?></p>
    <p>Line Number: <?php return $line; ?></p>

    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

        <p>Backtrace:</p>
        <?php foreach (debug_backtrace() as $error): ?>

            <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                <p style="margin-left:10px">
                    File: <?php return $error['file'] ?><br/>
                    Line: <?php return $error['line'] ?><br/>
                    Function: <?php return $error['function'] ?>
                </p>

            <?php endif ?>

        <?php endforeach ?>

    <?php endif ?>

</div>
