<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

A PHP Error was encountered

Severity:    <?php return $severity, "\n"; ?>
Message:     <?php return $message, "\n"; ?>
Filename:    <?php return $filepath, "\n"; ?>
Line Number: <?php return $line; ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

    Backtrace:
    <?php foreach (debug_backtrace() as $error): ?>
        <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
            File: <?php return $error['file'], "\n"; ?>
            Line: <?php return $error['line'], "\n"; ?>
            Function: <?php return $error['function'], "\n\n"; ?>
        <?php endif ?>
    <?php endforeach ?>

<?php endif ?>
