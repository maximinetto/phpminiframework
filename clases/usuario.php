<?php
require_once("clases/audiovisual.php");

class Usuario extends ClaseBase{
	public $id=0;
    public $nombre = '';
	public $apellido = '';
    public $ci = '';
	public $edad = 0;
    public $email='';
    public $foto='';
    private $password;

    private $peliculasFavoritas;

    //Contructor que recibe un array
	public function __construct($obj=NULL) {
        //$this->db=DB::conexion();
        if(isset($obj)){
            foreach ($obj as $key => $value) {
                $this->$key=$value;
            }    
        }
        $tabla="usuarios";
        parent::__construct($tabla);
        $this->peliculasFavoritas = array();
    }
   
    public function getid() {
        return $this->id;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    
    public function getApellido() {
        return $this->apellido;
    }
    
    public function getCI() {
        return $this->ci;
    }
    
    public function getEdad() {
        return $this->edad;
    }
    
    public function getFoto() {
        return $this->foto;
    }
    

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setId($idUsuario){
        $this->id = $idUsuario;
    }

    public function setEmail($email){
        $this->email=$email;
    }
    
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }
    
    public function setCI($ci){
        $this->ci=$ci;
    }
    
    public function setEdad($edad){
        $this->edad=$edad;
    }

    public function setFoto($foto){
        $this->foto=$foto;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPeliculasFavoritas(){
        return $this->peliculasFavoritas;
    }

    public function agregarPeliculaFavorita(AudioVisual $film){
        $this->peliculasFavoritas[$film->getIdVideo()] = $film;
    }

    public function eliminarPeliculaFavorita(AudioVisual $film){
        unset($this->peliculasFavoritas[$film->getIdVideo()]);
    }

    public function setPeliculasFavoritas($peliculasFavoritas){
        $this->peliculasFavoritas = $peliculasFavoritas;
    }    

    public function getBusqueda($buscar){
        $usuarios=array();
        $stmt = $this->getDB()->prepare( 
            "SELECT * FROM usuarios 
            WHERE nombre like ? " );
        // Le agrego % para busque los que empiezan con la letra o terminan
        $buscar= '%'.$buscar.'%';
        $stmt->bind_param( "s",$buscar);
        $stmt->execute();
        $resultado = $stmt->get_result();
        while ($fila=$resultado->fetch_object()) {
            $persona= new Usuario($fila);
            $usuarios[]=$persona;
        }
        return $usuarios;
    }

    public function getUsuarioByID($id){
        $stmt = $this->getDB()->prepare( 
            "SELECT * FROM usuarios 
            WHERE id = ? " );

        $stmt->bind_param( "i", $id );
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        while ( $fila = $resultado->fetch_object() ) {
            $persona= new Usuario($fila);
        }
        return $persona;
    }
    

    public function agregar(){
        
        $nombre=$this->getNombre();
        $ape=$this->getApellido();
        $edad=$this->getEdad();
        $ci=$this->getCI();
        $password = sha1("123456");
        $email=$this->getEmail();
        $foto=$this->getFoto();

        $stmt = $this->getDB()->prepare( 
            "INSERT INTO usuarios 
        (nombre, apellido, edad, ci, email, pass, foto) 
           VALUES (?, ?, ?, ?, ?, ?, ?)" );

        $stmt->bind_param("ssissss",$nombre,
            $ape,$edad,$ci,$email,$password, $foto);
        return $stmt->execute();
    
    }

    public function editar(){
        
        Session::init();
        $log= Logger::defaultLog();
        $idUsuario = Session::get('usuario_id');
        $nombre=$this->getNombre();
        $ape=$this->getApellido();
        $edad=$this->getEdad();
        $ci=$this->getCI();
        $password = sha1($this->password);
        $email=$this->getEmail();
        $foto=$this->getFoto();

        $stmt = $this->getDB()->prepare( 
            "UPDATE usuarios 
            SET nombre = ?, apellido = ?, edad = ?, ci = ?, 
                email = ?, pass= ?, foto = ? 
            WHERE id = ?" );

        $stmt->bind_param("ssissssi",$nombre,
            $ape,$edad,$ci,$email,$password, $foto, $idUsuario);
        return $stmt->execute();
    
    }




    public function login($email,$pass){
        $stmt = $this->getDB()->prepare( "SELECT * from  usuarios WHERE email=? AND pass=?" );
        $stmt->bind_param("ss",$email,$pass);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if($resultado->num_rows<1){
            return false;
        }    
        $res=$resultado->fetch_object();
        Session::init();
        Session::set('usuario_logueado', true);
        Session::set('usuario_id', $res->id);
        Session::set('usuario_nombre', $res->nombre);
        Session::set('usuario_email', $res->email);
        Session::set("foto", $res->foto);
        return true;
    }
    
   public function logout(){
        Session::init();
        Session::destroy();
   } 

   public function __toString()
   {
       return "$this->nombre $this->apellido $this->ci";
   }
}
?>