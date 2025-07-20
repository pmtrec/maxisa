<?php
namespace PMT\SRC\Entity;

use PMT\APP\CORE\ABSTRACT\AbstractEntity;
class UsersEntity extends AbstractEntity{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $telephone;
    private string $password;
    private string $adresse;
    private string $numeroCarteIdentite;
    private string $photoRecto;
    private string $photoVerso;
    private TypeUser $typeUsers;
    private array $comptes=[];
    private array $numeros=[];
    public function __construct(int $id=0, string $nom="", string $prenom="", string $telephone="", string $password="", string $adresse="", string $numeroCarteIdentite="", string $photoRecto= "", string $photoVerso= ""){
        $this->id= $id;
        $this->nom= $nom;
        $this->prenom= $prenom;
        $this->password= $password;
        $this->adresse= $adresse;
        $this->numeroCarteIdentite= $numeroCarteIdentite;
        $this->photoRecto= $photoRecto;
        $this->photoVerso= $photoVerso;
    }
    
    public static function toArray():array{
        return[
            "id"=> $this->id,
            "nom"=> $this->nom,
            "prenom"=> $this->prenom,
            "login"=> $this->login,
            "password"=> $this->password,
            "adresse"=> $this->adresse,
            "numeroCarteIdentite"=> $this->numeroCarteIdentite,
            "photoIdentite"=> $this->photoIdentite,
            "typeUsers"=> $this->typeUsers instanceof TypeUser ?$this->typeUsers->toArray() : null,
            "comptes"=>is_array($this->comptes)? array_map(fn(compte $compte)=>$compte->toArray(),$this->comptes)
            :$this->comptes,
            "numero"=>is_array($this->numeros)? array_map(fn(numero $numero)=>$numero->toArray(),$this->numeros):
          $this->numeros

        ];
    }
    public static function toObject($data):static{
        return $object= new static(
        $data["id"],
        $data["nom"],
        $data["prenom"],
        $data["telephone"],
        $data["password"],
        $data["adresse"],
        $data["num_carte_identite"],
        $data["photorecto"],
        $data["photoverso"],
       
        );

        if(!empty($data["typeUsers"]) && is_array( $data["typeUsers"] )){
            $object->setTypeUsers(TypeUser::toObject($data["typeUsers"]));
        }
      

        // a comprendre

    //       foreach ($data as $key => $value) {
    //     $method = 'set' . ucfirst($key);
    //     if (method_exists($user, $method)) {
    //         $user->$method($value);
    //     } else {
    //         error_log("Méthode $method inexistante dans UsersEntity"); // log utile pour debug
    //     }
    //    }
    }
    // "comptes" => is_array($this->comptes)
    // ? array_map(
    //     fn($c) => is_object($c) && method_exists($c, 'toArray') ? $c->toArray() : null,
    //     $this->comptes
    // )
    // : [],


    
    public function getId(){  return $this->id;}
    public function setId($id){$this->id = $id;return $this;}
    public function getNom(){return $this->nom;}
    public function setNom($nom){$this->nom = $nom;return $this;}
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of adresse
     */ 
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set the value of adresse
     *
     * @return  self
     */ 
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function addNumero($numero)
    {
        $this->numero[] = $numero;

        return $this;
    }

    /**
     * Get the value of numeroCarteIdentite
     */ 
    public function getNumeroCarteIdentite()
    {
        return $this->numeroCarteIdentite;
    }

    /**
     * Set the value of numeroCarteIdentite
     *
     * @return  self
     */ 
    public function setNumeroCarteIdentite($numeroCarteIdentite)
    {
        $this->numeroCarteIdentite = $numeroCarteIdentite;

        return $this;
    }

    /**
     * Get the value of photoIdentite
     */ 
    public function getPhotoIdentite()
    {
        return $this->photoIdentite;
    }

    /**
     * Set the value of photoIdentite
     *
     * @return  self
     */ 
    public function setPhotoIdentite($photoIdentite)
    {
        $this->photoIdentite = $photoIdentite;

        return $this;
    }

    /**
     * Get the value of typeUsers
     */ 
    public function getTypeUsers()
    {
        return $this->typeUsers;
    }

    /**
     * Set the value of typeUsers
     *
     * @return  self
     */ 
    public function setTypeUsers($typeUsers)
    {
        $this->typeUsers = $typeUsers;

        return $this;
    }
}