<?php

class classTabella {
/*
 * Dichiaro le variabili che utilizzerò all'interno della classe
 */
   var $_tabella;
   var $_numRiga;
   var $_valTabella;
   var $_valRiga;

   /*
   * Funzione che setta le varie variabili.
   */
    function __construct (){
       $this->_numRiga = 1; // la si imposta a 1 perchè il valore 0 corrisponde al tag table
       $this->_tabella = array ();
       $this->_valTabella = array ();
       $this->_valRiga = array();
    }

   /*
   * Funzione che consente di gestire i vari attributi
   * ACCESSO : PUBBLICO
   * IN => $attributi = array con chiave e valore width e 600
   * OUT => border=600 alt=400
   */
   public function stdAttributiTabella($valAttributi){
     if ($valAttributi == "")
        $this->_tabella[0][0]["attributi"] = "";
     else {
        $this->_tabella[0][0]["attributi"] = "";
        foreach ($valAttributi As $chiave => $valore){
          $this->_tabella[0][0]["attributi"] .= "$chiave=\"$valore\" ";
        }
      }
    }

    /*
     * Funzione che setta in una variabile interna i valorii della matrice valori
     * ACCESSO : PUBBLICO
     * IN => $matriceValore = matrice contenente il contenuto della tabella
     * OUT => Nulla
     */
    public function setValoriTabella ($matriceValore){
       for ($i = 1 ; $i <= count($matriceValore) ; $i++)
         for ($k = 0 ; $k < count($matriceValore[$i]) ; $k++)
             $this->_valTabella[$i][$k] = $matriceValore[$i][$k];
    }

    /*
     * Funzione che per ogni riga setta un valore corrispondente
     * a differenza della funzione sopra che prima si doveva settare l'intera
     * matrice per poi passarla alla classe con questa ad ogni riga si passa i
     * valori corrispondenti
     */
    public function addValoreRiga ($rigaMatrice){
        foreach ($rigaMatrice As $chiave => $valore)
             $this->_valRiga[$this->_numRiga][$chiave] = $valore;
    }

    /*
     * Funzione che dato un indice di riga e colonna ti recupera il valore
     * ACCESSO PRIVATO
     * IN => $indiceRiga / $indiceColonna
     * OUT => Valore
     */
    private function recuperaValore ($indiceRiga, $indiceColonna){
        // Con la voce commentata si utilizza la funzione
        // setValoriTabella;
        //return $this->_valTabella[$indiceRiga][$indiceColonna];
        return $this->_valRiga[$indiceRiga][$indiceColonna];
    }


    /*
     * Funzione che recupera il numero di riga attualmente usato
     *
     *
     */
    private function recuperaRiga ()
    {
        return $this->_numRiga;
    }

    /*
    * Funzione per aggiungere una riga con relative colonne
    *
    *
    */

   public function aggiungiRiga($attRiga,$numColonne,$attColonne){
      // Setto gli attributi per la riga
      $numeroRiga = $this->recuperaRiga();

      $this->_tabella[$numeroRiga][0]["attributiRiga"] = "";
			
			if ( $attRiga ) {
				foreach ($attRiga As $chiaveRiga => $valoreRiga)
					 $this->_tabella[$numeroRiga][0]["attributiRiga"] = "$chiaveRiga=\"$valoreRiga\"";
			}
			else
				$attRiga = "";

      // Aggiungo le varie colonne alla riga
      $this->_tabella[$numeroRiga][0]["numeroColonne"] = $numColonne;

      // Per ogni colonna aggiungo i vari stili
			if ( $attColonne ) {
				$numeroAttributiColonne = count($attColonne);
				for ($n = 0; $n < $numeroAttributiColonne ; $n++)
				{
					 $this->_tabella[$numeroRiga][$n]["attributiColonna"] = "";
					 foreach ($attColonne[$n] As $chiaveColonna => $valoreColonna)
							 $this->_tabella[$numeroRiga][$n]["attributiColonna"] .= "$chiaveColonna=\"$valoreColonna\"";
				 
				}
			}
			else
				$attColonne = "";

      $this->_numRiga = $numeroRiga + 1;
   }

     /*
    * Funzione che crea la tabella vera e propria
    * ACCESSO : PRIVATO
    * IN : NULLA
    * OUT : La tabella in formato html
    */
    private function creaTabella(){

      $content = "\n<table ";
      if (isset($this->_tabella[0][0]["attributi"])){
         $content .= $this->_tabella[0][0]["attributi"];
      }
      else $content .= "";

      $content .= ">\n";

      for ($i = 1 ; $i <= ($this->_numRiga - 1); $i++){       
         $content .= "<tr " . $this->_tabella[$i][0]["attributiRiga"] . ">\n";
         $numeroColonne = $this->_tabella[$i][0]["numeroColonne"];
         for ($k = 0 ; $k < $numeroColonne ; $k++)
         {
             $content .= "<td " . $this->_tabella[$i][$k]["attributiColonna"] . ">\n";
             $content .= $this->recuperaValore($i, $k) . "\n";
             $content .= "</td>\n";
         }
         $content .= "</tr>\n";
      }
      $content .= "</table>\n";

      return $content;
    }

    /*
     * Funzione che stampa a video la tabella
     * ACCESSO PUBBLICO
     * IN : Nulla
     * OUT : la tabella
     */
    public function stampaTabella (){
      // print $this->_tabella[0][0]["attributi"] = "ciao";
       print $this->creaTabella();
    }

    public function recuperaTabella (){
        return $this->creaTabella();
    }


}
/*
 * ESEMPIO DI UTILIZZO PER QUANTO RIGUARDA LA CLASSE
 *
 *

 *
 * ULTERIORE METODO DI USO DELLA CLASSE
 *

print "<html><body>\n";

include "moduli/primoAiuto/classi/classTabella.php";

$myTabella = new classTabella;
$myTabella->setTabella();
$myTabella->stdAttributiTabella(array("border"=>"1","w idth"=>"50%","align"=>"center"));
$myTabella->addValoreRiga(array("Questo e' il titolo"));
$myTabella->aggiungiRiga(array("bgcolor"=>"white"),1,a rray(array("colspan"=>"3")));

$myTabella->addValoreRiga(array("R1C1","R1C2","R1C3"));
$myTabella->aggiungiRiga(array("bgcolor"=>"red"),3,arr ay(array("bgcolor"=>"black"),array("bgcolor"=>"yellow" ),array("bgcolor"=>"yellow")));

$myTabella->addValoreRiga(array("R2C1","R2C2","R2C3"));
$myTabella->aggiungiRiga(array("bgcolor"=>"green"),3,a rray(array("bgcolor"=>""),array("bgcolor"=>""),array(" bgcolor"=>"")));

$myTabella->stampaTabella();

print "</body></html>";


 */

?>

