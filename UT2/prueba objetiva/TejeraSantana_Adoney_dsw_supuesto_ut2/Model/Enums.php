<?php

enum tipoAsiento: string
{
    case Disponible = 'A';
    case Ocupado = 'U';
    case Reservado = 'R';
    case Minusvalido_Libre = 'B';
    case Minusvalido_Ocupado = 'P';
    case Libre = '_';
}

enum salaEnum: string
{
    case Sala1 = "Sala1";
    case Sala2 = "Sala2";
    case Sala3 = "Sala3";
    case Sala4 = "Sala4";
}

enum tipoSala: string
{
    case NORMAL2D = "2D";
    case ATMOS = "ATMOS";
    case SCREENX = "SCREENX";
    case IMAX = "IMAX";
}

enum precioAsiento: string
{
    // El descuento por asientos minusválidos es de 2 euros en todos los tipos de salas.
    case DESCUENTO = "2";
    case NORMAL2D = "9.10";
    case ATMOS = "11";
    case SCREENX = "10.10";
    case IMAX = "12";
}
