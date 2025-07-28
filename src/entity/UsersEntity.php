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
    private ?int $typeId;
    private array $comptes=[];
    
    public function __construct(
        int $id = 0, 
        string $nom = "", 
        string $prenom = "", 
        string $telephone = "", 
        string $password = "", 
        string $adresse = "", 
        string $numeroCarteIdentite = "", 
        string $photoRecto = "", 
        string $photoVerso = "",
        ?int $typeId = null
    ){
        $this->id= $id;
        $this->nom= $nom;
        $this->prenom= $prenom;
        $this->telephone= $telephone;
        $this->password= $password;
        $this->adresse= $adresse;
        $this->numeroCarteIdentite= $numeroCarteIdentite;
        $this->photoRecto= $photoRecto;
        $this->photoVerso= $photoVerso;
        $this->typeId= $typeId;
    }
    
    public function toArray():array{
        return[
            "id"=> $this->id,
            "nom"=> $this->nom,
            "prenom"=> $this->prenom,
            "telephone"=> $this->telephone,
            "password"=> $this->password,
            "adresse"=> $this->adresse,
            "numeroCarteIdentite"=> $this->numeroCarteIdentite,
            "photoRecto"=> $this->photoRecto,
            "photoVerso"=> $this->photoVerso,
            "typeId"=> $this->typeId,
            "comptes"=> $this->comptes
        ];
    }
    
    public static function toObject($data):static{
        return new static(
            $data["id"] ?? 0,
            $data["nom"] ?? "",
            $data["prenom"] ?? "",
            $data["telephone"] ?? "",
            $data["password"] ?? "",
            $data["adresse"] ?? "",
            $data["num_carte_identite"] ?? "",
            $data["photorecto"] ?? "",
            $data["photoverso"] ?? "",
            $data["type_id"] ?? null
        );
    }

    // Getters et Setters
    public function getId(){  return $this->id;}
    public function setId($id){$this->id = $id;return $this;}
    
    public function getNom(){return $this->nom;}
    public function setNom($nom){$this->nom = $nom;return $this;}
    
    public function getPrenom(){return $this->prenom;}
    public function setPrenom($prenom){$this->prenom = $prenom;return $this;}
    
    public function getTelephone(){return $this->telephone;}
    public function setTelephone($telephone){$this->telephone = $telephone;return $this;}
    
    public function getPassword(){return $this->password;}
    public function setPassword($password){$this->password = $password;return $this;}
    
    public function getAdresse(){return $this->adresse;}
    public function setAdresse($adresse){$this->adresse = $adresse;return $this;}
    
    public function getNumeroCarteIdentite(){return $this->numeroCarteIdentite;}
    public function setNumeroCarteIdentite($numeroCarteIdentite){$this->numeroCarteIdentite = $numeroCarteIdentite;return $this;}
    
    public function getPhotoRecto(){return $this->photoRecto;}
    public function setPhotoRecto($photoRecto){$this->photoRecto = $photoRecto;return $this;}
    
    public function getPhotoVerso(){return $this->photoVerso;}
    public function setPhotoVerso($photoVerso){$this->photoVerso = $photoVerso;return $this;}
    
    public function getTypeId(){return $this->typeId;}
    public function setTypeId($typeId){$this->typeId = $typeId;return $this;}
    
    public function getComptes(){return $this->comptes;}
    public function setComptes($comptes){$this->comptes = $comptes;return $this;}
    public function addCompte($compte){$this->comptes[] = $compte;return $this;}
}