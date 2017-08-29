<?php

require_once 'Jugador.php';
require_once 'JugadorIA.php';
require_once 'Baraja.php';

class Juego{
    private $jugadores;
    private $esMano;
    private $baraja;
    private $numJug;
    public function __construct(){

        $this->baraja= new Baraja();
        $this->baraja->Barajear();
        $this->empezarJuego();

    }

    public function empezarJuego(){
        $this->numJug=$this->getOptions();

        $id=0;
        $this->jugadores=[];

        for ($i=0;$i<$this->numJug;$i++){
            //por el momento, el jugador humano es siempre el 0
            $_jugador=$i==0? new Jugador($id):new JugadorIA($id);
            $_jugador->empezarJuego();
            array_push($this->jugadores,$_jugador);
            $id++;
            if ($i+1==$this->numJug) $_jugador->setMano();
        }
        $this->ejecutarRonda();
    }

    public function getOptions(){
        echo "Bienvenido al simulador de 7 y medio en PHP\n";
        echo "Para empezar el juego primero teclea el numero de jugadores (min:2, max:6) // en estos momentos solo esta desarrollado para una sola persona, el resto son IA";

        $line = fgets(STDIN);
        $valor = intval($line);

        if ($valor<2 || $valor > 6){
            echo "valor incorrecto para el numero de jugadores.\n";
            //restart
            $this->empezarJuego();
        }
        $numJug=$valor;
        return $numJug;
    }

    public function ejecutarRonda(){
        $this->baraja->Barajear();

        foreach ($this->jugadores as $jugador){
            //reseteamos jugadores
            $jugador->empezarJuego();
            echo "Jugada del jugador ".$jugador->getId()."\n";
            while ($this->ejecutarTurnoIndv($jugador)){}
        }
        //finalizada la ronda, empezamos de nuevo, necesitamos limpiar las variables
        $this->mostrarResultados();
    }

    public function ejecutarTurnoIndv($jugador){

        $decision="";
        if (get_class($jugador)=="JugadorIA"){
            //el juego ayuda a la IA pasandole la puntuacion maxima de la mesa
            $puntuacionMaxMesa=0;
            foreach ($this->jugadores as $_jugador){
                $puntuacionJugador=$_jugador->estaEliminado()==true?0:$_jugador->getPuntos();
                $puntuacionMaxMesa=$puntuacionMaxMesa>$puntuacionJugador?$puntuacionMaxMesa:$puntuacionJugador;
            }
            if($jugador->tomarDecision($puntuacionMaxMesa)) $decision="pedir";
        }

        else {
            $decision= $this->esperandoInput();
        }

        if ($decision=="pedir"){
            $jugador->pedirCarta($this->baraja);
            return true;
        }
        else {
            return false;
        }
    }

    private function mostrarResultados(){
        echo "\nEl juego ha finalizado\n";
        $jugBanca=($this->jugadores[$this->numJug-1]);
        if ($jugBanca->estaEliminado()){
            echo "¡la banca pierde!\n";
            $arrayGanadores=[];
            foreach ($this->jugadores as $jugador){
                if ($jugador->esMano()) continue;
                if (!$jugador->estaEliminado()) array_push($arrayGanadores,$jugador);
            }
            foreach ($arrayGanadores as $ganador){
                echo "El jugador con Id ".$ganador->getId()." gana a la banca con ".$ganador->getPuntos()."\n";
            }
        }
        else{
            //si la banca no esta eliminada es que ha ganado
            echo "¡La banca gana!\n";
        }
        echo "pulsa cualquier tecla para continuar, escribe fin para terminar el programa";
        $line = fgets(STDIN);
        if (trim($line)=="fin"){
            exit();
        }
        $this->ejecutarRonda();
    }

    private function esperandoInput(){
        echo "\tEs tu turno, para pedir una carta utiliza 'p', pulsa cualquier otra tecla para pasar";
        $line = fgets(STDIN);
        if ($line=="p\n") return "pedir";
    }

}