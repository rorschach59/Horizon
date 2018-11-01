<?php

class ErrorController
{
    public static function errorLog($error)
    {   
        $file_error = $_SERVER['DOCUMENT_ROOT'].'/horizon/error/error_'.date('Y-m-d').'.log';
        $file = fopen($file_error, 'a+');
        fwrite($file, date('Y-m-d H:i:s').' : '.$error.PHP_EOL);
        fclose($file);
    }

    public static function flashMessage($level, $message)
    {
        $flash_message = new \stdClass();
        $flash_message->level = $level;
        $flash_message->message = $message;

        if(isset($flash_message) && !empty($flash_message)) {
            return '
            <div class="alert alert-'.$flash_message->level.' alert-dismissible fade show" role="alert">
                '.$flash_message->message.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }

    }

}