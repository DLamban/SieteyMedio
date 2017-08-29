<?php

class Jugador{

    private $id;
    protected $cartas;
    protected $puntos;
    protected $esMano;

    public function __construct($id){
        $this->id=$id;
    }

    public function setMano(){
        $this->esMano=true;
    }

    public function isMano(){
        return $this->esMano;
    }

    public function estaEliminado(){
        if ($this->getPuntos()>7.5){
            //claramente eliminado
            return true;
        }
        return false;
    }

    public function empezarJuego(){
        $this->cartas=[];
        $this->puntos=0;
        //$this->esMano=false;
    }

    public function pedirCarta($baraja){
        $carta=$baraja->getCarta();
        array_push($this->cartas,$carta);
        $this->puntos+=$carta->getValor();
        $this->printInfo($carta);
    }
    public function getId(){
        return $this->id;
    }
    public function getPuntos(){
        return $this->puntos;
    }

    public function printInfo($carta){
        echo "\tCarta repartida:".$carta->getName()." de ".$carta->getPalo()."\n";
        echo "\tCartas acumuladas:";
        foreach ($this->cartas as $_carta){
            echo $_carta->getName()." de ".$_carta->getPalo().",";
        }
        echo "Valor acumulado:".$this->getPuntos();
        echo "\n";
    }

    public function pasar(){

    }
}