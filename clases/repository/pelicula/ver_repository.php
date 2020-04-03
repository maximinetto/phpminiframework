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

    public function listarPorId(){
        $id_usuario=$this->getIdUsuario();
        $id_pelicula=$this->getIdPelicula();
        
        $stmt = $this->getDB()->prepare(
            "SELECT * FROM para_ver "
            . " WHERE id_usuario = ? AND imdbID = ?"
        );

        $stmt->bind_param("is", $id_usuario, $id_pelicula);

        $success = $stmt->execute();
        
        if(!$success)
            throw new ErrorException("Hubo un error en la consulta");

        $data = $stmt->get_result()->fetch_assoc();
        
        if(isset($data["tipo"])){
            $this->tipo = $data["tipo"];
        }    

        return $data;    
    }

    public function listarPorIdUsuario(){
        $id_usuario=$this->getIdUsuario();
        
        $stmt = $this->getDB()->prepare(
            "SELECT * FROM para_ver "
            . " WHERE id_usuario = ?"
        );

        $stmt->bind_param("i", $id_usuario);

        $success = $stmt->execute();
        
        if(!$success)
            throw new ErrorException("Hubo un error en la consulta");

        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);    

        return $data;    
    }

    public function agregar(){
        
        $id_usuario=$this->getIdUsuario();
        $id_pelicula=$this->getIdPelicula();
        $tipo = $this->getTipo();

        $data = $this->listarPorId();

        if(isset($data["tipo"]))
        {
            return true;
        }

        $stmt = $this->getDB()->prepare( 
            "INSERT INTO para_ver 
        (id_usuario, imdbID, tipo) 
           VALUES (?,?,?)" );

        $stmt->bind_param("iss",
        $id_usuario,
            $id_pelicula, $tipo);

        return $stmt->execute();
    
    }

    public function borrarMasTarde(){
        $id_usuario=$this->getIdUsuario();
        $id_pelicula=$this->getIdPelicula();

        $log = Logger::defaultLog();

        $log->putLog("IDUSUARIO: " . $id_usuario);
        $log->putLog("IDPELICULA: " . $id_pelicula);

        $stmt = $this->getDB()->prepare( 
            "DELETE FROM para_ver " .
             " WHERE " . 
             " id_usuario = ? AND imdbID = ? " );

        $stmt->bind_param("is",
        $id_usuario,
            $id_pelicula);

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