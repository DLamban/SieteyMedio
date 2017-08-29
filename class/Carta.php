<?php

/**
 * Class Carta
 * Carta sera un objeto con diferentes propiedades: palo, numero, esFigura
 */
class Carta{
    private $palo;
    private $numero;
    private $esFigura;

    public function __construct($palo,$numero){
        $this->palo=$palo;
        $this->numero=$numero;
        $this->esFigura= $numero>7;
    }
    public function getValor(){
        if ($this->numero>7) {return 0.5;}
        return $this->numero;
    }

    public function getPalo(){
        return $this->palo;
    }

    public function getName(){
        switch ($this->numero){
            case 1:
                return "As";
                break;
            case 8:
                return "Sota";
                break;
            case 9:
                return "Caballo";
                break;
            case 10:
                return "Rey";
                break;
            default:
                return $this->getValor();
                break;
        }
    }

}