<?php

header('Access-Control-Allow-Origin: *');




class Identificar_picto extends Game{

    // private $db;
    private $game;
    private $N;
    private $imgs;

    public function __construct()
    {
        // require_once 'db_function.php';
        // $db = new DBFunctions();
        $this->$game = array();
        $this->$N = 5;
        $this->$imgs = 3;
    }
    public function __construct($n)
    {
        $this->$game = array();
        $this->$N = $n;
        $this->$imgs = 3;
    }
    public function __destruct()
    {}    

    public function play(){
        $directorio = 'picts/shared';
        if(is_dir($directorio)){
            // Returns array of files 
            $fileslist = scandir($directory); 
            
            // Count number of files and store them to variable 
            $num_files = count($fileslist) - 2; 

            // Generate N matches
            for($x = 0; $x < $this->$N; $x++){
                // Select random imgs
                $fileslist = array_slice($fileslist, 2);
                $pictos = array_rand($fileslist, $this->$imgs);

                $sol = random_int(0 , $this->$imgs - 1);
                $sol_name = explode(".", $pictos[$sol])[0]; 
                // Substitute _ by blanks
                $sol_name = str_replace("_", " ", $sol_name);

                $page['sol'] = $sol;
                $page['sol_name'] = $sol_name;
                $page['pictos'] = $pictos;
                array_push($this->$game, $page);
            }
            
        }
        else{
            // Unreachable
            return null;
        }

        return $this->$game;
    }
        
}

