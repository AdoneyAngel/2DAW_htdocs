<?php
    /*
     * Escriba un programa que dibuje entre 1 y 10 círculos de colores (al azar)
     * usaremos colores HSL y numerados (al azar, del 1 al 9) en una fila de tabla.
     */

    echo "  <table class=\"conborde\">\n";
    echo "    <tbody>\n";
    echo "      <tr>\n";
        echo "        <td>\n";
        echo "          <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" width=\"70\" height=\"70\" font-size=\"45\">\n";
        echo "            <circle cx=\"35\" cy=\"35\" r=\"30\" fill=\"hsl(, 100%, 50%)\" />\n";
        echo "            <text x=\"35\" y=\"50\" text-anchor=\"middle\"></text>\n";
        echo "          </svg>\n";
        echo "        </td>\n";
    echo "      </tr>\n";
    echo "    </tbody>\n";
    echo "  </table>\n";
?>