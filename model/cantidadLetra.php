<?php 
function cambiarCantidadALetra($tyCantidad)  {  
    $tyCantidad = round($tyCantidad * 100) / 100; 
    $lyCantidad = (int)$tyCantidad; 
    $lyCentavos = ($tyCantidad - $lyCantidad) * 100; 
    $lyCentavos = round($lyCentavos * 100) / 100; 
    $laUnidades = Array("UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE", "VEINTE", "VEINTIUN", "VEINTIDOS", "VEINTITRES", "VEINTICUATRO", "VEINTICINCO", "VEINTISEIS", "VEINTISIETE", "VEINTIOCHO", "VEINTINUEVE"); 
    $laDecenas = Array("DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"); 
    $laCentenas = Array("CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"); 
    $lnNumeroBloques = 0; 
    do 
    { 
        $lnNumeroBloques++; 
        $lnPrimerDigito = 0; 
        $lnSegundoDigito = 0; 
        $lnTercerDigito = 0; 
        $lcBloque = ""; 
        $lnBloqueCero = 0; 
        for($i = 1; $i <= 3; $i++) 
        { 
            $lnDigito = $lyCantidad%10; 
            if($lnDigito != 0) { 
                switch($i) 
                { 
                    case 1: 
                    $lcBloque = " " . $laUnidades[$lnDigito - 1]; 
                    $lnPrimerDigito = $lnDigito; 
                    break; 
                    case 2: 
                    If ($lnDigito <= 2) 
                    { 
                        $lcBloque = " " . $laUnidades[($lnDigito * 10) + $lnPrimerDigito - 1]; 
                    } 
                    else 
                    { 
                        if($lnPrimerDigito != 0) 
                        { 
                            $y =" Y"; 
                        } 
                        else 
                        { 
                            $y=" "; 
                        } 
                        
                        $lcBloque = " " . $laDecenas[$lnDigito - 1] . $y . $lcBloque; 
                    } 
                    $lnSegundoDigito = $lnDigito; 
                    break; 
                    case 3: 
                    if($lnDigito == 1 and $lnPrimerDigito == 0 and $lnSegundoDigito == 0) 
                    { 
                        $cien = "CIEN"; 
                    } 
                    else 
                    { 
                        $cien = $laCentenas[$lnDigito - 1]; 
                    } 
                    $lcBloque = " " . $cien . $lcBloque; 
                    $lnTercerDigito = $lnDigito; 
                    break; 
                } 
            } 
            else 
            { 
                $lnBloqueCero = $lnBloqueCero + 1; 
            } 
            $lyCantidad = $lyCantidad / 10; 
            $lyCantidad = (int)$lyCantidad; 
            If ($lyCantidad == 0) 
            { 
                break; 
            } 
        } 
        switch($lnNumeroBloques) 
        { 
            case 1: 
            $CantidadEnLetra = $lcBloque; 
            $CORTALETRA = substr($CantidadEnLetra, -2);  
            if ($CORTALETRA == "UN") 
            { 
                $CantidadEnLetra = $lcBloque . "O"; 
            } 
            break; 
            case 2: 
            if ($lcBloque == " UN") 
            { 
                if($lnBloqueCero != 3) 
                { 
                    $mil= " MIL"; 
                } 
                $CantidadEnLetra = $mil . $CantidadEnLetra; 
                $CORTALETRA = substr($CantidadEnLetra, -2); 
                if ($CORTALETRA == "UN") 
                { 
                    $CantidadEnLetra = $lcBloque . "O"; 
                } 
            } 
            else 
            { 
                if($lnBloqueCero != 3) 
                { 
                    $mil=" MIL"; 
                } 
                $CantidadEnLetra = $lcBloque . $mil . $CantidadEnLetra; 
                $CORTALETRA = substr($CantidadEnLetra, -2); 
                if ($CORTALETRA == "UN") 
                { 
                    $CantidadEnLetra = $lcBloque . "O"; 
                } 
            } 
            break; 
            case 3: 
            if($lnPrimerDigito == 1 And $lnSegundoDigito == 0 And $lnTercerDigito == 0) 
            { 
                $millon= " MILLON"; 
            } 
            else 
            { 
                $millon= " MILLONES"; 
            } 
            $CantidadEnLetra = $lcBloque . $millon . $CantidadEnLetra; 
            $CORTALETRA = substr($CantidadEnLetra, -2); 
            if ($CORTALETRA == "UN") 
            { 
                $CantidadEnLetra = $lcBloque . "O"; 
            } 
            break; 
        } 
    }while($lyCantidad > 0); 
    if($lyCentavos == 0){
        $con=" PESOS "; 
        return $CantidadEnLetra = $CantidadEnLetra . $con . "MN"; 
    }else{
        $con=" PESOS CON "; 
        return $CantidadEnLetra = $CantidadEnLetra . $con . $lyCentavos . "/100 MN"; 
    }
//return $CantidadEnLetra; 
} 
//PARA LLAMAR A LA FUNCION 
//echo CantidadEnLetra(23.24); 
//echo "<br>"; 
//echo CantidadEnLetra(2020202020.22); 
//echo CantidadEnLetra($_POST['total']); 
?>