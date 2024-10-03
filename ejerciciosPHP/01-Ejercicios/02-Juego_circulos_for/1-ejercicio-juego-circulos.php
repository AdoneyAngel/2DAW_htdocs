<?php

    /* Escriba un programa que dibuje entre 
     * 1 y 10 círculos negros (al azar) en una fila de tabla.
     */

    echo "  <table class=\"conborde\">\n";
    echo "    <tbody>\n";
    echo "      <tr>\n";
        echo "        <td>\n";
        echo "          <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" width=\"70\" height=\"70\">\n";
        echo "            <circle cx=\"35\" cy=\"35\" r=\"30\" fill=\"black\" />\n";
        echo "          </svg>\n";
        echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </tbody>\n";
    echo "  </table>\n";
?>