# Xarxallibres

## Incorporar nuevo profesorado

En *Gestió de curs-> Actualització nou professorat*.

![Pantalla actualización nuevo profesorado](https://user-images.githubusercontent.com/24894039/141972611-85b87f03-684e-49c0-ab74-007e521c526c.png)

## Poner seguridad a las contraseñas de los profesores.

Para actualizar las contraseñas de los profesores con funcion hash
*UPDATE `Profesor` SET `contrasenya`=sha2(contrasenya,512)*

Puede dar un error porque no quepa en el campo. Se debe hacer entonces el campo contraseña mas largo

## Actualización contenidos

1. Exportar contenidos de ITACA
2. [Pasar de xml a csv](https://www.convertcsv.com/xml-to-csv.htm)
3. Eliminar las columnas Enseñanza y nombre en castellano
4. Substituir en curso:
  1. 2712304870 por 1ESO
  2. 2712304883 por 2ESO
  3. 2712304855 por 3ESO
  4. 2712304926 por 3PMAR
  5. 2712304896 por 4ESO
  6. 2712304946 por PR4
  7. Eliminar el resto de filas


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
* Eliminar filas de las enseñanzas de Bachillerato y Ciclos
* Hacer un filtro automático donde se seleccionen las asignaturas que no tienen libros y eliminar esas filas como en el paso anterior.
* Crear una tabla dinámica con **Campos fila**: *docente, dia_semana, sesion_orden* y **Campos datos** *Recuento grupos*
* Crear un formato condicional para que resalte cuando el recuento sea > 1 que significará que el docente más de un grupo en una sesión.
* Buscar las asignaturas que tienen más de un grupo y apuntarlas.
