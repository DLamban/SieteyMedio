<?php

require_once 'Jugador.php';
class JugadorIA extends Jugador{
    public function tomarDecision($puntuacionMax){
        if ($this->esMano==true){
            return $this->tomarDecisionBanca($puntuacionMax);
        }
        else{
            return $this->tomarDecisionJugador($puntuacionMax);
        }
    }

    public function tomarDecisionBanca($puntuacionMax){
        if (($this->puntos<$puntuacionMax && $this->puntos<7.5) || $puntuacionMax==0){
            return true;
        }
        return false;
    }

    public function tomarDecisionJugador($puntuacionMax){
        //se plantan en 6, en el blackjack el crupier se planta en 17 asi que el 6 me parece bien en 7 y medio
        if (($this->puntos<6)){
            return true;
        }
        return false;
    }
}