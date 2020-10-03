<?php
require_once("includes/conexion_db.php");
    
class Paginar
    {
        private $conexion;
        private $limite = 10;
        private $pagina;
        private $consulta;
        private $total;
        private $clave_busq;
        private $campofiltro;
    
        
        public function __construct($cons){
            $objConexion = new Conexion();
            $this->conexion=$objConexion;
            $this->consulta = $cons;
            $respuesta = $this->conexion->generarTransaccion($this->consulta);
            $this->total = $respuesta->num_rows; 
        }

        public function getDatos($p,$clv_busqueda,$cpfiltro) {
            $this->clave_busq=$clv_busqueda;
            $this->campofiltro=$cpfiltro;
            $this->pagina = $p;
            $inicio = ( $this->pagina - 1 ) * $this->limite ;
            
            if($inicio < 0){
                $inicio = 0;
                $this->pagina = 1;
            }
            
            if(($this->total-$this->limite)>0){
                if($inicio > ($this->total-$this->limite)){
                    $inicio = $this->total-$this->limite;
                    $this->pagina = $this->pagina-1;
                }
            }
            
            $consultar = $this->consulta.' limit '.$inicio.','.$this->limite;
            $respuesta = $this->conexion->generarTransaccion($consultar);
            if ($respuesta->num_rows>0) {
                while($row = $respuesta->fetch_assoc()) 
                $resultados[]  = $row;
                
            $result = new stdclass();
            $result->pagina = $this->pagina;
            $result->limite = $this->limite;
            $result->total = $this->total;
            $result->datos = $resultados;   
            return $result;
            }
        }
        //Poner color en donde estoy actualmente
        public function crearLinks( $enlaces ) {
            $ultimo  = ceil( $this->total / $this->limite);
            $comienzo = (($this->pagina - $enlaces) > 0) ? $this->pagina-$enlaces : 1;
            $fin  = (($this->pagina + $enlaces ) < $ultimo) ? $this->pagina+$enlaces : $ultimo;
            $clase = ($this->pagina == 1) ? "disabled" : "";
            $html = '<li class="page-item'.$clase.'"><a class="page-link" aria-label="Previous" href="?campofiltro='.$this->campofiltro.'&producto='.$this->clave_busq.'&limit='.$this->limite.'&page='.($this->pagina-1).'"><span aria-hidden="true">&#9664;</span></a></li>';  
            if($comienzo > 1) {
                $html  .= '<li class="page-item"><a class="page-link" href="?campofiltro='.$this->campofiltro.'&producto='.$this->clave_busq.'&limit='.$this->limite.'&page=1">1</a></li>';
                $html  .= '<li class="disabled"><span>...</span></li>';
            }  
            for($i = $comienzo ; $i <= $fin; $i++) {
                $clase  = ( $this->pagina == $i ) ? "active" : "";
                $claseTexto  = ( $this->pagina == $i ) ? "active bg-primary text-white" : "";
                $html  .= '<li class="page-item'.$clase.'"><a class="page-link '.$claseTexto.'" href="?campofiltro='.$this->campofiltro.'&producto='.$this->clave_busq.'&limit='.$this->limite.'&page='.$i.'">'.$i.'</a></li>';
            }
            if($fin < $ultimo) {
                $html  .= '<li class="disabled"><span>...</span></li>';
                $html  .= '<li class="page-item"><a class="page-link" href="?campofiltro='.$this->campofiltro.'&producto='.$this->clave_busq.'&limit='.$this->limite.'&page='.$ultimo.'">'.$ultimo.'</a></li>';
            }   
            $clase  = ( $this->pagina == $ultimo ) ? "disabled" : "enabled";
            $html  .= '<li class="page-item'.$clase.'"><a aria-label="Next" class="page-link"  href="?campofiltro='.$this->campofiltro.'&producto='.$this->clave_busq.'&limit='.$this->limite.'&page='.($this->pagina+1).'"><span aria-hidden="true">&#9654;</span></a></li>';
            return $html;
        }
    
    }
    
?>