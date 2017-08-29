<?php

require_once 'Carta.php';

class Baraja{

    private $cartas;
    private $cartasRepartidas;

    public function __construct(){
        $palos= array(
            'Espadas'   =>  'Espadas',
            'Bastos'    =>  'Bastos',
            'Copas'     =>  'Copas',
            'Oros'      =>  'Oros');

        $this->cartas= $this->crearBaraja($palos);
        $this->cartasRepartidas=0;
    }


    /**
     * Esta clase crea un array asociativo con los palos y las cartas internas
     * sin embargo, este array no es utilizable para devolver carta ya que esta jerarquizado
     * pero la posibilidad de sacar una carta es independiente de su palo.
     * @param $palos
     * @return mixed
     */
    public function crearBaraja($palos){
        $cartas= [];
        foreach ($palos as $palo){
            //usamos arrays dinamicos y la función push PHP
            for ($i=0;$i<10;$i++){
                $carta= new Carta($palo,$i+1);
                array_push($cartas,$carta);
            }
        }
        return $cartas;
    }


    public function Barajear(){
        shuffle($this->cartas);
        $this->cartasRepartidas=0;
    }

    public function getCarta(){
        $carta=$this->cartas[$this->cartasRepartidas];
        $this->cartasRepartidas++;
        return $carta;
    }
}
