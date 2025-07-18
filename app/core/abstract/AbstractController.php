<?php

namespace PMT\APP\CORE\ABSTRACT;
use PMT\APP\CORE\Session;


    abstract class AbstractController
     
    {

        protected string $layout = "layout/base.layout.php";
        protected Session $session;

        abstract public function index();
        abstract public function edit();
        abstract public function destroy(); 
        abstract public function store();
        abstract public function show();
        abstract public function create();
   

        public function __Construct(){
            $this->session=Session::getInstance();
        }

        public function renderHtml(string $view, array $data = [])
        {
            extract($data);
            
            ob_start();
            require_once __DIR__ . "/../../../template/" . $view;
            $containe = ob_get_clean();
            require_once __DIR__ . "/../../../template/". $this->layout;
        }
    }
