<?php
	function obtener_edad_segun_fecha($fecha_nacimiento)
	{
		$nacimiento = new DateTime($fecha_nacimiento);
		$fecha_inicio = new DateTime("2024-01-01");
		$diferencia = $fecha_inicio->diff($nacimiento);
		return $diferencia->format("%y");
	}

	function obtener_categoria_segun_edad($edad)
	{
		switch ($edad) {
			case $edad < 30:
				$categoria='ELITE';
				break;
			case $edad < 40:
				$categoria='MASTER 30';
				break;
            case $edad < 50:
                $categoria='MASTER 40';
                break;
            case $edad < 60:
                $categoria='MASTER 50';
                break;
            case $edad > 59:
                $categoria='MASTER 60';
                break;
		}
		return $categoria;
	}

	//función para quitar acentos
	function dropAccents($articulo){        
		//Y si reemplazas ñ por ñ y Ñ por Ñ
		  $tofind = "ÀÁÂÄÅàáâäÒÓÔÖòóôöÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿñÑ";
		  $replac = "AAAAAaaaaOOOOooooEEEEeeeeCcIIIIiiiiUUUUuuuuyñÑ";
		  return iconv('utf-8','cp1252',strtr(iconv('utf-8','cp1252',$articulo), iconv('utf-8','cp1252',$tofind), $replac));
		}
	  
?>