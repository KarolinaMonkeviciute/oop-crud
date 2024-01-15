<?php

namespace Colors\App;

use Colors\App\Controllers\HomeController;
use Colors\App\Controllers\ColorController;

class App
{
    static public function run(){
        $server = $_SERVER['REQUEST_URI'];
        $url = explode('/', $server);
        array_shift($url);

        return self::router($url);
    }

    static private function router($url){
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'GET' && count($url) == 1 && $url[0] == ''){
            return (new HomeController)->index();
        }
        if($method == 'GET' && count($url) == 2 && $url[0] == 'home'){
            return (new HomeController)->color($url[1]);
        }
        if($method == 'GET' && count($url) == 2 && $url[0] == 'colors' && $url[1] == 'create'){
            return (new ColorController)->create();
        }
        if($method == 'POST' && count($url) == 2 && $url[0] == 'colors' && $url[1] == 'store'){
            return (new ColorController)->store($_POST);
        }

        return '<h1>404</h1>';
    }

    static public function view($view, $data=[]){
        extract($data);
        ob_start();
        require ROOT.'views/top.php';
        require ROOT."views/$view.php";
        require ROOT.'views/bottom.php';
        $content = ob_get_clean();
        return $content;
    }
}