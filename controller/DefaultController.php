<?php

require 'model/DatabaseModel.php';

class DefaultController
{

    const PATH_VIEWS = 'view';

    /**
     * Show a template
     * @param string $file Pathfile
     * @param array  $data Datas will be used on the view
     */
    public static function show($file, array $data = array())
    {
        
        // Call the class for render
        $engine = new \League\Plates\Engine(self::PATH_VIEWS);

        // Add each datas to the view
        foreach($data as $key => $value) {
            $engine->addData( [ $key => $value ] );
        }

        // Delete the extension, not usefull but just in case
        $file = str_replace('.php', '', $file);

        // Render the template
        echo $engine->render('common/header', compact(''));
        echo $engine->render($file);
        echo $engine->render('common/footer', compact(''));

        die();
    }
}