<?php

namespace Colors\App;

use Colors\App\Controllers\HomeController;
use Colors\App\Controllers\ColorController;

class App
{
    static public function run(){
        $server = $_SERVER['REQUEST_URI'];
        $server = preg_replace('/\?.*$/', '', $server);
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
        if($method == 'GET' && count($url) == 1 && $url[0] == 'colors'){
            return (new ColorController)->index($_GET);
        }
        if($method == 'GET' && count($url) == 2 && $url[0] == 'colors' && $url[1] == 'create'){
            return (new ColorController)->create();
        }

        if($method == 'POST' && count($url) == 2 && $url[0] == 'colors' && $url[1] == 'store'){
            return (new ColorController)->store($_POST);
        }

        if($method == 'POST' && count($url) == 3 && $url[0] == 'colors' && $url[1] == 'destroy'){
            return (new ColorController)->destroy($url[2]);
        }

        if ('GET' == $method && count($url) == 3 && $url[0] == 'colors' && $url[1] == 'edit') {
            return (new ColorController)->edit($url[2]);
        }

        if($method == 'POST' && count($url) == 3 && $url[0] == 'colors' && $url[1] == 'update'){
            return (new ColorController)->update($url[2], $_POST);
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

    static public function redirect($url){
        header('Location: '.URL.'/'.$url);
        return null;
    }
}