
# Shopee
Tengo el gusto de presentar uno de mis proyectos al que más tiempo he dedicado, se trata de Shopee, una página web con temática de compraventa de productos. En esta página no hay un intercambio de mensajes como por ejemplo en Wallapop, sino que hay un sistema de ofertas y contraofertas con un límite, esto con la finalidad de que tanto comprador como vendedor lleguen a un acuerdo con la mayor brevedad posible.

Cada sección y función ha sido trabajada minuciosamente para ofrecer una gran experiencia de usuario, que se destaca por su interfaz intuitiva y sobretodo, fluidez en su uso.

Podreis acceder a mi proyecto a través de este enlace: 

https://shopee-production.up.railway.app/

Espero que os guste!! 😁




## Tecnologías utilizadas

**Frontend:**

JavaScript: Implementé la lógica interactiva del proyecto, como la manipulación del DOM y las interacciones dinámicas de usuario. Tambien fue necesario para interactuar con archivos PHP y mostrar datos en tiempo real.

SCSS: Diseñé estilos responsivos, utilizando variables para mantener el código organizado y escalable. Tambien optimicé el diseño visual con transiciones y efectos propios.

**Backend:** 

PHP: Fue necesario para procesar, interacturar y gestionar todos los datos de la plataforma.



## Instalación y uso de manera local

### PHP
En el caso de querer probar la plataforma de manera local, lo primero de todo es tener instalado el servidor PHP, en caso de no tenerlo, lo que yo hice fue adquirirlo mediante XAMPP.

Para descargar XAMPP hay que acceder al siguiente enlace: 

https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe/download

Una vez descargado, hay que abrir el instalador y seguir todos los pasos sin configurar nada, como viene de fábrica.

Bien, despues de tener instalado XAMPP, es necesario agregar una path en las variables de entorno del sistema operativo (en mi caso Windows).

Para ello, dejo unas capturas que sirven de orientación:

![Primer paso Variables de entorno](https://i.imgur.com/ti3BprC.png)
![Segundo paso Variables de entorno](https://i.imgur.com/lOyHfzh.png)
![Tercer paso Variables de entorno](https://i.imgur.com/Kc5WUHt.png)

Después de darle a "Nuevo", habrá que pegar la ruta donde se encuentre la carpeta de PHP, suele ubicarse en C:\xampp\php.

Después de crear la "path" de PHP, el siguiente paso es abrir Visual Studio Code e instalar la extensión de PHP (PHP Server). Para ello se accede al siguiente enlace, el cual al dar en el boton de instalar, se abrirá nuestro Visual Studio Code con la extensión instalada, solo faltaría seguir los pasos de configuración que aparecen en la pestaña de dicha extensión.
https://marketplace.visualstudio.com/items?itemName=brapifra.phpserver

### Base de datos

Para este apartado será necesario conocimientos básicos de MySQL, ya que habrá que instalar y configurar MySQL Workbench, MySQL Installer y el conector ODBC.

Estas herramientas se pueden encontrar en este enlace:
https://dev.mysql.com/downloads/

Una vez esté todo instalado, hay que ejecutar MySQL Workbench y dentro del usuario admin, que viene por defecto, tendremos que importar el script SQL que se encuentra dentro del repositorio.

### Configurar get_connection()

Por último, es obligatorio agregar los datos de la base de datos a la funcion get_connection(), la cual se encuentra en el archivo src/p2/p2_lib.php.

Dentro del archivo, hay que buscar el la funcion y agregar el nombre de la base de datos, el nombre y la contraseña del usuario donde se importó el script y el host.

```bash
  function get_connection() {
    // Configuración de la conexión a la base de datos
    $dsn = 'mysql:host=HOST;dbname=NOMBRE BASE DE DATOS';
    $user = 'USUARIO';
    $pass = 'CONTRASEÑA';
    try {
        // Crear una nueva instancia de PDO para la conexión
        $con = new PDO($dsn, $user, $pass);
        // Configurar el modo de error para que lance excepciones
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Si hay un error en la conexión, mostrar el mensaje de error
        echo 'Fallo en la conexion: ' . $e->getMessage();
    }
    return $con;
}
```

Después de seguir todo este proceso, solo queda iniciar el proyecto, para ello, abrimos el archivo index.php que se encuentra dentro de la carpeta src y hacemos click derecho, en el menú, nos apareceran las opciones de la extension PHP Server, y tendremos que darle a "PHP Server: Serve project".
