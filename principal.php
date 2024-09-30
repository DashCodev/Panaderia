<!DOCTYPE html>
<html>
<head>
    <title>Panaderia Delicious Bread</title> <!-- Título de la página -->
</head>
<frameset rows="100,*,100" frameborder="0"> <!-- Conjunto de marcos (frameset) con tres filas -->
    <frame src="a.php" /> <!-- Marco superior que carga el contenido de "a.htm" -->
    <frameset cols="15%,*,15%" frameborder="0"> <!-- Conjunto de marcos dentro de la segunda fila, divididos en tres columnas -->
        <frame name="leftFrame" src="b.php" /> <!-- Marco izquierdo que carga el contenido de "b.htm" -->
        <frame name="centerFrame" src="c.php" /> <!-- Marco central que carga el contenido de "c.htm" -->
        <frame name="rightFrame" src="d.php" /> <!-- Marco derecho que carga el contenido de "d.htm" -->
    </frameset>
    <frame src="e.php" /> <!-- Marco inferior que carga el contenido de "e.htm" -->
</frameset>

</html>
