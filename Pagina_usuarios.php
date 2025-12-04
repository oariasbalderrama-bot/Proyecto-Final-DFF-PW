<?php
session_start();
//Verificar si hay sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: Index.php");
    exit();
}

//Verificar que el rol no sea administrador
if ($_SESSION['usuario_rol'] === 'administrador') {
    header("Location: CRUD.php"); 
    exit();
}

//Si el rol es 'usuario', continúa
$nombre_usuario = htmlspecialchars($_SESSION['usuario_nombre']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recetas de Cocina<?= $nombre_usuario ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans bg-gray-50 min-h-screen">

    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-indigo-600">Recetario del chef Oscar</h1>
            
            <div class="flex items-center space-x-4">
                <span class="text-gray-700 font-medium">Bienvenido, <?= $nombre_usuario ?></span>
                <a 
                    href="logout.php" 
                    class="bg-red-500 text-white px-3 py-2 rounded-lg font-semibold hover:bg-red-600 transition duration-150"
                >
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <nav class="bg-white p-6 rounded-xl shadow-md mb-8 flex flex-col sm:flex-row gap-4">
            <input 
                type="text" 
                id="buscar-ingrediente" 
                placeholder="Buscar por ingrediente..." 
                class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
            />
            <input 
                type="text" 
                id="buscar-tiempo" 
                placeholder="Buscar por tiempo de cocción..." 
                class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
            />
        </nav>

        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 border-indigo-500 pb-2">Recetas Populares</h2>
        <section id="populares" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            
            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Ensalada Cesar</h3>
                <img src="Imagenes/Ensalada.jpg" alt="Ensalada Cesar" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        1 lechuga costina grande.<br>
                        1 pechuga de pollo.<br>
                        ½ taza de queso parmesano.<br>
                        Cubos de pan.<br>
                        Aceite de oliva.<br>
                        Páprika.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Lava y corta la lechuga.<br>
                        Cocina el pollo y córtalo en tiras.<br>
                        Tuesta el pan con aceite y páprika.<br>
                        Mezcla todo y agrega el queso.<br><br>
                        Tiempo: 15 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Enchiladas suizas</h3>
                <img src="Imagenes/Enchilada suiza.jpg" alt="Enchiladas suizas" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Tomates verdes, cebolla, jalapeños.<br>
                        Queso crema, cilantro, consomé.<br>
                        Tortillas de maíz, aceite de oliva.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Cocina los tomates con cebolla y chiles.<br>
                        Licúa con queso crema y cilantro.<br>
                        Rellena tortillas, báñalas con la salsa y hornea.<br><br>
                        Tiempo: 45 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Tinga de pollo</h3>
                <img src="Imagenes/tingadepollo.jpeg" alt="Tinga de pollo" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        2 Cubos de Concentrado de Tomate con Pollo<br>
                        1 Chile chipotle adobado<br>
                        1 Taza de puré de tomate natural<br>
                        1/4 De taza de agua<br>
                        3 Jitomates cortados en cuartos<br>
                        2 Cucharadas de aceite de vegetal<br>
                        1/4 De pieza de cebolla fileteada<br>
                        1 Pechuga de pollo cocida y deshebrada (600 g)<br>
                        Tostadas de maíz<br>
                        2 Tazas de lechuga desinfectada y fileteada<br>
                        1 Envase de Media Crema refrigerada (190 g)<br>
                        100 Gramos de queso panela rallado<br>
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Licúa el Concentrado de Tomate con Pollo, el chile chipotle, el puré de tomate, el agua y los jitomates.<br>
                        Calienta el aceite y cocina la cebolla hasta que cambie de color, vierte lo que licuaste, añade la pechuga de pollo y cocina hasta que espese moviendo ocasionalmente; deja enfriar ligeramente.<br>
                        Sirve la tinga sobre las tostadas, decora con la lechuga, la Media Crema y el queso.<br><br>
                        Tiempo: 90 minutos.
                    </p>
                </div>
            </div>
            
            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Albondigas</h3>
                <img src="Imagenes/albondiga.jpeg" alt="Albondigas" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        2 Tazas de Puré de tomate.<br>
                        1 Chile chipotle.<br>
                        3 Tazas de Agua.<br>
                        2 Cubos de Concentrado de Tomate con Pollo.<br>
                        1 Cucharada de Aceite de maíz.<br>
                        800 Gramos Carne de res molida.<br>
                        100 Gramos de Tocino picado y frito.<br>
                        1 Huevo.<br>
                        2 Cucharadas de Jugo MAGGI.<br>
                        1 Cucharada de Salsa Tipo Inglesa.<br>
                        2 Cucharadas de Cebolla finamente picada.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Para la salsa, licúa el puré de tomate, el chile, el agua y el Concentrado de Tomate con Pollo.
                        Calienta el aceite en una olla y cocina la salsa a fuego medio por 10 minutos.<br>
                        Para las albóndigas, mezcla la carne con el tocino, la cebolla, el huevo, el Jugo MAGGI
                        y la Salsa Tipo Inglesa. Forma las albóndigas, colócalas en la salsa, tapa y
                        cocina por 20 minutos a fuego medio o hasta que estén cocidas.<br><br>
                        Tiempo: 30 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Hamburgesa</h3>
                <img src="Imagenes/hamburgesa.jpeg" alt="Hamburgesa" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Carne picada (generalmente de res)<br>
                        Pan de hamburguesa<br>
                        Queso<br>
                        Lechuga<br>
                        Tomate<br>
                        Cebolla<br>
                        Pepinillos<br>
                        Salsas como ketchup, mostaza, y mayonesa.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Forma hamburguesas con carne molida, salpimienta y cocínalas en una sartén caliente con un poco de aceite durante 4-5 minutos por lado.<br>
                        Si deseas, añade queso al final para que se derrita.<br>
                        Tuesta ligeramente los panes, unta las salsas que prefieras y arma la hamburguesa con carne, lechuga, jitomate, cebolla y pepinillos.<br><br>
                        Tiempo: 25 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">HotCakes</h3>
                <img src="Imagenes/hotcakes.jpg" alt="HotCakes" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        1 1/4 Taza de leche semi descremada.<br>
                        1 Huevo.<br>
                        2 cucharadas de azúcar.<br>
                        1 1/2 a 2 tazas de harina(hasta conseguir textura del batido)<br>
                        1 Cucharadita de polvo de hornear<br>
                        1 Cucharada de aceite.<br>
                        1 Cucharadita de esencia de vainilla.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Para los hot cakes, junta todos los ingredientes en la juguera y procesa hasta obtener una mezcla semi-espesa.
                        Luego en una sartén preferentemente de teflón vierte pequeñas cantidades formando círculos de 5 cm aproximados y
                        cocina por ambos lados hasta dorar levemente. Repite el mismo procedimiento hasta acabar la mezcla.<br>
                        Para la salsa de manjar, en un bowl de vidrio o plástico junta el manjar con la leche.
                        Lleva al microondas a potencia media durante 10 segundos, revuelve hasta unificar y retira.<br>
                        Una vez listos, sírvelos de inmediato con la salsa de manjar tibia y acompáñalos con una taza de Nescafé que más
                        te guste.<br><br>
                        Tiempo: 5 minutos.
                    </p>
                </div>
            </div>

        </section>

        <h2 class="text-3xl font-extrabold text-gray-800 mb-6 border-b-2 border-indigo-500 pb-2 mt-12">Recetas Caseras</h2>
        <section id="caseras" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            
            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Pasta con Salsa de Tomate</h3>
                <img src="Imagenes/pasta.png" alt="Pasta con Salsa de Tomate" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Pasta.<br>
                        Tomates.<br>
                        Ajo.<br>
                        Aceite.<br>
                        Especias.<br>
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Cocina la pasta.<br>
                        Sofríe ajo, añade tomate y condimentos.<br>
                        Mezcla con la pasta.<br><br>
                        Tiempo: 20 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Sopa de Fideo</h3>
                <img src="Imagenes/fideos.png" alt="Sopa de Fideo" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Pasta de fideo.<br>
                        Jitomate.<br>
                        Ajo.<br>
                        Cebolla.<br>
                        Caldo o agua.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Dora la pasta en aceite.<br>
                        Licúa jitomate, ajo y cebolla, cuela y añade.<br>
                        Agrega caldo, sal y cocina hasta que el fideo esté suave.<br><br>
                        Tiempo: 30 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Sopes Mexicanos</h3>
                <img src="Imagenes/sopes.png" alt="Sopes Mexicanos" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Masa de maíz.<br>
                        Frijoles refritos.<br>
                        Crema.<br>
                        Queso.<br>
                        Lechuga.<br>
                        Salsa.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Forma discos con la masa y cocina en comal.<br>
                        Pellizca los bordes y fríe ligeramente.<br>
                        Unta frijoles, agrega crema, queso, lechuga y salsa.<br><br>
                        Tiempo: 40 minutos.
                    </p>
                </div>
            </div>
            
            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Huevos a la Mexicana</h3>
                <img src="Imagenes/huevo.png" alt="Huevos a la Mexicana" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Huevos.<br>
                        Jitomate.<br>
                        Cebolla.<br>
                        Chile verde.<br>
                        Sal.<br>
                        Aceite.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Sofríe cebolla, chile y jitomate.<br>
                        Agrega los huevos batidos.<br>
                        Cocina hasta que cuajen.<br><br>
                        Tiempo: 15 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Chilaquiles Rojos</h3>
                <img src="Imagenes/chilaquiles.png" alt="Chilaquiles Rojos" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Tortillas.<br>
                        Salsa roja.<br>
                        Crema.<br>
                        Queso.<br>
                        Cebolla.<br>
                        Aceite.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Fríe totopos (tiras de tortilla).<br>
                        Añade salsa caliente y mezcla.<br>
                        Sirve con crema, queso y cebolla.<br><br>
                        Tiempo: 25 minutos.
                    </p>
                </div>
            </div>

            <div class="tarjeta bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                <h3 class="text-xl font-bold p-4 bg-gray-100 text-gray-800">Tacos Dorados de Pollo</h3>
                <img src="Imagenes/tacos.png" alt="Tacos Dorados de Pollo" class="w-full h-48 object-cover"/>
                <div class="p-4">
                    <button class="btn-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-2">Ver ingredientes</button>
                    <p class="ingredientes max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Ingredientes:<br>
                        Tortillas.<br>
                        Pollo deshebrado.<br>
                        Crema.<br>
                        Queso.<br>
                        Lechuga.<br>
                        Salsa.
                    </p>
                    <button class="btn-preparacion-toggle w-full bg-indigo-500 text-white py-2 rounded-lg font-semibold hover:bg-indigo-600 transition duration-150 mt-3">Ver preparación</button>
                    <p class="preparacion max-h-0 opacity-0 overflow-hidden transition-all duration-500 text-gray-600 mt-2 p-2 border-l-4 border-indigo-300 bg-indigo-50">
                        Rellena tortillas con pollo y enrolla.<br>
                        Fríe hasta dorar.<br>
                        Sirve con crema, queso, lechuga y salsa.<br><br>
                        Tiempo: 30 minutos.
                    </p>
                </div>
            </div>

        </section>
    </div>

    <footer class="bg-gray-800 text-white mt-10 p-8">
        <div class="max-w-7xl mx-auto flex justify-between flex-wrap gap-4">
            <p class="text-sm">Derechos reservados para Arias Oscar</p>
            <div>
                <h4 class="font-semibold mb-1">Contacto Arias:</h4>
                <p class="text-sm">Celular: 6548522</p>
                <p class="text-sm">Correo: oarias@gmail.com</p>
            </div>
        </div>
    </footer>

    <script>
        //Ocultar/Mostrar con clases de Tailwind para transicionar
        function toggleVisibility(button, targetSelector) {
            const target = button.nextElementSibling;
            
            target.classList.toggle('max-h-0');
            target.classList.toggle('opacity-0');
            
            target.classList.toggle('max-h-screen');
            
            const isShown = !target.classList.contains('max-h-0'); // Se considera 'visible' si NO tiene max-h-0
            const isIngredientes = targetSelector === '.ingredientes';

            if (isIngredientes) {
                button.textContent = isShown ? 'Ocultar ingredientes' : 'Ver ingredientes';
            } else {
                button.textContent = isShown ? 'Ocultar preparación' : 'Ver preparación';
            }
        }

        //Mostrar/ocultar ingredientes
        document.querySelectorAll('.btn-toggle').forEach(button => {
            button.addEventListener('click', () => {
                toggleVisibility(button, '.ingredientes');
            });
        });

        //Mostrar/ocultar preparación
        document.querySelectorAll('.btn-preparacion-toggle').forEach(button => {
            button.addEventListener('click', () => {
                toggleVisibility(button, '.preparacion');
            });
        });

        const tarjetas = document.querySelectorAll('.tarjeta');

        //Filtro por ingrediente
        document.getElementById('buscar-ingrediente').addEventListener('input', function () {
            const filtro = this.value.toLowerCase();
            tarjetas.forEach(tarjeta => {
                const textoIngredientes = tarjeta.querySelector('.ingredientes').textContent.toLowerCase();
                //Usa la clase 'hidden' de Tailwind para ocultar
                tarjeta.classList.toggle('hidden', !textoIngredientes.includes(filtro));
            });
        });

        //Filtro por tiempo de cocción
        document.getElementById('buscar-tiempo').addEventListener('input', function () {
            const filtro = this.value.toLowerCase().trim();
            tarjetas.forEach(tarjeta => {
                const textoPreparacion = tarjeta.querySelector('.preparacion').textContent.toLowerCase();

                //Buscar la línea que contiene "tiempo:"
                const matchTiempo = textoPreparacion.match(/tiempo:\s*(\d+)\s*minutos/);
                let mostrar = true;

                if (filtro === '') {
                    //Si el filtro está vacío, mostrar todas
                    mostrar = true;
                } else if (matchTiempo) {
                    //Si se encuentra, compara si el filtro está contenido en el tiempo
                    mostrar = textoPreparacion.includes(filtro);
                } else {
                    //Oculta si no se encuentra un tiempo y el filtro no está vacío
                    mostrar = false;
                }
                
                // Usa la clase 'hidden' de Tailwind para ocultar
                tarjeta.classList.toggle('hidden', !mostrar);
            });
        });

    </script>
</body>

</html>