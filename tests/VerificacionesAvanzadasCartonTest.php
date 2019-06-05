<?php

namespace Bingo;

use PHPUnit\Framework\TestCase;

class VerificacionesAvanzadasCartonTest extends TestCase {

  /**
   * Verifica que los números del carton se encuentren en el rango 1 a 90.
   */
  public function testUnoANoventa() {
    $carton = new CartonJs;
    foreach ($carton->filas() as $fila) {
      foreach (celdas_ocupadas($fila) as $celda) {
        $this->assertTrue(1 <= $celda && $celda <= 90);
      }
    }
  }

  /**
   * Verifica que cada fila de un carton tenga exactamente 5 celdas ocupadas.
   */
  public function testCincoNumerosPorFila() {
    $carton = new CartonJs;
    $cantNumeros = 0;
    foreach($carton->filas() as $fila){
      foreach($fila as $celda){
        if($celda != 0){
          $cantNumeros += 1;    
        }
      }
      $this->assertEquals(5, $cantNumeros);
      $cantNumeros = 0;
    }
  }

  /**
   * Verifica que para cada columna, haya al menos una celda ocupada.
   */
  public function testColumnaNoVacia() {
    $carton = new CartonJs;
    $cantNumeros = 0;
    foreach($carton->columnas() as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      $this->assertNotEquals(0, $cantNumeros);
      $cantNumeros = 0; 
    }
  }

  /**
   * Verifica que no haya columnas de un carton con tres celdas ocupadas.
   */
  public function testColumnaCompleta() {
    $carton = new CartonJs;
    $cantNumeros = 0;
    foreach($carton->columnas() as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      $this->assertNotEquals(3, $cantNumeros);
      $cantNumeros = 0; 
    }
  }

  /**
   * Verifica que solo hay exactamente tres columnas que tienen solo una celda
   * ocupada.
   */
  public function testTresCeldasIndividuales() {
    $carton = new CartonJs;
    $cantNumeros = 0;
    $celdasIndividuales = 0;
    foreach($carton->columnas() as $columna){
      foreach($columna as $celda){
        if($celda != 0)
          $cantNumeros ++; 
      }
      if($cantNumeros == 1)
        $celdasIndividuales ++;
      $cantNumeros = 0; 
    }
    $this->assertEquals(3, $celdasIndividuales);
  }

  /**
   * Verifica que los números de las columnas izquierdas son menores que los de
   * las columnas a la derecha.
   * min (array_filter($lista)) //min de lista sin cero.
   */
   
  public function testNumerosIncrementales() {
    $carton = new CartonJs;
    $indice = 0;
    $mayores[];
    $menores[];
    foreach ($carton->columnas() as $columna){
      $mayores[$indice] = 1;
      $menores[$indice] = 90;
      foreach (celdas_ocupadas($columna) as $celda){
        if ($mayores[$indice] < $celda)
          $mayores[$indice] = $celda;
        if ($menores[$indice] > $celda)
          $menores[$indice] = $celda;
      }
      $indice ++;
    }
    for ($indice = 0; $indice < 8; $indice ++){
      $this->assertTrue($mayores[$indice] < $menores[$indice + 1]);
    }
  }


  /**
   * Verifica que en una fila no existan más de dos celdas vacias consecutivas.
   */
  public function testFilasConVaciosUniformes() {
    $carton = new CartonJs;
    foreach($carton->filas() as $fila){
      $anterior = 1;
      $anterior_anterior = 1;
      foreach($fila as $celda){
        $this->assertFalse($anterior == $anterior_anterior && $anterior == $celda && $anterior == 0);

        $anterior_anterior = $anterior;
        $anterior = $celda;
      }
    }
  }

}
