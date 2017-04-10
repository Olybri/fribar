<?php

use Symfony\Component\Yaml\Yaml;

class Database
{
    private $pdo;
    
    public function __construct($environment = "")
    {
        // parse phinx.yml pour déduire les identifiants
        
        $config = Yaml::parse(file_get_contents("phinx.yml"));
        
        if(empty($environment))
            $environment = $config["environments"]["default_database"];
        
        $db_info = $config["environments"][$environment];
        
        $host = $db_info["host"];
        $name = $db_info["name"];
        $user = $db_info["user"];
        $pass = $db_info["pass"];
        
        $this->pdo = new PDO("mysql:host=$host;dbname=$name;charset=utf8", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    // Renvoie l'ID du dernier élément inséré
    public function last_id()
    {
        return $this->pdo->query("SELECT LAST_INSERT_ID()")->fetchColumn();
    }
    
    
    /// BARS ///
    
    // Renvoie un tableau listant tous les bars
    public function bars()
    {
        return $this->pdo->query("SELECT * FROM bar")->fetchAll();
    }
    
    // Renvoie un bar
    public function bar($bar_id)
    {
        $st = $this->pdo->prepare("SELECT * FROM bar WHERE id = ?");
        $st->execute([$bar_id]);
        return $st->fetch();
    }
    
    // Renvoie le nombre de bières servies dans un bar
    public function product_count($bar_id)
    {
        $st = $this->pdo->prepare("SELECT COUNT(DISTINCT product_id) FROM service WHERE bar_id = ?");
        $st->execute([$bar_id]);
        return $st->fetchColumn();
    }
    
    // Renvoie le meilleurs prix (pour un litre) du bar
    public function best_price($bar_id)
    {
        $st = $this->pdo->prepare("SELECT * FROM service WHERE bar_id = ?");
        $st->execute([$bar_id]);
        
        $best = 0;
        foreach($st as $service)
        {
            $price = $service["price"] / $service["volume"] * 10;
            if($best == 0 || $price < $best)
                $best = $price;
        }
        
        return $best;
    }
    
    // Renvoie un tableau listant les services de bières d'un bar
    public function bar_services($bar_id)
    {
        $st = $this->pdo->prepare("SELECT * FROM service WHERE bar_id = ?");
        $st->execute([$bar_id]);
        return $st->fetchAll();
    }
    
    // Ajoute un bar et renvoie son ID
    public function add_bar($name)
    {
        $st = $this->pdo->prepare("INSERT INTO bar (name) VALUES (?)");
        $st->execute([$name]);
        
        return $this->last_id();
    }
    
    // Ajoute des services dans un bar
    public function add_services($bar_id, $product_ids, $volumes, $prices)
    {
        $this->pdo->beginTransaction();
        $st = $this->pdo->prepare("INSERT INTO service (bar_id, product_id, volume, price) VALUES (?, ?, ?, ?)");
        
        foreach($product_ids as $key => $product_id)
        {
            $volume = $volumes[$key];
            $price = $prices[$key] * 100;
            
            $st->execute([$bar_id, $product_id, $volume, $price]);
        }
        
        $this->pdo->commit();
    }
    
    
    /// BIÈRES ///
    
    // Renvoie un tableau listant toutes les bières
    public function products()
    {
        return $this->pdo->query("SELECT * FROM product")->fetchAll();
    }
    
    // Renvoie une bière
    public function product($product_id)
    {
        $st = $this->pdo->prepare("SELECT * FROM product WHERE id = ?");
        $st->execute([$product_id]);
        return $st->fetch();
    }
    
    // Renvoie un tableau listant les services d'une bière
    public function product_services($product_id)
    {
        $st = $this->pdo->prepare("SELECT * FROM service WHERE product_id = ?");
        $st->execute([$product_id]);
        return $st->fetchAll();
    }
    
    // Ajoute une bière et renvoie son ID
    public function add_product($name)
    {
        $st = $this->pdo->prepare("INSERT INTO product (name) VALUES (?)");
        $st->execute([$name]);
        
        return $this->last_id();
    }
}
