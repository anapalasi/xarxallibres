# xarxallibres

## Poner seguridad a las contraseñas de los profesores.

Para actualizar las contraseñas de los profesores con funcion hash
*UPDATE `Profesor` SET `contrasenya`=sha2(contrasenya,512)*
Puede dar un error porque no quepa en el campo. Se debe hacer entonces el campo contraseña mas largo

## Actualización grupos profesores

* Importar de ITACA *contenido_matricula* y *horarios_grupo*
* (Pasar de xml a csv)[https://www.convertcsv.com/xml-to-csv.htm]

De *contenido_matricula* eliminar:

* Enseñanza
* Idioma
* ACIs
* 
