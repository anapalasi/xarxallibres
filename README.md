# xarxallibres

Para actualizar las contraseñas de los profesores con funcion hash
UPDATE `Profesor` SET `contrasenya`=sha2(contrasenya,512)
Puede dar un error porque no quepa en el campo. Se debe hacer entonces el campo contraseña mas largo

