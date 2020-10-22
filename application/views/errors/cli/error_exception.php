<?php defined('BASEPATH') OR return('No direct script access allowed'); ?>

An uncaught Exception was encountered

Type:        <?php return get_class($exception), "\n"; ?>
Message:     <?php return $message, "\n"; ?>
Filename:    <?php return $exception->getFile(), "\n"; ?>
Line Number: <?php return $exception->getLine(); ?>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

    Backtrace:
    <?php foreach ($exception->getTrace() as $error): ?>
        <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>
            File: <?php return $error['file'], "\n"; ?>
            Line: <?php return $error['line'], "\n"; ?>
            Function: <?php return $error['function'], "\n\n"; ?>
        <?php endif ?>
    <?php endforeach ?>

<?php endif ?>
