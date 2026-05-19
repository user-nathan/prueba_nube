<?php
// public/index.php

// 1. Forzar que los errores se muestren en pantalla durante las pruebas en la nube
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Cargamos los archivos principales usando la ruta exacta interna
// Como 'app' está dentro de 'public', está al mismo nivel que este archivo index.php
require_once __DIR__ . '/app/core/database.php';
require_once __DIR__ . '/app/core/enrutador.php';

// 3. Iniciamos el enrutador
$enrutador = new Enrutador();

// --- TUS RUTAS (Asegúrate de que coincidan exactamente con las mayúsculas/minúsculas de tus archivos) ---

// Cuando el usuario entre a la raíz "/", llamará al método "index" del "homeController"
$enrutador->get('/', 'homeController@index');

// Rutas de Registro
$enrutador->get('/registro', 'autenticacionController@mostrarRegistro');
$enrutador->post('/registro', 'autenticacionController@registrar');

// Rutas de Login
$enrutador->get('/login', 'autenticacionController@mostrarLogin');
$enrutador->post('/login', 'autenticacionController@login');

// Ruta de Cierre de Sesión 
$enrutador->get('/logout', 'autenticacionController@logout');

// Ruta del Perfil
$enrutador->get('/perfil', 'usuarioController@mostrarPerfil');
$enrutador->post('/perfil/actualizar', 'usuarioController@actualizarPerfil');

// Recargar créditos y checkout
$enrutador->get('/recargar', 'creditosController@mostrarTienda');
$enrutador->get('/checkout', 'creditosController@mostrarCheckout');
$enrutador->post('/checkout', 'creditosController@procesarPago');

// Ruta para el administrador
$enrutador->get('/admin', 'adminController@mostrarPanel');

// Rutas para añadir y editar samples
$enrutador->get('/admin/nuevo-sample', 'adminController@mostrarFormularioSample');
$enrutador->post('/admin/nuevo-sample', 'adminController@guardarSample');
$enrutador->get('/admin/editar-sample', 'adminController@mostrarEditarSample');
$enrutador->post('/admin/editar-sample', 'adminController@actualizarSample');

// Rutas para Elementos del Catálogo
$enrutador->get('/admin/elementos', 'adminController@mostrarElementos');
$enrutador->post('/admin/nuevo-album', 'adminController@guardarAlbum');
$enrutador->post('/admin/nuevo-genero', 'adminController@guardarGenero');
$enrutador->post('/admin/nueva-categoria', 'adminController@guardarCategoria');

// Ruta para ver el contenido de una librería específica y descargas
$enrutador->get('/libreria', 'homeController@mostrarLibreria');
$enrutador->get('/libreria/descargar', 'homeController@descargarSample');

// 4. Ponemos a funcionar el enrutador
$enrutador->despachar();