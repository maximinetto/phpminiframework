<?php

require_once 'clases/usuario.php';
require_once 'clases/factory_audiovisual.php';
require_once "clases/helpers/utils.php";

class UserRepository {

    private $db;

    public function __construct()
    {
        $this->db=DB::conexion();    
    }

    public function getUsuariosFavoritos(){
        
        $sql="SELECT * FROM usuarios ".
        "LEFT JOIN favoritos ".
        "ON usuarios.id = favoritos.id_usuario";

        $resultados=array();
        
        $resultado =$this->db->query($sql)   
        or die ("Fallo en la consulta");
        
        $previousID = null; 

        $objeto = null;
        while ( $fila = $resultado->fetch_object() )
        {
            $lastID = $fila["id"];
            
            if( self::isDifferentUser($previousID, $lastID) ){
                $objeto = new Usuario($fila);
            }   
            
            $tipo = $fila["tipo"];
            $audiovisual = FactoryAudioVisual::getAudiovisual($tipo, $fila);
            $objeto->setPeliculasFavoritas($audiovisual);
            
            if(isset($objeto))
                $resultados[$lastID] = $objeto;
            
            $previousID = $lastID;
            
        }

        return $resultados;
    }

    function getUsuarioFavoritos($idUser){
        $sql = "SELECT favoritos.imdbID as imdbID, tipo FROM favoritos " .
             "WHERE " . 
             "favoritos.id_usuario = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $idUser);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $audiovisuales = array();
        
        while ( $fila = $resultado->fetch_object() ) {
            $current = objectToArray($fila);
            $tipo = $current["tipo"];
            $audiovisual = FactoryAudioVisual::getAudiovisual($tipo, $current);
            $audiovisuales[] = $audiovisual;
        }

        return $audiovisuales;
    }

    public function guardar($idUsuario, $favoritas){
        foreach($favoritas as $favorita){
            $stmt = $this->db->prepare( 
                "INSERT INTO favoritos 
            (id_usuario, imdbID, tipo) 
               VALUES (?,?,?)" );
            $stmt->bind_param("iss",$idUsuario, $favorita->getIdVideo(), $favorita->tipo());

            if(!$stmt->execute()) {
                echo "Fallo la ejecución";
                return;
            }       
        }
    }

    public function borrarFavorito($idUsuario, $favorita){
        $stmt = $this->db->prepare(
            "DELETE FROM favoritos" .
            "WHERE " . 
            "id_usuario = ? AND imdbID = ?"
        );

        $stmt->bind_param("is", $idUsuario, $favorita->getIdVideo());

        return $stmt->execute();
        
    }

    private function isDifferentUser($previousID, $lastID){
        if(!isset($previousID))
            return false;

        return $previousID !== $lastID;
    }

}