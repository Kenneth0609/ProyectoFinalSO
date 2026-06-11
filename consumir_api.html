<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consumo de API - Estudiantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="contenedor">
        <h1>Consumo de API con JavaScript</h1>

        <section class="busqueda">
            <input type="text" id="identificacion" placeholder="Digite la identificación">
            <button onclick="buscarEstudiante()">Buscar</button>
            <button onclick="cargarEstudiantes()">Mostrar todos</button>
        </section>

        <p id="total"></p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                </tr>
            </thead>
            <tbody id="tabla-estudiantes">
            </tbody>
        </table>
    </main>

    <script>
        const API_URL = "api_estudiantes.php";

        async function cargarEstudiantes() {
            try {
                const respuesta = await fetch(API_URL);
                const resultado = await respuesta.json();

                mostrarDatos(resultado);
            } catch (error) {
                console.error("Error al consumir la API:", error);
                alert("No se pudo consumir la API.");
            }
        }

        async function buscarEstudiante() {
            const identificacion = document.getElementById("identificacion").value.trim();

            if (identificacion === "") {
                alert("Digite una identificación.");
                return;
            }

            try {
                const respuesta = await fetch(`${API_URL}?identificacion=${encodeURIComponent(identificacion)}`);
                const resultado = await respuesta.json();

                mostrarDatos(resultado);
            } catch (error) {
                console.error("Error al buscar estudiante:", error);
                alert("No se pudo realizar la búsqueda.");
            }
        }

        function mostrarDatos(resultado) {
            const tabla = document.getElementById("tabla-estudiantes");
            const total = document.getElementById("total");

            tabla.innerHTML = "";
            total.textContent = `Total de registros encontrados: ${resultado.total}`;

            resultado.datos.forEach(estudiante => {
                const fila = document.createElement("tr");

                fila.innerHTML = `
                    <td>${estudiante.id}</td>
                    <td>${estudiante.identificacion}</td>
                    <td>${estudiante.nombre}</td>
                    <td>${estudiante.correo}</td>
                `;

                tabla.appendChild(fila);
            });
        }

        cargarEstudiantes();
    </script>
</body>
</html>