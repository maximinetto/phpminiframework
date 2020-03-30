<?php
class VerRepository extends ClaseBase {
	public $id_usuario=0;
    private $imdbID;
    private $tipo;

    //Contructor que recibe un array
	public function __construct($obj=NULL) {
        //$this->db=DB::conexion();
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }    
        }
        $tabla="para_ver";
        parent::__construct($tabla);

    }

    public function agregar(){
        
        $id_usuario=$this->getIdUsuario();
        $id_pelicula=$this->getIdPelicula();
        $tipo = $this->getTipo();

        $log = Logger::defaultLog();

        $log->putLog("Usuario: " . $id_usuario);
        $log->putLog("Pelicula: " . $id_pelicula);
        $log->putLog("Tipo: " . $tipo);

        $stmt = $this->getDB()->prepare( 
            "INSERT INTO para_ver 
        (id_usuario, imdbID, tipo) 
           VALUES (?,?,?)" );

        $stmt->bind_param("iss",
        $id_usuario,
            $id_pelicula, $tipo);

        return $stmt->execute();
    
    }
   
    public function getIdUsuario() {
        return $this->id_usuario;
    }

    public function getIdPelicula() {
        return $this->imdbID;
    }

    public function getTipo(){
        return $this->tipo;
    }
    
}
?>