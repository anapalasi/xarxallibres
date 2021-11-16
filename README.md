# Xarxallibres

## Poner seguridad a las contraseñas de los profesores.

Para actualizar las contraseñas de los profesores con funcion hash
*UPDATE `Profesor` SET `contrasenya`=sha2(contrasenya,512)*
Puede dar un error porque no quepa en el campo. Se debe hacer entonces el campo contraseña mas largo

## Actualización grupos profesores

* Importar de ITACA *contenido_matricula* y *horarios_grupo*
* [Pasar de xml a csv](https://www.convertcsv.com/xml-to-csv.htm)
* De *contenido_matricula* eliminar:

  * Enseñanza
  * Idioma
  * ACIs
  * tipo_basico
  * tipo_predom
  * curso_pendiente
* De *horarios_grupos* eliminar:
  *  Plantilla
  *  Hora_desde y Hora_hasta
  *  Enseñanza
  *  Curso
  *  Aula
  *  Idioma
* Ordenar por docente, dia_semana, sesion_orden
* Crear una columna llamada *Texto* con concatenación de grupo y contenido
* Crear una columna llamada *Repetido* que compare la celda de Texto de la fila actual con la anterior. Si coinciden pondrá verdadero y si no, falso
* *Datos-> Filtro automático* y seleccionar que *Repetido* sea verdadero
* Se eliminan las columnas repetidos. Se seleccionan las filas con *Repetido = Verdadero* y con el menú *Hoja-> Eliminar filas*
* Eliminar columnas *Repetido* y *Texto*
* Crear una tabla dinámica con **Campos fila**: *docente, dia_semana, sesion_orden* y **Campos datos** *Recuento grupos*
* Crear un formato condicional para que resalte cuando el recuento sea > 1 que significará que el docente más de un grupo en una sesión
